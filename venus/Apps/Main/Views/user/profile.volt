{% extends 'layouts/bs.volt' %} {% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">
            {{ content() }}

            <!-- FORM -->
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>{{ text.simple('profile') }}</legend>
                        <fieldset>
                            <div class="form-group">
                                {% if locker.unlock('__user') %}
                                <label class="col-sm-2 control-label">{{ text.simple('nick') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['nick'] }}</label>
                                </div>
                                <label class="col-sm-2 control-label">{{ text.simple('forumtitle') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['forumtitle'] }}</label>
                                </div>
                                <label class="col-sm-2 control-label">{{ text.simple('email') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['email'] }}</label>
                                </div>
                                {% endif %} {% if locker.unlock('__partner') %} {% if data['name'] is defined %}
                                <label class="col-sm-2 control-label">{{ text.simple('name') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['name'] }}</label>
                                </div>
                                {% endif %} {% if data['surname'] is defined %}
                                <label class="col-sm-2 control-label">{{ text.simple('surname') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['surname'] }}</label>
                                </div>
                                {% endif %} {% if data['company_name'] is defined %}
                                <label class="col-sm-2 control-label">{{ text.simple('company_name') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['company_name'] }}</label>
                                </div>
                                {% endif %} {% if data['partner_site'] is defined %}
                                <label class="col-sm-2 control-label">{{ text.simple('partner_site') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['partner_site'] }}</label>
                                </div>
                                {% endif %} {% if data['phone'] is defined %}
                                <label class="col-sm-2 control-label">{{ text.simple('phone') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['phone'] }}</label>
                                </div>
                                {% endif %} {% if data['info'] is defined %}
                                <label class="col-sm-2 control-label">{{ text.simple('info') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">{{ data['info'] }}</label>
                                </div>
                                {% endif %}
                                <label class="col-sm-2 control-label">{{ text.simple('role') }}</label>
                                <div class="col-sm-10">
                                    <label class="col-sm-2 control-label">partner</label>
                                </div>
                                {% endif %}
                            </div>
                        </fieldset>
                        {% if locker.unlock('__partner') %}
                        <fieldset>
                            <div class="form-group">
                                <form action="{{ viewconf.baseurl }}{{lang}}/user/profile" method="post">
                                    <legend>{{ text.simple('payment_method') }}</legend>
                                    
                                    <h4>Payout method</h4>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default payoneer {% if data['payout']['method'] is defined %}{% if data['payout']['method'] =='payoneer' %} active payout_method{% endif %}{% endif %}">
                                            <input type="radio" name="payout_method" value="payoneer" {% if data[ 'payout'][ 'method'] is defined %}{% if data[
                                                'payout'][ 'method']=='payoneer' %}checked="checked" {% else %}checked="unchecked" {%
                                                endif %}{% endif %}>Payoneer Global Bank Transfer
                                        </label>
                                        <label class="btn btn-default paypal {% if data['payout']['method'] is defined %}{% if data['payout']['method'] =='paypal' %} active payout_method{% endif %}{% endif %}">
                                            <input type="radio" name="payout_method" value="paypal" {% if data[ 'payout'][ 'method'] is defined %}{% if data[
                                                'payout'][ 'method']=='paypal' %}checked="checked" {% else %}checked="unchecked" {%
                                                endif %}{% endif %}>Paypal
                                        </label>
                                        <label class="btn btn-default skrill {% if data['payout']['method'] is defined %}{% if data['payout']['method'] =='skrill' %} active payout_method{% endif %}{% endif %}">
                                            <input type="radio" name="payout_method" value="skrill" {% if data[ 'payout'][ 'method'] is defined %}{% if data[
                                                'payout'][ 'method']=='skrill' %}checked="checked" {% else %}checked="unchecked" {%
                                                endif %}{% endif %}>Skrill
                                        </label>
                                    </div>
                                    <div class="container0">
                                            <input type="hidden" name="email" value="{% if data['payout']['email'] is defined %}{{data['payout']['email']}}{% endif %}">
                                    </div>
                                    {{ form.render('csrf', ['value': security.getToken()]) }}
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i>{{ text.simple('save') }}</button>
                                </form>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <legend>{{ text.simple('payment_history') }}</legend>
                                {% if payments is not empty %}
                                <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                           <thead>
                                              <tr>
                                                 <th>#</th>
                                                 <th>Time</th>
                                                 <th>Game</th>
                                                 <th>Amount</th>
                                                 <th>Payment method</th>
                                              </tr>
                                           </thead>
                                           <tbody>
                                                {% for i in 0..(payments|length) %}
                                                    {% if payments[i] is defined %} 
                                                            <tr>
                                                                <td>{{i}}</td>
                                                                <td>{% if payments[i]['time'] is not empty %}{{date("Y-m-d  H:i", payments[i]['time'])}}{% endif %}</td>
                                                                <td>{% if payments[i]['land'] is not empty %}{{payments[i]['land']}}{% endif %}</td>
                                                                <td>{{payments[i]['amount']}}</td>
                                                                <td>{{payments[i]['payment_method']}}</td>
                                                            </tr>
                                                    {% endif %}
                                                {% endfor %}
                                            </tbody>
                                        </table>
                                </div>
                                {% endif %}
                            </div>
                        </fieldset>
                        {% endif %}
                    </div>
                </div>
            </div>
            <!-- /FORM -->

        </div>
    </div>
</section>
{% endblock %} {# PAGE HEADER CONTENT#} {% block pagetitle %} CHANGE_ME {% endblock %} {% block meta_desc %} CHANGE_ME {%
endblock %} {% block meta_keywords %} CHANGE_ME {% endblock %} {% block endofhead %} {% endblock %} {# PAGE FOOTER CONTENT
FOR SCRIPTS #} {% block endofbody %}

<script type="text/javascript">
function myFunction() {
    $('.payout_method').cheched = true;
    $(this).parent('fieldset').remove();
    $('.container0').append("<input type='hidden' name='email' value='{% if data['payout']['email'] is defined %}{{data['payout']['email']}}{% endif %}'>");
}
    $(document).ready(function () {

        var wrapper = $(".container0");

        $('body').on('click', ".payoneer", function (e) {
            e.preventDefault();
            $(wrapper).children('fieldset').remove();
            $(wrapper).children('input').remove();
            $(wrapper).append(
                "<fieldset>"+
                "<div class=\"form-group {% if form.messages('email') %}has-error{% endif %}\">"+
                "<h4>{{ text.simple('payoneer_information') }}</h4>"+
                "<label class=\"col-sm-2 control-label\">{{ text.simple('email') }}</label>"+
                "<div class=\"col-sm-10\">"+
                "<input type=\"input\" name=\"email\" class=\"form-control\" value=\"{% if data['payout']['email'] is defined %}{% if data['payout']['method'] == 'payoneer' %}{{data['payout']['email']}}{% endif %}{% endif %}\">"+
                "{{ form.messages('email') }}"+
                "</div></div>"+
                "<button class='delete btn btn-danger' onclick=\"myFunction()\">Cancel</button>"+
                "</fieldset>"
            ); //add check form
        });

        $('body').on('click', ".paypal", function (e) {
            e.preventDefault();
            $(wrapper).children('fieldset').remove();
            $(wrapper).children('input').remove();
            $(wrapper).append(
                "<fieldset>"+
                "<div class=\"form-group {% if form.messages('email') %}has-error{% endif %}\">"+
                "<h4>{{ text.simple('paypal_information') }}</h4>"+
                "<label class=\"col-sm-2 control-label\">{{ text.simple('email') }}</label>"+
                "<div class=\"col-sm-10\">"+
                "<input type=\"input\" name=\"email\" class=\"form-control\" value=\"{% if data['payout']['email'] is defined %}{% if data['payout']['email'] == 'paypal' %}{{data['payout']['email']}}{% endif %}{% endif %}\">"+
                "{{ form.messages('email') }}"+
                "</div></div>"+
                "<button class='delete btn btn-danger' onclick=\"myFunction()\">Cancel</button>"+
                "</fieldset>"
            ); //add check form
        });

        $('body').on('click', ".skrill", function (e) {
            e.preventDefault();
            $(wrapper).children('fieldset').remove();
            $(wrapper).children('input').remove();
            $(wrapper).append(
                "<fieldset>"+
                "<div class=\"form-group {% if form.messages('email') %}has-error{% endif %}\">"+
                "<h4>{{ text.simple('skrill_information') }}</h4>"+
                "<label class=\"col-sm-2 control-label\">{{ text.simple('email') }}</label>"+
                "<div class=\"col-sm-10\">"+
                "<input type=\"input\" name=\"email\" class=\"form-control\" value=\"{% if data['payout']['email'] is defined %}{% if data['payout']['email'] == 'skrill' %}{{data['payout']['email']}}{% endif %}{% endif %}\">"+
                "{{ form.messages('email') }}"+
                "</div></div>"+
                "<button class='delete btn btn-danger' onclick=\"myFunction()\">Cancel</button>"+
                "</fieldset>"
            ); //add check form
        });

    });



    //-->
</script>
{% endblock %}