<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #0d9488;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        .student-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .student-info table {
            width: 100%;
        }

        .student-info td {
            padding: 5px 0;
        }

        .student-info .label {
            font-weight: bold;
            width: 150px;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            width: 25%;
            padding: 5px;
        }

        .summary-box {
            background-color: #f0fdfa;
            border: 1px solid #0d9488;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .summary-box h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-box p {
            font-size: 28px;
            font-weight: bold;
            color: #0d9488;
        }

        table.grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.grades-table th,
        table.grades-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table.grades-table th {
            background-color: #0d9488;
            color: white;
            font-weight: bold;
        }

        table.grades-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .grade-excellent {
            background-color: #dcfce7 !important;
        }

        .grade-good {
            background-color: #dbeafe !important;
        }

        .grade-fair {
            background-color: #fef9c3 !important;
        }

        .grade-poor {
            background-color: #fee2e2 !important;
        }

        .score {
            font-size: 18px;
            font-weight: bold;
        }

        .category {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
        }

        .category-excellent {
            background-color: #22c55e;
            color: white;
        }

        .category-good {
            background-color: #3b82f6;
            color: white;
        }

        .category-fair {
            background-color: #eab308;
            color: white;
        }

        .category-poor {
            background-color: #ef4444;
            color: white;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN NILAI MAHASISWA</h1>
        <p>Sistem Informasi Praktek Kerja Lapangan</p>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $user->name }}</td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td>: {{ $student->nis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>: {{ $student->class ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Sekolah</td>
                <td>: {{ $student->school->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Program Magang</td>
                <td>: {{ $student->internshipProgram->name
                    ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Industri</td>
                <td>: {{
                    $student->internshipProgram->industry->name
                    ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td>
                    <div class="summary-box">
                        <h3>Rata-rata</h3>
                        <p>{{ number_format($averageScore,
                            1) }}</p>
                    </div>
                </td>
                <td>
                    <div class="summary-box">
                        <h3>Tertinggi</h3>
                        <p>{{ $grades->max('score') ?? 0 }}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="summary-box">
                        <h3>Terendah</h3>
                        <p>{{ $grades->min('score') ?? 0 }}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="summary-box">
                        <h3>Total Kriteria</h3>
                        <p>{{ $gradeCount }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="grades-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Kriteria Penilaian</th>
                <th
                    style="width: 100px; text-align: center;">
                    Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $index => $grade)
            <tr
                class="@if($grade->score >= 90) grade-excellent @elseif($grade->score >= 80) grade-good @elseif($grade->score >= 70) grade-fair @else grade-poor @endif">
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $grade->criterion->name ??
                        '-' }}</strong>
                    @if($grade->criterion->description)
                    <br><small style="color: #666;">{{
                        $grade->criterion->description
                        }}</small>
                    @endif
                </td>
                <td style="text-align: center;">
                    <span class="score">{{ $grade->score
                        }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr
                style="background-color: #f0fdfa; font-weight: bold;">
                <td colspan="2" style="text-align: right;">
                    Rata-rata Keseluruhan</td>
                <td colspan="2"
                    style="text-align: center; font-size: 18px; color: #0d9488;">
                    {{ number_format($averageScore, 1) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh
            Sistem Informasi Praktek Kerja Lapangan</p>
        <p>Tanggal Cetak: {{ $date }}</p>
    </div>
</body>

</html>