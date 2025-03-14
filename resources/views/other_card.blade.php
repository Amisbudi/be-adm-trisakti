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
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .par-1 {
            margin-top: -80px;
            text-align: center;
            justify-content: center;
            line-height: 0.3;
        }

        .header img {
            max-width: 100px;
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
            font-size: 18px;
            text-align: center;
            line-height: 0.4;
        }

        .content {
            margin-top: 10px;
            font-size: 16px;
            line-height: 1;
        }

        .signature {
            margin-left: 48%;
            text-align: left;
            /* margin-top: 40px; */
        }

        .ttd {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 0;
            right: 0;
        }

        .profile {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 160px;
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
    </style>
</head>

<body>
    <div class="header">
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
    <div class="par-1">
        <p><strong>BUKTI PENDAFTARAN CALON MAHASISWA</strong></p>
        <P><strong style="text-transform: uppercase">{{ $participant->selection_path_name }} </strong></P>
    </div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="text" style="flex-grow: 1; margin-right: 20px;">
            <div>
                <p><strong>1. DATA DIRI</strong></p>
                <table style="margin-left: 15px; border-collapse: collapse; width: 60%; table-layout: auto; font-size: 14px">
                    <tbody>
                        <tr>
                            <td style="padding: 4px; width: 1%; text-align: left;">a.</td>
                            <td style="padding: 4px; width: 20%; text-align: left;">Nama Lengkap</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $participant->fullname }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; width: 1%; text-align: left;">b.</td>
                            <td style="padding: 4px; width: 20%; text-align: left;">Email</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">: {{ $participant->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <p><strong>2. DATA AKADEMIK</strong></p>
                <table style="margin-left: 15px; border-collapse: collapse; width: 60%; table-layout: auto;">
                    <tbody>
                        <tr>
                            <td style="padding: 4px; width: 1%; text-align: left;">a.</td>
                            <td style="padding: 4px; width: 20%; text-align: left;">Peminatan di SLTA</td>
                            <td style="padding: 4px; width: 39%; text-align: left;">:
                                {{ $participant->education_major }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 4px; text-align: left;">b.</td>
                            <td style="padding: 4px; text-align: left;">Nilai Rapor/UTBK</td>
                            <td style="padding: 4px; text-align: left;">:</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="profile"
            style="height: 200px; width: 150px; text-align: center; justify-content: center; align-content: center;">
            <img style="width: 120px; height: 160px; padding: 10px;" src="{{ $participant->photo_url }}" />
        </div>
    </div>

    <p><strong>3. PILIHAN PROGRAM STUDI</strong></p>
    <table style="margin-left: 15px; border-collapse: collapse; width: 40%; table-layout: auto;">
        <tbody>
            @foreach ($program_study as $key => $ps)
                <tr>
                    <td style="padding: 4px; width: 2%; text-align: left;">{{ $key + 1 }}.</td>
                    <td style="padding: 4px; width: 25%; text-align: left;">
                        {{ $ps['study_program_name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p style="margin: 0">Jakarta, {{ date('d F Y') }}</p>
        <p style="margin: 0">
            Penanggung Jawab PMB Universitas Trisakti Tahun Akademik
            {{ $school_year }}
        </p>
        <br>
        <p>TTD</p>
        <br>
        <p>
            Dr. Ir. Muhammad Burhannudinnur, M.Sc., IPU
        </p>
    </div>
</body>

</html>
