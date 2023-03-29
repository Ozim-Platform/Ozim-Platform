<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/favicon.ico">

    <title>Ozim @yield('title') </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="/css/vendors_css.css">

    <!-- Style-->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/skin_color.css">

</head>
<body class="hold-transition theme-primary bg-gradient-primary">

<div class="container h-p100">
    <div class="row align-items-center justify-content-md-center h-p100">

        <div class="col-12">
            @yield('content')
        </div>
    </div>
</div>


<!-- Vendor JS -->
<script src="/js/vendors.min.js"></script>
<script src="/assets/icons/feather-icons/feather.min.js"></script>
<script type="text/javascript" src="/js/jquery.mask.js"></script>

</body>
</html>
