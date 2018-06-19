{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <div class="content-wrapper">
            <div class="content-heading">
            <div class="pull-right"><a href="{{viewconf.baseurl}}{{lang}}/forum/topic/{{ subjectkey }}" class="btn btn-sm btn-default text-sm">{{ text.simple('forum_back_button') }}</a>
            </div>{{text.simple('forum_edit_message')}}
            <small>ID: {{data['content']['_key']}}</small>
        </div>
    {{ content() }}
            <table class="table table-striped">

                <tbody>
                    <tr class="separate-top">
                        <td class="text-center">
                            <a href="#">
                                <strong>{{data['sender']['nick']}}</strong>
                            </a>
                        </td>
                        <td class="text-right">
                            <em>{{date("Y-m-d  H:i",data['content']['time'])}}</em>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%;" class="text-center">
                            <div class="mt">
                                <a href="#">
                                    <img src="{{data['sender']['avatar']}}?s=64&d=identicon" alt="avatar" class="img-circle thumb64">
                                </a>
                            </div>
                            <small>{{data['sender']['forumtitle']}}</small>
                        </td>
                        <td>
                        <form id="postForm" method="POST" onsubmit="return postForm()">
                        <textarea class="input-block-level" id="summernote" name="content">{{data['content']['message']}}</textarea><button type="submit" class="btn btn-primary">{{ text.simple('forum_save') }}</button>
                        <input type="hidden" name="key" value="{{data['content']['_key']}}">
                        <input type="hidden" name="csrf" value="{{security.getToken()}}">
                        </form>
                        </td>
                    </tr>
                    <tr class="separate-top">
                        <td class="text-center">&nbsp;
                        </td>
                        <td class="text-right">&nbsp;
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</section>
{% endblock %}


{% block endofhead %}
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet"> {% endblock %} {% block endofbody %}
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet"> {% endblock %} {% block endofbody %}
<script src="{{ viewconf.baseurl }}djs/summernote.min.js.php?f=forum&sf={{lang}}"></script>
<script type="text/javascript">
    <!--

    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
            toolbar: [
                ['unre', ['undo', 'redo']],
                ['insert', ['picture', 'link', 'video', 'table']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['extra', ['codeview']],
            ]
        });
        var postForm = function() {
            var content = $('textarea[name="content"]').html($('#summernote').code());
        }
    });

    //-->
</script>
{% endblock %}