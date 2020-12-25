{% extends 'layout.volt' %}
{% block body %}
<h1>Edit</h1>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{{ url('article/update') }}">
            {% for locale, name in locales %}
            <h3>Article ({{ name }})</h3>
            <hr>
            <div class="form-group">
                <label for="article_translation_short_title">Title</label>
                {{ form.render('translations['~locale~'][article_translation_short_title]', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="article_translation_long_title">Long title</label>
                {{ form.render('translations['~locale~'][article_translation_long_title]', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="article_translation_description">Description</label>
                {{ form.render('translations['~locale~'][article_translation_description]', {'class':'form-control', 'rows': 8}) }}
            </div>
            <div class="form-group">
                <label for="article_translation_slug">Slug</label>
                {{ form.render('translations['~locale~'][article_translation_slug]', {'class':'form-control'}) }}
            </div>
            {{ form.render('translations['~locale~'][article_translation_lang]') }}
            {% endfor %}
            <div class="form-group">
                <label for="article_is_published">Is published</label>
                {{ form.render('article_is_published', {'class':'form-control'}) }}
            </div>
            <h3>Categories</h3>
            <hr>
            <div class="form-group">
                <label for="categories">Select one or more categories</label>
                {{ form.render('categories[]', {'class':'form-control'}) }}
            </div>
            <h3>Hash tags</h3>
            <hr>
            <div class="form-group">
                <label for="hashtags">Select one or more hash tags</label>
                {{ form.render('hashtags[]', {'class':'form-control'}) }}
            </div>
            {{ form.render('save', {'value':'Save'}) }}
            {{ form.render('csrf', {'value':security.getToken()}) }}
        </form>
    </div>
</div>
{% endblock %}
