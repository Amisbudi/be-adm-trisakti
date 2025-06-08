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
                        <td style="width: 30%;">Hal</td>
                        <td style="width: 5%;">:</td>
                        <td>Surat Keputusan Rektor Universitas Trisakti</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $intake['reference_number'] }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($intake['publication_date'])->translatedFormat('d F Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Judul Tengah -->
    <div style="text-align: center; margin-top: 20px;">
        <strong style="font-size: 16px;">
            DAFTAR NAMA CALON MAHASISWA YANG DITERIMA<br>
            MELALUI PROGRAM <span style="text-transform: uppercase">{{ $intake['selection_path_name'] }}</span><br>
            TAHUN AKADEMIK {{ $intake['schoolyear'] }}
        </strong>
    </div>

    <div class="section">

        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Nomor Peserta</th>
                    <th>Nama</th>
                    <th>Asal Sekolah</th>
                    <th>Program Studi</th>
                    <th>Peringkat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lampiran as $row)
                    <tr style="text-transform: uppercase;">
                        <td>{{ $row['registration_number'] }}</td>
                        <td>{{ $row['fullname'] }}</td>
                        <td>{{ $row['sma']['school'] ?? '-' }}</td>
                        <td>{{ $row['study_program_name'] }}</td>
                        <td style="text-align: center;">{{ $row['rank'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 30px">Ditetapkan di: Jakarta</p>
        <p>Pada Tanggal: {{ \Carbon\Carbon::parse($intake['publication_date'])->translatedFormat('d F Y') }}</p>
    </div>

</body>

</html>
