<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @livewireStyles

    <title>{{ env('APP_NAME') }} - Details</title>
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            direction: rtl;
            margin: 0;
            padding: 20px;
        }
    </style>
</head>

<body>
    @livewire('id-query')
</body>
@livewireScripts

</html>