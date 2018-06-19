<!DOCTYPE html>
<html>

<head>
    <title>{{ text.simple('site_name') }}</title>
    <style>
        html,
        body {
            height: 100%
        }
        
        html {
            background: url({{ viewconf.baseurl }}static/img/background.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 800;
            font-family: 'Lucida Sans Unicode';
            color: white;
        }
        
        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle
        }
        
        .content {
            text-align: center;
            display: inline-block
        }
        
        a {
            color: white
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <img src="{{viewconf.baseurl}}static/img/logo.png" />
            <p>SELECT YOUR LANGUAGE</p>
            <a href="{{viewconf.baseurl}}en/forum">English</a> <br />
            <a href="{{viewconf.baseurl}}fr/forum">French</a> <br />
            <a href="{{viewconf.baseurl}}de/forum">German</a> <br />
            <a href="{{viewconf.baseurl}}pl/forum">Polish</a> <br />
            <a href="{{viewconf.baseurl}}pt/forum">Portuguese</a> <br />
            <a href="{{viewconf.baseurl}}ru/forum">Russian</a> <br />
            <a href="{{viewconf.baseurl}}es/forum">Spanish</a> <br />
            <a href="{{viewconf.baseurl}}tr/forum">Turkish</a> <br />
        </div>
    </div>
</body>

</html>