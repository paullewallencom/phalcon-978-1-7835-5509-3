<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{% block pageTitle %}Learning Phalcon{% endblock %}</title>

{{ stylesheetLink('../assets/default/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
{{ stylesheetLink('../assets/default/css/lp.css') }}

<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    {% block navbar %}
        {% include 'common/navbar.volt' %}
    {% endblock %}

    <div class="container">
        <div class="lp-header">
            <h1 class="lp-title">Learning Phalcon</h1>
            <p class="lead lp-description">The fastest PHP Framework</p>
        </div>
        {{ content() }}
        <div class="row">
            <div class="col-sm-12 lp-main">
                {% block body %}

                {% endblock %}
            </div>
        </div>
    </div>

    {% block footer %}
        {% include 'common/footer.volt' %}
    {% endblock %}

    {{ javascriptInclude("../assets/default/bower_components/jquery/dist/jquery.min.js") }}
    {{ javascriptInclude("../assets/default/bower_components/bootstrap/dist/js/bootstrap.min.js") }}
    {{ javascriptInclude("../assets/default/js/lp.js") }}
    {% block javascripts %} {% endblock %}
</body>
</html>
