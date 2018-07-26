<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Fitmanager RESTful API service for market places
                    <br>
                    Environment: {{ app()->environment() }}
                </div>

                <div class="links">
                    <button type="button" id="hello">Call API</button>
                    <button type="button" id="getActivities">Get API logs</button>
                </div>
            </div>
        </div>
        <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('#hello').on('click', function () {
                    $.get('http://localhost:8000/api/hello', function (data) {
                        alert(data);
                    });
                });
                $('#getActivities').on('click', function () {
                    $.get('http://localhost:8000/api/filter_logs/personal_infos?user_id=489&from_date=2018-06-02 06:00:00&to_date=2018-06-02 10:00:00', function (data) {
                        console.log(data.data[0].data);
                        // console.log(data.data[0].api_logs.channel);
                        // console.log(typeof data.data[0].api_logs);
                        // var obj = JSON.parse(data);
                        // alert(obj.id);
                    });
                });
            });
        </script>
    </body>
</html>
