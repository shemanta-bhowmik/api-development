<?php

class APIDEV
{
    // constructs
    function __construct()
    {
        add_action('rest_api_init', [$this, 'render_routes']);
    }

    // functions: routes
    function render_routes()
    {
        register_rest_route('apidev/v2', 'apidev', [
            'method'                => 'GET',
            'callback'              => [$this, 'apidev'],
            'permission_callback'   => __return_true
        ]);
    }

    // functions: callback
    function apidev() {}
}
