$(document).ready(function(){

    if(controller_name == 'site' && action_name == 'index')
    {
        $("#content-1").mCustomScrollbar({
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
        var post_id = entity_id;
        setInterval(function(){
            var pin_post = 0;
            var enable_comments = 0;

            if(typeof $('#post-auto_save:checked').val() == 'undefined')
            {
                return false;
            }

            if(typeof $('#post-pin_post:checked').val() != 'undefined')
            {
                pin_post = 1;
            }
            if(typeof $('#post-enable_comments:checked').val() != 'undefined')
            {
                enable_comments = 1;
            }

            var post_categories = $('#post-post_categories').val();
            var tags = $('#post_tags').val();
            var keywords = $('#post_keywords').val();
            // console.log($('#post_keywords').val());
            var url = base_url + '/post/default/auto-save';
            var data = {
                title: $('#post-title').val(),
                short_text: tinymce.get('post-short_text').getContent(),
                more_text: tinymce.get('post-more_text').getContent(),
                meta_description: $('#post-meta_description').val(),
                status: $('#post-status').val(),
                minute: $('#post-minute').val(),
                hour: $('#post-hour').val(),
                date: $('#post-date').val(),
                pin_post: pin_post,
                enable_comments: enable_comments,
                post_id: post_id
            };

            if(data['title'] != '' && data['short_text'] != '')
            {
                $.post(url,{Post: data,post_categories: post_categories,tags: tags,keywords: keywords},function(data){
                    if(parseInt(data) >= 0)
                    {
                        post_id = data;
                        $('#post-post_id').val(post_id);
                    }
                });
            }
        }, 10000);
    }

    $('.upload-box-link').click(function(){
        $(this).select();
    })


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

});