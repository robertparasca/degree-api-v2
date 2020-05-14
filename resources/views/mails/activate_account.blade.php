<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Activate account</title>
</head>
<body>
    <h1>test</h1>
    {{$token}}
    Activate your account <a href={{'http://localhost:3001/activate-account?token=' . $token}}>here</a>.
    <br>
</body>
</html>
