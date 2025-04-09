jQuery(document).ready(function($) {
    $('#zakat-calculator-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serializeArray();
        
        formData.push({
            name: 'nonce',
            value: zakat_calculator_vars.nonce
        });
        
        formData.push({
            name: 'action',
            value: 'calculate_zakat'
        });
        
        $.ajax({
            url: zakat_calculator_vars.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    $('#result-total-assets').text('$' + data.total_assets);
                    $('#result-total-liabilities').text('$' + data.total_liabilities);
                    $('#result-net-zakatable').text('$' + data.net_zakatable);
                    $('#result-nisab-threshold').text('$' + data.nisab_threshold);
                    $('#result-zakat-due').text('$' + data.zakat_due);
                    $('#zakat-rate').text(data.zakat_rate);
                    
                    if (data.meets_nisab) {
                        $('#nisab-status-message').html('Your wealth has reached the <strong>Nisab threshold</strong>, so Zakat is obligatory upon you.');
                        $('#nisab-status-message').addClass('nisab-reached').removeClass('nisab-not-reached');
                    } else {
                        $('#nisab-status-message').html('Your wealth has <strong>not reached</strong> the Nisab threshold, so Zakat is not obligatory upon you at this time.');
                        $('#nisab-status-message').addClass('nisab-not-reached').removeClass('nisab-reached');
                    }
                    
                    $('#zakat-calculator-results').slideDown();
                    
                    $('html, body').animate({
                        scrollTop: $('#zakat-calculator-results').offset().top - 50
                    }, 500);
                } else {
                    alert('Error calculating Zakat... Please try again.');
                }
            },
            error: function() {
                alert('Server error... Please try again later.');
            }
        });
    });
    
    $('#reset-form').on('click', function() {
        $('#zakat-calculator-results').slideUp();
        
        $('#zakat-calculator-form input[type="number"]').val(0);
    });
    
    $('#update-gold-price').on('click', function() {
        const button = $(this);
        const originalText = button.text();
        
        button.text('Updating...').prop('disabled', true);
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'update_gold_price',
                nonce: zakat_calculator_vars.nonce
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Failed to update gold price. Please try again.');
                    button.text(originalText).prop('disabled', false);
                }
            },
            error: function() {
                alert('Server error. Please try again later.');
                button.text(originalText).prop('disabled', false);
            }
        });
    });
    
    $('#zakat-calculator-form input[type="number"]').on('input', function() {
        updateTotals();
    });
    
    function updateTotals() {
        let totalAssets = 0;
        let totalLiabilities = 0;
        
        $('#zakat-calculator-form input[name="cash"], #zakat-calculator-form input[name="gold_silver"], #zakat-calculator-form input[name="stocks"], #zakat-calculator-form input[name="trade"], #zakat-calculator-form input[name="raw_materials"], #zakat-calculator-form input[name="loans_receivable"], #zakat-calculator-form input[name="receivables"], #zakat-calculator-form input[name="business_cash"], #zakat-calculator-form input[name="inventory"], #zakat-calculator-form input[name="business_receivables"], #zakat-calculator-form input[name="real_estate"], #zakat-calculator-form input[name="fixed_assets"], #zakat-calculator-form input[name="mobile_assets"]').each(function() {
            totalAssets += parseFloat($(this).val()) || 0;
        });
        
        $('#zakat-calculator-form input[name="due_debts"], #zakat-calculator-form input[name="zakat_paid"]').each(function() {
            totalLiabilities += parseFloat($(this).val()) || 0;
        });
        
        if ($('#running-total-assets').length) {
            $('#running-total-assets').text('$' + totalAssets.toFixed(2));
            $('#running-total-liabilities').text('$' + totalLiabilities.toFixed(2));
            $('#running-net-worth').text('$' + (totalAssets - totalLiabilities).toFixed(2));
        }
    }
});