{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">
            {{ content() }} {% if locker.unlock('__employee') %}

            <!-- FORM -->
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ viewconf.baseurl }}{{lang}}/user/edit/{{data['_key']}}" method="post" autocomplete="nope">
                            <legend>{{ text.simple('profile') }}</legend>
                            {% if form.messages('csrf') %}
                            <div class="alert alert-danger">{{ text.simple('form_error_csrf') }}</div>
                            {% endif %}

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ text.simple('nick') }}</label>
                                    <div class="col-sm-10">
                                        <label class="col-sm-2 control-label">{{ data['nick'] }}</label>
                                    </div>
                                    <label class="col-sm-2 control-label">{{ text.simple('forumtitle') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="forumtitle" class="form-control" data-parsley-minlength="1" value="{% if data['forumtitle'] is defined %}{{data['forumtitle']}}{% endif %}">{{ form.messages('forumtitle') }}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group {% if form.messages('name') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="name" class="form-control" data-parsley-minlength="2" value="{% if data['name'] is defined %}{{data['name']}}{% endif %}">{{ form.messages('name') }}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group {% if form.messages('surname') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('surname') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="surname" class="form-control" data-parsley-minlength="2" value="{% if data['surname'] is defined %}{{data['surname']}}{% endif %}">{{ form.messages('surname') }}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group {% if form.messages('company_name') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('company_name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="company_name" class="form-control" data-parsley-minlength="2" value="{% if data['company_name'] is defined %}{{data['company_name']}}{% endif %}">{{ form.messages('company_name') }}
                                    </div>
                                </div>
                                <div class="form-group {% if form.messages('partner_site') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('partner_site') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="partner_site" class="form-control" value="{% if data['partner_site'] is defined %}{{data['partner_site']}}{% endif %}">{{ form.messages('partner_site') }}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group {% if form.messages('phone') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('phone') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="phone" class="form-control" data-parsley-minlength="9" value="{% if data['phone'] is defined %}{{data['phone']}}{% endif %}">{{ form.messages('phone') }}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group {% if form.messages('info') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('info') }}</label>
                                    <div class="col-sm-10">
                                        <input type="input" name="info" class="form-control" data-parsley-minlength="0" value="{% if data['info'] is defined %}{{data['info']}}{% endif %}">{{ form.messages('info') }}
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>

                                <div class="form-group {% if form.messages('roles') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">{{ text.simple('roles') }}</label>


                                    {% for role in data['roles'] %}
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="roles[{{role}}]" checked value>{{role}}</label>
                                    {% endfor %} {{ form.messages('roles') }}
                                </div>

                            </fieldset>
                            {{ form.render('csrf', ['value': security.getToken()]) }}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i>{{ text.simple('save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /FORM -->

            {% endif %}
        </div>
    </div>
</section>
{% endblock %} {# PAGE HEADER CONTENT#} {% block pagetitle %} CHANGE_ME {% endblock %} {% block meta_desc %} CHANGE_ME {%
endblock %} {% block meta_keywords %} CHANGE_ME {% endblock %} {% block endofhead %}
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
<style>
    @font-face {
        font-family: 'Glyphicons Halflings';
        src: url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot');
        src: url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'),
        url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.woff') format('woff'),
        url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.ttf') format('truetype'),
        url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
    }

    .glyphicon {
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: normal;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
    }

    .glyphicon-ok:before {
        content: "\e013";
    }

    .glyphicon-user:before {
        content: "\e008";
    }
</style>
{% endblock %}