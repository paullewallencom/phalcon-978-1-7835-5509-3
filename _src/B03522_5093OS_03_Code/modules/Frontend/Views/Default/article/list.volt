{% extends 'layout.volt' %}
{% block body %}
    <ul>
    {% for article in articles %}
        <li><a href="{{ url('article/' ~ article.getArticleSlug()) }}">{{ article.getArticleShortTitle() }}</a></li>
    {% endfor %}
    </ul>
{% endblock %}
