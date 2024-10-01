<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Onext Digital</title>
    <link rel="icon" type="image/x-icon" href="https://onextdigital.com/wp-content/uploads/2023/10/OnextDigital-logo.png">
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app"></div>
</body>
</html>