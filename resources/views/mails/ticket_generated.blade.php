<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Cerere acceptată</title>
</head>
<body>
    <div>
        <p>Dragă {{$student->student->last_name}} {{$student->student->first_name}}, cererea ta a fost acceptată la data de {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ticket->validated_at, 'UTC')->setTimezone('Europe/Bucharest')->format('d.m.Y')}}.</p>
        <p>Adeverința poate fi descarcată din aplicație, dar este de asemenea atașată și acestui email.</p>

        <p>Numai bine,</p>
        <p>{{$validatedBy->staff->last_name}} {{$validatedBy->staff->first_name}}</p>
    </div>
</body>
</html>
