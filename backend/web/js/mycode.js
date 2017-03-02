$(document).ready(function(){

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

    var post_id = null;
    if(modules_name == 'post' && (action_name == 'create' || action_name == 'update'))
    {
        setInterval(function(){
            var pin_post = 0;
            var comment_active = 0;
            if(typeof $('#post-pin_post:checked').val() != 'undefined')
            {
                pin_post = 1;
            }
            if(typeof $('#post-comment_active:checked').val() != 'undefined')
            {
                comment_active = 1;
            }

            var post_categories = $('#post-post_categories').val();
            var tags = $('#post_tags').val();
            var keywords = $('#post_keywords').val();
            var status = 0;
            var url = base_url + '/post/create';
            if(action_name == 'update')
            {
                status = $('#post-status').val();
                url = base_url + '/post/update?id=' + entity_id;
            }
            var data = {
                title: $('#post-title').val(),
                short_text: tinymce.get('post-short_text').getContent(),
                more_text: tinymce.get('post-more_text').getContent(),
                meta_description: $('#post-meta_description').val(),
                status: status,
                minute: $('#post-minute').val(),
                hour: $('#post-hour').val(),
                date: $('#post-date').val(),
                pin_post: pin_post,
                comment_active: comment_active,
                post_id: post_id
            };

            $.post(url,{Post: data,post_categories: post_categories,tags: tags,keywords: keywords},function(data){
                if(parseInt(data) >= 0)
                {
                    post_id = data;
                    $('#post-post_id').val(post_id);
                }
            });
        }, 10000);
    }

    $('.upload-box-link').click(function(){
        $(this).select();
    })
});