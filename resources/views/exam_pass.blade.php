<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Kelulusan</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        html,
        table {
            font-size: 13px;
            font-family: Segoe UI, Tahoma, sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 3px solid black;
        }

        p {
            margin-bottom: 10px;
        }

        template {
            margin: 0;
        }
    </style>
</head>

<body>
    <img style='float:right' height='96px' src='https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png' />

    <p style='clear:both;'>
        Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ ($reference_number == null) ? '-' : $reference_number }} <br>
        Lampiran &nbsp;: 6 lembar <br>
        Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>{{ "Surat Kelulusan " . $selection_path_name . " Tahun Akademik " . $schoolyear }}</b> <br>
    </p>

    <p>
        Bandung, {{  \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }} <br>
        Kepada Yth. <br>
        Saudara <b>{{ strtoupper($name) }}</b> <br>
        Nomor Peserta <b>{{ $registration_number }}</b> <br>
    </p>

    @if ($transfer_status == true)
    <p style='text-align: justify;'>
        Dengan Hormat, <br>
        Sehubung dengan nilai Saudara <b>{{ $name }} ({{ $registration_number }})</b> yang belum memenuhi passing grade untuk lulus di prodi 
        yang Saudara pilih namun cukup untuk diterima di prodi lainnya, maka Saudara kami tawarkan <b> LULUS</b> di Program Studi 
        <b>({{ $transfer_program_study_name }})</b>, {{ "Fakultas " . $transfer_faculty_name }} Universitas Trisakti Tahun Akademik
        {{ $schoolyear }} sesuai dengan sidang kelulusan calon mahasiswa baru Universitas Trisakti Jalur {{ $selection_program_name }}
        Tahun Akademik {{ $schoolyear }}
    </p>
    @else
    <p style='text-align: justify;'>
        Dengan Hormat, <br>
        Dengan ini kami ucapkan selamat kepada <b>{{ $name }} ({{ $registration_number }})</b> telah <b>DITERIMA</b> sebagai calon
        mahasiswa di Program Studi <b>({{ $program_study_name }})</b>, {{ "Fakultas " . $faculty_name }} Universitas Trisakti Tahun Akademik
        {{ $schoolyear }} sesuai dengan sidang kelulusan calon mahasiswa baru Universitas Trisakti Jalur {{ $selection_path_name }}
        Tahun Akademik {{ $schoolyear }}
    </p>
    @endif

    <p style='text-align: justify;'>
        Sehubungan dengan hal tersebut, berikut rincian total biaya pendidikan dan jadwal pembayaran yang wajib Saudara
        lakukan :
    </p>

    <table style='width:100%;'>
        <tr>
            <th>No</th>
            <th>Uraian</th>
            <th>Jumlah Tagihan</th>
            <th>Jadwal Pembayaran</th>
            <th>Nomor Tagihan</th>
        </tr>
        @if($transaction_billing != null)
        @foreach ($transaction_billing['bills_detail'] as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><b>{{ $item['bills_name'] }}</b></td>
                <td><b>{{ "Rp. " . number_format(($item['cost']), 0, '.', '.') }}</b></td>
                <td style='text-align: center;'>{{  \Carbon\Carbon::parse($start_date_payment)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d M Y') . ' - ' . \Carbon\Carbon::parse($end_date_payment)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d M Y') }}</td>
                <td style='text-align: center;'>{{ $virtual_account }}</td>
            </tr>
        @endforeach
        @endif
        <tr>
            <td colspan='2' style='text-align: center;'><b>TOTAL BIAYA</b></td>
            <td><b>Rp. {{ number_format($total_cost, '0', '.', '.') }}</b></td>
            <td colspan='2' style='text-align: center;'>
                <b>Kode Perusahaan Universitas Trisakti :<br>
                    Mandiri (-) , BNI (-)</b><br>
                Petunjuk pembayaran biaya pendidikan dapat dilihat pada <b>Lampiran VI</b>
                di Surat Kelulusan ini
            </td>
        </tr>
    </table>

    <p style='text-align: justify;'>
        Dengan melakukan pembayaran biaya pendidikan yang tertera di atas, maka Saudara telah mengetahui dan menyetujui
        ketentuan pengembalian dana undur diri, dimana pengembalian biaya pendidikan hanya dapat dilakukan bagi calon
        mahasiswa yang mengundurkan diri karena diterima dijalur <b>SNMPTN atau SBMPTN</b>, dengan komponen biaya yang
        dikembalikan adalah <b>total yang sudah dibayarkan dikurangi biaya sebesar Uang Partisipasi Penyelenggaraan
            Pendidikan (UP3).</b> Adapun Batas waktu pengajuan undur diri yakni <b>maksimal 7 hari kalender setelah pengumuman
            SNMPTN atau SBMPTN.</b>
    </p>

    <p style='text-align: justify;'>
        <b>Pengajuan undur diri di luar ketentuan tersebut di atas maka tidak ada pengembalian dana.</b> (Ketentuan pengembalian
        dana undur diri dapat dilihat pada <b>Lampiran V</b>). <b>Apabila tidak melakukan pembayaran sesuai dengan batas waktu
            yang telah ditentukan di atas, maka dianggap mengundurkan diri.</b>
    </p>

    <p style='text-align: justify;'>
        Silahkan Saudara melakukan registrasi online di <a href='https://admisi.trisakti.ac.id/'>https://admisi.trisakti.ac.id/</a> setelah melakukan
        pembayaran biaya pendidikan. Calon mahasiswa baru wajib melaksanakan <b>registrasi online</b> sesuai jadwal yang
        ditentukan. Apabila tidak melaksanakan registrasi tersebut dianggap <b>mengundurkan diri,</b> meskipun telah melakukan
        pembayaran sesuai yang dipersyaratkan. Mekanisme registrasi online adalah sebagai berikut:
    </p>

    <div class='page-break'></div>

    <img style='float:right' height='96px' src='https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png' />

    <ol style='clear:both;'>
        <li value='1' style='margin: 10px 0;'>
            Registrasi Online Tahap 1 <br>
            Calon mahasiswa mengisi biodata secara <b>valid</b> melalui <a href='https://admisi.trisakti.ac.id/'>https://admisi.trisakti.ac.id/</a><br>
            Registrasi Online Tahap 1 dapat dilakukan jika Saudara sudah melakukan pembayaran biaya pendidikan Uang
            Partisipasi Penyelenggaraan Pendidikan (UP3). Batas registrasi online tahap 1 atau pengajuan verifikasi berkas<br>
            Registrasi Online mewajibkan calon mahasiswa LOG IN dengan menggunakan :<br>
            <b>USERNAME / NO PESERTA</b> : {{ $registration_number }}<br>
            <b>PASSWORD</b> : {{ $password }}
        </li>

        <li style='margin: 10px 0;'>
            Registrasi Online Tahap 2 <br>
            Calon mahasiswa melakukan UPLOAD berkas melalui <a href='https://admisi.trisakti.ac.id/'>https://admisi.trisakti.ac.id/</a> sesuai pada
            <b>lampiran I.</b> Registrasi Online Tahap 2 dapat dilakukan apabila sudah melakukan pembayaran biaya pendidikan
            secara <b> LUNAS.</b>
        </li>

        <li>
            Registrasi Online Tahap 3 <br>
            Setelah Saudara melengkapi persyaratan dan upload berkas di Registrasi Online Tahap 1 dan 2, calon mahasiswa
            <b> WAJIB</b> mencetak <b>BERITA ACARA . BERITA ACARA</b> dapat dicetak apabila <b>Registrasi Tahap 1 dan 2 telah dinyatakan VALID </b>
            Apabila tidak menyelesaikan registrasi online tahap 3 dengan waktu yang telah ditentukan maka dinyatakan mengundurkan diri dan tidak ada pengembalian.
        </li>
    </ol>

    <p>
        Sebagai informasi, jadwal kegiatan yang dilaksanakan untuk mahasiswa baru akan diinformasikan berikutnya pada laman
        <a href="http://pkkmb.trisakti.ac.id/login">http://pkkmb.trisakti.ac.id/login</a>  dan Instagram @pmb.usakti
    </p>

    <p>
        Untuk Informasi, Silahkan hubungi nomor dibawah ini :<br><br>
        <b>Admisi Nasional</b><br>
        Telepon : (+62) 5663232<br>
    </p>

    <p>Demikian disampaikan, kami ucapkan selamat atas keberhasilan Saudara.</p>

    <p>Hormat Kami, <br>
    <img src="https://www.smartgetspaid.com/wp-content/uploads/2018/11/B_signed3-01-crop.png" width="64px"/><br>
    <u>- </u><br>Wakil Rektor III Universitas Trisakti</p>
    <h2 style='margin-top:36px;'>LAMPIRAN</h2>
    <p style='font-size:10px'>
        Lampiran I : Petunjuk REGISTRASI ON-LINE<br>
        Lampiran II : Petunjuk Pelaksanaan REGISTRASI ON-SITE<br>
        Lampiran III : Pakta Integritas Studi<br>
        Lampiran IV : Pernyataan Beasiswa<br>
        Lampiran V : Ketentuan Pengembalian Dana Undur Diri<br>
        Lampiran VI : Tata Cara Pembayaran Biaya Kuliah<br>
    </p>
</body>

</html>