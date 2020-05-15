<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Ticket rejected</title>
</head>
<body>
<div>
    <p>Dragă {{$student->student->last_name}} {{$student->student->first_name}}, cererea ta a fost respinsă la data de {{$ticket->validated_at}}.</p>
    <p>Motivul pentru care a fost respinsă este: {{$ticket->rejection_reason}}.</p>

    <p>Numai bine,</p>
    <p>{{$validatedBy->staff->last_name}} {{$validatedBy->staff->first_name}}</p>
</div>
</body>
</html>
