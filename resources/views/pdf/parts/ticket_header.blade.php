
<h1><span>{{$institute->university_name}}</span></h1>
<h1 class="bold"><span>{{$institute->faculty_name}}</span></h1>
<h1>DOMENIUL DE STUDII: <span class="bold italic">{{$student->field_of_study}}</span></h1>
<h1>PROGRAMUL DE STUDII: <span class="bold italic">{{$student->program_of_study ?? '-' }}</span></h1>
<h1>NR. <span>{{$ticket->registration_number}}</span> din <span>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->validated_at, 'UTC')->setTimezone('Europe/Bucharest')}}</span></h1>

<h2>ADEVERINȚĂ</h2>
