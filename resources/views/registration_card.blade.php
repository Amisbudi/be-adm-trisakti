<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Card</title>

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
            margin-right: 130px;
            text-align: left;
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

        .right img {
            margin-top: 24px;
        }

        .header::after {
            clear: both;
        }

        .participant-data {
            margin-top: 2%;
            width: 100%;
            padding: 1%;
        }

        .participant-data-item {
            width: 100%;
            text-align: center;
            padding: 10px;
        }

        .participant-data-item img {
            max-width: 200px;
            max-height: 100px;
        }

        .participant-data-item-2 {
            width: 100%;
        }

        .participant-data-item-2 table td {
            padding-left: 5px;
            padding-right: 5px;
        }

        .participant-session {
            width: 100%;
            margin-top: 1%;
            padding: 1%;
        }

        .participant-session .participant-session-table-data table td {
            margin-left: 5px;
            margin-right: 5px;
        }

        .participant-session .participant-session-table-session table {
            margin-top: 1%;
            border-collapse: collapse;
            width: 100%;
        }

        .participant-session .participant-session-table-session table th,
        .participant-session .participant-session-table-session table td {
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        .participant-session .participant-session-table-session table th {
            background-color: #283891;
            color: #ffffff;
        }

        .participant-session .participant-session-table-session table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .participant-program-study {
            width: 100%;
            margin-top: 1%;
            padding: 1%;
        }

        .participant-program-study table {
            border-collapse: collapse;
            width: 100%;
        }

        .participant-program-study table th,
        .participant-program-study table td {
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        .participant-program-study table th {
            background-color: #283891;
            color: #ffffff;
        }

        .participant-program-study table tr:nth-child(even) {
            background-color: #f2f2f2
        }

        .participant-announcement {
            width: 100%;
            padding: 1%;
        }

        .participant-announcement table {
            border-collapse: collapse;
            width: 100%;
        }

        .participant-announcement table th,
        .participant-announcement table td {
            text-align: left;
            padding: 8px;
            text-align: center;
        }

        .participant-announcement table th {
            background-color: #283891;
            color: #ffffff;
        }

        .participant-announcement table tr:nth-child(even) {
            background-color: #f2f2f2
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.5cm;
        }

        .date-w {
            width: 20%;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="main">
            <h2>Kartu Peserta<br>Seleksi Mahasiswa Baru</h2>
            <p>Tahun Ajaran {{ $school_year }}</p>
            <p style="font-size: small;">Jl. Kyai Tapa No.1, RT.6/RW.16, Grogol, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11440<br>spmb.trisakti.ac.id</p>
        </div>
        <div class="right">
            <img src='https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png' width="100px" />
        </div>
    </div>
    <hr>
    <div class="participant-data">
        <b>Data Peserta Mahasiswa Baru</b>
        <hr>
        <div class="participant-data-item">
            <img src="{{ $participant->photo_url }}" />
        </div>
        <div class="participant-data-item-2">
            <table>
                <tr>
                    <td>Nomor Peserta</td>
                    <td>:</td>
                    <td>{{ $participant->registration_number }}</td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>:</td>
                    <td>{{ $participant->fullname }}</td>
                </tr>
                <tr>
                    <td>Nomor Ponsel</td>
                    <td>:</td>
                    <td>{{ $participant->mobile_phone_number }}</td>
                </tr>
                <tr>
                    <td>Jalur Seleksi</td>
                    <td>:</td>
                    <td>{{ $participant->selection_path_name }}</td>
                </tr>
                @if ($participant_tpa != null)
                <tr>
                    <td>Jadwal TPA</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($participant_tpa->exam_start_date)->format('d F Y') . ' (' . \Carbon\Carbon::parse($participant_tpa->exam_start_date)->format('H:i') . ' - ' . \Carbon\Carbon::parse($participant_tpa->exam_end_date)->format('H:i') . ')' }}</td>
                </tr>
                @endif
                @if ($participant_interview != null)
                <tr>
                    <td>Jadwal Interview</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($participant_interview->exam_start_date)->format('d F Y') . ' (' . \Carbon\Carbon::parse($participant_interview->exam_start_date)->format('H:i') . ' - ' . \Carbon\Carbon::parse($participant_interview->exam_end_date)->format('H:i') . ')' }}</td>
                </tr>
                @endif
                @if ($participant_psychological != null)
                <tr>
                    <td>Jalur Psikotes</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($participant_psychological->exam_start_date)->format('d F Y') . ' (' . \Carbon\Carbon::parse($participant_psychological->exam_start_date)->format('H:i') . ' - ' . \Carbon\Carbon::parse($participant_psychological->exam_end_date)->format('H:i') . ')' }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
    @if ($participant->exam_status_id == 2)
    <div class="participant-session">
        <b>Data Pelaksanaan Ujian</b>
        <hr>
        <div class="participant-session-table-data">
            <table>
                <tr>
                    <td>Status Ujian</td>
                    <td>:</td>
                    <td>{{ $participant->exam_status }}</td>
                </tr>
                @if($participant->exam_status_id == 2)
                <tr>
                    <td>Kategori Kursus Ujian</td>
                    <td>:</td>
                    <td>{{ $participant_cbt->moodle_category_name }}</td>
                </tr>
                <tr>
                    <td>Nama Kursus Ujian</td>
                    <td>:</td>
                    <td>{{ $participant_cbt->moodle_course_name }}</td>
                </tr>
                <tr>
                    <td>Situs Pelaksanaan</td>
                    <td>:</td>
                    <td><a href="https://dev-trisakti.seculab.space/login/index.php">https://dev-trisakti.seculab.space/login/index.php</a></td>
                </tr>
                @else
                <tr>
                    <td>Lokasi Pelaksanaan</td>
                    <td>:</td>
                    @if($participant->location == null || $participant->location == "")
                    <td>-</td>
                    @else
                    <td>{{ $participant->location }}</td>
                    @endif
                </tr>
                @endif
            </table>
        </div>
        @if($participant->exam_status_id == 1 or $participant->exam_status_id == 2)
        <div class="participant-session-table-session">
            <table>
                <tr>
                    <th>Sesi</th>
                    <th>Nama Sesi</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                </tr>
                @foreach ($sessions as $session)
                <tr>
                    <td>{{ $session['session'] }}</td>
                    <td>{{ $session['session_name'] }}</td>
                    <td>{{ $session['session_start'] }}</td>
                    <td>{{ $session['session_end'] }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <p style="color: red;"><i>*Gunakan akun pendaftaran sebagai autentifikasi untuk masuk kedalam website pelaksaan ujian</i></p>
        @endif
    </div>
    @endif
    <div class="participant-program-study">
        <b>Pilihan Program Studi</b>
        <hr>
        <table>
            @if($participant->category == "PJJ-ONLINE" or $participant->category == "PASCASARJANA")
            <tr>
                <th>Prioritas</th>
                <th>Fakultas</th>
                <th>Program Studi</th>
                <th>Konsentrasi</th>
                <th>Kelas</th>
            </tr>
            @foreach($program_study as $ps)
            <tr>
                <td>{{ $ps['priority'] }}</td>
                <td>{{ $ps['faculty_name'] }}</td>
                <td>{{ $ps['study_program_name'] }}</td>
                <td>{{ $ps['specialization_name_ori'] }}</td>
                <td>{{ $ps['class_type'] }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <th>Prioritas</th>
                <th>Fakultas</th>
                <th>Program Studi</th>
                <th>Besaran SDP 2</th>
            </tr>
            @foreach($program_study as $ps)
            <tr>
                <td>{{ $ps['priority'] }}</td>
                <td>{{ $ps['faculty_name'] }}</td>
                <td>{{ $ps['study_program_name'] }}</td>
                <td>{{ "Rp " . number_format($ps['education_fund'] + $ps['minimum_donation']) }}</td>
            </tr>
            @endforeach
            @endif
        </table>
    </div>
    <footer><i style="font-size: 13px;">{{ 'Dicetak di Universitas Trisakti ' . date('d F Y') }}</i></footer>
</body>

</html>