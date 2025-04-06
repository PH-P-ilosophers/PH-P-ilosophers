<?php
$query = new WP_Query(array(
    'posts_per_page' => 1,
    "post_type" => "hadith-selection",
    "orderby" => "post_date",
    "order" => "DESC",
));
$offset = get_option("selection_interval", 1);
$hadith_date = date("F, j Y", strtotime(get_field('hadith_date') . "+$offset days"));

?>

<div class="wrap">
    <h1>Hadith Selection Settings</h1>
    <h2><?php get_option('selection_interval') ?></h2>
    <p>The field below will represent the number of days between generated hadith selections</p>
    <form method="post" action="options.php">
        <?php
        // Output the settings fields and sections
        // This is the settings group
        settings_fields('hadith_selection_options');
        // This will display the plugin's settings section
        do_settings_sections('hadith-selection');
        ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">Selection Interval</th>
                <td><input type="number" min='1' max='7' name="selection_interval"
                        value="<?php echo esc_attr(get_option('selection_interval', 1)); ?>" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    <p>Date for next hadith selection: <?php echo $hadith_date ?> </p>
</div>