<!doctype html>
<html lang="it">
  <head>
     <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="theme-color" content="#00bf76">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" type="" href="/images/favicon.png">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!--<script src="/js/custom.js"></script>-->
    <title>Dashboard - EPEBOOK</title>
  </head>
  <body class="dashboard">
    <?= $this->Flash->render() ?>
    <div class="page-wrapper">
        <?= $this->fetch('content') ?>
    </div>
    <!-- Modal for company profile completion START -->
    <div class="modal fade" id="modal-company-profile-completion" tabindex="-1" role="dialog" aria-labelledby="modalManageBlockedUsersCenterTitle" aria-hidden="true">

    </div>
    <!-- Modal for company profile completion END -->
    <script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    checkForCompanyProfilation();
    //Retrieve time to pull friendships
    $("#pending-friendships-counter").hide();
    var timeToPullFriendships = 0;
    $.ajax({
        url: '/config/get-time-to-pull-friendships',
        data: {

        },
        method: 'POST',
        dataType: 'json',
        statusCode: {
            403: function(xhr){
                location.href="/user/login?redirect=/user/profile";
            }
        },
        success: function(data, textStatus, jqXHR){
           timeToPullFriendships = data;
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
    $.ajax({
        url: '/user-friendship/get-pending-friendships',
        data: {

        },
        method: 'POST',
        dataType: 'json',
        statusCode: {
            403: function(xhr){
                location.href="/user/login?redirect=/user/profile";
            }
        },
        success: function(data, textStatus, jqXHR){
            $("#pending-friendships-counter").html(data["COUNT"]);
            if(data["COUNT"] == 0){
                $("#pending-friendships-counter").hide();
            }else{
                $("#pending-friendships-counter").show();
            }
            checkForFriendshipRequests();
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
    function checkForCompanyProfilation(){
        $.ajax({
            url: '/user-profile/is-organization-anagraphic-complete',
            data: {

            },
            method: 'POST',
            dataType: 'json',
            statusCode: {
                403: function(xhr){
                    location.href="/user/login?redirect=/user/profile";
                }
            },
            success: function(data, textStatus, jqXHR){
                if(data == 'NO'){
                    showModalForCompanyProfileCompletion();
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
    function showModalForCompanyProfileCompletion(){
        $.ajax({
            url: '/user-profile/get-modal-for-company-profile-completion',
            data: {

            },
            method: 'POST',
            statusCode: {
                403: function(xhr){
                    location.href="/user/login?redirect=/user/profile";
                }
            },
            success: function(data, textStatus, jqXHR){
                $("#modal-company-profile-completion").html(data);
                $('#modal-company-profile-completion').modal({show: true, backdrop: 'static', keyboard: false});
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }
    function checkForFriendshipRequests(){
        setTimeout(function(){
            $.ajax({
                url: '/user-friendship/get-pending-friendships',
                data: {

                },
                method: 'POST',
                dataType: 'json',
                statusCode: {
                    403: function(xhr){
                        location.href="/user/login?redirect=/user/profile";
                    }
                },
                success: function(data, textStatus, jqXHR){
                    $("#pending-friendships-counter").html(data["COUNT"]);
                    if(data["COUNT"] == 0){
                        $("#pending-friendships-counter").hide();
                    }else{
                        $("#pending-friendships-counter").show();
                    }
                    checkForFriendshipRequests();
                },

                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }, timeToPullFriendships);
    }



    checkForUnreadMessages()
    $("#unread-messages-counter").hide();

    function checkForUnreadMessages(){
        setInterval(function(){
            $.ajax({
                url: '/mail-message/getUserInbox',
                data: {
                    'mode': 'unread'
                },
                method: 'POST',
                dataType: 'json',
                statusCode: {
                    403: function(xhr){
                        location.href="/user/login?redirect=/user/profile";
                    }
                },
                success: function(data, textStatus, jqXHR){
                    $("#unread-messages-counter").html(data);
                    if(data == 0){
                        $("#unread-messages-counter").hide();
                    }else{
                        $("#unread-messages-counter").show();
                    }
                    //checkForUnreadMessages();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }, 10000);
    }
    </script>
  </body>
</html>
