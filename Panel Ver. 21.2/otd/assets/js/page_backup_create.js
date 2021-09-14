//======================================================================================================================
// Backup interval
//======================================================================================================================

    $('select[name="interval"]').change(function() {
        var $this = $(this);
        var $weekdays = $('#app-weekdays');
        var $daysOfMonth = $('#app-days-of-month');

        $weekdays.hide();
        $daysOfMonth.hide();

        switch ($this.val())
        {
            case 'weekly':
                $weekdays.show(200);
                break;
            case 'monthly':
                $daysOfMonth.show(200);
                break;
        }
    }).trigger('change');

//======================================================================================================================
// Backup scope
//======================================================================================================================

    // Show / hide custom scope settings.
    $('input[name="scope"]').change(function() {
        var $this = $(this);
        var $div = $('.app-show-with-custom-scope');

        $this.is(':checked') && $this.val() === 'custom' ? $div.show(200) : $div.hide();
    }).trigger('change');


    // Show paths selection and path exclude option.
    $('input[name="is_paths"]').change(function() {
        var $this = $(this);
        var $div = $('.app-show-with-paths');

        $this.is(':checked') ? $div.show(200) : $div.hide();
    }).trigger('change');

    // Show exclude selection.
    $('input[name="is_exclude_paths"]').change(function() {
        var $this = $(this);
        var $div = $('.app-show-with-exclude-paths');

        $this.is(':checked') ? $div.show(200) : $div.hide();
    }).trigger('change');


    // Show user selection.
    $('input[name="is_user_accounts"]').change(function() {
        var $this = $(this);
        var $div = $('.app-show-with-user-accounts');

        $this.is(':checked') ? $div.show(200) : $div.hide();
    }).trigger('change');

    // Show with user selection requiring a user list.
    $('select[name="user_scope"]').change(function() {
        var $this = $(this);
        var $div = $('.app-show-with-user-accounts-list');

        $this.val() === 'include' || $this.val() === 'exclude' ? $div.show(200) : $div.hide();
    }).trigger('change');