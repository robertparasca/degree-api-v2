@include('pdf.parts.ticket_head')
<body>

    @include('pdf.parts.ticket_header')

    <div>
        <p>Studentul (a) <span>{{$student->last_name}} {{$student->first_name}}</span> este înscris (ă) în anul <span class="b">2019/2020</span> în anul <span>{{$student->active_year}}</span> de studii, studii universitare de <span class="b">licență</span>, în limba <span class="b">română</span>, <span class="b">învățământ cu frecvență</span>, <span>{{$student->is_paying_tax ? 'taxă' : 'buget'}}</span>.</p>
        <p>Adeverința se eliberează pentru a-i servi la <span>{{$ticket->reason}}</span>.</p>
    </div>

</body>
</html>
