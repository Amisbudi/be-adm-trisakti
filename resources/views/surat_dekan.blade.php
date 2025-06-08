<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        h2 {
            text-align: center;
        }

        .table-no-border td,
        .table-no-border th {
            border: none;
            padding: 4px;
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid black;
            padding: 4px;
        }

        .section {
            margin-top: 30px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <h2>SURAT KEPUTUSAN DEKAN<br>FAKULTAS SENI RUPA DAN DESAIN</h2>

    <p>Nomor: {{ $surat['nomor'] }}</p>
    <p>Lampiran: {{ $surat['lampiran'] }}</p>
    <p>Perihal: Hasil Seleksi <span style="text-transform: capitalize">{{ $surat['jalur'] }}</span></p>

    <div style="margin-left: 40px; margin-right: 40px;">
        <p>Dengan ini kami laporkan hasil seleksi lamaran <span
                style="text-transform: capitalize">{{ $surat['jalur'] }}</span>,</p>
        <ul>
            <li>Fakultas: SENI RUPA DAN DESAIN</li>
            <li>Periode: {{ $surat['periode'] }}</li>
        </ul>

        <p>dengan hasil sebagai berikut:</p>
        <p>- Lamaran yang <strong>DITERIMA </strong>berjumlah {{ $surat['jumlah_diterima'] }} orang</p>
        <p> Dengan rincian sebagai berikut:</p>
        <table style="margin-left: 20px;">
            @php $no = 1; @endphp
            @foreach ($surat['rincian_diterima'] as $program => $jumlah)
                <tr>
                    <td style="width: 5%;">{{ $no++ }}.</td>
                    <td style="width: 75%;">Program Studi {{ $program }}</td>
                    <td style="width: 5%;">:</td>
                    <td style="width: 15%;">{{ $jumlah }} orang</td>
                </tr>
            @endforeach
        </table>

        <p>- Lamaran yang <strong>TIDAK DITERIMA </strong>berjumlah {{ $surat['jumlah_tidak_diterima'] }} orang</p>
        <p> Dengan rincian sebagai berikut:</p>
        <table style="margin-left: 20px;">
            @php $no = 1; @endphp
            @foreach ($surat['rincian_tidak_diterima'] as $program => $jumlah)
                <tr>
                    <td style="width: 5%;">{{ $no++ }}.</td>
                    <td style="width: 75%;">Program Studi {{ $program }}</td>
                    <td style="width: 5%;">:</td>
                    <td style="width: 15%;">{{ $jumlah }} orang</td>
                </tr>
            @endforeach
        </table>

        <p>Mohon kiranya hasil seleksi <span style="text-transform: capitalize">{{ $surat['jalur'] }}</span> sesuai
            tersebut diatas diterbitkan hasilnya sesuai Surat Keputusan Wakil Rektor Bidang Akademik pada: <br>
            Bulan : <br>
            Demikian kami sampaikan. Terima kasih atas perhatian dan kerjasamanya. <br>
            Minggu ke : 1/2/3/4 (pilih salah satu) <br>
            Rincian terlampir.</p>
        <div style="width: 200px; margin-left: auto; text-align: center;">
            <div style="margin-top: 30px;">Dekan,</div>
            <div style="margin-top: 60px;">{{ $surat['dekan'] }}</div>
        </div>


    </div>

    <div style="page-break-before: always;"></div>

    <table style="width: 100%;">
        <tr>
            <!-- Logo Trisakti -->
            <td style="width: 25%; text-align: center;">
                <img src="https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png"
                    alt="Logo Trisakti" width="100" />
            </td>

            <!-- Info Lampiran -->
            <td style="width: 75%; vertical-align: top;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 30%;">LAMPIRAN I</td>
                        <td style="width: 5%;">:</td>
                        <td>Surat Dekan Universitas Trisakti</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $surat['nomor'] }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ $surat['tanggal'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Judul Tengah -->
    <div style="text-align: center; margin-top: 20px;">
        <strong style="font-size: 16px;">
            DAFTAR NAMA CALON MAHASISWA YANG DITERIMA<br>
            MELALUI PROGRAM <span style="text-transform: uppercase">{{ $surat['jalur'] }}</span><br>
            TAHUN AKADEMIK {{ $surat['schoolyear'] }}
        </strong>
    </div>

    <div class="section">
        <h3>LAMPIRAN I - DAFTAR NAMA CALON MAHASISWA YANG DITERIMA</h3>
        <p>Tahun Akademik {{ $surat['schoolyear'] }}</p>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Peserta</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Program Studi</th>
                    <th>Peringkat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lampiran as $row)
                    @php
                        $no++;
                    @endphp
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row['registration_number'] }}</td>
                        <td>{{ $row['fullname'] }}</td>
                        <td>{{ $row['sma']['school'] ?? '-' }}</td>
                        <td>{{ $row['study_program_name'] }}</td>
                        <td>{{ $row['rank'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 30px">Ditetapkan di: Jakarta</p>
        <p>Pada Tanggal: {{ $surat['tanggal'] }}</p>
    </div>

</body>

</html>
