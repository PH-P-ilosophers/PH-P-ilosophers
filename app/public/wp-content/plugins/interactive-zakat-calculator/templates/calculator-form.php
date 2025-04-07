<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="zakat-calculator-container">
    <div class="zakat-calculator-intro">
        <h2>Zakat Calculator</h2>
        <p>This Zakat calculator helps you determine how much Zakat you need to pay. The calculator considers your
            comprehensive net assets (total wealth). </p>
        <p>Nisaab is the <strong> minimum amount </strong>wealth a Muslim must have before they are obligated to pay
            Zakat</p>
        <p>Remember that charity in Islam (Zakat) is not just one of the core
            pillars of Islam, but a tool to help ease poverty, suffering and hardship throughout the globe.

        </p>
        <p>Current Nisab threshold: <strong>$<?php echo number_format($nisab_threshold, 2); ?></strong>
            (<?php echo $settings['nisab_value']; ?> grams of silver)</p>
        <p>Silver price: <strong>$<?php echo number_format($settings['silver_price_per_gram'], 2); ?></strong> per gram
        </p>
    </div>

    <form id="zakat-calculator-form" class="zakat-calculator-form">
        <div class="zakat-calculator-section">
            <h3>Personal Assets</h3>

            <div class="zakat-calculator-field">
                <label for="cash">Personal cash on hand & in bank accounts</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="cash" name="cash" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="gold_silver">Total value of gold, silver & precious items</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="gold_silver" name="gold_silver" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="stocks">Total value of stocks, shares, bonds</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="stocks" name="stocks" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="trade">Items of trade (current cost price)</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="trade" name="trade" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="raw_materials">Raw materials (current cost price)</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="raw_materials" name="raw_materials" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="loans_receivable">Loans (lent out)</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="loans_receivable" name="loans_receivable" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="receivables">Money owed to you for items sold or manufactured or fabricated</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="receivables" name="receivables" min="0" step="0.01" value="0">
            </div>
        </div>

        <div class="zakat-calculator-section">
            <h3>Business Assets</h3>

            <div class="zakat-calculator-field">
                <label for="business_cash">Business cash on hand & in bank accounts</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="business_cash" name="business_cash" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="inventory">Net value of business inventory & trade goods</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="inventory" name="inventory" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="business_receivables">Total business receivables by Zakat due date</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="business_receivables" name="business_receivables" min="0" step="0.01"
                    value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="real_estate">Real estate properties' investment/sale value</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="real_estate" name="real_estate" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="fixed_assets">Net income from exploited fixed business assets (e.g. rental unit)</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="fixed_assets" name="fixed_assets" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="mobile_assets">Net income from exploited mobile business assets (cars you own or control and
                    lease to others are an example of a mobile asset)</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="mobile_assets" name="mobile_assets" min="0" step="0.01" value="0">
            </div>
        </div>

        <div class="zakat-calculator-section">
            <h3>Liabilities</h3>

            <div class="zakat-calculator-field">
                <label for="due_debts">Necessary immediately due debts (rent, food, utilities, insurance, medical,
                    education, transportation, etc. No long-term debts)</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="due_debts" name="due_debts" min="0" step="0.01" value="0">
            </div>

            <div class="zakat-calculator-field">
                <label for="zakat_paid">Zakat paid in advance</label>
                <span class="currency-symbol">$</span>
                <input type="number" id="zakat_paid" name="zakat_paid" min="0" step="0.01" value="0">
            </div>
        </div>

        <div class="zakat-calculator-actions">
            <button type="submit" id="calculate-zakat" class="button button-primary">Calculate Zakat</button>
            <button type="reset" id="reset-form" class="button">Reset</button>
        </div>
    </form>

    <div id="zakat-calculator-results" class="zakat-calculator-results" style="display: none;">
        <h3>Your Zakat Calculation Results</h3>

        <div class="zakat-result-item">
            <span class="result-label">Total Assets:</span>
            <span class="result-value" id="result-total-assets">$0.00</span>
        </div>

        <div class="zakat-result-item">
            <span class="result-label">Total Liabilities:</span>
            <span class="result-value" id="result-total-liabilities">$0.00</span>
        </div>

        <div class="zakat-result-item">
            <span class="result-label">Net Zakatable Amount:</span>
            <span class="result-value" id="result-net-zakatable">$0.00</span>
        </div>

        <div class="zakat-result-item">
            <span class="result-label">Nisab Threshold:</span>
            <span class="result-value" id="result-nisab-threshold">$0.00</span>
        </div>

        <div class="zakat-result-item result-important">
            <span class="result-label">Total Zakat Due:</span>
            <span class="result-value" id="result-zakat-due">$0.00</span>
        </div>

        <div class="zakat-calculation-info">
            <p id="nisab-status-message"></p>
            <p>Zakat is calculated at <span id="zakat-rate">2.5</span>% of your net zakatable wealth.</p>
        </div>
    </div>
</div>