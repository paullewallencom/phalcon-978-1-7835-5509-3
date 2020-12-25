{% extends 'layout.volt' %}
{% block body %}
<h1>Add</h1>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="post" action="{{ url('user/create') }}">
            <h4>User details</h4>
            <hr>
            <div class="form-group">
                <label for="user_first_name">First name</label>
                {{ form.render('user_first_name', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="user_last_name">Last name</label>
                {{ form.render('user_last_name', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="user_email">Email</label>
                {{ form.render('user_email', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="user_password">Password</label>
                {{ form.render('user_password', {'class':'form-control'}) }}
            </div>
            <div class="form-group">
                <label for="user_is_active">Is active</label>
                {{ form.render('user_is_active', {'class':'form-control'}) }}
            </div>
            <h4>User profile</h4>
            <hr>
            <div class="form-group">
                <label for="user_profile_location">Location</label>
                {{ form.render('user_profile_location', {'class':'form-control'}) }}
            </div>
            <h4>User role</h4>
            <hr>
            <div class="form-group">
                <label for="user_acl_role">Role</label>
                {{ form.render('user_acl_role', {'class':'form-control'}) }}
            </div>
            {{ form.render('save', {'value':'Save'}) }}
            {{ form.render('csrf', {'value':security.getToken()}) }}
        </form>
    </div>
</div>
{% endblock %}
