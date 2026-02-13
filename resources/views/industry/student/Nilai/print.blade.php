<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak Nilai</title>

    <script>
        window.onload = function () {
            window.print();
        }
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="card">

    <div class="title">LAPORAN NILAI SISWA</div>

    <div>
        <p><strong>NIS:</strong> 76521</p>
        <p><strong>Nama:</strong> John Doe</p>
        <p><strong>Kelas:</strong> 12 RPL 2</p>
        <p><strong>Guru Pembimbing:</strong> Lorem Ipsum, S.Pd.</p>
        <p><strong>Sekolah:</strong> SMK IT (Informatika) AL-GPT</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kriteria</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="text-left">Kriteria A</td>
                <td>80</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">Kriteria B</td>
                <td>85</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">Kriteria C</td>
                <td>90</td>
            </tr>
            <tr>
                <td colspan="2"><strong>NILAI AKHIR</strong></td>
                <td><strong>85</strong></td>
            </tr>
        </tbody>
    </table>

</div>

</body>
</html>
