{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="pull-right"><a href="javascript:window.history.back()" class="btn btn-sm btn-default text-sm">{{ text.simple('forum_back_button') }}</a>
            </div>{{topic['subject']['subject']}}
            <small>ID: {{topic['subject']['_key']}}
            {% if locker.unlock('__employee') %}
            <a href="javascript:deleteSubject()" target="_blank"><i class="fa fa-trash-o"></i></a>
            {% endif %}
            </small>
        </div>
        {{ content() }}
        <div class="panel panel-default">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2" class="h4">{{topic['subject']['subject']}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {% for msg in topic['messages'] %}
                    <tr id="head{{msg['content']['_key']}}"class="separate-top">
                        <td class="text-center">
                            <a href="#">
                                <strong>{{msg['sender']['nick']}}</strong>
                            </a>
                        </td>
                        <td class="text-right">
                        {% if locker.unlock('__employee') %}
                            <a href="javascript:deleteMsg({{msg['content']['_key']}})"><i class="fa fa-trash-o"></i></a>
                            <a href="{{viewconf.baseurl}}{{lang}}/forum/editmsg/{{msg['content']['_key']}}/{{topic['subject']['_key']}}"><i class="fa fa-edit"></i> </a>
                        {% endif %}
                            <em>{{date("Y-m-d  H:i",msg['content']['time'])}}</em>
                        </td>
                    </tr>
                    <tr id="msg{{msg['content']['_key']}}">
                        <td style="width: 15%;" class="text-center">
                            <div class="mt">
                                <a href="#">
                                    <img src="{{msg['sender']['avatar']}}?s=64&d=identicon" alt="avatar" class="img-circle thumb64">
                                </a>
                            </div>
                            <small>{{msg['sender']['forumtitle']}}</small>
                        </td>
                        <td>{{msg['content']['message']}}
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
        <div class="text-center mb-lg">
        <nav>
            <ul class="pagination m0">
                {{ htmlgen.pagination(on_page , total_page , viewconf.baseurl ~ lang ~ '/forum/topic/'~ topic['subject']['_key']~'/%PAGE%')}}
            </ul>
        </nav>
        </div>
        {% if locker.unlock('__user') %}
        <div class="panel panel-flat">
            <form id="postForm" method="POST" data-parsley-validate="" novalidate="" data-destroy="false">
                <legend>{{ text.simple('forum_reply_to_topic') }}</legend>
                <fieldset>
                    <div>
                        <div class="col-sm-2 control-label mt">
                            <small>{{ text.simple('forum_quick_rules') }}</small>


                        </div>
                        <div class="col-sm-10">
                            <textarea class="input-block-level" id="summernote" name="content" data-parsley-minlength="50"></textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">{{ text.simple('forum_send_message') }}</button>
                </div>
            </form>
        </div>
        {%else%}
        <div class="panel panel-info">
            <div class="panel-heading">{{ text.simple('you_are_not_logged_in') }}</div>
            <div class="panel-body">
                <p>{{ text.simple('forum_login_message') }}</p>
            </div>
            <div class="panel-footer">
                <a href="{{viewconf.baseurl}}{{lang}}/user/slogin">
                         {{ text.simple('login') }}</a> / <a href="{{viewconf.baseurl}}{{lang}}/user/sregister">
                         {{ text.simple('sign_up') }}</a>
            </div>
        </div>
        {% endif %}
</section>
{% endblock %}





{% block pagetitle %}{{topic['subject']['subject']}}{% endblock %} 
 
 
 
 
 {% block endofhead %}
<link href="{{ viewconf.assets }}vendor/sweetalert/dist/sweetalert.css"rel="stylesheet">
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet"> 
{% endblock %}




 {% block endofbody %}
<script src="{{ viewconf.assets }}vendor/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ viewconf.baseurl }}djs/summernote.min.js.php?f=forum&sf={{lang}}"></script>
<script type="text/javascript">
    <!--
{% if locker.unlock('__employee') %}
function deleteMsg(key){
    swal({
        title: "Are you sure?",
        text: "You will be not able to recover it.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
        },
        function(){
            $.ajax({
            type: 'GET',
            url: '{{viewconf.baseurl}}{{lang}}/forum/deletemsg/' + key,
            dataType: "json",
            success: function(data){
                if(data.deleted){
                    swal("Deleted!", data.message, "success")
                    $('#msg'+key).remove()
                    $('#head'+key).remove()
                }else{
                    swal("Failed to delete", 'Error: '+data.message, "error")
                }
            }
        });

    });
};

function deleteSubject(){
    swal({
        title: "Are you sure?",
        text: "You will be not able to recover it.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
        },function(){
            window.location.href = '{{viewconf.baseurl}}{{lang}}/forum/deletesubject/{{topic['subject']['_key']}}'
        })}
{% endif %}


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
            ],
            onChange: function() {
                $('textarea[name="content"]').html($('#summernote').code());
            }
        });
    });

    //-->
</script>
{% endblock %}