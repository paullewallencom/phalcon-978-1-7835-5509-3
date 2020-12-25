{% for record in records['items'] %}
{% if (record['article_is_published'] == 1) %}
<div class="lp-post">
    <h2 class="lp-post-title">{{ record['article_translations'][0]['article_translation_short_title'] }}</h2>
    <p class="lp-post-meta">{{ record['article_created_at']|date("d M Y") }} by <a href="#">{{ record['article_author']['user_first_name'] }} {{ record['article_author']['user_last_name'] }}</a></p>

    <p>
        {{ record['article_translations'][0]['article_translation_long_title'] }}
        <a href="{{ url('articles/' ~ record['article_translations'][0]['article_translation_slug']) }}">Read more</a>
    </p>
</div>
{% endif %}
{% endfor %}
