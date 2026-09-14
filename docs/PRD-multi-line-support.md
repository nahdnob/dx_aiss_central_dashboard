# PRD: Dukungan Multi-Line untuk AISS Central Dashboard

**Status:** Draft untuk review — belum diimplementasikan
**Dibuat:** 2026-08-03
**Konteks:** Ditulis setelah audit menyeluruh terhadap codebase saat ini (bukan asumsi/template generik)

---

## 1. Latar Belakang

Aplikasi ini awalnya dibangun dengan asumsi **1 line produksi, 1 PLC**. Dalam beberapa sesi terakhir, sebagian besar aplikasi sudah direfactor untuk mendukung banyak line dengan strategi: menambahkan kolom `line_id` (nullable FK ke tabel `lines`) pada tabel-tabel utama, ditambah sebuah "line yang sedang dipilih" berbasis session (`session('selected_line_id')`) yang di-enforce oleh middleware `EnsureLineSelected`.

Strategi ini **sudah terbukti bekerja dengan baik** untuk halaman-halaman CRUD/reporting: SOP, Risk Assessment, DASG, Machines, Products, Best Records (NCD), Line Performance, dan System Manager — semuanya sudah difilter `where('line_id', session('selected_line_id'))` dan sudah diverifikasi menghasilkan data yang benar-benar berbeda antar line (bukan sekadar tidak error).

Namun, **satu area besar belum ikut direfactor sama sekali: pipeline Cycle Time / sensor real-time**, yaitu bagian yang menerima data langsung dari PLC via Node-RED. Bagian ini masih 100% berasumsi hanya ada **satu** PLC dan **satu** "mode/pattern yang sedang berjalan" untuk seluruh aplikasi. Menambahkan PLC kedua (line kedua berjalan bersamaan) akan **merusak logika ini**, bukan sekadar "kurang lengkap".

Dokumen ini menjawab tiga pertanyaan yang diajukan:
1. Apakah `line_id` sudah cukup sebagai strategi? → **Ya, lanjutkan strategi ini** — lihat §4.
2. Bagian mana yang belum sesuai konsep? → **Lihat §5**, terutama pipeline cycle time.
3. Bagaimana konsekuensi 2 PLC terhadap arsitektur saat ini? → **Lihat §5.2 dan §6.**

---

## 2. Tujuan (Goals)

- Setiap line produksi dapat memiliki PLC-nya sendiri, mengirim data sensor secara independen, tanpa saling menimpa/kontaminasi data line lain.
- Setiap line dapat menjalankan **mode/pattern cycle time yang berbeda pada waktu yang sama** (Line 1 menjalankan "5MP", Line 2 menjalankan "3MP", bersamaan).
- Proses background (`sensor:complete-data`, `sensor:summary-data`) memproses **semua line yang aktif**, bukan hanya satu.
- Tetap menggunakan pendekatan `line_id` yang sudah ada — **tidak** perlu database terpisah per line, tidak perlu arsitektur multi-tenant yang berat (skala saat ini: 2 line, bukan ratusan tenant).

## 3. Non-Tujuan (Non-Goals)

- **Tidak** membangun arsitektur multi-tenant penuh (DB/schema terpisah per line). Skala 2 (mungkin bertambah sedikit) line tidak membutuhkan itu.
- **Tidak** mencakup deployment/konfigurasi fisik Node-RED & PLC kedua secara operasional — PRD ini menentukan **kontrak data** yang harus dipenuhi Node-RED, bukan langkah instalasinya.
- **Tidak** mencakup migrasi/pembersihan data historis yang saat ini `line_id`-nya `NULL` secara otomatis — ini didaftarkan sebagai open question (§8), butuh keputusan Anda.

---

## 4. Apakah `line_id` Sudah Cukup?

**Ya.** Ini adalah pendekatan yang tepat untuk skala aplikasi ini (beberapa line dalam satu pabrik, satu database bersama), dan sudah terbukti bekerja di 10 tabel + semua controller CRUD/report. Rekomendasi: **lanjutkan pola yang sama**, jangan ganti strategi — tinggal **perluas cakupannya** ke tabel-tabel yang belum tersentuh (§5.2), karena di situlah letak celahnya, bukan pada strategi itu sendiri.

---

## 5. Hasil Audit: Bagian yang Sudah vs Belum Sesuai Konsep

### 5.1 Sudah Line-Aware (bekerja dengan baik hari ini)

