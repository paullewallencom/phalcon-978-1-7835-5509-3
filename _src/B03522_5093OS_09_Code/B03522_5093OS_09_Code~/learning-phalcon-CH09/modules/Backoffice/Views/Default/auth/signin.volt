{% extends 'layout_simple.volt' %}
{% block pageTitle %}Sign in{% endblock %}
{% block css %}
    {{ assets.outputCss('signin') }}
{% endblock %}
{% block body %}

<form class="form-signin" method="post" action="">
    {{ content() ~ flashSession.output() }}
    <h2 class="form-signin-heading">Sign in</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    {{ signinForm.render('email', {'class':'form-control', 'required':true, 'autofocus':true, 'type':'email'}) }}
    <label for="inputPassword" class="sr-only">Password</label>
    {{ signinForm.render('password', {'class':'form-control', 'required':true}) }}
    <div class="checkbox">
        <label>
           {{ signinForm.render('remember') }} Remember me
        </label>
    </div>
    {{ signinForm.render('signin', {'value':'Sign in'}) }}
    {{ signinForm.render('csrf', {'value':security.getToken()}) }}
</form>

{% endblock %}
