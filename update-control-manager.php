<?php
/*
Plugin Name: Update Control Manager
Description: Provides an interface to control updates. Stops all update checks for plugins, themes, and core.
Version: 1.1.0
Author: Md Mahfuz Reham
Author URI: https://github.com/mahfuzreham
Plugin URI: https://github.com/mahfuzreham/update-control-manager
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register settings
function ucm_register_settings() {
    register_setting('ucm_settings_group', 'disable_plugin_updates');
    register_setting('ucm_settings_group', 'disable_theme_updates');
    register_setting('ucm_settings_group', 'disable_core_updates');
}
add_action('admin_init', 'ucm_register_settings');

// Add Admin Menu
function ucm_add_admin_menu() {
    add_menu_page(
        'Update Control Manager',     // Page title
        'Update Control',             // Menu title
        'manage_options',             // Capability
        'update-control-manager',     // Menu slug
        'ucm_settings_page',          // Callback function
        'dashicons-admin-tools',      // Icon
        81                            // Menu position
    );
}
add_action('admin_menu', 'ucm_add_admin_menu');

// Render Settings Page
function ucm_settings_page() { 
    ?>
    <div class="wrap">
        <h1 style="margin-bottom: 10px;">Update Control Manager V1.0</h1>
        <p style="font-size: 16px;">Control WordPress updates for plugins, themes, and the core system.</p>
        <form method="post" action="options.php">
            <div style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
                <?php
                settings_fields('ucm_settings_group');
                do_settings_sections('update-control-manager');
                submit_button('Save Settings');
                ?>
            </div>
        </form>

   
        <!-- Remote Ads Section -->
        <div style="margin-top: 30px; background: #f4f4f4; padding: 15px; border: 1px solid #ddd; border-radius: 8px; text-align: center;">
            <h2 style="margin-bottom: 5px; font-size: 18px;"><a href="https://mahfuzreham.com/ads-ucm"><img src="https://i.ibb.co.com/zHCzJ11/Host-Mdn-Banner.png" alt="HostMdn- Banner" border="0"></a></h2>
           
        </div>

        <!-- Author Section -->
        <div style="margin-top: 30px; background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px; display: flex; align-items: center; gap: 20px; max-width: 600px;">
            <img src="https://simgbb.com/avatar/rGdkw6kJr7gt.jpg" alt="Author Picture" style="border-radius: 50%; width: 100px; height: 100px;">
            <div>
                <h3 style="margin: 0;">Md Mahfuz Reham</h3>
                <p style="margin: 5px 0;"><strong>Plugin Author</strong></p>
                <p style="margin: 0;">GitHub Profile: <a href="https://github.com/mahfuzreham" target="_blank">Visit Here</a></p>
                 <p style="margin: 0;">Website: <a href="https://mahfuzreham.com" target="_blank">Visit Here</a></p>
                 <a href="https://www.buymeacoffee.com/mahfuzreham"><img src="https://img.buymeacoffee.com/button-api/?text=Buy me an internet&emoji=🌐&slug=mahfuzreham&button_colour=5F7FFF&font_colour=ffffff&font_family=Lato&outline_colour=000000&coffee_colour=FFDD00" /></a>

            </div>
        </div>
    </div>
    <?php
}

// Register Settings Fields
function ucm_register_fields() {
    add_settings_section(
        'ucm_main_section',
        '',
        '__return_false', // No section title
        'update-control-manager'
    );

    // Disable Plugin Updates Field
    add_settings_field(
        'disable_plugin_updates',
        '<strong>Disable Plugin Updates</strong>',
        'ucm_plugin_updates_callback',
        'update-control-manager',
        'ucm_main_section'
    );

    // Disable Theme Updates Field
    add_settings_field(
        'disable_theme_updates',
        '<strong>Disable Theme Updates</strong>',
        'ucm_theme_updates_callback',
        'update-control-manager',
        'ucm_main_section'
    );

    // Disable Core Updates Field
    add_settings_field(
        'disable_core_updates',
        '<strong>Disable WordPress Core Updates</strong>',
        'ucm_core_updates_callback',
        'update-control-manager',
        'ucm_main_section'
    );
}
add_action('admin_init', 'ucm_register_fields');

// Field Callbacks
function ucm_plugin_updates_callback() {
    $value = get_option('disable_plugin_updates');
    echo '<label><input type="checkbox" name="disable_plugin_updates" value="1" ' . checked(1, $value, false) . '> Disable Plugin Updates</label>';
}

function ucm_theme_updates_callback() {
    $value = get_option('disable_theme_updates');
    echo '<label><input type="checkbox" name="disable_theme_updates" value="1" ' . checked(1, $value, false) . '> Disable Theme Updates</label>';
}

function ucm_core_updates_callback() {
    $value = get_option('disable_core_updates');
    echo '<label><input type="checkbox" name="disable_core_updates" value="1" ' . checked(1, $value, false) . '> Disable WordPress Core Updates</label>';
}

// Disable Plugin Updates
if (get_option('disable_plugin_updates')) {
    add_filter('auto_update_plugin', '__return_false');
    add_filter('site_transient_update_plugins', '__return_null');
}

// Disable Theme Updates
if (get_option('disable_theme_updates')) {
    add_filter('auto_update_theme', '__return_false');
    add_filter('site_transient_update_themes', '__return_null');
}

// Disable Core Updates
if (get_option('disable_core_updates')) {
    add_filter('auto_update_core', '__return_false');
    add_filter('pre_site_transient_update_core', '__return_null');
}


<?php
/*
Plugin Name: Update Control Manager
Description: Provides an interface to control updates. Stops all update checks for plugins, themes, and core.
Version: 1.1.0
Author: Md Mahfuz Reham
Author URI: https://github.com/mahfuzreham
Plugin URI: https://github.com/mahfuzreham/update-control-manager
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin version and constants
define('UCM_VERSION', '1.1.0');
define('UCM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UCM_TEXT_DOMAIN', 'update-control-manager');

// Register settings
function ucm_register_settings() {
    register_setting('ucm_settings_group', 'disable_plugin_updates', 'absint');
    register_setting('ucm_settings_group', 'disable_theme_updates', 'absint');
    register_setting('ucm_settings_group', 'disable_core_updates', 'absint');
}
add_action('admin_init', 'ucm_register_settings');

// Add Admin Menu
function ucm_add_admin_menu() {
    add_menu_page(
        __('Update Control Manager', UCM_TEXT_DOMAIN),     // Page title
        __('Update Control', UCM_TEXT_DOMAIN),             // Menu title
        'manage_options',                                  // Capability
        'update-control-manager',                          // Menu slug
        'ucm_settings_page',                               // Callback function
        'dashicons-admin-tools',                           // Icon
        81                                                 // Menu position
    );
}
add_action('admin_menu', 'ucm_add_admin_menu');

// Render Settings Page
function ucm_settings_page() { 
    ?>
    <div class="wrap">
        <h1 style="margin-bottom: 10px;"><?php _e('Update Control Manager V1.1.1', UCM_TEXT_DOMAIN); ?></h1>
        <p style="font-size: 16px;"><?php _e('Control WordPress updates for plugins, themes, and the core system.', UCM_TEXT_DOMAIN); ?></p>
        <form method="post" action="options.php">
            <?php
            settings_fields('ucm_settings_group');
            wp_nonce_field('ucm_settings_nonce_action', 'ucm_settings_nonce');
            ?>
            <div style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); max-width: 600px;">
                <?php do_settings_sections('update-control-manager'); ?>
                <?php submit_button(__('Save Settings', UCM_TEXT_DOMAIN)); ?>
            </div>
        </form>
    </div>
    <?php
}

// Register Settings Fields
function ucm_register_fields() {
    add_settings_section(
        'ucm_main_section',
        '',
        '__return_false',
        'update-control-manager'
    );

    add_settings_field(
        'disable_plugin_updates',
        '<strong>' . __('Disable Plugin Updates', UCM_TEXT_DOMAIN) . '</strong>',
        'ucm_plugin_updates_callback',
        'update-control-manager',
        'ucm_main_section'
    );

    add_settings_field(
        'disable_theme_updates',
        '<strong>' . __('Disable Theme Updates', UCM_TEXT_DOMAIN) . '</strong>',
        'ucm_theme_updates_callback',
        'update-control-manager',
        'ucm_main_section'
    );

    add_settings_field(
        'disable_core_updates',
        '<strong>' . __('Disable WordPress Core Updates', UCM_TEXT_DOMAIN) . '</strong>',
        'ucm_core_updates_callback',
        'update-control-manager',
        'ucm_main_section'
    );
}
add_action('admin_init', 'ucm_register_fields');

// Callbacks for settings fields
function ucm_plugin_updates_callback() {
    $value = get_option('disable_plugin_updates');
    echo '<label><input type="checkbox" name="disable_plugin_updates" value="1" ' . checked(1, $value, false) . '> ' . __('Disable Plugin Updates', UCM_TEXT_DOMAIN) . '</label>';
}

function ucm_theme_updates_callback() {
    $value = get_option('disable_theme_updates');
    echo '<label><input type="checkbox" name="disable_theme_updates" value="1" ' . checked(1, $value, false) . '> ' . __('Disable Theme Updates', UCM_TEXT_DOMAIN) . '</label>';
}

function ucm_core_updates_callback() {
    $value = get_option('disable_core_updates');
    echo '<label><input type="checkbox" name="disable_core_updates" value="1" ' . checked(1, $value, false) . '> ' . __('Disable WordPress Core Updates', UCM_TEXT_DOMAIN) . '</label>';
}

// Disable updates based on settings
function ucm_disable_updates() {
    // Security nonce check
    if (!isset($_POST['ucm_settings_nonce']) || !wp_verify_nonce($_POST['ucm_settings_nonce'], 'ucm_settings_nonce_action')) {
        return;
    }

    if (get_option('disable_plugin_updates')) {
        add_filter('auto_update_plugin', '__return_false');
        add_filter('site_transient_update_plugins', '__return_null');
    }

    if (get_option('disable_theme_updates')) {
        add_filter('auto_update_theme', '__return_false');
        add_filter('site_transient_update_themes', '__return_null');
    }

    if (get_option('disable_core_updates')) {
        add_filter('auto_update_core', '__return_false');
        add_filter('pre_site_transient_update_core', '__return_null');
    }
}
add_action('init', 'ucm_disable_updates');

// Custom plugin update checker for GitHub
function update_control_manager_check_for_updates($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    // URL to your updates.json file
    $remote_url = 'https://raw.githubusercontent.com/mahfuzreham/update-control-manager/main/updates.json';

    // Fetch updates.json
    $response = wp_remote_get($remote_url);

    if (is_wp_error($response)) {
        return $transient;
    }

    $update_data = json_decode(wp_remote_retrieve_body($response));

    if ($update_data && isset($update_data->version)) {
        $current_version = get_plugin_data(__FILE__)['Version'];

        // Check for a new version
        if (version_compare($current_version, $update_data->version, '<')) {
            $transient->response[$update_data->slug] = (object) array(
                'slug'        => $update_data->slug,
                'plugin'      => $update_data->slug . '/' . $update_data->slug . '.php',
                'new_version' => $update_data->version,
                'url'         => 'https://github.com/mahfuzreham/update-control-manager', // Changelog link
                'package'     => $update_data->download_url,
            );
        }
    }

    return $transient;
}
add_filter('pre_set_site_transient_update_plugins', 'update_control_manager_check_for_updates');

// Clear update cache after plugin updates
function update_control_manager_clear_update_cache($upgrader_object, $options) {
    if ($options['action'] === 'update' && $options['type'] === 'plugin') {
        delete_site_transient('update_plugins');
    }
}
add_action('upgrader_process_complete', 'update_control_manager_clear_update_cache', 10, 2);


