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
