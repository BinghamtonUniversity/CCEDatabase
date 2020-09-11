<?php

return [
    'home_page' => '',
    'menu' => '
        <li><a href="{{home_page}}">Home</a></li>
        <li><a href="{{search_page}}">Search</a></li>
        <li><a href="{{organizations_page}}">Organizations</a></li>
        <li><a href="{{newlistings_page}}">Recent Listings</a></li>
    ',
    'footer' => '
        &copy; {{year}} Binghamton University Center for Civic Engagement |
        <a href="https://www.binghamton.edu/cce/about/index.html" style="color:white;">Contact the Office</a>
    ',
];