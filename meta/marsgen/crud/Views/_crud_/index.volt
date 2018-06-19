{% extends 'layouts/bs.volt' %}

{% block page_content %}
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row">

            <!--content-->
            <div class="col-lg-9">
                <div class="panel panel-default">
                <div class="panel-heading">{{ text.simple('list') }}</div>
                    
                    {#{dump(data)}#}
                    <div class="table-responsive">
                           <table class="table table-striped table-hover">
                              <thead>
                                 <tr>
                                    <th>_Key</th>
                                    /*{for:areas}*/
                                    <th>/*{areas>name}*/</th>
                                    /*{/for}*/
                                 </tr>
                              </thead>
                              <tbody>
                              {% for row in data %}
                                 <tr id="row{{row['_key']}}">
                                    <td>{{row['_key']}}</td>
                                    /*{for:areas}*/
                                    <td>{{row['/*{areas>name}*/']}}</td>
                                    /*{/for}*/
                                    <td>
                                        
                                    <a href="{{ viewconf.baseurl }}{{lang}}//*{classPrefix_}*//read/{{row['_key']}}" title="See Details">
                                       <span class="fa fa-eye"></span>
                                    </a>
                                    <a href="{{ viewconf.baseurl }}{{lang}}//*{classPrefix_}*//update/{{row['_key']}}" title="Edit">
                                       <span class="fa fa-edit"></span>
                                    </a>

                                    <a href="javascript:deleteItem('{{row['_key']}}')" title="Delete">
                                       <span class="fa fa-trash"></span>
                                    </a>
                           
                                    </td>
                                 </tr>
                              {% endfor %}
                              </tbody>
                           </table>
                        </div>
                        <br />
                      <div class="text-center mb-lg">
                        <nav>
                          <ul class="pagination m0">
                            {{ htmlgen.pagination(on_page , total_page , viewconf.baseurl ~ lang ~ '//*{classPrefix_}*//index/%PAGE%')}}
                          </ul>
                        </nav>
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
<link href="{{ viewconf.assets }}vendor/sweetalert/dist/sweetalert.css"rel="stylesheet">
{% endblock %} 

{# PAGE FOOTER CONTENT FOR SCRIPTS #}

{% block endofbody %}
<script src="{{ viewconf.baseurl }}djs/summernote.min.js.php?f=CHANGE_ME&sf={{lang}}"></script>
<script src="{{ viewconf.assets }}vendor/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    <!--

    function deleteItem(key){
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
            url: '{{viewconf.baseurl}}{{lang}}//*{classPrefix_}*//delete/' + key,
            dataType: "json",
            success: function(data){
                if(data.deleted){
                    swal("Deleted!", data.message, "success")
                    $('#row'+key).remove()
                }else{
                    swal("Failed to delete", 'Error: '+data.message, "error")
                }
            }
        });

    });
};

    $(document).ready(function() {
        $('.summernote').summernote({
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
{% endblock %}