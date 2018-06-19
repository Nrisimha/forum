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
                    <legend>Key: {{data['_key']}}</legend>
                        {{content()}}
                        {{dump(data)}}
                        <div>
                            <div class="col-sm-2"><strong>_key:</strong></div>
                            <div class="col-sm-10">{{data['_key']}}</div>
                        </div>
                        /*{for:areas}*/
                        <div>
                            <div class="col-sm-2"><strong>/*{areas>name}*/:</strong></div>
                            <div class="col-sm-10">{{data['/*{areas>name}*/']}}</div>
                        </div>
                        /*{/for}*/ 
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
{% block pagetitle %} CHANGE ME {% endblock %}
{% block meta_desc %} CHANGE ME {% endblock %}
{% block meta_keywords %} CHANGE ME {% endblock %}

{% block endofhead %}
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet">
{% endblock %} 

{# PAGE FOOTER CONTENT FOR SCRIPTS #}

{#% block endofbody %}
<script src="{{ viewconf.baseurl }}djs/summernote.min.js.php?f=forum&sf={{lang}}"></script>

<script type="text/javascript">
    <!--

    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
            dialogsInBody: true,
            toolbar: [
                ['unre', ['undo', 'redo']],
                ['insert', ['picture', 'link', 'video', 'table']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
              //  ['extra', ['codeview']],
            ]
        });
        var postForm = function() {
            var content = $('textarea[name="content"]').html($('#summernote').code());
        }
    });

    //-->
</script>
{% endblock %#}