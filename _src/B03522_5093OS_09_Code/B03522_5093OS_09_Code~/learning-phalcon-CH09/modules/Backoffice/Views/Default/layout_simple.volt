<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{% block pageTitle %}Learning Phalcon{% endblock %}</title>
{{ stylesheetLink('../assets/default/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
{{ assets.outputCss('headerCss') }}
{% block css %}{% endblock %}

<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 main">
          {% block body %}

          {% endblock %}
        </div>
      </div>
    </div>

    {{ assets.outputJs('footerJs') }}
    {% block javascripts %} {% endblock %}
</body>
</html>
