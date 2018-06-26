<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{% block meta_desc %}{{ text.simple('meta_desc') }}{% endblock %}">
    <meta name="keywords" content="{% block meta_keyowords %}{{ text.simple('meta_keywords') }}{% endblock %}">
    <title>{{ text.simple('page_title') }}: {% block pagetitle %}{{ text.simple('page_title') }}{% endblock %}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="{{ viewconf.assets }}vendor/whirl/dist/whirl.css">
    <link rel="stylesheet" href="{{ viewconf.baseurl }}static/css/bootstrap.css" id="bscss">
    <link rel="stylesheet" href="{{ viewconf.baseurl }}static/css/app.css" id="maincss">
    <link rel="stylesheet" href="{{ viewconf.baseurl }}static/css/app-theme.css"> {% block endofhead %}{% endblock %}
</head>

<body class="layout-boxed">
    <div class="wrapper">
        <header class="topnavbar-wrapper">
            <!-- START Top Navbar-->
            <nav role="navigation" class="navbar topnavbar">
                <!-- START navbar header-->
                <div class="navbar-header">
                    <a href="{{ viewconf.baseurl }}{{lang}}/forum" class="navbar-brand">
                        <div class="brand-logo">
                            <img src="{{ viewconf.baseurl }}static/img/logo_beta.png" alt="App Logo" class="img-responsive">
                        </div>
                    </a>
                </div>
                <!-- END navbar header-->
                <!-- START Nav wrapper-->
                <div class="navbar-collapse collapse">
                    <!-- START Left navbar-->
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#dashboard" data-toggle="dropdown">{{ text.simple('forum') }}</a>
                            <ul class="dropdown-menu animated fadeIn">
                                <li>
                                    <a href="{{viewconf.baseurl}}en/forum">English</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}fr/forum">French</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}de/forum">German</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}pl/forum">Polish</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}pt/forum">Portuguese</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}ru/forum">Russian</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}es/forum">Spanish</a>
                                </li>
                                <li>
                                    <a href="{{viewconf.baseurl}}tr/forum">Turkish</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- START Right Navbar-->
                    <ul class="nav navbar-nav navbar-right">
                        {% if locker.unlock('__user') %} {% if locker.unlock('__employee') %}
                        <li>
                            <a href="{{viewconf.baseurl}}{{lang}}/user/users">
                                {{text.simple('users_list')}}
                            </a>
                        </li>
                        {% endif %}
                        <li>
                            <a href="{{viewconf.baseurl}}{{lang}}/user/profile">
                                {{session.get('nick')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{viewconf.baseurl}}{{lang}}/user/logout">
                                {{ text.simple('logout') }}
                                <em class="fa fa-power-off"></em>
                            </a>
                        </li>
                        {% else %}
                        <li>
                            <a href="{{viewconf.baseurl}}{{lang}}/user/slogin">
                                {{ text.simple('login') }}
                                <em class="fa fa-power-off"></em>
                            </a>
                        </li>
                        {% endif %}
                    </ul>
                    <!-- END Right Navbar-->
                </div>
            </nav>
        </header>

        <div>
            {% block page_content %}{% endblock %}
        </div>
        <div class="row">
            <div class="col-xs-12">
                <footer>
                    <p>{{ text.simple('footer_copyright') }}</p>
                </footer>
            </div>
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
    {#
    <script src="{{ viewconf.assets }}vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>#}
    <script src="{{ viewconf.assets }}js/app.js"></script>
    <script src="{{ viewconf.assets }}vendor/parsleyjs/dist/parsley.min.js"></script>
    <script src="{{ viewconf.assets }}vendor/garlic/garlic.min.js"></script>
    {% block endofbody %}{% endblock %}
</body>

</html>