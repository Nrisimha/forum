{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">{{ text.simple('forum_categories') }}</div>
        {{content()}} {%for g in data%}
        <div class="panel panel-default">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="h4 col-md-7">{{g['group']['name']}}</th>
                        <th class="h4 text-center hidden-xs hidden-sm col-md-1">{{ text.simple('forum_topics') }}</th>
                        <th class="h4 hidden-xs hidden-sm col-md-4">{{ text.simple('forum_last_message') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {%for s in g['category']%}
                    <tr>
                        <td>
                            <h4>
                                <a href="{{viewconf.baseurl}}{{s['category']['language']}}/forum/topics/{{s['category']['_key']}}">
                                    <strong>{{s['category']['name']}}</strong>
                                </a>
                            </h4>
                            <div class="text-muted">{{s['category']['description']}}</div>
                        </td>
                        <td class="text-muted text-center hidden-xs hidden-sm">
                            <strong>{{s['category']['total_topics']}}</strong>
                        </td>
                        <td class="hidden-xs hidden-sm"><a href="{{ viewconf.baseurl }}{{s['category']['language']}}/forum/topic/{{s['topic']['_key']}}">{{s['topic']['subject']}}</a>
                            <br>
                            <small>{{date("Y-m-d  H:i",s['topic']['time'])}}</small>
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
        {% endfor %}

    </div>
</section>
{% endblock %}