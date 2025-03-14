<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bukti Pendaftaran Calon Mahasiswa</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
            height: 60px;
        }

        .par-1 {
            margin-top: -90px;
            text-align: center;
            justify-content: center;
            line-height: 0.3;
        }

        .header img {
            max-width: 70px;
            margin-right: 20px;
        }

        .tr-center th,
        td {
            text-align: center;

        }

        th,
        td {
            line-height: 15px;
        }

        .header h1 {
            font-size: 16px;
            text-align: center;
            line-height: 0.4;
        }

        .content {
            margin-top: 10px;
            font-size: 16px;
            line-height: 1;
        }

        .profile {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 130px;
            right: 0;
        }

        .footer {
            margin-top: 5px;
        }

        .highlight {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        th,
        td {
            font-size: 12px;
            padding: 10px;
            text-align: left;
        }

        .signature-section {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .details p,
        .signature-section p {
            margin: 0;
            font-size: 12px;
        }

        .signature-section .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature div {
            text-align: center;
            width: 40%;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png"
            alt="Logo Universitas Trisakti" />
        <div>
            <h1>TANDA TERIMA</h1>
            <h1>BERKAS PENGUNDURAN DIRI CALON MAHASISWA BARU</h1>
            <h1>UNIVERSITAS TRISAKTI TAHUN AKADEMIK {{ $school_year }}</h1>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="text" style="flex-grow: 1; margin-right: 20px;">
            <div>
                <p style="font-size: 14px">Telah terima dari Calon Mahasiswa :</p>
                <table
                    style="margin-left: 25px; border-collapse: collapse; width: 90%; table-layout: auto; font-size: 14px">
                    <tbody>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Nama Lengkap</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $participant->fullname }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Nomor Pendaftaran</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">:
                                {{ $participant->registration_number }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Fakultas / Jurusan</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">:
                                {{ $registration->faculty . ' / ' . $registration->program_study }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Paket Pembayaran</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $registration->nama_paket }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Alamat</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">:
                                {{ $registration->address_detail }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;"></td>
                            <td style="padding: 4px; width: 39%; text-align: left;">:
                                {{ $registration->address_disctrict_name . ', ' . $registration->address_city_name . ', ' . $registration->address_province_name . ', ' . $registration->address_country_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Telepon</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $participant->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="text" style="flex-grow: 1; margin-right: 20px;">
            <p>Bersama ini dikembalikan jumlah uang yang telah dibayarkan dengan dikurangi biaya administrasi perincian
                sebagai berikut:</p>
            <div style="border: 1px solid #000; padding: 10px 0px 10px 20px; font-size: 12px; margin-right: 20px;">
                <table style="border-collapse: collapse; width: 95%; table-layout: auto; font-size: 14px">
                    <tbody>
                        <tr>
                            <td style="padding: 4px; width: 75%; text-align: left;">Paket A Cicilan 1</td>
                            <td style="padding: 4px; width: 15%; text-align: right; ">{{ "Rp. " . number_format(($refund->biaya_paket), 0, '.', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; text-align: right;" colspan="2">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 75%; text-align: right;">Total Terbayar</td>
                            <td style="padding: 4px; width: 15%; text-align: right; ">{{ "Rp. " . number_format(($refund->biaya_paket), 0, '.', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 75%; text-align: right;">Dikurangi Biaya Administrasi</td>
                            <td style="padding: 4px; width: 15%; text-align: right; ">{{ "Rp. " . number_format(($refund->biaya_admisistrasi), 0, '.', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 75%; text-align: right;"></td>
                            <td style="padding: 4px; width: 15%; text-align: right; ">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 75%; text-align: right;">Yang Dikembalikan</td>
                            <td style="padding: 4px; width: 15%; text-align: right; "><strong>{{ "Rp. " . number_format(($refund->biaya_pengembalian), 0, '.', '.') }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="text" style="flex-grow: 1; margin-right: 20px;">
            <div>
                <p style="font-size: 14px">Yang akan ditransfer paling cepat tanggal
                    {{ date('d - m - Y', strtotime($refund->tanggal_transfer)) }} di Biro Administrasi Keuangan (BAKU)
                    Universitas Trisakti Gedung DR. Syarief Thajeb Lantai 8.</p>
                <table
                    style="margin-left: 25px; border-collapse: collapse; width: 80%; table-layout: auto; font-size: 14px">
                    <tbody>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Atas Nama</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->nama }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Alamat</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">:
                                {{ $refund->alamat }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Identitas</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->identitas }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">No Identitas</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->no_identitas }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">No Rekening</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->no_rek }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Nama Pemilik No Rekening</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->nama_pemilik }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Bank</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->nama_bank }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 20%; text-align: left;">Hubungan dengan Pemilik</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $refund->hubungan_pemilik }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="signature-section">
        <div class="signature" style="display: flex; justify-content: space-between;">
            <div style="margin-right: 400px;">
                <p>Yang menyerahkan berkas asli,</p>
                <p>Orang Tua/Wali/Mahasiswa</p>
                <p style="margin-top: 60px;">(.........................................)</p>
                <p>Nama Terang</p>
            </div>
            <div style="margin-left: 400px;">
                <p>{{ date('d - m - Y') }}</p>
                <p>Yang menerima berkas,</p>
                <p style="margin-top: 60px;">(.........................................)</p>
                <p>Nama Terang</p>
            </div>
        </div>
    </div>
</body>

</html>
