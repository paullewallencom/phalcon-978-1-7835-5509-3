{% extends 'layout.volt' %}
{% block body %}
<div class="pull-left">
    <h1>Users</h1>
</div>
<div class="pull-right">
    <a class="btn btn-success" href="{{ url('user/add') }}" aria-label="Left Align">
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
              <th>Name</th>
              <th>Email</th>
              <th>Location</th>
              <th>Created at</th>
              <th>Options</th>
            </tr>
            </thead>
            <tbody>
            {% for record in records['items'] %}
            <tr>
              <th scope="row">{{ record['id'] }}</th>
              <td>{{ record['user_first_name'] }} {{ record['user_last_name'] }}</td>
              <td>{{ record['user_email'] }}</td>
              <td>{{ record['user_profile']['user_profile_location'] }}</td>
              <td>{{ record['user_created_at'] }}</td>
              <td>
                <a class="btn btn-default btn-xs" href="{{ url('user/edit/' ~ record['id']) }}" aria-label="Left Align">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <a class="btn btn-danger btn-xs" href="{{ url('user/delete/' ~ record['id']) }}" aria-label="Left Align">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
              </td>
            </tr>
            {% else %}
            <tr>
                <td colspan="4">There are no records in your database</td>
            </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
{% if (records['total_pages'] > 1) %}
{% include 'common/paginator' with {'page_url' : url('user/list'), 'stack' : records} %}
{% endif %}
{% endblock %}
