<nav>
  <ul class="pager">
    <li class="previous {% if (stack['current'] < 2) %}disabled{% endif %}"><a href="{{ page_url ~ '?p=' ~ stack['before'] }}"><span aria-hidden="true">&larr;</span> Previous</a></li>
    <li class="next {% if (stack['current'] == stack['total_pages']) %}disabled{% endif %}"><a href="{{ page_url ~ '?p=' ~ stack['next'] }}">Next <span aria-hidden="true">&rarr;</span></a></li>
  </ul>
</nav>