{% extends 'layout.volt' %}
{% block body %}
<div class="pull-left">
    <h1>Hashtags</h1>
</div>
<div class="pull-right">
    <a class="btn btn-success" href="{{ url('hashtag/add') }}" aria-label="Left Align">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New
    </a>
</div>
<div class="clearfix"></div>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Hashtag</th>
              <th>Created at</th>
              <th>Options</th>
            </tr>
            </thead>
            <tbody>
            {% for hashtag in hashtags['items'] %}
            <tr>
              <th scope="row">{{ hashtag['id'] }}</th>
              <td>{{ hashtag['hashtag_name'] }}</td>
              <td>{{ hashtag['hashtag_created_at'] }}</td>
              <td>
                <a class="btn btn-default btn-xs" href="{{ url('hashtag/edit/' ~ hashtag['id']) }}" aria-label="Left Align">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <a class="btn btn-danger btn-xs" href="{{ url('hashtag/delete/' ~ hashtag['id']) }}" aria-label="Left Align">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
              </td>
            </tr>
            {% else %}
            <tr>
                <td colspan="4">There are no hashtags in your database</td>
            </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
{% if (hashtags['total_pages'] > 1) %}
{% include 'common/paginator' with {'page_url' : url('hashtag/list'), 'stack' : hashtags} %}
{% endif %}
{% endblock %}
