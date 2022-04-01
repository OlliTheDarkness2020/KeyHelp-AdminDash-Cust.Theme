// Bulk operation scope
$('select[name="client_scope"]').change(function() {
    var $this = $(this);
    var $div = $('.app-show-with-client-accounts-list');

    $this.val() === 'include' || $this.val() === 'exclude' ? $div.show(200) : $div.hide();
}).trigger('change');