<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hello {{$mailData['created_by']->name}}</h1>
    <p>Job Title: {{$mailData['job']->title}}</p>

    <p>Employee Details:</p>
    <p>Name: {{$mailData['user']->name }}</p>
    <p>Name: {{$mailData['user']->email }}</p>
    <p>Name: {{$mailData['user']->mobile }}</p>
</body>
</html>
