@include('pdf.parts.ticket_head')
<body>

    @include('pdf.parts.ticket_header')

    <div>
        <p>Studentul(a) <span>{{$student->last_name}} {{$student->first_name}}</span> este înscris(ă) în anul <span>{{$activeYear}}</span> în anul <span>{{$student->active_year}}</span> de studii, studii universitare de <span>{{$cycleOfStudy}}</span>, în limba <span>{{$student->language == 0 ? 'română' : 'engleză'}}</span>, <span>{{$student->is_ID ? 'învățământ fără frecvență' : 'învățământ cu frecvență'}}</span>, <span>{{$student->is_paying_tax ? 'taxă' : 'buget'}}</span>.</p>
        <p>Adeverința se eliberează pentru a-i servi la <span>{{$ticket->reason}}</span>.</p>
    </div>

    @include('pdf.parts.ticket_footer')

</body>
</html>
