<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta Ujian</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 18px;
            margin: 0;
        }

        .kop-container {
            /* padding: 20px; */
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;

        }

        .kop-container h1 {
            font-size: 18px;
            text-align: center;
        }

        .kop-container img {
            margin-top: 10px;
            max-width: 100px;
            max-height: 70px;
            margin-right: 20px;
        }

        .text-center {
            text-align: center;
            flex-grow: 1;
            margin: 0 10px;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 0;
            right: 0;
        }

        .content {
            margin-top: -70px;
            /* text-align: center; */
            border: 1px solid #000;
        }


        /* @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            th {
                background-color: #ffffff !important;
            }
        } */
    </style>
</head>

<body>
    <div class="kop-container">
        <img src="https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png"
            alt="Logo Universitas Trisakti" />
        <div>
            <h1>PENERIMAAN MAHASISWA BARU</h1>
            <h1>UNIVERSITAS TRISAKTI</h1>
            <h1>TAHUN AKADEMIK {{ $school_year }}</h1>
        </div>
        <div>
            <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(100)->generate($qrcode)) }}"
                width="100px" class="qr-code" />
        </div>
    </div>

    <div class="content">
        <h1 style="margin: 30px 0 30px 0; text-align: center;">KARTU PESERTA UJIAN</h1>

        <div style="border-top: 1px solid #000;">
            <table>
                <tr>
                    <td>No. Formulir</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;: {{ $participant->registration_number }}</td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;: {{ $participant->fullname }}</td>
                </tr>
                <tr>
                    <td>Pragram 1</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;: {{ $participant->selection_path_name }}</td>
                </tr>
            </table>
        </div>

        <div>
            <table style="border: #000 1px solid; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #000;">
                        <td style="width: 10%; text-align: center; border-right: 1px solid #000;">#</td>
                        <td style="width: 40%; text-align: center; border-right: 1px solid #000;">Materi Ujian</td>
                        <td style="width: 25%; text-align: center; border-right: 1px solid #000;">Waktu</td>
                        <td style="width: 55%; text-align: center;">Lokasi Ujian</td>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($sessions))
                    @foreach ($sessions as $key => $session )
                    <tr>
                        <td  style="width: 10%; text-align: center;">{{ $key + 1 }}</td>
                        <td style="padding: 0 5px 0 5px;">{{ $session['nama_ujian'] }}</td>
                        <td  style="padding: 0 5px 0 5px; text-align: center;">{{ $session['date_start'] }} WIB</td>
                        <td style="padding: 0 5px 0 5px;">{{ $session['location'] ?? $session['date_end']. 'WIB' }} </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>            
        </div>

        <div>
            <img style="width: 120px; height: 160px; padding: 10px;" src="{{ $participant->photo_url }}" />
        </div>

        <div style="border-top: 1px solid #000; padding: 10px;">
            <p style="display: inline; margin-right: 10px;">Keterangan :</p>
            <br><br>
            <ul style="list-style-type: decimal; font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding-left: 20px; display: inline-block;">
                <li>
                    Kartu Peserta Ujian (KPU) hanya berlaku untuk calon mahasiswa bersangkutan, yang isinya BERBEDA antara satu calon mahasiswa dengan calon mahasiswa lainnya, dan WAJIB diunduh untuk dokumentasi pribadi.
                </li>
                <li>
                    JADWAL USM dan MATA UJIAN sesuai waktu yang tercantum pada KPU.
                </li>
                <li>
                    Pemilihan PROGRAM STUDI akan menentukan MATERI MATA UJIAN.
                </li>
                <li>
                    "USER ID" dan "PASSWORD" digunakan untuk MENGIKUTI UJIAN dan MELIHAT HASIL SELEKSI pada: <a href="https://admsi.trisakti.ac.id" target="_blank">https://admsi.trisakti.ac.id</a>
                </li>
                <li>
                    Sebelum mengikuti USM mahasiswa mempelajari Panduan Ujian Saringan Masuk (USM) Online Universitas Trisakti 2024/2025.
                </li>
                <li>
                    Pada saat mengikuti USM calon mahasiswa wajib mengerjakan soal ujian sendiri tanpa bantuan orang lain.
                </li>
            </ul>
        </div>
        

    </div>
</body>

</html>