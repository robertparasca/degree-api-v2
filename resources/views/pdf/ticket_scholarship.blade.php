@include('pdf.parts.ticket_head')
<body>

    @include('pdf.parts.ticket_header')

    <div>
        <p>Domnul(a) <span>{{$student->last_name}} {{$student->first_name}}</span> este student(ă) al(a) Facultății de Automatică și Calculatoare, domeniul / programul de studii <span>{{$student->active_year !== 'I' || $student->active_year !== 'II' ? $student->program_of_study : $student->field_of_study }}</span>, anul <span>{{$student->active_year}}</span>, an universitar <span>{{$activeYear}}</span>, studii universitare de <span>{{$cycleOfStudy}}</span>, <span>{{$student->is_ID ? 'învățământ fără frecvență' : 'învățământ cu frecvență'}}</span>, în limba <span>{{$student->language == 0 ? 'română' : 'engleză'}}</span>.</p>
        @if(!$scholarship)
            <p>Studentul(a) <span>nu beneficiază</span> de bursă în semestrul <span>{{$isFirstSemester ? 'I' : 'II'}}</span>, an universitar <span>{{$activeYear}}</span>.</p>
        @endif
        @if($scholarship)
            <p>Studentul(a) <span>beneficiază</span> de bursă de <span>{{strtolower($scholarship->type)}}</span> în semestrul <span>{{$isFirstSemester ? 'I' : 'II'}}</span>, an universitar <span>{{$activeYear}}</span>, cuantumul bursei fiind de <span>{{$scholarship->amount}}</span> lei/lună.</p>
        @endif
        <p>Se eliberează prezenta adeverință la cererea studentului.</p>
    </div>

    @include('pdf.parts.ticket_footer')

</body>
</html>
