<?php

class RADP_REST_API_Cookie_Demo
{
    function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
        add_shortcode('rest_api_cookie_demo', [$this, 'render']);
    }

    // routes 
    function register_routes()
    {
        register_rest_route('rest-api-demo/v1', '/cookie-auth', array(
            'methods'               => 'GET',
            'callback'              => array($this, 'cookie_auth_demo'),
            'permission_callback'   => array($this, 'check_cookie_auth'),
        ));

        register_rest_route('rest-api-demo/v1', '/cookie-auth-post', array(
            'methods'               => 'POST',
            'callback'              => array($this, 'cookie_auth_post_demo'),
            'permission_callback'   => array($this, 'check_cookie_auth'),
        ));
    }

    // check cookie auth
    function check_cookie_auth()
    {
        // For cookie authentication, WordPress checks if user is logged in
        // The nonce verification happens automatically for logged-in users
        return is_user_logged_in();
    }

    // collect user information
    public function cookie_auth_demo()
    {
        $current_user = wp_get_current_user();

        return new WP_REST_Response(array(
            'message' => 'Cookie authentication successful!',
            'user_id' => $current_user->ID,
            'user_login' => $current_user->user_login,
            'user_email' => $current_user->user_email,
            'display_name' => $current_user->display_name,
            'timestamp' => current_time('mysql'),
            'method' => 'GET'
        ), 200);
    }

    public function cookie_auth_post_demo() {}

    // shortcode
    function render()
    {
        $nonce = wp_create_nonce('wp_rest');
        ob_start(); ?>

        <div id="rest-api-cookie-demo" style="margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h3>REST API Cookie Authentication Demo</h3>
            <p>This button demonstrates cookie authentication with WordPress REST API.</p>
            <?php if (is_user_logged_in()): ?>
                <p><strong>Status:</strong> You are logged in as <?php echo wp_get_current_user()->display_name; ?></p>
                <button id="cookie-auth-get-btn" class="button">Test GET with Cookie Auth</button>
                <button id="cookie-auth-post-btn" class="button">Test POST with Cookie Auth</button>
                <button id="cookie-auth-unauthorized-btn" class="button" style="background: #dc3232; color: white; margin-left: 10px;">Test Unauthorized Call</button>
            <?php else: ?>
                <p><strong>Status:</strong> You are not logged in. Please <a href="<?php echo wp_login_url(get_permalink()); ?>">login</a> to test cookie authentication.</p>
                <button id="cookie-auth-guest-btn" class="button" disabled>Login Required</button>
                <button id="cookie-auth-unauthorized-guest-btn" class="button" style="background: #dc3232; color: white; margin-left: 10px;">Test Unauthorized Call</button>
            <?php endif; ?>
            <div id="demo-response" style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-radius: 3px; display: none;"></div>
        </div>

        <style>
            /* Container styling */
            #rest-api-cookie-demo {
                max-width: 600px;
                margin: 20px auto;
                padding: 24px;
                background: #ffffff;
                border: 1px solid #dbeafe;
                /* Light blue border */
                border-radius: 8px;
                /* Applied 8px radius */
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            /* Typography */
            #rest-api-cookie-demo h3 {
                margin: 0 0 15px 0;
                color: #1e3a8a;
                /* Deep blue header */
                font-size: 1.2rem;
            }

            #rest-api-cookie-demo p {
                color: #475569;
                font-size: 0.95rem;
                margin-bottom: 20px;
            }

            /* Button Styling */
            #rest-api-cookie-demo .button {
                display: inline-block;
                padding: 10px 18px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                border: none;
                margin-right: 8px;
                margin-bottom: 10px;
                border-radius: 6px;
                /* Your 4-8px range preference */
                background-color: #2563eb;
                /* Primary Blue */
                color: #ffffff !important;
                text-decoration: none;
            }

            #rest-api-cookie-demo .button:hover {
                background-color: #1d4ed8;
                /* Darker blue on hover */
                box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
            }

            /* Unauthorized/Danger Button Variation */
            #cookie-auth-unauthorized-btn,
            #cookie-auth-unauthorized-guest-btn {
                background-color: #ef4444 !important;
                /* Red for alert */
                margin-left: 0 !important;
            }

            #cookie-auth-unauthorized-btn:hover,
            #cookie-auth-unauthorized-guest-btn:hover {
                background-color: #dc2626 !important;
            }

            /* Disabled State */
            #rest-api-cookie-demo .button:disabled {
                background-color: #cbd5e1 !important;
                color: #64748b !important;
                cursor: not-allowed;
                box-shadow: none;
            }

            /* Response Console */
            #demo-response {
                margin-top: 20px;
                padding: 12px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 4px;
                /* Slightly sharper radius for terminal look */
                font-family: monospace;
                font-size: 0.85rem;
                color: #1e40af;
                display: none;
            }
        </style>

<?php return ob_get_clean();
    }
}
