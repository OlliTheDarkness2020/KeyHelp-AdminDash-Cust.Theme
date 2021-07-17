//======================================================================================================================
// Select backup storage type
//======================================================================================================================

    $('select[name="storage_type"]').on('change', function() {
        var $this = $(this);

        var prefix = 'app-storage-settings-';
        var allElements = $('div[id^="' + prefix + '"]');
        var selectedElement = $('#' + prefix + $this.val());

        allElements.hide();
        allElements.find('input[required]').addClass('app-toggle-required').prop('required', false);

        selectedElement.show(200);
        selectedElement.find('.app-toggle-required').prop('required', true);
    }).trigger('change');

//======================================================================================================================
// SFTP
//======================================================================================================================

    // Common DOM elements.
    var $sftpPublicKey = $('input[name="sftp_public_key"]');
    var $sftpPrivateKey = $('input[name="sftp_private_key"]');
    var $sftpKeyExists = $('#app-sftp-key-exists');
    var $sftpKeyNotExists = $('#app-sftp-key-not-exists');

    // Select auth method.
    $('select[name="sftp_auth_method"]').on('change', function() {
        if ($('select[name="storage_type"]').val() === 'sftp')
        {
            var $this = $(this);

            var prefix = 'app-sftp-auth-';
            var allElements = $('div[id^="' + prefix + '"]');
            var selectedElement = $('#' + prefix + $this.val());

            allElements.hide();
            allElements.find('input[required]').addClass('app-toggle-required').prop('required', false);

            selectedElement.show(200);
            selectedElement.find('.app-toggle-required').prop('required', true);
        }
    }).trigger('change');

    // Show public key or 'create public key' button.
    $sftpPublicKey.on('change', function() {
        var $this = $(this);

        $sftpKeyExists.hide();
        $sftpKeyNotExists.hide();

        $this.val() === '' ? $sftpKeyNotExists.show(200) : $sftpKeyExists.show(200);
    }).trigger('change');

    // Create key pair.
    $('#app-sftp-create-key').on('click', function() {
        var $this = $(this);

        ajax({
            action: 'generate_key_pair',
            success: function(data)
            {
                if (data.error === false)
                {
                    $sftpPrivateKey.val(data.private_key);
                    // Wihtout trigger, on change won't fire on hidden elements.
                    $sftpPublicKey.val(data.public_key).trigger('change');
                }
                else
                {
                    $sftpPrivateKey.val('');
                    $sftpPublicKey.val('ERROR');
                }
            },
            beforeSend: function()
            {
                $this.addClass('is-loading');
            },
            complete: function()
            {
                $this.removeClass('is-loading');
            }
        });
    });

    // Remove key pair.
    $('#app-sftp-remove-key').on('click', function() {
        $sftpPrivateKey.val('');
        // Wihtout trigger, on change won't fire on hidden elements.
        $sftpPublicKey.val('').trigger('change');
    });

//======================================================================================================================
// Save form
//======================================================================================================================

    $('#form-repository-settings').submit(function() {
        $('#app-modal-save-settings').addClass('is-active');
    });
