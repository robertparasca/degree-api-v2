<h1>UNIVERSITATEA TEHNICĂ GHEORGHE ASACHI DIN IAȘI</h1>
<h1 class="bold">FACULTATEA DE AUTOMATICĂ ȘI CALCULATOARE</h1>
<h1>DOMENIUL DE STUDII: <span class="bold italic">{{$student->field_of_study}}</span></h1>
<h1>PROGRAMUL DE STUDII: <span class="bold italic">{{$student->program_of_study ?? '-' }}</span></h1>
<h1>NR. <span>{{$ticket->registration_number}}</span> din <span>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->validated_at, 'UTC')->setTimezone('Europe/Bucharest')->format('d.m.Y')}}</span></h1>

<h2>ADEVERINȚĂ</h2>
