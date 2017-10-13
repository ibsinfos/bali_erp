$(function() {

    var _url = $("#_url").val();

    var ib_msg = $("#ib_msg");

    //ib_msg.html('Please wait...');

    setTimeout(function(){

        ib_msg.html('Checking the system...<br>');

        $.get( _url + "files/create_htaccess/", function( data ) {


            if(data == 'ok'){


              var ib_ajax =  $.get( _url + "settings/url_rewrite_enable/", function( data ) {

                    ib_msg.append(data);

                    // check if it's working

                    $.get( _url + "settings/url_rewrite_check/", function( data ) {

                        if(data == 'ok'){

                            location.reload();

                        }
                        else{
                            $.get( "?ng=files/remove_htaccess/", function( data ) {
                                ib_msg.append("Sorry, Unable to enable URL Rewrite. Check the Server supports URL Rewriting.");
                            });
                        }

                    });

                }).fail(function() {

                  ib_msg.append("System, encountered an error. Please remove the .htaccess file from root directory.");

                  $.get( "?ng=files/remove_htaccess/", function( data ) {
                      ib_msg.append("Sorry, Unable to enable URL Rewrite. Check the Server supports URL Rewriting.");
                  });

              });

            }
            else{
                ib_msg.append(data);
            }



        });


    }, 2000);

});