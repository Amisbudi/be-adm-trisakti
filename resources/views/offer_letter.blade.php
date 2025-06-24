<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Penerimaan Mahasiswa Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.6;
        }

        h2,
        h3 {
            text-align: center;
        }

        .content {
            margin-top: 30px;
        }

        .section {
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid black;
            /* hanya border luar */
        }

        th,
        td {
            border: none;
            /* hilangkan border antar sel */
            padding: 4px 6px;
            /* lebih rapat */
            text-align: left;
            line-height: 1.2;
            /* lebih pendek */
        }

        td:first-child {
            padding-left: 20px;
            /* seperti margin-left untuk kolom pertama */
        }
    </style>
</head>

<body>
    <img style='float:left' height='96px'
        src='https://fileserver.telkomuniversity.ac.id/dev-trisakti/DEV/ADM/logo/trisakti.png' />

    <h2>UNIVERSITAS TRISAKTI <br>JAKARTA</h2>

    <div class="content">
        <p> NOMOR : {{ $reference_number == null ? '-' : $reference_number }}<br>
            Lampiran: - <br>
            Perihal: Pemberitahuan diterima sebagai calon Mahasiswa di Universitas Trisakti</p>

        <p>Kepada Yth:<br>
            Sdr. Lilis Syuryanah,<br>
            Orang Tua Calon Mahasiswa</p>

        <p>Diberitahukan dengan hormat, bahwa Calon Mahasiswa Universitas Trisakti dibawah ini:</p>

        <p>Nama: <strong>ANGELITA GEOVANIA</strong><br>
            No. Peserta: <strong>25400148</strong></p>

        <p>Dinyatakan <strong>LULUS</strong> melalui {{ $selection_path_name }} Universitas Trisakti Tahun Akademik
            {{ $schoolyear }} Periode
            {{ \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F Y') }}.<br>
            Putra/putri Saudara dapat diterima pada:</p>

        <p>Fakultas: <strong>{{ $faculty_name }}</strong><br>
            Program Studi: <strong>{{ $program_study_name }}</strong><br>
            Peringkat: <strong>{{ $rank }}</strong></p>

        <div class="section">
            <p>Berdasarkan peringkat tersebut, kami tetapkan biaya yang harus dibayar adalah sebagai beriku</p>
            <table>
                <tr>
                    <th colspan="2"><strong>A</strong></th>
                </tr>
                <tr>
                    <th>Dibayar Sekali</th>
                    <th></th>
                </tr>
                @foreach($packages as $item)
                @if(isset($item['package']) && $item['package']->angsuran == 1)
                @php
                    $detail = $item['details'][0];
                    $bpp = $detail->bpp / 100 * $biaya->bpp_i;
                    $praktikum = $detail->praktikum / 100 * $biaya->praktikum;
                    $bppsks = $detail->bpp_sks / 100 * $biaya->bpp_ii * $sks;
                @endphp
                <tr>
                    <td>Sumbangan Pengembangan</td>
                    <td>Rp. {{ number_format($bpp, '0', '.', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Praktikum</td>
                    <td>Rp. {{ number_format($praktikum, '0', '.', '.') }}</td>
                </tr>
                @php
                    if ($rank == 1) {
                        $spp = $biaya->spp_i * $detail->spp / 100;
                    }else if ($rank == 2){
                        $spp = $biaya->spp_ii  * $detail->spp / 100;
                    }else if( $rank == 3){
                        $spp = $biaya->spp_iii  * $detail->spp / 100;
                    }else{
                        $spp = 0;
                    }
                @endphp
                <tr>
                    <td>Tuition Fee Package</td>
                    <td>Rp. {{ number_format($spp, '0', '.', '.') }}</td>
                </tr>
                <tr>
                    <td>Registration (tiap tahun)</td>
                    <td>Rp 0,00</td>
                </tr>
                <tr>
                    <td>Biaya Penyelenggaraan Pendidikan - SKS (tiap semester) ({{ $sks }}sks X Rp325000.00)</td>
                    <td>Rp. {{ number_format($bppsks, '0', '.', '.') }}</td>
                </tr>
                <tr>
                    <td>Dana Kesejahteraan Mahasiswa (tiap tahun)</td>
                    <td>Rp 0,00</td>
                </tr>
                @php
                    $total = $bpp + $praktikum + $spp + $bppsks;
                @endphp
                <tr>
                    <td>Total Pembayaran</td>
                    <td><strong>Rp. {{ number_format($total, '0', '.', '.') }}</strong></td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Dibayar mulai 4 May 2025 s/d 4 May 2025</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Total Pembayaran Paket A</td>
                    <td><strong>Rp {{ number_format($total, '0', '.', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th>B</th>
                    <th></th>
                </tr>
                @foreach($packages as $item)
                @if(isset($item['package']) && $item['package']->angsuran > 1)
                @php
                    $detail = $item['details'][0];
                    $bpp = $detail->bpp / 100 * $biaya->bpp_i;
                    $praktikum = $detail->praktikum / 100 * $biaya->praktikum;
                    $bppsks = $detail->bpp_sks / 100 * $biaya->bpp_ii * $sks;
                @endphp
                <tr>
                    <th>Cicilan Ke - {{ $detail->angsuran_ke }}</th>
                    <th></th>
                </tr>
                <tr>
                    <td>Sumbangan Pengembangan</td>
                    <td>Rp. {{ number_format($bpp, '0', '.', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Praktikum</td>
                    <td>Rp. {{ number_format($praktikum, '0', '.', '.') }}</td>
                </tr>
                @php
                    if ($rank == 1) {
                        $spp = $biaya->spp_i * $detail->spp / 100;
                    }else if ($rank == 2){
                        $spp = $biaya->spp_ii  * $detail->spp / 100;
                    }else if( $rank == 3){
                        $spp = $biaya->spp_iii  * $detail->spp / 100;
                    }else{
                        $spp = 0;
                    }
                @endphp
                <tr>
                    <td>Tuition Fee Package</td>
                    <td>Rp. {{ number_format($spp, '0', '.', '.') }}</td>
                </tr>
                <tr>
                    <td>Registration (tiap tahun)</td>
                    <td>Rp 0,00</td>
                </tr>
                <tr>
                    <td>Biaya Penyelenggaraan Pendidikan - SKS (tiap semester) ({{ $sks }}sks X Rp325000.00)</td>
                    <td>Rp. {{ number_format($bppsks, '0', '.', '.') }}</td>
                </tr>
                <tr>
                    <td>Dana Kesejahteraan Mahasiswa (tiap tahun)</td>
                    <td>Rp 0,00</td>
                </tr>
                @php
                    $total = $bpp + $praktikum + $spp + $bppsks;
                @endphp
                <tr>
                    <td>Total </td>
                    <td><strong>Rp. {{ number_format($total, '0', '.', '.') }}</strong></td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>Rp 17.750.000,00</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <p>Pembayaran dapat dilakukan secara Online di seluruh Cabang BNI atau ATM BNI atau Internet/Mobile Banking
                BNI di Indonesia dengan
                menggunakan nomor Virtual Account yang dapat dibuat setelah anda memilih paket pembayaran. Kami
                menyediakan cara pembayaran:</p>
            <p style="margin-top: 10px;">
            <ol>
                <li>
                    <strong>Paket A</strong>: dibayar lunas sebesar <strong>Rp 17.750.000,00</strong>
                    tanggal: <strong>4 Mei 2025 s/d 26 Mei 2025</strong>
                </li>
                <li>
                    <strong>Paket B</strong>: dibayar pertama sebesar <strong>Rp 6.687.500,00</strong>
                    tanggal: <strong>4 Mei 2025 s/d 26 Mei 2025</strong>, sisanya <strong>Rp 11.062.500,00</strong>
                    dibayar 3x angsuran setiap bulan terhitung mulai bulan <strong>Juni 2025</strong>
                </li>
            </ol>
            </p>

            <p>Apabila Saudara mendapat kesulitan tentang pembayaran di Bank BNI setempat/ATM atau Mobile/Internet banking, Saudara dapat menghubungi Bank BNI Trisakti Telp. (021) 5656466 Senin-Jumat pada jam kerja, atau WA ke Barensif nomor 082110002227</p>

            <p>Setelah melalukan pembayaran, saudara diwajibkan melakukan  registrasi untuk melengkapi persyaratan akademik (persyaratan akademik
                dapat dilihat di petunjuk teknis Penerimaan Mahasiswa Baru Universitas Trisakti yang dapat di unduh di https://admisi.trisakti.ac.id)</p>

            <p>Untuk penjelasan lebih lanjut, Saudara dapat menghubungi Kabag Tata Usaha FEB di KAMPUS A, GEDUNG S LT. 4 atau telp: 62-21-5644270, 62-21-5644271 <br> Demikian, yang dapat disampaikan. Atas perhatian Saudara diucapkan terima kasih.
            </p>
        </div>

        <div class="section">
            <p>Untuk pertanyaan lebih lanjut:<br>
                Hubungi: Kabag Tata Usaha FEB<br>
                Lokasi: Kampus A, Gedung S Lt. 4<br>
                Telp: (021) 5644270 / 5644271</p>
        </div>

        <p style="margin-top: 40px;">Jakarta, 5 Mei 2025<br>
            Koordinator/Penanggung Jawab Penyelenggaraan PMB 2025/2026</p>

        <p><strong>Dr. Ir. Muhammad Burhannudinnur, M.Sc., IPU</strong></p>
    </div>

</body>

</html>
