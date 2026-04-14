<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Perangkingan WASPAS - {{ $batch_id }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; padding: 30px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 14px; }
        
        .content { margin-bottom: 40px; }
        .section-title { font-size: 16px; font-weight: bold; margin-top: 30px; margin-bottom: 10px; border-left: 5px solid #4B49AC; padding-left: 10px; text-transform: uppercase; }
        .meta-info { margin-bottom: 20px; font-size: 13px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; page-break-inside: avoid; }
        table th, table td { border: 1px solid #333; padding: 8px; text-align: center; font-size: 12px; }
        table th { background-color: #f2f2f2; font-weight: bold; }
        .text-left { text-align: left; }
        .font-weight-bold { font-weight: bold; }
        
        .footer { margin-top: 50px; }
        .signature-wrapper { float: right; width: 250px; text-align: center; }
        .signature-space { height: 70px; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .section-title { border-left: 5px solid #333; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4B49AC; color: white; border: none; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak Sekarang
        </button>
        <button onclick="window.close(); window.location.href='{{ route('waspas.show', $batch_id) }}';" style="padding: 10px 20px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 5px; cursor: pointer;">
            Kembali
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN HASIL PERANGKINGAN WASPAS</h1>
        <p>Sistem Pendukung Keputusan Pemilihan Pasar Terbaik</p>
        <p>PD. Pasar Surya Surabaya</p>
    </div>

    <div class="content">
        <div class="meta-info">
            <p><strong>Tanggal Perhitungan:</strong> {{ \Carbon\Carbon::parse($hasil->first()->created_at)->translatedFormat('d F Y') }}</p>
            <p><strong>Dicetak pada:</strong> {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        <!-- 1. Matriks Keputusan (X) -->
        <div class="section-title">1. Matriks Keputusan (X)</div>
        <table>
            <thead>
                <tr>
                    <th>Pasar</th>
                    @foreach($kriterias as $k)
                    <th>{{ $k->nama_kriteria }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($evaluatedPasars as $p)
                <tr>
                    <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                    @foreach($kriterias as $k)
                    <td>{{ $matrix[$p->id_pasar][$k->id_kriteria] }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- 2. Matriks Normalisasi (R) -->
        <div class="section-title">2. Matriks Normalisasi (R)</div>
        <table>
            <thead>
                <tr>
                    <th>Pasar</th>
                    @foreach($kriterias as $k)
                    <th>{{ $k->nama_kriteria }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($evaluatedPasars as $p)
                <tr>
                    <td class="text-left font-weight-bold">{{ $p->nama_pasar }}</td>
                    @foreach($kriterias as $k)
                    <td>{{ number_format($normalizedMatrix[$p->id_pasar][$k->id_kriteria], 4) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- 3. Hasil Akhir & Perangkingan -->
        <div class="section-title">3. Hasil Akhir & Perangkingan</div>
        <table>
            <thead>
                <tr>
                    <th width="50">Rank</th>
                    <th class="text-left">Nama Pasar</th>
                    <th>Skor WSM (Q1)</th>
                    <th>Skor WPM (Q2)</th>
                    <th>Skor Akhir (Qi)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr style="{{ $h->rangking == 1 ? 'background-color: #f9f9f9;' : '' }}">
                    <td><strong>{{ $h->rangking }}</strong></td>
                    <td class="text-left font-weight-bold">{{ $h->pasar->nama_pasar }}</td>
                    <td>{{ number_format($h->skor_wsm, 4) }}</td>
                    <td>{{ number_format($h->skor_wpm, 4) }}</td>
                    <td class="font-weight-bold">{{ number_format($h->skor_total_qi, 4) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="signature-wrapper">
            <p>Surabaya, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>Direktur Utama</strong></p>
            <div class="signature-space"></div>
            <p>__________________________</p>
            <p>NIP. .............................</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
