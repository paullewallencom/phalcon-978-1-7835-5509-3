<div class="lp-masthead">
    <div class="container">
        <nav class="lp-nav">
            <a class="lp-nav-item active" href="{{ url('') }}">Home</a>
            {% for category in categories['items'] %}
            <a class="lp-nav-item" href="{{ url('categories/' ~ category['category_translations'][0]['category_translation_slug']) }}">{{ category['category_translations'][0]['category_translation_name'] }}</a>
            {% endfor %}
        </nav>
    </div>
</div>
