{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <legend>{{ text.simple('user_operations') }}</legend>
                        <ul>
                            <li>{{ link_to('user/signup', text.simple('sign_up')) }}</li>
                            <li>{{ link_to('user/login', text.simple('login')) }}</li>
                            <li>{{ link_to('user/logout', text.simple('logout')) }}</li>
                        </ul>
                    </div>
                </div>
            </div>


            <!-- FORM -->
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ viewconf.baseurl }}{{lang}}/user/newnick" method="post" data-parsley-validate="" novalidate="" data-persist="garlic" data-destroy="false">
                            <legend>{{ text.simple('choose_username') }}</legend>

                            {{ content() }} {% if form.messages('csrf') %}
                            <div class="alert alert-danger">{{ text.simple('form_error_csrf') }}</div>
                            {% endif %}
                            <p>{{ text.simple('you_should_choose_an_username_to_use_FORUM_net') }}</p>

                            <fieldset>
                                <div class="form-group {% if form.messages('nick') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('form_nick') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="nick" class="form-control" data-parsley-minlength="3">{{ form.messages('nick') }}{{ form.messages('nick') }}
                                    </div>
                                </div>
                            </fieldset>

                            {{ form.render('csrf', ['value': security.getToken()]) }}
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>{{ text.simple('save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /FORM -->

        </div>
    </div>
</section>

{% endblock %}