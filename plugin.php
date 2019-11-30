<?php

/**
 * Plugin Name:       WP Smooth Scroll Up Pluign by OA
 * Plugin URI:        https://oadev.site
 * Description:       Smooth Scroll Up is a lightweight plugin that creates a customizable back to top feature in your WordPress website.
 * Version:           1.2.1
 * Author:            Oluwarotimi Akintan 
 * Author URI:        https://oadev.site
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smooth-scroll-up-plugin-OA
 * Domain Path:       /languages
 */

define('SMTH_SCRL_UP_PLUGIN_DIR', 'smooth-scroll-up');
define('SMTH_SCRL_UP_PLUGIN_NAME', 'Smooth Scroll Up');

class Smooth_Scroll_Up
{
    /**
     * Constructor
     */
    public function __construct()
    {

        //Load localisation files
        add_action("plugins_loaded", array(&$this, "ssu_text_domain"));

        //Set Up Scroll Up Element
        include_once plugin_dir_path(__FILE__) . '/lib/class-scrollup-handler.php';
        new ScrollUp_Handler();

        //Options Page
        include_once plugin_dir_path(__FILE__) . '/lib/class-options-handler.php';
        new Options_Handler();

        //Action links
        add_filter('plugin_action_links', array(&$this, 'ssu_action_links'), 10, 2);
    }

    /**
     * This function add action links in plugins listing page
     */
    function ssu_action_links($links, $file) {
        static $current_plugin = '';

        if (!$current_plugin) {
            $current_plugin = plugin_basename(__FILE__);
        }

        if ($file == $current_plugin) {
            $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=smooth-scroll-up">' . __('Settings', 'smooth-scroll-up') . '</a>';
            array_unshift($links, $settings_link);
        }

        return $links;
    }

    /**
     * This function loads the text domain
     */
    function ssu_text_domain() {
        load_plugin_textdomain('smooth-scroll-up', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}

new Smooth_Scroll_Up();
