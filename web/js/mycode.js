$(document).ready(function(){

    $('.main-container').css({'min-height': $(window).height()});

    $('.s-link-copy').click(function(){

        // reset
        $('.s-link-copy').html('Copy');

        var copyText = $(this).parent().find('input');
        copyText.select();
        document.execCommand("copy");

        $(this).html('Copied!');
    });

    if(controller_name == 'dashboard' && action_name == 'home')
    {
        $("#content-2").mCustomScrollbar({
            autoHideScrollbar:false,
            theme:"dark",
            snapAmount:40,
            scrollButtons:{enable:true},
            keyboard:{scrollAmount:40},
            mouseWheel:{deltaFactor:40},
            scrollInertia:400
        });
    }

    $('.last-visitors-lock').click(function () {
        $(this).hide();
    });

    $('.group-items').hover(function(){
        var class_name = $(this).attr('class').trim();
        if(class_name == 'group-items')
        {
            $(this).children('.sub-item').stop().slideDown();
        }
    },function(){
        var class_name = $(this).attr('class').trim();
        if(class_name == 'group-items')
        {
            $(this).children('.sub-item').stop().slideUp();
        }
    });

    if(modules_name == 'post' && (action_name == 'create' || action_name == 'update'))
    {

    }

    if(modules_name == 'post' && (action_name == 'view'))
    {
        if($.urlParam('clear_local_storage') == 1)
        {
            clear_local_storage();
        }
    }

    $('.upload-box-link').click(function(){
        $(this).select();
    });

    $('.auto-saved-btn').click(function(){
        if(action_name == 'update')
        {
            var post_id = $.urlParam('id');
        }
        else
        {
            var post_id = '';
        }
        var temp_post_title = localStorage.getItem("temp_post_title"+post_id);
        if(temp_post_title !== null)
        {
            $('#post-title').val(localStorage.getItem("temp_post_title"+post_id));
        }

        var temp_post_short_text = localStorage.getItem("temp_post_short_text"+post_id);
        if(temp_post_short_text !== null)
        {
            tinymce.get('post-short_text').setContent(temp_post_short_text);
        }

        var temp_post_more_text = localStorage.getItem("temp_post_more_text"+post_id);
        if(temp_post_more_text !== null)
        {
            tinymce.get('post-more_text').setContent(temp_post_more_text);
        }
    });


    $('#post-status').change(function(){
        post_status_value = $(this).find(":selected").val();
        if(post_status_value == 2)
        {
            $('#post-date-section').removeClass('display-none');
        }
        else
        {
            $('#post-date-section').addClass('display-none');
        }
    });

    var post_status_value = $('#post-status').find(":selected").val();
    if(post_status_value ==2)
    {
        $('#post-status').change();
    }


    $('.post-more-btn').click(function () {
        $('#more-text-section').removeClass('visibility-hidden');
        $('.post-more-section').addClass('display-none');
    });

    var mote_text_value = $('#post-more_text').val();
    if(mote_text_value != '')
    {
        $('.post-more-btn').click();
    }

    $('.newsletter-log-title').click(function(){
        $('.newsletter-log-detail').slideUp();
        $(this).parent().find('.newsletter-log-detail').slideDown();
    });

    $('.restore-default-template').click(function(){
        var url = base_url + '/newsletter/default/get-default-template';
        $.get(url,{},function(data){
            $('#newsletter-template').val(data);
        });
    });

    function survey(selector, callback) {
        var input = $(selector);
        var oldvalue = input.val();
        setInterval(function(){
            if (input.val()!=oldvalue){
                oldvalue = input.val();
                callback();
            }
        }, 100);
    }
    survey('#user-avatar', function(){
        $('.user-profile, .user-profile-big').attr('src', $('#user-avatar').val());
    });

    $('#more-menu').click(function(){
        $(".sm-menu").animate({height: '100%'}, 'slow', function(){
            $(".menu-section-2").show();
        });
        $(".menu-section-1").hide();
    });

    $('.down-menu').click(function(){
        $(".menu-section-2").hide();
        $(".sm-menu").animate({height: '40px'}, 'slow', function(){
            $(".menu-section-1").show();
        });
    });
});

function done_typing(editor) {
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2000;  //time in ms, 5 second for example
    var $input = $('#myInput');

    editor.on('keyup', function (e) {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    editor.on('keydown', function (e) {
        clearTimeout(typingTimer);
    });

//user is "finished typing," do something
    function doneTyping () {
        set_content_to_local_storage();
    }
}

$('#post-title').change(function(){
    set_content_to_local_storage();
});

function clear_local_storage() {
    var post_id = $.urlParam('id');

    localStorage.removeItem("temp_post_title");
    localStorage.removeItem("temp_post_short_text");
    localStorage.removeItem("temp_post_more_text");

    localStorage.removeItem("temp_post_title"+post_id);
    localStorage.removeItem("temp_post_short_text"+post_id);
    localStorage.removeItem("temp_post_more_text"+post_id);
}

function set_content_to_local_storage() {
    if(action_name == 'update')
    {
        var post_id = $.urlParam('id');
    }
    else
    {
        var post_id = '';
    }

    localStorage.setItem("temp_post_title"+post_id, $('#post-title').val());
    localStorage.setItem("temp_post_short_text"+post_id, tinymce.get('post-short_text').getContent());
    localStorage.setItem("temp_post_more_text"+post_id, tinymce.get('post-more_text').getContent());
}

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

    if(results == null)
    {
        return 0;
    }

    return results[1] || 0;
}
