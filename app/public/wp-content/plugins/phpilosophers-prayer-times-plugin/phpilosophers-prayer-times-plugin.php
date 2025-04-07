<?php
/**
 * @package PrayerTimesPlugin
 */
/* 
Plugin Name: Prayer Times Plugin
Plugin URI: http://www.phpilosophers.local
Description: A plugin to display prayer times for a given location.
Version: 1.0
Author: Mark Lessey
Author URI: http://www.phpilosophers.local
License: GPLv2 or later
Text Domain: prayer-times-plugin
*/


defined('ABSPATH') or exit('Cannot access this path directly.');


class PT
{

    function __construct()
    {

        add_shortcode('prayer-time', array($this, 'shortcode_callback'));
        add_action('wp_head', array($this, 'get_prayer_times'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

    }

    function activate()
    {
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    function uninstall()
    {
        // Uninstall code here
    }

    function check_page_exists($slug, $post_type)
    {
        // Make sure that we have values set for $slug and $post_type
        if (!$slug || !$post_type) {
            return false;
        }

        // We will not sanitize the input as get_page_by_path() will handle that
        $post_object = get_page_by_path($slug, OBJECT, $post_type);

        if (!$post_object) {
            return false;
        }

        return $post_object;
    }

    public function shortcode_callback($atts)
    {
        ob_start();

        include plugin_dir_path(__FILE__) . 'templates/prayer-times.php';

        return ob_get_clean();
    }

    function prayer_time_page_setup()
    {

        if ($this->check_page_exists("prayer-time-page", 'page'))
            return;
        wp_insert_post(array(
            'post_title' => "Prayer Times",
            'post_type' => 'page',
            'post_content' => '[prayer-time]',
            'post_name' => 'prayer-time-page',
            'post_status' => 'publish'
        ));
    }


    function register()
    {

    }


    function get_prayer_times()
    {

        if (is_page('prayer-time-page')) {

            // From URL to get webpage contents.
            // $url = "https://api.aladhan.com/v1/methods";

            $date_set = date('d-m-Y', strtotime('now'));
            // Location coordinates for Trinidad and Tobago
            $latitude = 10.657820;
            $longitude = -61.516708;
            $url = "https://api.aladhan.com/v1/timings/$date_set?latitude=$latitude&longitude=$longitude&method=99";


            // Initialize a CURL session.
            $ch = curl_init();

            // Return Page contents.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            //grab URL and pass it to the variable.
            curl_setopt($ch, CURLOPT_URL, $url);

            $raw_data = curl_exec($ch);

            $json_data = json_decode($raw_data, true);

            global $result;
            $result = $json_data['data']['timings'];

            return $result;
        }
    }


    public function enqueue_scripts()
    {
        wp_enqueue_style('prayer-times-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0');

    }


}

$wp = new PT();

?>