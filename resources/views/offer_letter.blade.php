<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Penerimaan Mahasiswa Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
            line-height: 1.4;
        }

        h2,
        h3 {
            text-align: center;
        }

        .content {
            margin-top: 40px;
        }

        .section {
            margin-top: 5px;
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
            line-height: 1;
            /* lebih pendek */
        }

        td:first-child {
            padding-left: 20px;
            /* seperti margin-left untuk kolom pertama */
        }

        p {
            line-height: 1.2;
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
            Sdr/i. {{ $family->family_name }},<br>
            Orang Tua Calon Mahasiswa</p>

        <p>Diberitahukan dengan hormat, bahwa Calon Mahasiswa Universitas Trisakti dibawah ini:</p>

        <p>Nama: <strong>{{ $name }}</strong><br>
            No. Peserta: <strong>{{ $registration_number }}</strong></p>

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
                @foreach ($packages as $item)
                    @if (isset($item['package']) && $item['package']->angsuran == 1)
                        @php
                            $detail = $item['details'][0];
                            if ($rank == 1) {
                                $bpp = ($biaya->bpp_i * $detail->bpp) / 100;
                            } elseif ($rank == 2) {
                                $bpp = ($biaya->bpp_ii * $detail->bpp) / 100;
                            } elseif ($rank == 3) {
                                $bpp = ($biaya->bpp_iii * $detail->bpp) / 100;
                            } else {
                                $bpp = 0;
                            }
                            $praktikum = ($detail->praktikum / 100) * $biaya->praktikum;
                            $bppsks = ($detail->bpp_sks / 100) * $biaya->bpp_sks * $sks;
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
                                $spp = ($biaya->spp_i * $detail->spp) / 100;
                            } elseif ($rank == 2) {
                                $spp = ($biaya->spp_ii * $detail->spp) / 100;
                            } elseif ($rank == 3) {
                                $spp = ($biaya->spp_iii * $detail->spp) / 100;
                            } else {
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
                            <td>Biaya Penyelenggaraan Pendidikan - SKS (tiap semester) ({{ $sks }} sks X Rp.
                                {{ number_format($biaya->bpp_sks, '0', '.', '.') }})</td>
                            <td>Rp. {{ number_format($bppsks, '0', '.', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Dana Kesejahteraan Mahasiswa (tiap tahun)</td>
                            <td>Rp 0,00</td>
                        </tr>
                        @php
                            $totalA = $bpp + $praktikum + $spp + $bppsks;
                        @endphp
                        <tr>
                            <td>Total Pembayaran</td>
                            <td><strong>Rp. {{ number_format($totalA, '0', '.', '.') }}</strong></td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Dibayar mulai
                        {{ \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($publication_date)->addDays(22)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td><strong>Total Pembayaran Paket A</strong></td>
                    <td><strong>Rp {{ number_format($totalA, '0', '.', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table>
                <tr>
                    <th>B</th>
                    <th></th>
                </tr>
                @foreach ($packages as $item)
                    @if (isset($item['package']) && $item['package']->angsuran > 1)
                        @php
                            $grandTotal = 0;
                            $totalB = 0;
                        @endphp
                        @foreach ($item['details'] as $detail)
                            @php
                                $bpp = ($detail->bpp / 100) * $biaya->bpp_i;
                                $praktikum = ($detail->praktikum / 100) * $biaya->praktikum;
                                $bppsks = ($detail->bpp_sks / 100) * $biaya->bpp_ii * $sks;
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
                                    $spp = ($biaya->spp_i * $detail->spp) / 100;
                                } elseif ($rank == 2) {
                                    $spp = ($biaya->spp_ii * $detail->spp) / 100;
                                } elseif ($rank == 3) {
                                    $spp = ($biaya->spp_iii * $detail->spp) / 100;
                                } else {
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
                                <td>Biaya Penyelenggaraan Pendidikan - SKS (tiap semester) ({{ $sks }} sks X
                                    Rp. {{ number_format($biaya->spp_ii, '0', '.', '.') }})</td>
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
                            @php
                                if($detail->angsuran_ke == 1){
                                    $totalB = $total;
                                }
                                $grandTotal = $grandTotal + $total;
                            @endphp
                        @endforeach
                    @endif
                @endforeach
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Dibayar mulai
                        {{ \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($publication_date)->addDays(22)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td><strong>Total Pembayaran Paket B</strong></td>
                    <td><strong>Rp. {{ number_format($grandTotal, '0', '.', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="section">
            @php
                $transaction_billing = json_decode($transaction_billing);
            @endphp
            <p>Pembayaran dapat dilakukan secara Online di seluruh Cabang BNI atau ATM BNI atau Internet/Mobile Banking
                BNI di Indonesia dengan
                menggunakan nomor Virtual Account {{ (isset($transaction_billing->virtual_account)) ? '<strong>'. $transaction_billing->virtual_account. '</strong>' . 'yang telah dibuat saat' : 'yang dapat dibuat setelah' }} anda memilih paket pembayaran. Kami
                menyediakan cara pembayaran:</p>
            <p style="margin-top: 10px;">
            <ol>
                <li>
                    <strong>Paket A</strong>: dibayar lunas sebesar <strong>Rp. {{ number_format($totalA, '0', '.', '.') }}</strong>
                    tanggal: <strong>
                        {{ \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($publication_date)->addDays(22)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}</strong>
                </li>
                <li>
                    <strong>Paket B</strong>: dibayar pertama sebesar <strong>Rp. {{ number_format($totalB, '0', '.', '.') }}</strong>
                    tanggal: <strong>
                        {{ \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($publication_date)->addDays(22)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}</strong>,
                    sisanya <strong>Rp. {{ number_format($grandTotal - $totalB, '0', '.', '.') }}</strong>
                    dibayar 3x angsuran setiap bulan terhitung mulai bulan <strong>Juni 2025</strong>
                </li>
            </ol>
            </p>

            <p>Apabila Saudara mendapat kesulitan tentang pembayaran di Bank BNI setempat/ATM atau Mobile/Internet
                banking, Saudara dapat menghubungi Bank BNI Trisakti Telp. (021) 5656466 Senin-Jumat pada jam kerja,
                atau WA ke Barensif nomor 082110002227</p>

            <p>Setelah melalukan pembayaran, saudara diwajibkan melakukan registrasi untuk melengkapi persyaratan
                akademik (persyaratan akademik
                dapat dilihat di petunjuk teknis Penerimaan Mahasiswa Baru Universitas Trisakti yang dapat di unduh di
                https://admisi.trisakti.ac.id)</p>

            <p>Untuk penjelasan lebih lanjut, Saudara dapat menghubungi Kabag Tata Usaha FEB di KAMPUS A, GEDUNG S LT. 4
                atau telp: 62-21-5644270, 62-21-5644271 <br> Demikian, yang dapat disampaikan. Atas perhatian Saudara
                diucapkan terima kasih.
            </p>
        </div>

        <div class="section">
            <p>Untuk pertanyaan lebih lanjut:<br>
                Hubungi: Kabag Tata Usaha FEB<br>
                Lokasi: Kampus A, Gedung S Lt. 4<br>
                Telp: (021) 5644270 / 5644271</p>
        </div>

        <p style="margin-top: 40px;">Jakarta, {{ \Carbon\Carbon::parse($publication_date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('d F Y') }}<br>
            Koordinator/Penanggung Jawab Penyelenggaraan PMB {{ $schoolyear }}</p>

        <p>
            <br>
            <br>
            <br>
            <br>
            <strong>Dr. Ir. Muhammad Burhannudinnur, M.Sc., IPU</strong></p>
    </div>

</body>

</html>
