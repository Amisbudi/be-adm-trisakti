<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            position: relative;
        }

        .main {
            margin: 0 130px;
            text-align: center;
            line-height: 130%;
        }

        .left,
        .right {
            width: 130px;
            position: absolute;
            top: 0;
        }

        .left {
            left: 0;
            text-align: left;
        }

        .right {
            right: 0;
            text-align: right;
        }

        .header::after {
            clear: both;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.5cm;
        }

        .participant-data .participant-credit-table-credit table {
            margin-top: 1%;
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #283891;
        }

        .participant-data .participant-credit-table-credit table th,
        .participant-data .participant-credit-table-credit table td {
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        .participant-data .participant-credit-table-credit table th {
            background-color: #283891;
            color: #ffffff;
        }

        .participant-data .participant-credit-table-credit table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .participant-data {
            margin-top: 2%;
            width: 100%;
            padding: 1%;
        }

        .participant-credit-table-detail {
            width: 100%;
        }

        .participant-credit-table-detail table td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="main">
            <h2>Transkrip Kredit Transfer</h2>
            <p>Universitas Trisakti</p>
            <p style="font-size: small;">Jl. Kyai Tapa No.1, RT.6/RW.16, Grogol, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11440<br>spmb.trisakti.ac.id</p>
        </div>
        <div class="left">
            <img src='https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png' width="100px" />
        </div>
        <div class="right">
            <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(100)->generate('https://admisi.trisakti.ac.id/')) }}" width="100px" />
        </div>
    </div>
    <hr>
    <div class="participant-data">
        <b>Data Kredit Transfer</b>
        <hr>
        <div class="participant-credit-table-detail">
            <table>
                <tr>
                    <td>Nomor Peserta</td>
                    <td>:</td>
                    <td>{{ $document_transcript->registration_number }}</td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>:</td>
                    <td>{{ $document_transcript->fullname }}</td>
                </tr>
                <tr>
                    <td>Total Mata Kuliah</td>
                    <td>:</td>
                    <td>{{ $document_transcript->total_course }}</td>
                </tr>
                <tr>
                    <td>Total SKS</td>
                    <td>:</td>
                    <td>{{ $document_transcript->total_credit }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="participant-data">
        <b>Detail Kredit Transfer</b>
        <hr>
        <div class="participant-credit-table-credit">
            <table>
                <tr>
                    <th style="background-color: #ccc; color: black; text-align:left" colspan="5">Mata Kuliah Asal</th>
                    <th style="border-left: 2px solid #283891; background-color: #ccc; color: black; text-align:left" colspan="4">Mata Kuliah Penyetaraan</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>SKS</th>
                    <th>Nilai</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>SKS</th>
                    <th>Nilai</th>
                </tr>
                @foreach ($mapping_document_transcript as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data['course_code'] }}</td>
                    <td>{{ $data['course_name'] }}</td>
                    <td>{{ $data['credit_hour'] }}</td>
                    <td>{{ $data['grade'] }}</td>
                    <td style="border-left: 2px solid #283891;">{{ $data['course_code_approved'] }}</td>
                    <td>{{ $data['course_name_approved'] }}</td>
                    <td>{{ $data['credit_hour_approved'] }}</td>
                    <td>{{ $data['grade_approved'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <footer><i style="font-size: 13px;">{{ 'Dicetak di Universitas Trisakti ' . date('d F Y') }}</i></footer>
</body>

</html>