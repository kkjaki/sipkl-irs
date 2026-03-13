<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cetak Nilai PKL</title>

<!-- ===================== SCRIPT ===================== -->
<script>

window.onload = function () {
    hitungNilai();
    setTanggal();
    window.print();
};

function hitungNilai() {

    const scores = document.querySelectorAll(".score");

    let total = 0;
    let count = 0;

    scores.forEach(el => {

        const val = parseFloat(el.innerText);

        if (!isNaN(val)) {
            total += val;
            count++;
        }

    });

    const avg = count ? Math.round(total / count) : 0;

    document.getElementById("nilaiAkhir").innerText = avg;
}

function setTanggal() {

    const today = new Date();

    document.getElementById("tanggal").innerText =
        today.toLocaleDateString("id-ID");
}

</script>

<style>

/* ===================== GLOBAL ===================== */

body {
    font-family: Arial, Helvetica, sans-serif;
    padding: 30px;
    background: #f4f6f9;
}

.container {
    max-width: 900px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* ===================== KOP SURAT ===================== */

.kop {
    display: flex;
    align-items: center;
    gap: 20px;
}

.kop img {
    width: 80px;
}

.kop-text {
    flex: 1;
    text-align: center;
}

.kop-text h1 {
    font-size: 26px;
    margin: 0;
    font-weight: bold;
    letter-spacing: 1px;
}

.kop-text p {
    margin: 4px 0;
    font-size: 14px;
}

.line {
    margin-top: 10px;
}

.line .top {
    border-top: 3px solid black;
}

.line .bottom {
    border-top: 1px solid black;
    margin-top: 3px;
}

/* ===================== JUDUL ===================== */

.title {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    margin: 25px 0;
}

/* ===================== DATA SISWA ===================== */

.info {
    display: grid;
    grid-template-columns: 160px 10px 1fr;
    gap: 6px;
    font-size: 14px;
    margin-bottom: 20px;
}

/* ===================== TABEL NILAI ===================== */

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th {
    background: #f1f5f9;
}

table th,
table td {
    border: 1px solid #ccc;
    padding: 10px;
    font-size: 14px;
}

.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

.nilai-akhir {
    font-weight: bold;
    background: #f9fafb;
}

/* ===================== FOOTER ===================== */

.footer {
    margin-top: 40px;
    display: flex;
    justify-content: space-between;
}

.ttd {
    text-align: center;
    margin-top: 50px;
}

/* ===================== RESPONSIVE ===================== */

@media (max-width:768px) {

    .kop {
        flex-direction: column;
        text-align: center;
    }

    .kop img {
        width: 60px;
    }

    .kop-text h1 {
        font-size: 20px;
    }

    table th,
    table td {
        font-size: 13px;
        padding: 8px;
    }

    .info {
        grid-template-columns: 120px 10px 1fr;
    }

}

/* ===================== PRINT ===================== */

@media print {

    body {
        background: white;
        padding: 0;
    }

    .container {
        box-shadow: none;
    }

}

</style>
</head>


<body>

<div class="container">

    <!-- ===================== KOP SURAT ===================== -->
    <div class="kop">

        <img src="/images/logo-irs.png" alt="Logo IRS">

        <div class="kop-text">

            <h1>PT. INTERNET RAKYAT SEJAHTERA</h1>

            <p>
                Alamat: Desa Kedawung, RT 04 RW 02 Kec. Susukan Kab. Banjarnegara,
                Kode Pos 53475 Telp. 081229482102
            </p>

        </div>

    </div>

    <div class="line">
        <div class="top"></div>
        <div class="bottom"></div>
    </div>


    <!-- ===================== JUDUL ===================== -->

    <div class="title">
        LAPORAN NILAI SISWA PKL
    </div>


    <!-- ===================== DATA SISWA ===================== -->

    <div class="info">

        <div>NIS</div>
        <div>:</div>
        <div>76521</div>

        <div>Nama</div>
        <div>:</div>
        <div>John Doe</div>

        <div>Kelas</div>
        <div>:</div>
        <div>XII RPL 2</div>

        <div>Guru Pembimbing</div>
        <div>:</div>
        <div>Lorem Ipsum, S.Pd.</div>

        <div>Sekolah</div>
        <div>:</div>
        <div>SMK IT Informatika AL-GPT</div>

    </div>


    <!-- ===================== TABEL NILAI ===================== -->

    <table>

        <thead>
            <tr>
                <th width="60">No</th>
                <th>Kriteria</th>
                <th width="120">Skor</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td class="text-center">1</td>
                <td class="text-left">Kriteria A</td>
                <td class="text-center score">80</td>
            </tr>

            <tr>
                <td class="text-center">2</td>
                <td class="text-left">Kriteria B</td>
                <td class="text-center score">85</td>
            </tr>

            <tr>
                <td class="text-center">3</td>
                <td class="text-left">Kriteria C</td>
                <td class="text-center score">90</td>
            </tr>

            <tr class="nilai-akhir">
                <td colspan="2">NILAI AKHIR</td>
                <td class="text-center" id="nilaiAkhir">0</td>
            </tr>

        </tbody>

    </table>


    <!-- ===================== FOOTER ===================== -->

    <div class="footer">

        <div>
            Keterangan:<br>
            Nilai akhir merupakan rata-rata dari seluruh kriteria penilaian.
        </div>

        <div class="ttd">

            Banjarnegara, <span id="tanggal"></span><br>
            Pembimbing Industri

            <br><br><br>

            ( __________________ )

        </div>

    </div>

</div>

</body>
</html>