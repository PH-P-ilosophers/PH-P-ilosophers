<?php
/**
 * Plugin Name: Interactive Zakat Calculator
 * Description: A Zakat calculator that helps Muslims calculate their obligatory charity based on various assets and liabilities.
 * Version: 1.0
 * Author: Sajie Al Razi
 * Text Domain: zakat-calculator
 */

if (!defined('ABSPATH')) {
    exit;
}

class ZakatCalculator
{
    public function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'activate'));

        add_shortcode('zakat_calculator', array($this, 'shortcode_callback'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        add_action('wp_ajax_calculate_zakat', array($this, 'calculate_zakat'));
        add_action('wp_ajax_nopriv_calculate_zakat', array($this, 'calculate_zakat'));

        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));

        add_action('wp_ajax_update_silver_price', array($this, 'ajax_update_silver_price'));

    }

    public function activate()
    {
        $defaults = array(
            'nisab_value' => 612.36,
            'zakat_rate' => 2.5,
            'silver_price_per_gram' => 0.95 * 6.8,
            'last_silver_price_update' => 0,
        );

        add_option('zakat_calculator_settings', $defaults);

    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('zakat-calculator-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0');
        wp_enqueue_script('zakat-calculator-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0.0', true);

        wp_localize_script('zakat-calculator-script', 'zakat_calculator_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('zakat_calculator_nonce'),
        ));
    }

    public function shortcode_callback($atts)
    {
        $settings = get_option('zakat_calculator_settings');

        if (time() - $settings['last_silver_price_update'] > 86400) {
            $this->update_silver_price();
            $settings = get_option('zakat_calculator_settings');
        }

        $nisab_threshold = $settings['nisab_value'] * $settings['silver_price_per_gram'];

        ob_start();

        include plugin_dir_path(__FILE__) . 'templates/calculator-form.php';

        return ob_get_clean();
    }

    public function calculate_zakat()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zakat_calculator_nonce')) {
            wp_send_json_error('Security check failed');
        }

        $settings = get_option('zakat_calculator_settings');
        $zakat_rate = $settings['zakat_rate'] / 100;

        $assets = array(
            'cash' => isset($_POST['cash']) ? floatval($_POST['cash']) : 0,
            'gold_silver' => isset($_POST['gold_silver']) ? floatval($_POST['gold_silver']) : 0,
            'stocks' => isset($_POST['stocks']) ? floatval($_POST['stocks']) : 0,
            'dividends' => isset($_POST['trade']) ? floatval($_POST['trade']) : 0,
            'raw_materials' => isset($_POST['raw_materials']) ? floatval($_POST['raw_materials']) : 0,
            'loans_receivable' => isset($_POST['loans_receivable']) ? floatval($_POST['loans_receivable']) : 0,
            'receivables' => isset($_POST['receivables']) ? floatval($_POST['receivables']) : 0,
            'business_cash' => isset($_POST['business_cash']) ? floatval($_POST['business_cash']) : 0,
            'inventory' => isset($_POST['inventory']) ? floatval($_POST['inventory']) : 0,
            'business_receivables' => isset($_POST['business_receivables']) ? floatval($_POST['business_receivables']) : 0,
            'real_estate' => isset($_POST['real_estate']) ? floatval($_POST['real_estate']) : 0,
            'fixed_assets' => isset($_POST['fixed_assets']) ? floatval($_POST['fixed_assets']) : 0,
            'mobile_assets' => isset($_POST['mobile_assets']) ? floatval($_POST['mobile_assets']) : 0,
        );

        $liabilities = array(
            'due_debts' => isset($_POST['due_debts']) ? floatval($_POST['due_debts']) : 0,
            'zakat_paid' => isset($_POST['zakat_paid']) ? floatval($_POST['zakat_paid']) : 0,
        );

        $total_assets = array_sum($assets);
        $total_liabilities = array_sum($liabilities);
        $net_zakatable = $total_assets - $total_liabilities;

        $nisab_threshold = $settings['nisab_value'] * $settings['silver_price_per_gram'];
        $meets_nisab = ($net_zakatable >= $nisab_threshold);

        $zakat_due = $meets_nisab ? $net_zakatable * $zakat_rate : 0;

        $response = array(
            'success' => true,
            'total_assets' => number_format($total_assets, 2),
            'total_liabilities' => number_format($total_liabilities, 2),
            'net_zakatable' => number_format($net_zakatable, 2),
            'nisab_threshold' => number_format($nisab_threshold, 2),
            'meets_nisab' => $meets_nisab,
            'zakat_due' => number_format($zakat_due, 2),
            'zakat_rate' => $settings['zakat_rate'],
            'silver_price' => $settings['silver_price_per_gram'],
            'nisab_value' => $settings['nisab_value'],
        );

        wp_send_json_success($response);
    }

    private function update_silver_price()
    {
        $silver_price_usd = 0.95;
        $usd_to_ttd_rate = 6.8;
        $silver_price_ttd = $silver_price_usd * $usd_to_ttd_rate;
        $settings = get_option('zakat_calculator_settings');
        $settings['silver_price_per_gram'] = floatval($silver_price_ttd);
        $settings['last_silver_price_update'] = time();
        update_option('zakat_calculator_settings', $settings);

        return true;
    }

    public function add_admin_menu()
    {
        add_options_page(
            'Zakat Calculator Settings',
            'Zakat Calculator',
            'manage_options',
            'zakat-calculator',
            array($this, 'settings_page')
        );
    }

    public function ajax_update_silver_price()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zakat_calculator_nonce')) {
            wp_send_json_error('Security check failed');
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permission denied');
        }

        $result = $this->update_silver_price();

        if ($result) {
            $settings = get_option('zakat_calculator_settings');
            wp_send_json_success(array(
                'message' => 'silver price updated successfully',
                'price' => $settings['silver_price_per_gram'],
                'formatted_price' => number_format($settings['silver_price_per_gram'], 2),
                'last_update' => date('F j, Y, g:i a', $settings['last_silver_price_update'])
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to update silver price'));
        }
    }
    public function register_settings()
    {
        register_setting('zakat_calculator_options', 'zakat_calculator_settings');

        add_settings_section(
            'zakat_calculator_section',
            'General Settings',
            array($this, 'settings_section_callback'),
            'zakat-calculator'
        );

        add_settings_field(
            'nisab_value',
            'Nisab Value (in grams of silver)',
            array($this, 'nisab_value_callback'),
            'zakat-calculator',
            'zakat_calculator_section'
        );

        add_settings_field(
            'zakat_rate',
            'Zakat Rate (%)',
            array($this, 'zakat_rate_callback'),
            'zakat-calculator',
            'zakat_calculator_section'
        );

        add_settings_field(
            'silver_price',
            'Current silver Price',
            array($this, 'silver_price_callback'),
            'zakat-calculator',
            'zakat_calculator_section'
        );
    }
    public function settings_section_callback()
    {
        echo '<p>Configure the settings for your Zakat Calculator.</p>';
    }

    public function nisab_value_callback()
    {
        $settings = get_option('zakat_calculator_settings');
        ?>
        <input type="number" step="0.01" name="zakat_calculator_settings[nisab_value]"
            value="<?php echo esc_attr($settings['nisab_value']); ?>" />
        <p class="description">The minimum amount of wealth required for Zakat (typically 612.36g of silver).</p>
        <?php
    }
    public function zakat_rate_callback()
    {
        $settings = get_option('zakat_calculator_settings');
        ?>
        <input type="number" step="0.01" name="zakat_calculator_settings[zakat_rate]"
            value="<?php echo esc_attr($settings['zakat_rate']); ?>" />
        <p class="description">The percentage rate at which Zakat is calculated (typically 2.5%).</p>
        <?php
    }

    public function silver_price_callback()
    {
        $settings = get_option('zakat_calculator_settings');

        ?>
        <p><strong>Current price:</strong> $<?php echo number_format(0.95 * 6.8, decimals: 2); ?> per gram</p>

        <p class="description">*silver price is set to a static value of($<?php echo number_format(0.95 * 6.8, 2); ?>
            TTD).</p>
        <?php
    }

    public function settings_page()
    {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('zakat_calculator_options');
                do_settings_sections('zakat-calculator');
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }
}

$zakat_calculator = new ZakatCalculator();
