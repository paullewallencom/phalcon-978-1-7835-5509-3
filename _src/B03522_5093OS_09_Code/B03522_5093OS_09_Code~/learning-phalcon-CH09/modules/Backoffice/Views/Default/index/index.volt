{% extends 'layout.volt' %}
{% block body %}
<div class="row">
    <div class="col-md-6 col-xs-6 text-center">
        <h1>{{ dashboard['total_articles'] }} <span class="glyphicon glyphicon-align-justify"></span></h1>
        <small>Articles</small>
    </div>
    <div class="col-md-6 col-xs-6 text-center">
        <h1>{{ dashboard['total_categories'] }} <span class="glyphicon glyphicon-th"></span></h1>
        <small>Categories</small>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-xs-6 text-center">
        <h1>{{ dashboard['total_hashtags'] }} <span class="glyphicon glyphicon-tag"></span></h1>
        <small>Tags</small>
    </div>
    <div class="col-md-6 col-xs-6 text-center">
        <h1>{{ dashboard['total_users'] }} <span class="glyphicon glyphicon-user"></span></h1>
        <small>Users</small>
    </div>
</div>
{% endblock %}
