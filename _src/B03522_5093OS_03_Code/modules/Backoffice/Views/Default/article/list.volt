{% extends 'layout.volt' %} {% block body %}
<h1 class="page-header">Articles</h1>
<h2 class="sub-header">List</h2>
<div class="table-responsive">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Is publised</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
        {% for article in articles %}
            <tr>
                <td>{{ article.getId() }}</td>
                <td>{{ article.getArticleShortTitle() }}</td>
                <td>{{ article.getIsPublished() }}</td>
                <td>{{ article.getCreatedAt() }}</td>
                <td>{{ article.getUpdatedAt() }}</td>
                <td>
                    <a href="{{ url('article/edit/' ~ article.getId()) }}">Edit</a> |
                    <a href="{{ url('article/delete/' ~ article.getId()) }}">Delete</a> |
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

</div>
{% endblock %}
