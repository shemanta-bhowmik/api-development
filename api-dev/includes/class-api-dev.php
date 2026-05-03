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
        register_rest_route('apidev/v1', 'test', [
            'method'                => 'GET',
            'callback'              => [$this, 'test'],
            'permission_callback'   => '__return_true'
        ]);
    }

    // functions: callback
    function test($request)
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
}
