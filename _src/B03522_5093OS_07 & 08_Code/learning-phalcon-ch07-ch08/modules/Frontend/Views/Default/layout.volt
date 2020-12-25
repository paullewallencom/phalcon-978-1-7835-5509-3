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
    {% block body %}
    <h1>I did it !</h1>
    {% endblock %}

    {{ javascriptInclude("../assets/default/bower_components/jquery/dist/jquery.min.js") }}
    {{ javascriptInclude("../assets/default/bower_components/bootstrap/dist/js/bootstrap.min.js") }}
    {{ javascriptInclude("../assets/default/js/lp.js") }}
    {% block javascripts %} {% endblock %}
</body>
</html>
