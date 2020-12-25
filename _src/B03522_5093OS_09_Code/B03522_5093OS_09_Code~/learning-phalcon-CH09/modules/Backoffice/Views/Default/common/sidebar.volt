{% set c_name = dispatcher.getControllerName() %}
<ul class="nav nav-sidebar">
    <li{% if c_name == 'article' %} class="active"{% endif %}><a href="{{ url('article/list') }}">Articles</a></li>
    <li{% if c_name == 'category' %} class="active"{% endif %}><a href="{{ url('category/list') }}">Categories</a></li>
    <li{% if c_name == 'hashtag' %} class="active"{% endif %}><a href="{{ url('hashtag/list') }}">Hashtags</a></li>
    <li{% if c_name == 'user' %} class="active"{% endif %}><a href="{{ url('user/list') }}">Users</a></li>
</ul>
