$(document).ready(function(){
    $(".opt_delete_account a").click(function(){
        $("#dialog-delete-account").dialog('open');
    });

    $("#dialog-delete-account").dialog({
        autoOpen: false,
        modal: true,
        buttons: [
            {
                text: matrix.langs.delete,
                click: function() {
                    window.location = matrix.base_url + '?page=user&action=delete&id=' + matrix.user.id  + '&secret=' + matrix.user.secret;
                }
            },
            {
                text: matrix.langs.cancel,
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
});