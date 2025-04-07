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
        add_action('wp_head', array($this, 'prayer_time_page_setup'));
        add_action('wp_head', array($this, 'get_prayer_times'));

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
            'post_title' => "Prayer Time",
            'post_type' => 'page',
            'post_content' => '[prayer-time]',
            'post_name' => 'prayer-time-page',
            'post_status' => 'publish'
        ));
    }

    function generate_html()
    {
        if (is_page('prayer-time-page'))
            include plugin_dir_path(__FILE__) . 'templates/prayer-times.php';
    }

    function generate_html2()
    {
        if (is_page('prayer-time-page'))
            include plugin_dir_path(__FILE__) . 'templates/sampe.php';
    }


    function register()
    {
        add_action('admin_menu', array($this, 'add_admin_page'));

    }

    function add_admin_page()
    {
        add_menu_page("Prayer Times Plugin", "Prayer Times", "manage_options", "prayer_times_plugin", array($this, "admin_index"), 'dashicons-clock', 110);
    }

    function admin_index()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/prayer-times.php';
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

            $result = $json_data['data']['timings'];

            return $result;
        }
    }

    function display_prayer_times()
    {

        $result = $this->get_prayer_times();
        $date_set = date('d-m-Y', strtotime('now'));

        // return ("<div class='prayer-times'>Upcoming Prayer Times in Port Of Spain:<br><br>$date_set<br>" . implode("<br>", array_map(function($key, $value) {
        //     return "$key : " . date('h:i', strtotime($value));
        // }, array_keys($result), $result)) . "</div>");

        // echo "Upcoming Prayer Times in Port Of Spain:<br>";
        // echo "<br>";
        // echo $date_set . "<br>";
        // foreach ($result as $key => $value) {
        //     echo "<br>";
        //     echo $key . " : " . date('h:i',strtotime($value)) ;
        //     echo "<br>";
        // }

        $this->generate_html();
    }

    function display_prayer_times2()
    {

        $result = $this->get_prayer_times();
        $date_set = date('d-m-Y', strtotime('now'));

        // return ("<div class='prayer-times'>Upcoming Prayer Times in Port Of Spain:<br><br>$date_set<br>" . implode("<br>", array_map(function($key, $value) {
        //     return "$key : " . date('h:i', strtotime($value));
        // }, array_keys($result), $result)) . "</div>");

        // echo "Upcoming Prayer Times in Port Of Spain:<br>";
        // echo "<br>";
        // echo $date_set . "<br>";
        // foreach ($result as $key => $value) {
        //     echo "<br>";
        //     echo $key . " : " . date('h:i',strtotime($value)) ;
        //     echo "<br>";
        // }

        $this->generate_html2();
    }


}

$wp = new PT();
$wp->register();


// register_activation_hook(__FILE__, array($wp, 'activate') );





// add_action( 'admin_menu', 'register' );
// add_action( 'init', 'prayer_times_setup' );
//     function prayer_times_menu() {
//         add_options_page(
//             'Prayer Times Settings',
//             'Prayer Times',
//             'manage_options',
//             'prayer-times-settings',
//             'prayer_times_settings_page',
//         );
//     }

//     function prayer_times_plugin_register_settings() {
//         register_setting('prayer_times_plugin_options', 'my_footer_message');
//         add_settings_section(
//             'prayer_times_plugin_section', 
//             'Prayer Time Settings', 
//             'prayer_times_plugin_section_callback', 
//             'prayer-times-plugin',
//         );

//         add_settings_field(
//             'my_footer_message', 
//             'Footer Message', 
//             'prayer_times_plugin_field_callback',  
//             'prayer-times-plugin',
//             'prayer_times_plugin_section',

//         );
//     }


//     function phpilosophers_prayer_times_plugin () {
//         phpinfo();

//         if (is_page('events-page')) {
//             echo "Hey";

//             // From URL to get webpage contents.
//             $url = "https://www.geeksforgeeks.org/";

//             // Initialize a CURL session.
//             $ch = curl_init(); 

//             // Return Page contents.
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//             //grab URL and pass it to the variable.
//             curl_setopt($ch, CURLOPT_URL, $url);

//             $result = curl_exec($ch);

//             echo $result; 
//         }
//     }
// }

// if (class_exists('PraryerTimesPlugin')) {
//     $PrayTimesPlugin = new PrayerTimesPlugin();
// }

//     add_action( 'admin_menu', 'prayer_times_menu' );
// }

?>