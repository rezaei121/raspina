var validation = yii.validation;

validation.changeInvalidNumbers = function(input){
    var enNumbers = {
        '۰': '0',
        '۱': '1',
        '۲': '2',
        '۳': '3',
        '۴': '4',
        '۵': '5',
        '۶': '6',
        '۷': '7',
        '۸': '8',
        '۹': '9',
        '٠': '0',
        '١': '1',
        '٢': '2',
        '٣': '3',
        '٤': '4',
        '٥': '5',
        '٦': '6',
        '٧': '7',
        '٨': '8',
        '٩': '9',
    }
    input = input.replace(/[۰-۹٠-٩]/g,function (i) {
        return enNumbers[i];
    });
    return input;
};
validation.captcha = function (value, messages, options) {
    value = validation.changeInvalidNumbers(value);
    if (options.skipOnEmpty && pub.isEmpty(value)) {
        return;
    }

    // CAPTCHA may be updated via AJAX and the updated hash is stored in body data
    var hash = $('body').data(options.hashKey);
    if (hash == null) {
        hash = options.hash;
    } else {
        hash = hash[options.caseSensitive ? 0 : 1];
    }
    var v = options.caseSensitive ? value : value.toLowerCase();
    for (var i = v.length - 1, h = 0; i >= 0; --i) {
        h += v.charCodeAt(i);
    }
    if (h != hash) {
        validation.addMessage(messages, options.message, value);
    }
};

