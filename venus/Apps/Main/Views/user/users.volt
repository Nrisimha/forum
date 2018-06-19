{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">
                {{ content() }}
                {% if locker.unlock('__employee') %}
            <!--content-->
            <div class="col-lg-9">
                <form id="postForm" method="POST" onsubmit="" style="float:left">
                        <fieldset>
                            <label class="col-sm-8 control-label">{{text.simple('pages_per_page')}}</label>
                            <select name="perpage" class="form-control col-sm-8" onchange="this.form.submit()">
                                    <option {% if(perPage == 10) %} selected="selected"{% endif %}>10</option>
                                    <option {% if(perPage == 20) %} selected="selected"{% endif %}>20</option>
                                    <option {% if(perPage == 50) %} selected="selected"{% endif %}>50</option>
                                    <option {% if(perPage == total) %} selected="selected"{% endif %}>{{ text.simple('all_pages') }}</option>
                                    </select>
                            <label class="col-sm-8 control-label">{{text.simple('nick')}}</label>  
                            <div class="col-sm-10">
                                <input type="input" name="nick" class="form-control" {%if nick is defined%}value="{{nick}}"{%endif%}>
                            </div>
                        </fieldset>
                           
                <div class="panel panel-default">
                    <div class="panel-heading">{{ text.simple('list') }}</div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{text.simple('avatar')}}</th>

                                    <th>{{text.simple('nick')}}</th>

                                    <th>{{text.simple('forumtitle')}}</th>

                                    <th>{{text.simple('roles')}}</th>

                                </tr>
                            </thead>
                            <tbody>
                                {% if data is defined %}
                                    {% for row in data %}
                                    <tr id="row['_key']}}">

                                        <td>{% if row['avatar'] is defined %}{{row['avatar']}}{% endif %}</td>

                                        <td>{% if row['nick'] is defined %}{{row['nick']}}{% endif %}</td>

                                        <td>{% if row['forumtitle'] is defined %}{{row['forumtitle']}}{% endif %}</td>

                                        <td>{% if row['roles'] is defined %} 
                                                {% for i in 0..row['roles']|length %}
                                                    {% if row['roles'][i] is defined %} 
                                                        {{row['roles'][i]}} <br>
                                                    {% endif %} 
                                                {% endfor %} 
                                            {% endif %}</td>

                                        <td>
                                            <a href="{{ viewconf.baseurl }}{{lang}}/user/peek/{{row['_key']}}" title="{{ text.simple('see_details') }}">
                                        <span class="fa fa-book"></span>
                                        </a>
                                            <a href="{{ viewconf.baseurl }}{{lang}}/user/edit/{{row['_key']}}" title="{{ text.simple('edit') }}">
                                        <span class="fa fa-edit"></span>
                                        </a>
                                        </td>
                                    </tr>
                                    {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                    <br />
                    <div class="text-center mb-lg">
                        <nav>
                            <ul class="pagination m0">
                                {{ htmlgen.paginationSubmit(on_page , total_page )}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </form>
            </div>
            <!--/content-->
            
            {% endif %}
        </div>
    </div>
</section>
{% endblock %}