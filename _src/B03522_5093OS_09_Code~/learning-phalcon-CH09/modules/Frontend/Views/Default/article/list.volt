{% extends 'layout.volt' %}
{% block body %}
    {% if records['total_items'] > 0 %}
    {% include 'article/common/list.item' with {'records':records} %}
    {% endif %}
    {% if records['total_items'] > 2 %}
    {% include 'common/paginator' with {'records':records} %}
    {% endif %}
{% endblock %}
