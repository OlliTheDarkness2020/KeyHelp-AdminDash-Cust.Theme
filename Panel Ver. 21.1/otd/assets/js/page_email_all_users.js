//======================================================================================================================
// Update textarea to TinyMce
//======================================================================================================================

    initTinyMce('textarea[name="body"]');

//======================================================================================================================
// Send test email
//======================================================================================================================

    $('.app-send-test-email').click(function() {
        var $this = $(this);
        var $error = $('#app-send-test-error');
        var $errorMessage = $('#app-send-test-error-message');

        // To enable access to textarea value.
        tinyMCE.triggerSave();

        ajax({
            action: 'send_test_email',
            data: {
                recipient	: $('input[name=test_recipient]').val(),
                subject		: $('input[name=subject]').val(),
                body		: $('textarea[name=body]').val(),
                is_html     : true
            },
            success: function(data)
            {
                animateButton($this, !data.error);

                if (data.error)
                {
                    $errorMessage.html(data.error_msg);
                    $error.show();
                }
            },
            beforeSend: function()
            {
                $error.hide();
                $this.addClass('is-loading');
            },
            complete: function()
            {
                $this.removeClass('is-loading');
            }
        });
    });