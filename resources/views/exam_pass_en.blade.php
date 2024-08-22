<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letter of Graduation</title>
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
            margin: 0px;
        }
    </style>
</head>

<body>
    <img style='float:right' height='64px' src='https://fileserver.telkomuniversity.ac.id/DEV/ADM/logo/rkc6f6KEhnHN7nWpXizaUkqd3li3ZY0xVtRQPVxe.png' />

    <p style='clear:both;'>
        Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $reference_number }} <br>
        Attachment &nbsp;: 6 pages <br>
        Subject &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>{{ "Letter of Graduation Pathway " . $selection_path_name_en . " Academic Year " . $schoolyear }}</b> <br>
    </p>

    <p>
        Bandung, {{ date('d F Y', strtotime($publication_date)) }} <br>
        To <br>
        {{ $pronouns }} <b>{{ strtoupper($name) }}</b> <br>
        Participant's Number <b>{{ $registration_number }}</b> <br>
    </p>

    <p style='text-align: justify;'>
        Dear {{ $pronouns }} {{ $name }}<br>
        We hereby congratulate <b>{{ $pronouns }} {{ $name }} ({{ $registration_number }})</b> on being <b>ACCEPTED</b> as a prospective student in the 
        <b>({{ $program_study_name }})</b>, {{ "in the School of " . $faculty_name_en }} Telkom University Academic Year
        {{ $schoolyear }} based on the Telkom University Committee on the admission of the prospective students of Telkom University through {{ $selection_program_name }}
        Pathway in the Academic Year of {{ $schoolyear }} on {{ date('d F Y', strtotime($council_date)) }}.
    </p>

    <p style='text-align: justify;'>
        In this regard, the following are the details of the total tuition fee and the payment schedule that you must make:
    </p>

    <table style='width:100%;'>
        <tr>
            <th>No</th>
            <th>Description</th>
            <th>Billing Amount</th>
            <th>Payment Schedule</th>
            <th>Billing Number</th>
            <th>Note</th>
        </tr>
        <tr>
            <td>1</td>
            <td><b>Phase 1 : UP3</b><br>Educational Participation Fee (UP3)</td>
            <td><b>{{ "IDR. " . number_format(($up3 - $up3discount), 0, '.', '.') }}</b></td>
            <td style='text-align: center;'>{{ date("d M Y", strtotime($start_date_1)) }} <br>s/d<br> {{ date("d M Y", strtotime($end_date_1)) }}</td>
            <td style='text-align: center;'>2 <b>{{ $registration_number }}</b></td>
            <td style='text-align: center;'>UP3 is paid once at the beginning of the study</td>
        </tr>
        <tr>
            <td>2</td>
            <td><b>Phase 2 : BPP</b><br>Tuition Fee (BPP) for the first semester</td>
            <td><b>{{ "IDR. " . number_format(($bpp - $bppdiscount), 0, '.', '.') }}</b></td>
            <td style='text-align: center;'>{{ date("d M Y", strtotime($start_date_2)) }} <br>s/d<br> {{ date("d M Y", strtotime($end_date_2)) }}</td>
            <td style='text-align: center;'>3 <b>{{ $registration_number }}</b></td>
            <td style='text-align: center;'>BPP is paid every semester</td>
        </tr>
        @if ($category == "PJJ-ONLINE" || $category == "PASCASARJANA" || $category == "EKSTENSI")
        @if ($sdp2 == 0)
        <tr>
            <td>3</td>
            <td><b>Insurance</b></td>
            <td><b>{{ "IDR. " . number_format($insurance, 0, '.', '.') }}</b></td>
            <td style='text-align: center;'>{{ date("d M Y", strtotime($start_date_3)) }} <br>s/d<br> {{ date("d M Y", strtotime($end_date_3)) }}</td>
            <td style='text-align: center;'>4 <b>{{ $registration_number }}</b></td>
            <td style='text-align: center;'>Insurance is paid each semester</td>
        </tr>
        @else
        <tr>
            <td rowspan='2'>3</td>
            <td><b>Phase 3 : SDP2</b><br>Contribution of Educational Development Fund Donation (SDP2) based on the amount you have filled at the time of the registration</td>
            <td><b>{{ "IDR. " . number_format(($sdp2 - $sdp2discount), 0, '.', '.') }}</b></td>
            <td rowspan='2' style='text-align: center;'>{{ date("d M Y", strtotime($start_date_3)) }} <br>s/d<br> {{ date("d M Y", strtotime($end_date_3)) }}</td>
            <td rowspan='2' style='text-align: center;'>4 <b>{{ $registration_number }}</b></td>
            <td style='text-align: center;'>SDP2 is paid once at the beginning of the study</td>
        </tr>
        <tr>
            <td><b>Insurance</b></td>
            <td><b>{{ "IDR. " . number_format($insurance, 0, '.', '.') }}</b></td>
            <td style='text-align: center;'>Insurance is paid each semester</td>
        </tr>
        @endif
        @else
        <tr>
            <td rowspan='3'>3</td>
            <td><b>Phase 3 : SDP2</b><br>Contribution of Educational Development Fund Donation (SDP2) based on the amount you have filled at the time of the registration</td>
            <td><b>{{ "IDR. " . number_format(($sdp2 - $sdp2discount), 0, '.', '.') }}</b></td>
            <td rowspan='3' style='text-align: center;'>{{ date("d M Y", strtotime($start_date_3)) }} <br>s/d<br> {{ date("d M Y", strtotime($end_date_3)) }}</td>
            <td rowspan='3' style='text-align: center;'>4 <b>{{ $registration_number }}</b></td>
            <td style='text-align: center;'>SDP2 is paid once at the beginning of the study</td>
        </tr>
        <tr>
            <td><b>Dormitory</b></td>
            <td><b>{{ "IDR. " . number_format(($dormitory - $dormitorydiscount), 0, '.', '.') }}</b></td>
            <td style='text-align: center;'>Dormitory is paid for the first year only</td>
        </tr>
        <tr>
            <td><b>Insurance</b></td>
            <td><b>{{ "IDR. " . number_format($insurance, 0, '.', '.') }}</b></td>
            <td style='text-align: center;'>Insurance is paid each semester</td>
        </tr>
        @endif
        <tr>
            <td colspan='2' style='text-align: center;'><b>TOTAL AMOUNT</b></td>
            <td><b>IDR. {{ number_format($totalPayment, '0', '.', '.') }}</b></td>
            <td colspan='3' style='text-align: center;'>
                <b>Telkom University Company Code: <br>
                    Mandiri (10020) , BNI (7011)</b><br>
                    Payment procedures of tuition fees can be downloaded in <b>Appendix VI</b>
            </td>
        </tr>
    </table>

    <p style='text-align: justify;'>
        <b>By making the payment of tuition fees listed above, you have acknowledged and agreed with the refund policy for student withdrawals.</b> 
        Refund is only available for candidates who withdraw from registration because they are admitted to state universities via National Entrance 
        Selection of State Universities (SNMPTN) or Joint Entrance Selection of State Universities (SBMPTN), and the withdrawal application must be 
        submitted <b>no later than 7 calendar days after the result of SNMPTN or SBMPTN is announced.</b> In this case, <b>all fees except Education 
        Participation Funding (UP3) will be refunded.</b> The deadline for submitting the withdrawal is 7 calendar days after the announcement of the 
        SNMPTN or SBMPTN.
    </p>

    <p style='text-align: justify;'>
        <b>There will be no refund for student withdrawal for other reasons</b> (refund policy for student withdrawal is included in <b>Appendix V). 
        If no payment is made as scheduled, students are regarded to have cancelled the registration. </b>
    </p>

    <p style='text-align: justify;'>
        Please <b>register online at</b> <a href='http://igracias.telkomuniversity.ac.id/admission'>http://igracias.telkomuniversity.ac.id/admission</a> 
        after paying the tuition fee. You must register online according to the specified schedule. If you do not carry out the registration 
        (registration stages 1 - 3) mentioned above, <b>you will be deemed to have WITHDRAWN</b> and there will be no refund, even though you have 
        made the required payment. The online registration mechanism is as follows:
    </p>

    <div class='page-break'></div>

    <img style='float:right' height='64px' src='https://fileserver.telkomuniversity.ac.id/DEV/ADM/logo/rkc6f6KEhnHN7nWpXizaUkqd3li3ZY0xVtRQPVxe.png' />

    <ol style='clear:both;'>
        <li value='1' style='margin: 10px 0;'>
            Online Registration Stage 1 <br>
            Complete a <b>valid</b> profile at <a href='http://igracias.telkomuniversity.ac.id/admission'>http://igracias.telkomuniversity.ac.id/admission</a><br>
            This step can be done once you have paid the tuition fee for Educational Participation Fee (UP3). The online registration limit for stage 1 or 
            file verification submission is on xxx at the latest (D+7 UP3 payment).<br>
            Online Registration requires you to LOG IN using <br>
            <b>USERNAME / /PARTICIPANT'S NUMBER</b> : {{ $registration_number }}<br>
            <b>PASSWORD</b> : {{ $password }}
        </li>

        <li style='margin: 10px 0;'>
            Online Registration Stage 2<br>
            UPLOAD the documents at <a href='http://igracias.telkomuniversity.ac.id/admission'>http://igracias.telkomuniversity.ac.id/admission</a> as stated in 
            <b>Appendix 1.</b> This step can be done once you have paid the tuition fee in FULL. The deadline for online registration for Stage 2 or submitting 
            file verification is 31 August 2022 at the latest. 
        </li>

        <li>
        	Online Registration Stage 3<br>
            After you have completed the requirements and uploaded the files in the Online Registration Stages 1 and 2, you <b>MUST</b> print out the <b>MINUTES/REPORT. 
            It can be printed if the Registration Stages 1 and 2 have been declared VALID</b> starting <b>on August 1, 2022 and no later than September 2, 2022</b>. 
            If you do not complete the online registration Stage 3 within the specified time, you will be declared withdrawn and there will be no refund.
        </li>
    </ol>

    <p>
        For your information, the schedule of activities carried out for new students will be informed later at <a href='https://pkkmb.telkomuniversity.ac.id/'>https://pkkmb.telkomuniversity.ac.id/</a>
        and Instagram @pkkmb.telkomuniversity. Meanwhile, the information on academic activities can be checked at <a href='https://baa.telkomuniversity.ac.id/'>https://baa.telkomuniversity.ac.id/</a>
        and Instagram @baa.univtelkom.
    </p>

    <p>
        For further information, please contact the following numbers : <br><br>
        <b>National Admission</b><br>
        Telephone : 0811 2025 200 / 0811 2025 300<br>
        Whatsapp : 0811 2233 9123<br>
        Online Registration (WhatsApp) : 0821 2666 6844 / 0812 2490 6096<br><br>
    </p>

    <p>Once again, we extend our congratulations on your admission and we are looking forward to having you join us.</p>

    <p>Sincerely yours, <br>
    <img src="https://fileserver.telkomuniversity.ac.id/exam_pass/warek3.png" width="64px"/><br>
    <u>Dr. Dida Diah Damayanti, ST., M.Eng.Sc</u><br>Vice Rector III Telkom University</p>
    <h2 style='margin-top:36px;'>APPENDIX</h2>
    <p style='font-size:10px'>
        Appendix I : Procedures of Online Registration<br>
        Appendix II : Information Guide after Registration<br>
        Appendix III : Study Integrity Pact<br>
        Appendix IV : Statement of Willingness to Study<br>
        Appendix V : Terms of Tuition Fee Refund<br>
        Appendix VI : Payment Method<br>
    </p>

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0001.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0002.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0003.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0004.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0005.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0006.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0007.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0008.jpg' width='100%' />

    <div class='page-break'></div>
    <img src='https://fileserver.telkomuniversity.ac.id/exam_pass/template/en/0009.jpg' width='100%' />
</body>

</html>