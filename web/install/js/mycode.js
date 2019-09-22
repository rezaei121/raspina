$(document).ready(function(){

    $('#close-db-log').click(function () {
        $('.hole').hide();
    });

    $('#db-section input').keyup(function () {
        var dbms = $('#install-dbms').val();
        var db_host = $('#install-db_host').val();
        var db_name = $('#install-db_name').val();
        var db_username = $('#install-db_username').val();
        var db_password = $('#install-db_password').val();

        if(dbms != '' && db_host != '' && db_name != '' && db_username != '')
        {
            $('#test-connection').removeClass('disabled')
        }
        else
        {
            $('#test-connection').addClass('disabled')
        }
    });

    $('#test-connection').click(function(){

        var dbms = $('#install-dbms').val();
        var db_host = $('#install-db_host').val();
        var db_name = $('#install-db_name').val();
        var db_username = $('#install-db_username').val();
        var db_password = $('#install-db_password').val();
        var db_table_prefix = $('#install-table_prefix').val();

        if(dbms != '' && db_host != '' && db_name != '' && db_username != '')
        {
            var jqxhr = $.post( base_url + '/install/test-connection', {
                dbms: dbms,
                db_host: db_host,
                db_name: db_name,
                db_username: db_username,
                db_password: db_password,
                db_table_prefix: db_table_prefix
            }, function(data) {
                if(data == 1)
                {
                    $('#db-section').hide();
                    $('#user-section, #setting-section').show();

                    $('.hole').show();
                    $.post( base_url + '/install/migration', function (data) {
                        var import_result = data;
                        if(import_result == 0)
                        {
                            import_result = "error: can not import. please run manually {migrate/up} command.";
                        }
                        $('#db-log').val(import_result)
                    });
                    alert('database connected successfully.');
                }
                else
                {
                    alert('database not connect!');
                }
            })
        }
    });
});
