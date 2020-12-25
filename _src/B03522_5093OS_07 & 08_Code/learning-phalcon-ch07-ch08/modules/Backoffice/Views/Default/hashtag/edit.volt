{% extends 'layout.volt' %}
{% block body %}
<h1>Edit</h1>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{{ url('hashtag/update') }}">
            <div class="form-group">
                <label for="hashtag_name">Name</label>
                {{ form.render('hashtag_name', {'class':'form-control'}) }}
            </div>
            {{ form.render('save', {'value':'Save'}) }}
            {{ form.render('csrf', {'value':security.getToken()}) }}
        </form>
    </div>
</div>
{% endblock %}
