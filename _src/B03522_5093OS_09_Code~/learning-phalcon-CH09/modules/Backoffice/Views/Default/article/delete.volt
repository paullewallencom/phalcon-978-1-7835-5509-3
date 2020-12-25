{% extends 'layout.volt' %}
{% block body %}
<h1>Confirm deletion</h1>
<h3>Are you sure you want to delete the selected element?</3>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{{ url('article/delete/' ~ id) }}" class="form-inline">
            <input type="submit" value="Yes, delete" class="btn btn-sm btn-danger btn-block">
            <a href="{{ url('article/list') }}" class="btn btn-lg btn-default btn-block">Cancel</a>
        </form>
    </div>
</div>
{% endblock %}