| Tabel | Kolom `line_id` | Controller sudah filter? |
|---|---|---|
| `sops`, `risk_assessments`, `dasgs`, `ncds` | ✅ | ✅ |
| `line_performances`, `product_summaries` | ✅ | ✅ |
| `product_ins`, `product_outs`, `patterns`, `machines` | ✅ | ✅ (patterns via `PatternController`, `CycleTimeQueryService`) |

Modal pemilihan line saat login, session `selected_line_id`/`selected_line_name`, middleware `EnsureLineSelected` — semua ini sudah menjadi fondasi yang benar dan **tidak perlu diubah**.

### 5.2 BELUM Line-Aware — Jalur Kritis (Cycle Time / Sensor)

Ini bagian yang Anda curigai, dan benar:

| Tabel | `line_id`? | Masalah |
|---|---|---|
| `sensors` | ❌ | Hanya `id` + `name` (Sensor 1..7). Identitas sensor murni posisional (indeks ke-N dari word D-memory PLC), **bukan** terikat ke line manapun. |
| `sensor_histories` | ❌ | Hanya bisa diketahui line-nya secara **tidak langsung**, lewat `pattern_id → patterns.line_id`. Masalahnya: `pattern_id` selalu `NULL` saat Node-RED insert (lihat §5.3), baru diisi belakangan oleh cron job. |
| `sensor_summaries` | ❌ | Sama seperti di atas — line hanya bisa ditelusuri transitif lewat `pattern_id`. |
| `pattern_histories` | ❌ | Ini **log global tunggal** "mode mana yang sedang aktif". Tidak ada `line_id`. Parahnya: **ada 2 form UI berbeda** (dashboard utama & halaman cycle-time monitoring) yang sama-sama menulis ke tabel yang sama, satu di antaranya tidak difilter line sama sekali (`PatternService::get()` di dashboard = `Pattern::all()`, tidak scoped). |
| `pattern_sensor`, `shifts`, `work_hours` | ❌ | `shifts`/`work_hours` kemungkinan memang boleh global (jadwal shift pabrik biasanya sama untuk semua line) — **perlu konfirmasi Anda**, lihat §8. |

**Yang paling berbahaya:** `App\Services\Sensor\SensorContextService::currentPattern()` — dipakai oleh KEDUA cron job (`sensor:complete-data`, `sensor:summary-data`) yang jalan tiap menit — mengambil `PatternHistory::latest()->value('pattern_id')` **tanpa filter line sama sekali**. Dengan 2 PLC aktif bersamaan, cron ini hanya akan memproses data milik **satu** line (siapa pun yang terakhir mengaktifkan pattern-nya secara global), dan **diam-diam mengabaikan line yang lain** — tidak error, hanya datanya tidak pernah terproses.

Sebagai perbandingan: `App\Services\CycleTime\CycleTimeQueryService::getActivePattern()` (dipakai halaman *cycletimes/monitoring*, bukan cron) **sudah** menyaring lewat `whereHas('pattern', fn($q) => $q->where('line_id', session('selected_line_id')))`. Jadi tampilan web sudah "terasa" line-aware, tapi mesin pemroses data di baliknya (cron) belum — ini kesenjangan tampilan-vs-data yang perlu ditutup.

**Hardcode topologi sensor:** `CompletingDataService` dan `app/Helpers/time.php::calculate_duration()` sama-sama punya baris `in_array($sensor->id, [1, 5])` untuk menangani sensor berpasangan (dual-strobe). ID sensor 1 dan 5 ini spesifik untuk topologi line yang ada sekarang — begitu sensor line kedua ditambahkan (kemungkinan ID 8, 9, 10, ...), baris ini harus diketahui/diupdate manual, dan tidak akan otomatis berlaku untuk line 2 walau topologinya sama persis.

### 5.3 Jalur Ingestion Node-RED (PLC → Database)

Ditemukan di `storage/node-red/flows.json` (satu-satunya dokumentasi integrasi PLC yang ada di repo ini):

- PLC saat ini: **Omron, protokol FINS/UDP, IP `192.168.2.9:9600`**, di-poll tiap 2 detik (baca `D0`–`D19`, 20 word).
- Function node mendekode 20 word tersebut jadi grup-grup 3 word (BCD datetime) → mendukung hingga **~6 sensor** dari satu blok pembacaan.
- Untuk setiap sensor yang nilainya berubah (artinya "sensor tersebut baru saja trigger"), Node-RED langsung `INSERT INTO sensor_histories (pattern_id, sensor_id, time, ...) VALUES (NULL, ${idx+1}, ...)` — **langsung ke MySQL, tidak lewat Laravel sama sekali** (tidak ada endpoint API/webhook di aplikasi ini).
- `pattern_id` **selalu NULL** saat insert — baru diisi belakangan oleh cron `sensor:complete-data` berdasarkan "pattern aktif global" tadi.
- `sensor_id` = posisi ke-`idx+1` dalam blok D-memory, **bukan** ID yang sengaja dipetakan ke suatu line.

