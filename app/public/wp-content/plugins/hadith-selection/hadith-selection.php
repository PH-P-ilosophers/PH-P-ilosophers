<?php
/*
Plugin Name: Hadith Selector
Description: Generates Daily Hadith Selections
Version: 1.0
Author: Jared De Four
License: GPL2
*/
defined('ABSPATH') or die('Access unavailable');

class HS
{

    function __construct()
    {
        add_action('init', array($this, 'hadith_post_type'));
        add_action('admin_init', array($this, 'hadith_selection_register_settings'));
        add_action('wp_head', array($this, 'hadith_page_setup'));
        add_action('wp_head', array($this, 'generate_hadith'));

    }

    function activate()
    {
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }


    function register()
    {
        add_action('admin_menu', array($this, 'add_admin_page'));

    }

    function add_admin_page()
    {
        add_menu_page("Hadith Plugin", "Hadith", "manage_options", "hadith_plugin", array($this, "admin_index"), 'dashicons-book-alt', 110);
    }

    function admin_index()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
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

    function hadith_page_setup()
    {

        if ($this->check_page_exists("hadith-selection-page", 'page'))
            return;
        wp_insert_post(array(
            'post_title' => "Hadith Selection",
            'post_type' => 'page',
            'post_name' => 'hadith-selection-page',
            'post_status' => 'publish'
        ));
    }
    // function hadith_selections_menu()
    // {
    //     add_options_page(
    //         'My Custom Plugin Settings', // Page title
    //         'Hadith Settings', // Menu title
    //         'manage_options', // Capability (who can access the page)
    //         'hadith-selection-menu', // Menu slug (used in the URL)
    //         array($this, 'hadith_selection_settings_page') // Callback function to display the settings page
    //     );

    // }

    function hadith_selection_register_settings()
    {
        // Register the settings group and individual settings
        register_setting('hadith_selection_options', 'selection_interval'); // 'my_footer_message' is the option name
        // Add a settings section to the settings page
        add_settings_section(
            'my_custom_plugin_section', // Section ID
            'Custom Footer Settings', // Section Title
            'hadit_selection_section_callback', // Callback function
            'my-custom-plugin' // Page (slug) where the section will be displayed
        );
        // Add a settings field to the section
        add_settings_field(
            'selection_interval', // Field ID
            'Selection Interval', // Field Title
            'hadith_selection_field_callback', // Callback function to render the field
            'hadith-selection', // Page (slug)
            'hadith_selection_section' // Section where this field should appear
        );
    }


    function hadith_post_type()
    {
        register_post_type('hadith-selection', array(
            'supports' => array('title', 'editor', "custom-fields"),
            'rewrite' => array('slug' => 'hadith-selection'),
            'has_archive' => true,
            'public' => true,
            "show_in_rest" => true,
            "publicly_queryable" => true,
            'labels' => array(
                'name' => "Hadith Selections",
                'add_new_item' => 'Add New Hadith Selection',
                'edit_item' => 'Edit Hadith Selection',
                'all_items' => 'All Hadith Selections',
                'singular_name' => "Hadith Selection  "
            ),
            'menu_icon' => 'dashicons-book'
        ));
    }


    function fetch_hadith_selection()
    {
        $book_listings = array('sahih-bukhari', 'sahih-muslim', 'al-tirmidhi', 'abu-dawood', 'ibn-e-majah', 'sunan-nasai', 'mishkat');
        $book_number = rand(0, count($book_listings) - 1);
        $book = $book_listings[$book_number];
        $hadith_number = rand(1, 3000);
        $url = "https://hadithapi.com/public/api/hadiths?apiKey=$2y$10\$hrDt1wMhH0MuMuSfiSYJuTXJt8YqBWw6r4VB2qabGJ3PcSUqKO6&book=$book&hadithNumber=$hadith_number";

        // Initialize a CURL session.
        $ch = curl_init();

        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_close($ch);

        $raw_data = curl_exec($ch);

        $json_data = json_decode($raw_data, true);
        return $json_data['hadiths']['data'][0];
    }

    function hadith_generated()
    {
        date_default_timezone_set('EST');

        $query = new WP_Query(array(
            'posts_per_page' => -1,
            "post_type" => "hadith-selection",
            "orderby" => "post_date",
            "order" => "DESC",
        ));


        if ($query->have_posts()) {
            $query->the_post();
            the_title();
            $offset = get_option("selection_interval", 1);
            $hadith_date = date("Ymd", strtotime(get_field('hadith_date') . "+$offset days"));
            $current_date = date("Ymd");

            if ($hadith_date >= $current_date)
                return true;
        }
        return false;
    }
    function generate_hadith()
    {

        if (is_page('hadith-selection-page') && !$this->hadith_generated()) {

            $hadith = $this->fetch_hadith_selection();
            $hadith_english = $hadith['hadithEnglish'];
            $hadith_arabic = $hadith['hadithArabic'];

            while (!$hadith_english || !$hadith_arabic) {
                $hadith = $this->fetch_hadith_selection();
                $hadith_english = $hadith['hadithEnglish'];
                $hadith_arabic = $hadith['hadithArabic'];
            }

            $book_name = $hadith['book']['bookName'];
            $writer_name = $hadith['book']['writerName'];
            $chapter_name = $hadith['chapter']['chapterEnglish'];
            $hadith_number = $hadith['hadithNumber'];

            $new_post = array(
                'post_title' => "$book_name - $chapter_name: $hadith_number",
                'post_type' => 'hadith-selection',
                'post_status' => 'publish',
                'meta_input' => array(
                    'english_hadith' => $hadith_english,
                    'hadith_writer' => $writer_name,
                    'arabic_hadith' => $hadith_arabic,
                    'hadith_date' => (string) date("Ymd")
                )

            );

            wp_insert_post($new_post);
        }
    }



}

