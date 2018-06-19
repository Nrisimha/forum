{% extends 'layouts/bs.volt' %}

{% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">

            <!--content-->
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <legend>{{ text.simple('update') }}</legend>
                        <form method="post" data-parsley-validate="" novalidate="" data-persist="garlic" data-destroy="false">
                            {{ content() }} 

                            {% if form.messages('csrf') %}
                            <div class="alert alert-danger">{{ text.simple('form_error_csrf') }}</div>
                            {% endif %}

/*{for:areas}*/
                            <fieldset>
                                <div class="form-group {% if form.messages('/*{areas>name}*/') %}has-error{% endif %}">
                                    <label class="col-sm-2 control-label">/*{areas>name}*/</label>
                                    <div class="col-sm-10">
                                        {#<textarea class="input-block-level summernote" name="/*{areas>name}*/">{{data['/*{areas>name}*/']}}</textarea>#}
                                        <input type="input" name="/*{areas>name}*/" class="form-control" data-parsley-minlength="3" data-parsley-type="alphanum" value="{{data['/*{areas>name}*/']}}">{{ form.messages('/*{areas>name}*/') }}
                                    </div>
                                </div>
                            </fieldset>
/*{/for}*/

                            {{ form.render('csrf', ['value': security.getToken()]) }}

                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>{{ text.simple('update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!--/content-->

            <!--submenu-->
            <div class="col-lg-3">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <legend>{{ text.simple('operations') }}</legend>
                        <ul>
                            <li><a href="{{ viewconf.baseurl }}static/app/panels.html">HTML ELEMENTS</a></li>
                            <li><a href="{{ viewconf.baseurl }}{{lang}}//*{classPrefix_}*//create">{{ text.simple('create') }}</a></li>
                            <li><a href="{{ viewconf.baseurl }}{{lang}}//*{classPrefix_}*/">{{ text.simple('list_all') }}</a></li>
/*{for:filterAreas}*/
                            <li><a href="{{ viewconf.baseurl }}{{lang}}//*{classPrefix_}*///*{filterAreas>name}*/list">{{ text.simple('filtered_list') }}</a></li>
/*{/for}*/ 
                        </ul>
                    </div>
                </div>
            </div>
            <!--/submenu-->

        </div>
    </div>
</section>

{% endblock %}

{# PAGE HEADER CONTENT#}
{% block pagetitle %} CHANGE_ME {% endblock %}
{% block meta_desc %} CHANGE_ME {% endblock %}
{% block meta_keywords %} CHANGE_ME {% endblock %}

{% block endofhead %}
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet">
{% endblock %} 

{# PAGE FOOTER CONTENT FOR SCRIPTS #}

{% block endofbody %}
<script src="{{ viewconf.baseurl }}djs/summernote.min.js.php?f=CHANGE_ME&sf={{lang}}"></script>

<script type="text/javascript">
    <!--

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            dialogsInBody: true,
            toolbar: [
                ['unre', ['undo', 'redo']],
                ['insert', ['picture', 'link', 'video', 'table']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
             //   ['extra', ['codeview']],
            ]
        });
        var postForm = function() {
            var content = $('textarea[name="content"]').html($('#summernote').code());
        }
    });

    //-->
</script>
{% endblock %}