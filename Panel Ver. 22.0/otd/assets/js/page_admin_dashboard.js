//======================================================================================================================
// News
//======================================================================================================================

    var $newsContainer = $('#app-news-container');

    if ($newsContainer.length)
    {
        var newsTemplate = Handlebars.compile($('#app-news-template').html());

        ajax({
            action: 'get_news',
            data: {
                language: hash['language']
            },
            success: function(response) {
                if (response.error)
                {
                    $newsContainer.html(response.error_msg.replace(/\n/, '<br>'));
                }
                else
                {
                    $newsContainer.html('');
                    var till = response.items.length > 2 ? 2 : response.items.length;
                    for (var i = 0; i < till; i++)
                    {
                        var placeholder = response.items[i];
                        placeholder.excerpt = $('<textarea></textarea>').html(placeholder.excerpt).text();

                        placeholder.has_spacer = i < (till - 1);
                        $newsContainer.append(newsTemplate(placeholder));
                    }
                }
            },
            error: function(textStatus, error)
            {
                $newsContainer.html('AJAX_ERROR');
                ajaxLogError(textStatus, error);
            },
            beforeSend: function()
            {
                $newsContainer.addClass('is-loading');
            },
            complete: function()
            {
                $newsContainer.removeClass('is-loading');
            }
        });
    }

//======================================================================================================================
// Notes
//======================================================================================================================

    var $notes = $('#app-notes');
    var $textarea = $('#app-notes-textarea');
    var $btnEdit =  $('#app-edit-notes');
    var $btnSave =  $('#app-save-notes');
    var $card = $notes.closest('.card');

    $btnEdit.click(function() {
        $btnEdit.hide();
        $btnSave.show(200);
        $notes.hide();
        $textarea.val($notes.text());
        $textarea.trigger('input'); // trigger auto-resize
        $textarea.show(200);
        $textarea.focus();
    });

    $textarea.on('blur', function() {
        var string = $textarea.val();
        var stringSanitized = string.replace(/(?:\r\n|\r|\n)/g, "\n").trim();

        $btnEdit.show(200);
        $btnSave.hide();
        $textarea.hide();
        $notes.text(stringSanitized);
        $notes.show(200);

        ajax({
            action: 'set_server_notes',
            data: {
                server_notes: stringSanitized
            },
            beforeSend: function()
            {
                $card.addClass('is-loading');
            },
            complete: function()
            {
                $card.removeClass('is-loading');
            }
        });
    });

//======================================================================================================================
// KeyHelp updates available
//======================================================================================================================

    var $keyhelpUpdateAvailable = $('#app-keyhelp-update-available');
    var $keyhelpUpdateInfoError = $('#app-keyhelp-update-info-error');

    ajax({
        action   : 'get_latest_keyhelp_version',
        success: function(response)
        {
            if (response.error)
            {
                $keyhelpUpdateInfoError.show();
            }
            else if (response.is_update_available)
            {
                $keyhelpUpdateAvailable.show();
            }
        },
        error: function(textStatus, error)
        {
            $keyhelpUpdateInfoError.show();
            ajaxLogError(textStatus, error);
        }
    });

//======================================================================================================================
// Software updates available
//======================================================================================================================

    var $softwareUpdatesAvailable = $("#app-software-updates-available");
    var $softwareUpdatesContainer = $softwareUpdatesAvailable.parent();
    var $rebootRequired = $("#app-reboot-required");
    var $distUpgradeNote = $("#app-dist-upgrade-note");

    ajax({
        action: 'get_package_updates',
        success: function(response) {
            if (response.error)
            {
                console.log(response.error_msg);
            }
            else
            {
                $softwareUpdatesAvailable.prepend(response.update_message).show();

                if (response.update_count > 0)
                {
                    $distUpgradeNote.show(0);
                }

                if (response.is_reboot_required)
                {
                    $rebootRequired.show();
                }

                $softwareUpdatesContainer.show(200);
            }
        }
    });

//======================================================================================================================
// App versions
//======================================================================================================================

    var $appsLoadingIndicator = $('.app-applications-loading');

    ajax({
        action: 'get_app_versions',
        success: function(response) {
            if (response.error)
            {
                console.log(response.error_msg);
            }
            else
            {
                for (const [key, value] of Object.entries(response.apps))
                {
                    $('#app-application-version-' + key).html(value);
                }
            }
        },
        error: function(textStatus, error, test)
        {
            ajaxLogError(textStatus, error);
        },
        complete: function()
        {
            $appsLoadingIndicator.hide();
        }
    });


//======================================================================================================================
// Service status
//======================================================================================================================

    // Refresh on startup.
    updateServiceStatus();

    // Continue to call the update.
    var serviceStatusTimer = setInterval(updateServiceStatus, 15000);


    function updateServiceStatus()
    {
        var $loadingIndicator = $('#app-service-status-loading');
        var $loadingIndicatorItems = $('.app-service-status-item-loading');
        var $serviceItems = $(".app-service-status-item");

        var ports = $serviceItems.map(function() {
            return $(this).data("port");
        }).get();

        if (ports.length === 0)
        {
            return;
        }

        ajax({
            action: 'get_service_status',
            data: {
                ports: ports
            },
            success: function(response)
            {
                $serviceItems.each(function() {
                    var $this = $(this);
                    var $online = $this.find('.app-service-status-item-online');
                    var $offline = $this.find('.app-service-status-item-offline');
                    var port = $this.data('port');

                    if (port in response.ports)
                    {
                        if (response.ports[port])
                        {
                            $online.show();
                            $offline.hide();
                        }
                        else
                        {
                            $online.hide();
                            $offline.show();
                        }
                    }
                });
            },
            error: function(textStatus, error)
            {
                ajaxLogError(textStatus, error);

                $('#app-service-status-content').hide();
                $('#app-service-status-error').show();

                clearInterval(serviceStatusTimer);
            },
            beforeSend: function()
            {
                $loadingIndicator.show();
            },
            complete: function()
            {
                $loadingIndicator.hide();
                // They are only used on initial page load.
                $loadingIndicatorItems.hide();
            }
        });
    }