$(function() {
    /*
     * Show hidden phone number or email.
    */
    $('.phone.hidden, .email.hidden').click(function(e) {
        if(!$(this).hasClass('hidden')) {
            return;
        }

        e.preventDefault();

        var value = $(this).attr('data-value');
        $(this).removeClass('hidden');
        $(this).removeClass('hidden');
        $(this).html(value);

        if($(this).hasClass('phone')) {
            $(this).attr('href', 'tel:' + value);
        } else if($(this).hasClass('email')) {
            $(this).attr('href', 'mailto:' + value);
        }
    });

    /*
     * Open sharer in new window.
    */
    $('.ad-share a').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        window.open(url, '_blank', 'width=600, height=400');
    });
});

$(function() {
    var pass = document.querySelector('.pass-repeat #pass');
    var pass2 = document.querySelector('.pass-repeat #pass2');

    if(pass && pass2) {
        function validatePass() {
            if(pass.value != pass2.value) {
                pass2.setCustomValidity(matrix.repeat_password);
            } else {
                pass2.setCustomValidity('');
            }
        }

        document.querySelector('.pass-repeat #pass').onchange = validatePass;
        document.querySelector('.pass-repeat #pass2').onkeyup = validatePass;
    }
});
