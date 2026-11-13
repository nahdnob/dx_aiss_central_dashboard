# Tugas: Refactor struktur Blade components (Laravel)

## Konteks
Project Laravel dengan Blade anonymous components dan Tailwind CSS. Lokasi komponen: `resources/views/components/`. Saat ini struktur campur: sebagian komponen ada di `components/ui/` (misalnya `x-ui.page-hero`, `x-ui.modal`), sebagian di root (`x-button`, `x-input`, `x-card`).

Tujuan: menata ulang ke struktur "Opsi B" (dikelompokkan per kategori + folder fitur) TANPA mengubah tampilan maupun perilaku apa pun.

## Aturan wajib
1. Jangan ubah HTML, class Tailwind, atau logika di dalam komponen, kecuali yang disebut di tugas ini.
2. Jangan ubah controller, route, model, dan JS.
3. Gunakan `git mv` untuk memindahkan file supaya riwayat git terjaga.
4. Kerjakan fase demi fase. Setelah tiap fase, jalankan `php artisan view:clear` dan laporkan hasilnya sebelum lanjut.
5. Jangan menebak. Kalau ada komponen yang tidak ada di daftar, tampilkan dulu daftarnya dan tanyakan.

## Struktur target

```
resources/views/components/
├── layout/
│   ├── page-hero.blade.php
│   ├── breadcrumb.blade.php
│   ├── section-title.blade.php
│   └── footer.blade.php
├── ui/
│   ├── button.blade.php
│   ├── button-group.blade.php
│   ├── action-hover.blade.php
│   ├── card.blade.php
│   └── badge.blade.php          (hanya jika sudah ada)
├── form/
│   ├── input.blade.php
│   ├── file-input.blade.php
│   └── searchable-dropdown.blade.php
├── modal/
│   ├── index.blade.php          → <x-modal>
│   └── content.blade.php        → <x-modal.content>
├── table/
│   ├── index.blade.php          → <x-table>
│   ├── search.blade.php
│   └── empty.blade.php
├── pagination/
│   ├── index.blade.php          → <x-pagination>
│   ├── simple.blade.php
│   └── numbered.blade.php
├── machine/                     ← fitur: menerima model $machine
└── sop/                         ← fitur: menerima model $sop
```

## Pemetaan nama tag (lama → baru)

| Lama | Baru |
|---|---|
| `x-ui.page-hero` | `x-layout.page-hero` |
| `x-ui.footer` | `x-layout.footer` |
| `x-section-title` | `x-layout.section-title` |
| `x-breadcrumb` / `x-ui.breadcrumb` | `x-layout.breadcrumb` |
| `x-button` | `x-ui.button` |
| `x-button-group` | `x-ui.button-group` |
| `x-action-hover` | `x-ui.action-hover` |
| `x-card` | `x-ui.card` |
| `x-input` | `x-form.input` |
| `x-file-input` | `x-form.file-input` |
| `x-ui.searchable-dropdown` | `x-form.searchable-dropdown` |
| `x-ui.modal` | `x-modal` |
| `x-ui.modal-content` | `x-modal.content` |
| `x-table`, `x-table.*`, `x-pagination`, `x-pagination.*` | tetap |

Catatan: kalau ada nama file berbeda dari tabel (misalnya `hover-actions.blade.php` vs `action-hover.blade.php`), pakai nama yang benar-benar dipanggil di view, lalu laporkan.

## Fase 1: Inventarisasi (jangan ubah file dulu)
1. Daftar semua file di `resources/views/components/` beserta lokasinya.
2. Cari semua pemakaian tag `<x-...>` di `resources/views/` dan hitung jumlahnya per komponen.
3. Cari referensi komponen DI DALAM komponen lain (misalnya `modal/content` memanggil `x-button`, `table/index` memanggil `x-pagination`).
4. Tampilkan rencana pemindahan dan daftar file yang akan diubah. Tunggu konfirmasi saya.

## Fase 2: Pindahkan file
Pindahkan file sesuai struktur target dengan `git mv`. Ganti nama `modal.blade.php` → `modal/index.blade.php` dan `modal-content.blade.php` → `modal/content.blade.php`. Belum mengubah isi file.

## Fase 3: Update semua pemanggilan
1. Ganti tag lama ke baru sesuai tabel, termasuk tag penutup (`</x-button>` → `</x-ui.button>`) dan `<x-slot>` yang terkait.
2. Update pemanggilan komponen di DALAM komponen lain.
3. Update `@extends` / `@include` / `@component` jika ada yang merujuk komponen lama.
4. Pastikan tidak ada sisa tag lama:
   `grep -rnE "<x-(button|button-group|action-hover|card|input|file-input|section-title|breadcrumb)[ />]|<x-ui\.(page-hero|footer|modal|modal-content|searchable-dropdown|breadcrumb)" resources/views`
   Hasilnya harus kosong.

## Fase 4: Tailwind dan cache
1. Pastikan `tailwind.config.js` (atau `@source` di Tailwind v4) mencakup `resources/views/**/*.blade.php` termasuk subfolder `components/`.
2. Jalankan `php artisan view:clear`, lalu `php artisan view:cache` untuk mendeteksi error Blade.
3. Jalankan build (`npm run build`) dan pastikan tidak ada error.

## Fase 5: Ekstrak komponen fitur (opsional, lakukan setelah Fase 1-4 lolos)
Dari halaman `machines/index.blade.php` dan `machines/edit.blade.php`, ekstrak blok yang spesifik machine/SOP menjadi komponen di folder fitur:
- `machine/summary.blade.php` → `<x-machine.summary :machine="$machine" />` (kotak ringkasan mesin di modal)
- `machine/modal-link-sop.blade.php` → `<x-machine.modal-link-sop :machine="$machine" :sops="$availableSops" />`
- `machine/form-edit.blade.php` → form edit machine
- `machine/table-sops.blade.php` → tabel SOP yang terhubung

Aturan: komponen di folder fitur boleh menerima model dan memakai komponen generik. Komponen generik (`ui/`, `form/`, `layout/`, `modal/`, `table/`, `pagination/`) TIDAK boleh menerima model atau tahu nama kolom.

## Output yang saya minta
1. Ringkasan per fase: file yang dipindah, file yang diubah, jumlah tag yang diganti.
2. Hasil perintah grep Fase 3 (harus kosong) dan hasil `view:cache`.
3. Daftar hal yang tidak bisa dipastikan (jika ada) untuk saya cek manual di browser.
