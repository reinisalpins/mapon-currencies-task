<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mapon currency rates task</title>
    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
</head>
<body>
<div class="page-heading">
    <div class="container">
        <h1 class="page-title">Euro foreign exchange reference rates</h1>
    </div>
</div>
<div id="app" class="container"></div>
</body>
</html>
