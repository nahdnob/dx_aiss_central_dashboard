<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cycle Time Log Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #111827;
        }
        .header p {
            margin: 5px 0 0;
            color: #6b7280;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        .info-item {
            font-size: 14px;
        }
        .info-item strong {
            display: block;
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-ok {
            color: #059669;
            font-weight: bold;
        }
        .status-ng {
            color: #dc2626;
            font-weight: bold;
        }
        /* Hide buttons during print */
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
            .info-box {
                border: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-left: 10px;">Tutup</button>
    </div>

    <div class="header">
        <h1>Laporan Cycle Time Monitoring</h1>
        <p>AISS Central Dashboard</p>
    </div>

    <div class="info-box">
        <div class="info-item">
            <strong>Tanggal</strong>
            {{ $filterDate ? \Carbon\Carbon::parse($filterDate)->translatedFormat('d F Y') : '-' }}
        </div>
        <div class="info-item">
            <strong>Shift</strong>
            {{ $shift ? $shift->name . ' (' . \Carbon\Carbon::parse($shift->time_start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($shift->time_end)->format('H:i') . ')' : 'Semua Shift' }}
        </div>
        <div class="info-item">
            <strong>Mode Aktif</strong>
            {{ $pattern ? $pattern->name : 'Semua Mode' }}
        </div>
        @if($pattern)
        <div class="info-item">
            <strong>Batas Waktu (UCL / LCL)</strong>
            {{ $pattern->max_time }}s / {{ $pattern->min_time }}s
        </div>
        @endif
        <div class="info-item">
            <strong>Total Data</strong>
            {{ $logs->count() }} Data
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Mode</th>
                <th>POS</th>
                <th style="text-align: center;">Durasi (s)</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $index => $log)
                @php
                    $pos = $posMapping[$log->pattern_id][$log->sensor_id] ?? '-';
                    $posDisplay = $pos !== '-' ? 'POS ' . $pos : '-';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->time ? \Carbon\Carbon::parse($log->time)->format('H:i:s') : '-' }}</td>
                    <td>{{ $log->pattern?->name ?? '-' }}</td>
                    <td>{{ $posDisplay }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ number_format($log->duration, 2) }}</td>
                    <td style="text-align: center;">
                        @if($log->status == 1)
                            <span class="status-ok">OK</span>
                        @else
                            <span class="status-ng">NG</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">Tidak ada data yang ditemukan untuk filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        // Opsional: Otomatis memunculkan dialog print ketika halaman dimuat
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