if (class_exists("HS")) {
    $HS = new HS();
    $HS->register();
}



class WP_Skills_MetaBox_HadithSelectionCustomFields
{
    private $screen = array(
        'hadith-selection'
    );

    private $meta_fields = array(
        array(
            'label' => 'Hadith Date',
            'id' => 'hadith_date',
            'type' => 'text',
            'default' => '',
        ),
        array(
            'label' => 'Hadith Writer',
            'id' => 'hadith_writer',
            'type' => 'text',
            'default' => '',
        ),
        array(
            'label' => 'English Hadith',
            'id' => 'english_hadith',
            'type' => 'text',
            'default' => '',
        ),
        array(
            'label' => 'Arabic Hadith',
            'id' => 'arabic_hadith',
            'type' => 'text',
            'default' => '',
        )

    );

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('admin_footer', array($this, 'media_fields'));
        add_action('save_post', array($this, 'save_fields'));
    }

    public function add_meta_boxes()
    {
        foreach ($this->screen as $single_screen) {
            add_meta_box(
                'HadithSelectionCustomFields',
                __('Hadith Selection Custom Fields', 'text-domain'),
                array($this, 'meta_box_callback'),
                $single_screen,
                'normal',
                'default'
            );
        }
    }

    public function meta_box_callback($post)
    {
        wp_nonce_field('HadithSelectionCustomFields_data', 'HadithSelectionCustomFields_nonce');
        echo 'The custom fields for a hadith selection';
        $this->field_generator($post);
    }
    public function media_fields()
    { ?>
        <script>
            jQuery(document).ready(function ($) {
                if (typeof wp.media !== 'undefined') {
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    $('.new-media').click(function (e) {
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = $(this);
                        var id = button.attr('id').replace('_button', '');
                        _custom_media = true;
                        wp.media.editor.send.attachment = function (props, attachment) {
                            if (_custom_media) {
                                if ($('input#' + id).data('return') == 'url') {
                                    $('input#' + id).val(attachment.url);
                                } else {
                                    $('input#' + id).val(attachment.id);
                                }
                                $('div#preview' + id).css('background-image', 'url(' + attachment.url + ')');
                            } else {
                                return _orig_send_attachment.apply(this, [props, attachment]);
                            };
                        }
                        wp.media.editor.open(button);
                        return false;
                    });
                    $('.add_media').on('click', function () {
                        _custom_media = false;
                    });
                    $('.remove-media').on('click', function () {
                        var parent = $(this).parents('td');
                        parent.find('input[type="text"]').val('');
                        parent.find('div').css('background-image', 'url()');
                    });
                }
            });
        </script>
        <?php
    }

    public function field_generator($post)
    {
        $output = '';
        foreach ($this->meta_fields as $meta_field) {
            $label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
            $meta_value = get_post_meta($post->ID, $meta_field['id'], true);
            if (empty($meta_value)) {
                if (isset($meta_field['default'])) {
                    $meta_value = $meta_field['default'];
                }
            }
            switch ($meta_field['type']) {

                default:
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                        $meta_field['id'],
                        $meta_field['id'],
                        $meta_field['type'],
                        $meta_value
                    );
            }
            $output .= $this->format_rows($label, $input);
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }

    public function format_rows($label, $input)
    {
        return '<tr><th>' . $label . '</th><td>' . $input . '</td></tr>';
    }

    public function save_fields($post_id)
    {
        if (!isset($_POST['hadithselectioncustomfields_nonce']))
            return $post_id;
        $nonce = $_POST['hadithselectioncustomfields_nonce'];
        if (!wp_verify_nonce($nonce, 'hadithselectioncustomfields_data'))
            return $post_id;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        foreach ($this->meta_fields as $meta_field) {
            if (isset($_POST[$meta_field['id']])) {
                switch ($meta_field['type']) {
                    case 'email':
                        $_POST[$meta_field['id']] = sanitize_email($_POST[$meta_field['id']]);
                        break;
                    case 'text':
                        $_POST[$meta_field['id']] = sanitize_text_field($_POST[$meta_field['id']]);
                        break;
                }
                update_post_meta($post_id, $meta_field['id'], $_POST[$meta_field['id']]);
            } else if ($meta_field['type'] === 'checkbox') {
                update_post_meta($post_id, $meta_field['id'], '0');
            }
        }
    }
}

if (class_exists('WP_Skills_MetaBox_HadithSelectionCustomFields')) {
    new WP_Skills_MetaBox_HadithSelectionCustomFields;
}
;


