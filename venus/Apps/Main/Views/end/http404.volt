{% extends 'layouts/bs.volt' %} {% block page_content %}

<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3>{{ text.simple('http404') }}
            <small>{{ text.simple('http404_message') }}</small>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                {{content()}}
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />

            </div>
        </div>
    </div>
</section>

{% endblock %} {% block pagetitle %}404: Not Found{% endblock %} {% block endofhead %}
<link href="{{ viewconf.assets }}vendor/summernote/css/summernote.css" rel="stylesheet"> {% endblock %} {% block endofbody %}
<script src="{{ viewconf.assets }}vendor/summernote/js/summernote.js"></script>
<script src="http://venus.dev/wiky.js"></script>
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