⚠️ **Catatan ketidakcocokan yang perlu Anda konfirmasi:** file `.env` lokal memakai `DB_DATABASE=db_aiss`, sementara node MySQL di `flows.json` menunjuk ke database **`db_wip_monitoring`**. Perlu dipastikan mana yang benar-benar dipakai di production sebelum implementasi dimulai — kalau tidak, migrasi skema bisa saja diterapkan ke database yang salah.

### 5.4 ProductIn / ProductOut (bukan bagian cycle time, tapi sama-sama belum line-aware)

`ProductInService` dan `ProductOutService` masing-masing membaca file **path UNC yang di-hardcode di dalam kode**, bukan dari config:

- ProductIn: `\\FU551324001\Users\ADMIN\Documents\Pokayoke\DATA\...\Data Scan.txt`
- ProductOut: `\\192.168.2.1\Users\User\Documents\IGS\...\KANBAN DATA\Data.txt`

Keduanya sudah menunjuk ke 2 mesin fisik yang berbeda (bukan kebetulan sama), tapi **tidak ada parameter line** — begitu ada line kedua dengan mesin poka-yoke/kanban sendiri, service ini butuh path kedua yang juga hardcode, atau (lebih baik) path yang dikonfigurasi per-line.

---

## 6. Rencana Solusi (Requirements)

### REQ-1 — Tambah `line_id` ke `sensors`
Setiap sensor fisik terikat ke satu line. Sensor line 2 mendapat baris baru (ID baru, misalnya 8–13), **bukan** menimpa ID 1–7 milik line 1. Nama boleh sama ("Sensor 1") di kedua line karena dibedakan oleh `line_id`, bukan oleh angka di nama.

### REQ-2 — Tambah `line_id` ke `sensor_histories` dan `sensor_summaries`, diisi LANGSUNG oleh Node-RED
Ini adalah perubahan paling penting. Jangan mengandalkan rantai `pattern_id → patterns.line_id` yang rapuh (karena `pattern_id` NULL saat insert). Karena Node-RED **sudah tahu** PLC/line mana yang sedang ia baca (setiap flow PLC terpisah), node MySQL insert-nya tinggal ditambah satu kolom literal `line_id` sesuai flow-nya masing-masing. Jauh lebih sederhana dan tidak rapuh dibanding inferensi lewat join.

### REQ-3 — Tambah `line_id` ke `pattern_histories`
Setiap line punya riwayat "mode aktif" independen. `PatternHistoryController::store()` wajib mengambil/mewajibkan `line_id` (dari `session('selected_line_id')`, konsisten dengan pola yang sudah dipakai di controller lain) dan **menolak** aktivasi tanpa line yang jelas. Ini juga menutup celah 2 form UI yang saat ini bentrok (§5.2).

### REQ-4 — Ubah cron & service context menjadi per-line
`SensorContextService`, `CompletingDataService`, `SensorSummaryService`, dan command `sensor:complete-data`/`sensor:summary-data` direfactor agar **iterasi per line aktif** (mis. `Line::all()` atau line yang punya pattern history), bukan mengambil satu "current pattern" global. Setiap line diproses dengan pattern/shift/work-hour miliknya sendiri.

### REQ-5 — Hilangkan hardcode `[1, 5]` untuk sensor berpasangan
Ganti dengan data-driven, misalnya kolom `sensors.pair_sensor_id` (nullable, self-referencing) atau `sensors.duration_divisor`, sehingga topologi "sensor berpasangan" bisa didefinisikan per sensor per line tanpa mengedit kode setiap kali ada line baru.

### REQ-6 — Path ProductIn/ProductOut dikonfigurasi per-line
Tambahkan kolom pada tabel `lines` (mis. `pokayoke_path`, `kanban_path`) atau config array keyed by `line_id`, sehingga `ProductInService`/`ProductOutService` tidak perlu hardcode path — cukup loop per line yang punya path terdaftar.

### REQ-7 — Kontrak data untuk Node-RED (2 PLC)
Duplikasi flow Node-RED untuk PLC kedua (koneksi FINS baru ke IP PLC line tersebut), dengan penyesuaian:
- Node MySQL insert wajib menyertakan `line_id` (literal, sesuai flow).
- Penomoran `sensor_id` untuk line 2 tidak boleh bentrok dengan ID line 1 — gunakan ID baris `sensors` yang sudah dibuat di REQ-1 (bukan lagi index+1 mentah dari D-memory), atau pastikan base offset berbeda per line.

