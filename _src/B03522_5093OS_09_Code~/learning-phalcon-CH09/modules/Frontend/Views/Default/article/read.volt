{% extends 'layout.volt' %}
{% block body %}
    {% include 'article/common/item' with {'records':records, 'total_views' : total_views} %}
{% endblock %}
