<?php
class DIVI_API_User_Module extends ET_Builder_Module {
    public function init() {
        $this->name = esc_html__('API User Data', 'divi-child');
        $this->slug = 'divi_api_user_module';
        $this->vb_support = 'on';
    }

    public function get_fields() {
        return array(
            'user_id' => array(
                'label'           => esc_html__('User ID', 'divi-child'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Enter the User ID', 'divi-child'),
                'toggle_slug'     => 'main_content',
            ),
        );
    }

    public function render($attrs, $content = null, $render_slug) {
        $user_id = $this->props['user_id'];
        $api_token = get_api_token();

        if (empty($api_token)) {
            return '<div class="api-error">API token not configured</div>';
        }

        $user_data = $this->get_user_data($user_id, $api_token);
        
        if (is_wp_error($user_data)) {
            return '<div class="api-error">' . $user_data->get_error_message() . '</div>';
        }

        return $this->format_user_data($user_data);
    }

    private function get_user_data($user_id, $token) {
        $api_url = 'YOUR_API_ENDPOINT/users/' . $user_id;
        
        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            )
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (empty($body)) {
            return new WP_Error('no_data', 'No user data found');
        }

        return $body;
    }

    private function format_user_data($data) {
        $output = '<div class="api-user-data">';
        
        // Customize this based on your API response structure
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $output .= sprintf(
                    '<div class="user-field">
                        <strong>%s:</strong> %s
                    </div>',
                    esc_html(ucfirst($key)),
                    esc_html($value)
                );
            }
        }
        
        $output .= '</div>';
        return $output;
    }
}

new DIVI_API_User_Module;