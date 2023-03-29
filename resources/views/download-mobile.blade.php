<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ozim</title>
    <style>
        * {
            box-sizing: border-box;
        }
        html{
            display: flex;
            flex-flow: row nowrap;
            justify-content: center;
            align-content: center;
            align-items: center;
            height:100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            justify-content: center;
            align-content: center;
            margin: 0px auto;
            text-align: left;
        }
        .container {
            height: 100;
        }
        .column {
            flex-direction: column;
            float: left;
            width: 200;
            display: flex;
        }
    </style>
</head>

<body>
<div class="column">
    <img src="{{asset('images/googleplay.svg')}}" alt="Google Play" width="200" onclick="onGoogleplayClick()">
    <div class="container"></div>
    <img src="{{asset('images/appstore.svg')}}" alt="App Store" width="200" onclick="onAppStoreClick()">
</div>

<script src="{{asset('js/download-mobile/index.js')}}"></script>
</body>

</html>
