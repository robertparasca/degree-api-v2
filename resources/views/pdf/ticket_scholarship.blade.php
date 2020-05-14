@include('pdf.parts.ticket_head')
<body>

    @include('pdf.parts.ticket_header')
    <div>
        <p>Domnul(a) <span>{{$student->last_name}} {{$student->first_name}}</span> este student(ă) al(a) Facultății de Automatică și Calculatoare, domeniul / programul de studii <span>{{$student->program_of_study}}</span>, anul <span>{{$student->active_year}}</span>, an universitar <span class="b">2019/2020</span>, studii universitare de <span class="b">licență</span>, <span class="b">învățământ cu frecvență</span>, <span class="b">_______________</span>.</p>
        <p>Studentul(a) <span class="b">nu beneficiază</span> de bursă în semestrul <span class="b">II</span>, an universitar <span class="b">2019/2020</span>.</p>
        <p>Se eliberează prezenta adeverință la cererea studentului.</p>
    </div>
</body>
</html>
