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
        register_rest_route('apidev/v1', 'posts', [
            'method'                => 'GET',
            'callback'              => [$this, 'posts'],
            'permission_callback'   => '__return_true'
        ]);

        register_rest_route('apidev/v1', 'posts/(?P<id>\d+)', [
            'method'                => 'GET',
            'callback'              => [$this, 'posts_by_id'],
            'permission_callback'   => '__return_true'
        ]);
    }

    // functions: callback
    function posts($request)
    {
        // variables
        $id     = $request->get_param('id');
        $name   = $request->get_param('name');
        $all    = $request->get_params();

        // validation
        if (!is_numeric($id)) {
            return new WP_Error('invalid_id', 'ID field is a numeric field.', ['status' => 400]);
        }

        // data & accept peremeters
        $data = [
            'message'   => "Your requested id = {$id}",
            'name'      => "Name is = {$name}",
            'all'       => $all,
            'status'    => 'success'
        ];

        return new WP_REST_Response($data, 200);
    }

    function posts_by_id($request)
    {
        $id = $request->get_param('id');

        if (!is_numeric($id)) {
            return new WP_Error('invalid_id', 'ID field is a numeric field.', ['status' => 400]);
        }

        $data = [
            'message' => "Your post id = {$id}",
            'status'  => 'success'
        ];

        return new WP_REST_Response($data, 200);
    }
}
