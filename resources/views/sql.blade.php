<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kanban Board Sql Dump</title>
    </head>
    <body class="antialiased">
        <pre>{{ $dump }}</pre>
    </body>
</html>
