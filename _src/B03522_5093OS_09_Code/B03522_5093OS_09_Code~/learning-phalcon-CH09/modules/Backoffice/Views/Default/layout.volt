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
    {% include 'common/topbar.volt' %}
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        {% include 'common/sidebar.volt' %}
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          {{ content() ~ flashSession.output() }}

          {% block body %}
          <h1 class="page-header">Dashboard</h1>
          <h2 class="sub-header">Section title</h2>
          <div class="table-responsive">

          </div>
          {% endblock %}
        </div>
      </div>
    </div>

    {{ assets.outputJs('footerJs') }}
    {% block javascripts %} {% endblock %}
</body>
</html>
