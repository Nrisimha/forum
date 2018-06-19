{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="pull-right"><a href="{{ viewconf.baseurl }}{{data['category']['language']}}/forum" class="btn btn-sm btn-default text-sm">{{ text.simple('forum_all_forums') }}</a>
            </div>{{data['category']['name']}}
            <small>{{data['category']['description']}}</small>
        </div>
        {{ content() }}
        <div class="panel panel-default">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 50%" class="h4">{{ text.simple('forum_topics') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {%for subject in data['list']%}
                    <tr>
                        <td>
                            <h4>
                                <a href="{{ viewconf.baseurl }}{{data['category']['language']}}/forum/topic/{{subject['topic']['_key']}}">
                                    <strong>{{subject['topic']['subject']}}</strong>
                                </a>
                            </h4>
                            <div class="text-muted text-sm">
                                <span>
                                 <strong class="mr-sm">{{subject['topic']['views']}}</strong>{{ text.simple('forum_views') }}</span>
                                <span class="mh-sm"></span>
                                <span>
                                 <strong class="mr-sm">{{subject['topic']['replies']}}</strong>{{ text.simple('forum_replies') }}</span>
                            </div>
                        </td>
                        <td class="text-right hidden-xs hidden-sm">
                            <div class="text-muted">
                                <small class="mr-sm">{{ text.simple('forum_started_by') }} </small><a href="#" class="mr-sm">{{subject['sender']['nick']}}</a>
                                <small>{{date("Y-m-d  H:i",subject['topic']['time'])}}</small>
                            </div>
                        </td>
                    </tr>
                    {%endfor%}
                </tbody>
            </table>
        </div>
        <div class="text-center mb-lg">
        <nav>
            <ul class="pagination m0">
                {{ htmlgen.pagination(on_page , total_page , viewconf.baseurl ~ data['category']['language'] ~ '/forum/topics/'~data['category']['_key']~'/%PAGE%')}}
            </ul>
        </nav>
        </div>

        {% if locker.unlock('__user') %}
        <div class="text-center mb-lg">
            <button data-toggle="collapse" data-target="#topic-new" class="btn btn-primary">{{ text.simple('forum_new_topic') }}</button>
        </div>
        <div id="topic-new" class="collapse">
            <div class="panel panel-flat">
                <form id="postForm" method="POST" data-parsley-validate="" novalidate="" data-destroy="false">
                    <legend>{{ text.simple('forum_new_topic') }}</legend>

                    <fieldset>
                        <div>
                            <label class="col-sm-2 control-label">{{ text.simple('forum_rules') }}</label>
                            <div class="col-sm-10">
                                <p>{{ text.simple('forum_quick_rules') }}
                                </p>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="subject" class="col-sm-2 control-label">Subject</label>
                            <div class="col-sm-10">
                                <input type="text" name="subject" class="form-control" data-parsley-minlength="20">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="content" class="col-sm-2 control-label">Content</label>
                            <div class="col-sm-10">
                                <textarea class="input-block-level" id="summernote" name="content" data-parsley-minlength="50"></textarea>
                            </div>
                        </div>
                    </fieldset>

                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary">{{ text.simple('send_button') }}</button>
                    </div>
                </form>
            </div>
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
    </div>
</section>

{% endblock %} {% block pagetitle %}Forum: {{data['category']['name']}}{% endblock %} {% block endofhead %}
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet"> {% endblock %} {% block endofbody %}
<script src="{{ viewconf.baseurl }}djs/summernote.min.js.php"></script>
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
            ],
            onChange: function() {
                $('textarea[name="content"]').html($('#summernote').code());
            }
        });
    });

    //-->
</script>
{% endblock %}