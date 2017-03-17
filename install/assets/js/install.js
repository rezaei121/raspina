$(document).ready(function(){

    var hasError = 0;
    $('.install-submit').click(function(){
        $('.install-submit-error').html('');
        hasError = 0;
        $('.input-error').remove();
        inputRequiredCheck();
        inputLengthCheck(3);
        inputLengthCheck(5);
        inputEmailCheck();

        if(hasError)
        {
            $('.install-submit-error').html('please check the error field(s)');
            return false;
        }
    });

    function inputRequiredCheck(input_name) {
        $('.required').each(function(){
            var value = $(this).val();
            if(value.isEmpty())
            {
                $(this).after('<div class="input-error">can not be empty</div>').addClass('border-error');
                hasError++;
            }
        });
    }
    
    function inputLengthCheck(length) {
        $('.min-'+length).each(function(){
            var value = $(this).val().trim();
            if(value.length < length)
            {
                $(this).after('<div class="input-error">least '+length+' character</div>').addClass('border-error');
                hasError++;
            }
        });
    }

    function inputEmailCheck(length) {
        $('.email').each(function(){
            var value = $(this).val();
            if(!value.email())
            {
                $(this).after('<div class="input-error">email not valid</div>').addClass('border-error');
                hasError++;
            }
        });
    }

    $('input').click(function(){
        $(this).next('.input-error').remove();
        $(this).removeClass('border-error');

        $(this).next('.input-error').remove();
        $(this).removeClass('border-error');
    });

});

String.prototype.isEmpty = (function(){
    var r = /^\s*$/;
    return function () {
        return r.test(this);
    }
})();

String.prototype.email = (function(){
    var r = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return function () {
        return r.test(this);
    }
})();