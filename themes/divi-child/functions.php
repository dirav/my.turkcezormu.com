<?php
function divi_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
add_action('wp_enqueue_scripts', 'divi_child_enqueue_styles');

// Add custom Divi modules
function custom_divi_child_modules() {
    if (class_exists('ET_Builder_Module')) {
        include_once('includes/modules/APIUserModule/APISettings.php');
        include_once('includes/modules/APIUserModule/APIUserModule.php');
    }
}
add_action('et_builder_ready', 'custom_divi_child_modules');

// Add Admin Menu
function api_settings_menu() {
    add_menu_page(
        'API Settings',
        'API Settings',
        'manage_options',
        'api-settings',
        'api_settings_page',
        'dashicons-admin-generic',
        100
    );
}
add_action('admin_menu', 'api_settings_menu');

// Create Admin Settings Page
function api_settings_page() {
    // Save API Key
    if (isset($_POST['api_key'])) {
        update_option('custom_api_key', sanitize_text_field($_POST['api_key']));
        $token = generate_api_token($_POST['api_key']);
        if ($token) {
            update_option('custom_api_token', $token);
        }
    }

    $api_key = get_option('custom_api_key', '');
    $api_token = get_option('custom_api_token', '');
    ?>
    <div class="wrap">
        <h2>API Settings</h2>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">API Key</th>
                    <td>
                        <input type="text" name="api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text">
                    </td>
                </tr>
                <?php if ($api_token): ?>
                <tr>
                    <th scope="row">Current Token</th>
                    <td>
                        <code><?php echo esc_html($api_token); ?></code>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
            <?php submit_button('Save and Generate Token'); ?>
        </form>
    </div>
    <?php
}

// Generate API Token
function generate_api_token($api_key) {
    $api_url = 'YOUR_API_TOKEN_ENDPOINT';
    
    $response = wp_remote_post($api_url, array(
        'body' => array(
            'api_key' => $api_key
        ),
        'headers' => array(
            'Content-Type' => 'application/json'
        )
    ));

    if (is_wp_error($response)) {
        add_settings_error(
            'api_token_error',
            'api_token_error',
            'Error generating token: ' . $response->get_error_message(),
            'error'
        );
        return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if (isset($body['token'])) {
        return $body['token'];
    }

    return false;
}

// Helper function to get token
function get_api_token() {
    return get_option('custom_api_token', '');
}
