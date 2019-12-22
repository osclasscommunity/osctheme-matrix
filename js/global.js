matrix.extend = function(el, opt) {
        for (var name in opt) el[name] = opt[name];
        return el;
}
matrix.responsive = function(options) {
    defaults = {'selector':'#responsive-trigger'};
    options = $.extend(defaults, options);
    if($(options.selector).is(':visible')){
        return true;
    }
    return false;
}
matrix.toggleClass = function(element,destination,isObject) {
    var $selector = $('['+element+']');
    $selector.click(function (event) {
        var thatClass  = $(this).attr(element);
        var thatDestination;
        if (typeof(isObject) != "undefined"){
            var thatDestination  = $(destination);
        } else {
            var thatDestination  = $($(this).attr(destination));
        }
        thatDestination.toggleClass(thatClass);
        event.preventDefault();
        return;
    });
}
matrix.photoUploader = function(selector,options) {
    defaults = {'max':4};
    options = $.extend(defaults, options);
    matrix.photoUploaderActions($(selector),options);
}
matrix.addPhotoUploader = function(max) {
    if(max < $('input[name="'+$(this).attr('name')+'"]').length+$('.photos_div').length){
        var $image = $('<input type="file" name="photos[]">');
            matrix.photoUploaderActions(image);
        $('#post-photos').append($image);
    }
}
matrix.removePhotoUploader = function() {
    //removeAndAdd
},
matrix.photoUploaderActions = function($element,options) {
    $element.on('change',function(){
        var input  = $(this)[0];
        $(this).next('img').remove();
        $image = $('<img />');
        $image.insertAfter($element);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $image.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $image.remove();
        }
    });
}

$(document).ready(function(event){
    $('.r-list h1 span').click(function(){
        if(matrix.responsive()){
            var $parent     = $(this).parent().parent();
            if($parent.hasClass('active')){
                $parent.removeClass('active');
                $(this).find('i').removeClass('fa-caret-down');
                $(this).find('i').addClass('fa-caret-right');
            } else {
                $parent.addClass('active');
                $(this).find('i').removeClass('fa-caret-right');
                $(this).find('i').addClass('fa-caret-down');
            }
            return false;
        }
    });

    $('.see_by').hover(function(){
        $(this).addClass('hover');
    }, function(){
        $(this).removeClass('hover');
    })

    matrix.toggleClass('data-bclass-toggle','body',true);

    $('.flashmessage .ico-close').click(function(){
        $(this).parents('.flashmessage').remove();
    });
});

$(function() {
    var pass = document.querySelector('#pass.repeat');
    var pass2 = document.querySelector('#pass2.repeat');

    if(pass && pass2) {
        function validatePass() {
            if(pass.value != pass2.value) {
                pass2.setCustomValidity(matrix.repeat_password);
            } else {
                pass2.setCustomValidity('');
            }
        }

        document.querySelector('#pass.repeat').onchange = validatePass;
        document.querySelector('#pass2.repeat').onkeyup = validatePass;
    }
});