### REQ-8 — Migrasi data lama
Data historis yang `line_id`-nya `NULL` (semua data sensor/pattern yang ada saat ini) direkomendasikan di-backfill ke **Line 2**, karena seluruh bukti (SOP, mesin, PLC yang sudah terpasang) menunjukkan itulah line yang secara fisik sudah berjalan hari ini. **Perlu konfirmasi Anda** — lihat §8.

---

## 7. Ringkasan Perubahan Skema

| Tabel | Perubahan |
|---|---|
| `sensors` | + `line_id` (FK nullable → `lines`) |
| `sensor_histories` | + `line_id` (FK nullable → `lines`), diisi langsung oleh Node-RED |
| `sensor_summaries` | + `line_id` (FK nullable → `lines`) |
| `pattern_histories` | + `line_id` (FK nullable → `lines`) |
| `sensors` | + kolom penanda sensor berpasangan (ganti hardcode `[1,5]`) |
| `lines` | + kolom path sumber data ProductIn/ProductOut per line (opsional, atau config terpisah) |

---

## 8. Pertanyaan Terbuka (butuh keputusan Anda sebelum implementasi)

1. Data historis `line_id = NULL` (sensor histories, summaries, patterns, pattern histories) — backfill semua ke Line 2, atau biarkan sebagai data lama/tidak dipetakan? Backfill ke line 2
2. `.env` lokal pakai `db_aiss`, flow Node-RED (`flows.json`) menunjuk `db_wip_monitoring` — mana yang benar dipakai di production sekarang? db_aiss saja
3. Apakah Line 1 dan Line 2 berjalan dengan jadwal shift/jam kerja yang **sama persis**, atau butuh jadwal independen? (Menentukan apakah `shifts`/`work_hours` perlu ikut mendapat `line_id` atau memang boleh tetap global.) global
4. Skema penomoran sensor untuk PLC line 2 — sudah ada rencana pemetaan D-memory → sensor tertentu, atau perlu didiskusikan bersama saat REQ-1/REQ-7 dikerjakan? data yang sudah ada saat ini aktualnya untuk line 2, penomoran sensor dengan pos nya disamakan saja dengan saat ini untuk line 1 nya
5. Setuju bahwa `line_id` pada `sensor_histories`/`pattern_histories` diisi **langsung oleh Node-RED** (lebih sederhana, direkomendasikan) dibanding pendekatan inferensi lewat join yang berlaku sekarang? setuju

---

## 9. Rencana Bertahap (Rollout)

Bukan untuk dikerjakan sekarang — hanya urutan yang disarankan **setelah** PRD ini disetujui:

1. **Migrasi skema**: tambah kolom `line_id` pada `sensors`, `sensor_histories`, `sensor_summaries`, `pattern_histories`; backfill data lama sesuai keputusan §8.
2. **Refactor service layer**: `SensorContextService`, `CompletingDataService`, `SensorSummaryService`, `PatternHistoryController` menjadi per-line; satukan 2 form aktivasi pattern yang saat ini tidak konsisten.
3. **Update Node-RED**: duplikasi flow untuk PLC kedua + tambahkan `line_id` pada flow PLC pertama juga (agar keduanya konsisten).
4. **Path ProductIn/ProductOut per line** (REQ-6).
5. **Uji bersamaan**: jalankan simulasi 2 line aktif berbarengan, pastikan cron memproses keduanya, data tidak bercampur, dan tampilan dashboard/monitoring menunjukkan data yang benar sesuai line yang dipilih.

---

## 10. Ringkasan Jawaban Singkat

- **`line_id` sudah cukup?** Ya, lanjutkan — tinggal diperluas ke tabel yang belum tersentuh (§5.2, §6), bukan diganti strateginya.
- **Bagian yang belum sesuai konsep:** seluruh pipeline cycle time (`sensors`, `sensor_histories`, `sensor_summaries`, `pattern_histories`, cron job, dan 2 form aktivasi pattern yang bentrok) — persis area yang Anda curigai.
- **Konsekuensi 2 PLC:** setiap komponen di jalur ini butuh tahu "ini data milik line mana", dan itu harus datang **langsung dari Node-RED** (REQ-2/REQ-7), bukan disimpulkan belakangan seperti pola `pattern_id` yang berlaku sekarang.
