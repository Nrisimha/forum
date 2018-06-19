<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Bootstrap Admin App + jQuery">
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
    <title>{{ text.simple('page_title') }}</title>
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/whirl/dist/whirl.css">
    <link rel="stylesheet" href="{{ viewconf.assets }}css/bootstrap.css" id="bscss">
    <link rel="stylesheet" href="{{ viewconf.assets }}css/app.css" id="maincss">
    <style type="text/css">
 <!-- BODY {background:none transparent;}-->
 </style>
    {% block endofhead %}{% endblock %}
</head>

<body>
    <div class="wrapper">

        <div>
            {% block page_content %}{% endblock %}
        </div>
    </div>
    <script src="{{ viewconf.assets }}vendor/modernizr/modernizr.custom.js"></script>
    <script src="{{ viewconf.assets }}vendor/jquery/dist/jquery.js"></script>
    <script src="{{ viewconf.assets }}vendor/bootstrap/dist/js/bootstrap.js"></script>
    <script src="{{ viewconf.assets }}vendor/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="{{ viewconf.assets }}vendor/matchMedia/matchMedia.js"></script>
    <script src="{{ viewconf.assets }}vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
    <script src="{{ viewconf.assets }}vendor/jquery.easing/js/jquery.easing.js"></script>
    <script src="{{ viewconf.assets }}vendor/screenfull/dist/screenfull.js"></script>
    <script src="{{ viewconf.assets }}vendor/animo.js/animo.js"></script>
    {#<script src="{{ viewconf.assets }}vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>#}
    <script src="{{ viewconf.assets }}js/app.js"></script>
    <script src="{{ viewconf.assets }}vendor/parsleyjs/dist/parsley.min.js"></script>
    <script src="{{ viewconf.assets }}vendor/garlic/garlic.min.js"></script>
    {% block endofbody %}{% endblock %}
</body>

</html>