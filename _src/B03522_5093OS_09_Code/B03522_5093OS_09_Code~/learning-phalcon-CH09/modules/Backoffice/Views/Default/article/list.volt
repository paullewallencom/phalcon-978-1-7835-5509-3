{% extends 'layout.volt' %} {% block body %}
<div class="pull-left">
    <h1>Articles</h1>
</div>
<div class="pull-right">
    <a class="btn btn-success" href="{{ url('article/add') }}" aria-label="Left Align">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New
    </a>
</div>
<div class="clearfix"></div>
<hr>
<div class="table-responsive">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Is publised</th>
                <th>Author</th>
                <th>Created at</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
        {% for record in records['items'] %}
            <tr>
                <td>{{ record['id'] }}</td>
                <td>{{ record['article_translations'][0]['article_translation_short_title'] }}</td>
                <td>{{ record['article_is_published'] }}</td>
                <td>{{ record['article_author']['user_first_name'] }} {{ record['article_author']['user_last_name'] }}</td>
                <td>{{ record['article_created_at'] }}</td>
                <td>
                    <a class="btn btn-default btn-xs" href="{{ url('article/edit/' ~ record['id']) }}" aria-label="Left Align">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-danger btn-xs" href="{{ url('article/delete/' ~ record['id']) }}" aria-label="Left Align">
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
{% if (records['total_pages'] > 1) %}
{% include 'common/paginator' with {'page_url' : url('article/list'), 'stack' : records} %}
{% endif %}
{% endblock %}
