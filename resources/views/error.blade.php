<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
</head>
<body>
    <br>
    <h2> Error </h2>
    <br>
    <br>
    <br>
    @if($errors->any())
    <h4>{{$errors->first()}}</h4>
    @endif
    <a href="/agendamento">Voltar</a>
</body>
</html>