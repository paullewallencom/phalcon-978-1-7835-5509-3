{% for record in records['items'] %}
{% if (record['article_is_published'] == 1) %}
<div class="lp-post">
    <h2 class="lp-post-title">{{ record['article_translations'][0]['article_translation_short_title'] }}</h2>
    <p class="lp-post-meta">
    {{ record['article_created_at']|date("d M Y") }} by <a href="#">{{ record['article_author']['user_first_name'] }} {{ record['article_author']['user_last_name'] }}</a>
    {% if dispatcher.getActionName() == 'read') %}
    <span class="pull-right glyphicon glyphicon-eye-open">
        {{ total_views }}
    </span>
    {% endif %}
    </p>

    <p>
        <strong>{{ record['article_translations'][0]['article_translation_long_title'] }}</strong>
    </p>
    <p>
        {{ record['article_translations'][0]['article_translation_description'] }}
    </p>
</div>
{% endif %}
{% endfor %}
