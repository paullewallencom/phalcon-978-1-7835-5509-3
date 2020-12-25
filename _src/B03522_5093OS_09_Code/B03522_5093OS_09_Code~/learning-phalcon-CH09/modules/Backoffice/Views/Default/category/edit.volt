{% extends 'layout.volt' %}
{% block body %}
<h1>Edit</h1>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{{ url('category/update') }}">
            {% for locale, name in locales %}
            <h4>Category ({{ name }})</h4>
            <div class="form-group">
                <label for="category_name">Name</label>
                {{ form.render('translations['~locale~'][category_translation_name]', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="category_slug">Slug</label>
                {{ form.render('translations['~locale~'][category_translation_slug]', {'class':'form-control'}) }}
            </div>
            {{ form.render('translations['~locale~'][category_translation_lang]') }}
            {% endfor %}
            {{ form.render('save', {'value':'Save'}) }}
            {{ form.render('csrf', {'value':security.getToken()}) }}
        </form>
    </div>
</div>
{% endblock %}
