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

        .donation-link {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 12px 20px 12px 16px;
            border-radius: 16px;
            background: #f0fdfa;
            border: 1.5px solid #99f6e4;
            color: #0f766e;
            text-decoration: none;
            cursor: pointer;
            transition: 0.25s ease;
            max-width: 300px;
            margin-top: 10px;
        }


        .donation-link:hover {
            background: #ccfbf1;
            border-color: #2dd4bf;
            transform: translateY(-2px);
        }

        .donation-link .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #0f766e;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .donation-link .icon-box i {
            color: #fff;
            font-size: 20px;
        }

        .donation-link .link-text {
            text-align: right;
        }

        .donation-link .link-text .title {
            font-size: 14px;
            font-weight: 700;
            color: #0f766e;
            line-height: 1.3;
            margin: 0;
        }

        .donation-link .link-text .sub {
            font-size: 11px;
            color: #14b8a6;
            margin: 0;
        }

        .donation-link .chevron {
            margin-right: auto;
            color: #0f766e;
            opacity: 0.5;
            font-size: 18px;
        }

        @media (max-width: 800px) {

            .donation-link {
                display: inline-flex;
                align-items: center;
                gap: 14px;
                padding: 12px 20px 12px 16px;
                border-radius: 16px;
                background: #f0fdfa;
                border: 1.5px solid #99f6e4;
                color: #0f766e;
                text-decoration: none;
                cursor: pointer;
                transition: 0.25s ease;
                max-width: 100%;
                margin-top: 10px;
            }

            .donation-link .icon-box {
                width: 30px;
                height: 30px;
                border-radius: 10px;
                background: #0f766e;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .donation-link .icon-box i {
                color: #fff;
                font-size: 20px;
            }

            .donation-link .link-text {
                text-align: right;
            }

            .donation-link .link-text .title {
                font-size: 14px;
                font-weight: 700;
                color: #0f766e;
                line-height: 1.3;
                margin: 0;
            }

            .donation-link .link-text .sub {
                font-size: 11px;
                color: #14b8a6;
                margin: 0;
            }

            .donation-link .chevron {
                margin-right: auto;
                color: #0f766e;
                opacity: 0.5;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    @livewire('id-query')
</body>
@livewireScripts

</html>