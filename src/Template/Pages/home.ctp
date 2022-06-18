<?php 
use Cake\I18n\Time;
use Cake\View\Helper\FlashHelper;
$user = $this->request->Session()->read('Auth.User');
?>
<style>
    .w3-display-container {
    position: relative;
    }
    
    .w3-blue {
        color: #fff!important;
        background-color: #2196F3!important;
    }

    .w3-display-right {
        position: absolute;
        right: 0%;
        transform: translate(0%,-10%);
    }

    .w3-display-left {
        position: absolute;
        left: 0%;
        transform: translate(0%,-10%);
    }

    .w3-button {
        user-select: none;
        border: none;
        display: inline-block;
        padding: 8px 16px;
        vertical-align: middle;
        overflow: hidden;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        white-space: nowrap;
    }

    .sub-project-comment {
        display:inline-block;
        clear: both;
        padding: 20px;
        border-radius: 30px;
        margin: 0em 2em 0.5em 2em;
        font-family: Helvetica, Arial, sans-serif;
        float: left;
        background: #eee
    }

    .comment-wrapper {
        display: flex;
        margin-top: 1em;
    }

    .slcomment {
        margin-right: 1em
    }

    .searchBox {
        position: fixed;
        left: 70px;
        z-index: 999;
        background-color: #fff;
        width: 10em
    }

    .attachment {
        border: 1px solid #bbbbbb;
        border-radius: 7px;
        padding: 0.5em 0.5em 0.5em 1em;
        margin-bottom: 0.5em;
        display:flex;
        align-items:center;
        cursor: pointer;
    }

    .attachmentName {
        margin: 0 0 0 1em
    }


    .cut-text {
        margin: 0!important
    }

    .container .row {
        padding-right: 0px !important;
        margin-right: 0px !important;
    }

    .project-view-wrapper .project-sidebar .tab-content-wrapper .tab-content {
        overflow-y: auto;
        overflow-x: hidden;
        max-height: 360px;
    }
    /*#ui-id-1 {
        list-style-type: none;
        background-color: #fff;
        z-index: 999;

    }*/
</style>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- Bootstrap CSS -->
    <link rel="icon" type="" href="/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <!--<link rel="stylesheet" type="text/css" href="../css/style.css">-->
    <link rel="stylesheet" type="text/css" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="../css/owl.theme.default.min.css">
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="../js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="../js/jquery.bootcalendar.js"></script>
    <script type="text/javascript" src="../js/custom.js"></script>
    
     <?= 
        //$this->Html->css('style.css');
        $this->Html->css('bootstrap.css');
        $this->Html->script('jquery.bootcalendar.js');
        $this->Html->script('custom.js');    
    ?>
<!--<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#00bf76">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" type="" href="images/favicon.png">

    <title>Projects - epebook</title>
  </head>
  <body class="innerpage mail-page">
    <div class="page-wrapper">-->
        <!-- Header starts -->
        <div class="topbar-wrapper">
            <div class="logo"><a href="/"><img src="/images/epebook-logo.png" alt="epebook" title="epebook" width="179"> <img src="/images/epebook-icon.png" alt="epebook" title="epebook" width="42" class="icon"></a></div>
            <div class="container">
                <div class="flex-box">
                <div class="page-title">
                   <?= __('Projects') ?>
                </div>
                <div class="search-wrapper has-other-icons" style="display: flex; width: 30% !important;">
                    
                    <input id="searchBoxInput" name="searchBoxInput" type="text" class="form-control search-input" placeholder="Cerca Progetti">
                    
                    <div class="other-actions">                       
                        <a href="#" id="modCreateProject" style="background-color:rgba(0,0,0,0)"><img width='50px' height='50px' style="margin-left:30px" src="/images/black_plus.png" alt="add_project" title="<?= __('add project') ?>"></a>
                    </div>
                </div>
                
                <div class="icons-wrapper">
                <ul>
                    <li> <a href="/user-friendship/view-pending-friendship-requests"><span id="pending-friendships-counter" class="counter">2</span> <img src="/images/user-icon.png" width="17" alt="User" title="User"></a> </li>
                    <li> <a href="#"><span class="counter">1</span> <img src="/images/notification-icon.png" width="16" alt="Notifications" title="Notifications"></a> </li>
                    <li> <a href="/mail-message"><span id="unread-messages-counter" class="counter">5</span> <img src="/images/mail-icon.png" alt="messages" title="messages" width="20"></a> </li>
                    <li> <a href="settings.html"><img src="/images/settings-icon.png" alt="settings" title="settings" width="21"></a> </li>       
                </ul>
                </div>
                <div class="user-options">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="profile-icon" style="background-color: #000000;">
                                <img src="/img/profilephotoimages/default-male-avatar.jpg?refresh=<?= time() ?>" alt="username" title="username">
                            </span>
                            <span class="username">
                                <?= $user['email'] ?>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/user/profile"><?= __('Your Profile') ?></a>
                            <a class="dropdown-item" href="/user/logout"><?= __('Logout') ?></a>
                        </div>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
        <!-- Header Ends -->
        
        <!-- Custom Sidebar menu starts -->
        <div class="sidebar-wrapper">
            <style type="text/css">
                .sidebar .menu .active {
                    background: #28e28d;
                }
            </style>
            <div class="sidebar">
                <ul class="menu">
                    <li class="custom-menu-toggle"><a href="#" class="close-menu"> <span class="icon"><img src="images/menu-icons/Close-X.png" alt="Menu toggle" title="Menu toggle"> </span> <span class="menu-title"> <i>close</i> menu</span>  </a> </li>

                    <li class="active" tab="project"><a href="#"> <span class="icon"><img src="images/menu-icons/Calendario.png" alt="Progetti" title="progetti"> </span> <span class="menu-title">progetti</span>  </a> </li>
                    <li tab="research-entity"><a href="#"> <span class="icon"><img src="images/menu-icons/Scrivania.png" alt="Enti di ricerca" title="entidiricerca"> </span> <span class="menu-title">enti di ricerca</span>  </a> </li>
                     <li tab="spinoff"><a href="#"> <span class="icon"><img src="images/menu-icons/Hoots.png" alt="Spinoff" title="spinoff"> </span> <span class="menu-title">spinoff</span>  </a> </li>
                    <li tab="crowdfunding"><a href="#"> <span class="icon"><img src="images/menu-icons/biblio-generale.png" alt="Crowdfunding" title="crowdfunding"> </span> <span class="menu-title">Crowdfunding</span> </a> </li>
                    <li tab="addMember"><a href="#"> <span class="icon"><img src="images/menu-icons/Scrivania.png" alt="Crowdfunding" title="addMember"> </span> <span class="menu-title">aggiungi</span> </a> </li>
                </ul>
            </div>

            <script type="text/javascript">
                // sidebar navigation
                $('.sidebar .menu li').on('click', function() {
                    // if not close menu action
                    if(!$(this).hasClass("custom-menu-toggle")) {
                        selectedTab = $(this).attr('tab');
                        // check if it's a special tab
                        if(selectedTab == 'crowdfunding') { // if crowdfunding
                            alert('Redirect to crowdfunding');
                        } else if(selectedTab == 'addMember') { // if addMember
                            alert(('Redirect to signup page for spinoff/research entity'))
                        } else if(!$(this).hasClass('active')) {    // otherwise, if not already active as tab
                            $('.sidebar .menu li').removeClass("active");
                            $(this).addClass("active");
                            $('.innerpage-content .container .row .view-wrapper .view').fadeOut(500);
                            setTimeout(function() {
                                $(".innerpage-content .container .row .view-wrapper ." + selectedTab + "-view-wrapper").fadeIn(500);
                            }, 500);
                        }
                    }
                });
            </script>
        </div>
        <!-- Custom Sidebar menu Ends -->
        
        <!-- Innerpage content wrapper starts------>
            <div class="innerpage-content-wrapper" style="padding-top: 2.125rem">
                <!-- Innerpage contnet starts ----->
                <div class="innerpage-content" style="padding-bottom: 0px">
                    <div class="container">
                        <div class="row col-md-12">
                            <div class="view-wrapper col-md-10">
                                <!-- project list START -->
                                <div class="project-view-wrapper view">
                                    <style type="text/css">
                                        .project-view .nav { width: 100%; display: table;}
                                        .project-view .nav-tabs { padding-left: 50%; width: 100%; margin-bottom: 40px; }
                                        .project-view .nav .nav-item { display: table-cell; }
                                        .project-view .nav .nav-item a { padding-left: 0; padding-right: 0;}
                                        .project-list-wrapper h5 { padding-bottom: 0 !important; margin-top: 1.875rem; margin-bottom: 0 !important; }
                                        .project-view .tab-content { padding-top: 0 !important; }

                                    </style>
                                    <div class="project-view">
                                        <div class="tab-content-wrapper">
                                            <!-- Nav tabs -->
                                            <div class="nav-container nav-tabs">
                                                <ul class="nav nav-justified" id="project-list-nav" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" href="#school" role="tab" data-toggle="tab">
                                                            <?=__('Formativi')?>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#business" role="tab" data-toggle="tab">
                                                            <?=__('Aziendali')?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Tab panes -->
                                            
                                            <div class="tab-content">
                                                <!-- FORMATIVI -->
                                                <div role="tabpanel" class="tab-pane fade show active" id="project-list-school">
                                                    <div class="project-list-school">
                                                        <div class="project-list">                        
                                                            <!-- Owl Carousel Starts -->
                                                            <div class="owl-carousel">
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="http://localhost:8765/projectObject/view/5">Titolo lungo del progetto</a></div>
                                                                                <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                                <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                            </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                                <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                            </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                                <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                            </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>   
                                                <!-- AZIENDALI -->
                                                <div role="tabpanel" class="tab-pane fade hide" id="project-list-business">
                                                    <div class="project-list-business">
                                                        <div class="project-list">                        
                                                            <!-- Owl Carousel Starts -->
                                                            <div class="owl-carousel">
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="http://localhost:8765/projectObject/view/5">Titolo lungo del progetto</a></div>
                                                                                <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                                <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                            </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                                <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                            </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                                <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                            </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item">
                                                                    <div>
                                                                        <div class="collection">
                                                                           
                                                                            <div class="collection-image-wrapper">
                                                                                <div class="collection-img">
                                                                                    <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                                                </div>
                                                                                <div class="collection-action">
                                                                                    <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="collection-info-wrapper">
                                                                                <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                                            <div class="uploader-info">
                                                                                    <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                                                </div>
                                                                                <div class="collection-meta-info">
                                                                                    <div class="likes">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                                        </span>
                                                                                        <span>400</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                                        </span>
                                                                                        <span>275</span>
                                                                                    </div>
                                                                                    <div class="views">
                                                                                        <span class="icon">
                                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                                        </span>
                                                                                        <span>120</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Project list script -->
                                        <script type="text/javascript">
                                            $('#project-list-nav .nav-link').on("click", function() {
                                                if(!$(this).hasClass('active')) {
                                                    // render as active the selected nav
                                                    $('#project-list-nav .nav-link').removeClass('active');
                                                    $(this).addClass('active');
                                                    // pick attribute href
                                                    selectedType = $(this).attr('href');
                                                    // show it hiding the other one
                                                    if(selectedType == '#school') {
                                                        toShow = $('#project-list-school');
                                                        toHide = $('#project-list-business');
                                                    } else {
                                                        toShow = $('#project-list-business');
                                                        toHide = $('#project-list-school');
                                                    }
                                                    $(toHide).fadeOut(100);
                                                    setTimeout(function() {
                                                        $(toShow).fadeIn(500);
                                                        $(toHide).removeClass('show');
                                                        $(toHide).addClass('hide');
                                                        $(toHide).removeClass('active');
                                                        $(toShow).addClass('show');
                                                        $(toShow).removeClass('hide');
                                                        $(toShow).addClass('active');
                                                    }, 100);
                                            }
                                        });
                                        </script>
                                    </div>
                                </div>
                                <!-- project list END -->

                                <!-- research entity list START -->
                                <div class="research-entity-view-wrapper view hide">
                                    <style>
                                        .research-entity-list .nav { width: 50%; display: table; margin-left: 50%; }
                                        .research-entity-list .nav-tabs { padding-left: 50%; width: 100%; margin-bottom: 40px; }
                                        .research-entity-list .nav .nav-item { display: table-cell; }
                                        .research-entity-list .nav .nav-item a { padding-left: 0; padding-right: 0;}
                                    </style>
                                    <div class="research-entity-list">                
                                        <!-- Nav tabs -->
                                        <div class="nav-container nav-tabs">
                                            <ul class="nav nav-justified" id="project-list-nav" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#school" role="tab" data-toggle="tab">
                                                        <?=__('Enti di ricerca')?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Owl Carousel Starts -->
                                        <div class="owl-carousel">
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="http://localhost:8765/projectObject/view/5">Titolo lungo del progetto</a></div>
                                                            <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                        </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                        </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                        </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- research entity list END -->

                                <!-- spinoff list START -->
                                <div class="spinoff-view-wrapper view hide">
                                    <style>
                                        .spinoff-list .nav { width: 50%; display: table; margin-left: 50%; }
                                        .spinoff-list .nav-tabs { padding-left: 50%; width: 100%; margin-bottom: 40px; }
                                        .spinoff-list .nav .nav-item { display: table-cell; }
                                        .spinoff-list .nav .nav-item a { padding-left: 0; padding-right: 0;}
                                    </style>
                                    <div class="spinoff-list">                
                                        <!-- Nav tabs -->
                                        <div class="nav-container nav-tabs">
                                            <ul class="nav nav-justified" id="project-list-nav" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#school" role="tab" data-toggle="tab">
                                                        <?=__('SPINOFF')?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Owl Carousel Starts -->
                                        <div class="owl-carousel">
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="http://localhost:8765/projectObject/view/5">Titolo lungo del progetto</a></div>
                                                            <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                            <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                        </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                            <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                        </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                            <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                        </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="images/Blocco-Libro1.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro2.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div>
                                                    <div class="collection">
                                                       
                                                        <div class="collection-image-wrapper">
                                                            <div class="collection-img">
                                                                <img src="/images/Blocco-Libro3.jpg" alt="collection image" title="collection image">
                                                            </div>
                                                            <div class="collection-action">
                                                                <a href="#"><img src="/images/cuoricino-nel-bollino-icon.png" alt="+ nel bollino" title="+ nel bollino"></a>
                                                            </div>
                                                        </div>
                                                        <div class="collection-info-wrapper">
                                                            <div class="book-title"><a href="book-profile.html">Titolo lungo del progetto</a></div>
                                                                        <div class="uploader-info">
                                                                <div class="title">Descrizione del progetto, descrizione del progetto, descrizione del progetto, descrizione del progetto</div>
                                                            </div>
                                                            <div class="collection-meta-info">
                                                                <div class="likes">
                                                                    <span class="icon">
                                                                                        <img src="/images/cuoricino-icon.png" alt="likes" title="likes">
                                                                                    </span>
                                                                    <span>400</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/occhio-icon.png" alt="views" title="views">
                                                                                    </span>
                                                                    <span>275</span>
                                                                </div>
                                                                <div class="views">
                                                                    <span class="icon">
                                                                                        <img src="/images/pagine.png" alt="Pages" title="Pages">
                                                                                    </span>
                                                                    <span>120</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- spinoff list END -->
                            </div>

                            <!-- news list START -->
                            
                            <div class="col-md-2" style="padding-right: 0px; padding-top: 0.5rem; border-left: 1px solid lightgrey;">
                                <style type="text/css">
                                    .latest-updates { height: 50%; }
                                    .latest-updates h4 { padding: 0.5rem 1rem; margin-bottom: 20px; font-size: 1.1875rem; font-weight: 900; text-transform: uppercase;}
                                    .latest-updates .update { height: 40px; }
                                    .latest-updates .update .desc {margin-left: 35px; }
                                </style>
                                <div class="box latest-updates">
                                    <h4>AGGIORNAMENTI</h4>
                                    <div class="update">
                                        <div class="desc">
                                            <div class="title"><a href="#"> Aggiornamento 1</a> </div>
                                        </div>
                                    </div>
                                    <div class="update">
                                        <div class="desc">
                                            <div class="title"><a href="#"> Aggiornamento 2</a> </div>
                                        </div>
                                    </div>
                                    <div class="update">
                                        <div class="desc">
                                            <div class="title"><a href="#"> Aggiornamento 3</a> </div>
                                        </div>
                                    </div>
                                    <div class="update">
                                        <div class="desc">
                                            <div class="title"><a href="#"> Aggiornamento 4</a> </div>
                                        </div>
                                    </div>
                                    <div class="update">
                                        <div class="desc">
                                            <div class="title"><a href="#"> Aggiornamento 5</a> </div>
                                        </div>
                                    </div>
                                    <div class="update">
                                        <div class="desc">
                                            <div class="title"><a href="#"> Aggiornamento 6</a> </div>
                                        </div>
                                    </div>
                                </div>

                                <style type="text/css">
                                    .invitations { height: 50%; }
                                    .invitations h4 { padding: 0.5rem 1rem; margin-bottom: 20px; font-size: 1.1875rem; font-weight: 900; text-transform: uppercase;}
                                </style>
                                <div class="invitations tab-content-wrapper">
                                    <h4>INVITI</h4>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade show active" id="inviti">
                                            <ul class="list-unstyled">
                                              <li>
                                                <div class="img-wrapper">
                                                    <div class="img">  
                                                    </div>
                                                </div>
                                                  <div class="details">
                                                    <div class="title">Nome Utente</div>
                                                    <div class="project-name">Nome Progetto</div>
                                                    <div class="date">Friday at 1:23 pm</div>
                                                  </div>
                                                  <div class="btn-wrapper">
                                                    <button class="btn btn-sm btn-secondary">Accetta</button>
                                                  </div>
                                              </li>
                                              
                                          </ul>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                            <!-- new list END -->
                        </div>
                    </div>
                </div>
                <!-- Innerpage contnet END ----->
                
            </div>
        
        <!-- Innerpage content wrapper END ------>
        
    </div>

    <!-- Modal -->
    <div class="modal fade text-left" id="create-project-modal" tabindex="-1" role="dialog" aria-labelledby="create-project-modalLabel" aria-hidden="true">

    </div>
       

    <script>
       
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;

        function modCreateProject(){
            $.ajax({
                url: '/projectObject/create-project-modal/',
                method: 'get',
                success: function(data){
                    
                    $('#create-project-modal').html('');
                    $('#create-project-modal').html(data);
                    $('#create-project-modal').modal('show');
                    $('body').attr("class", "innerpage");
                    $('body').attr("style", "");
                },
                error: function (a, b, c) {
                    //console.log(a);
                    //console.log(b);
                    //console.log(c);
                }
            });
        }

        function getMemberProjects(page) {
            //console.log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>call");
            if (page == 1) {
                $('#member .w3-display-left').hide()
            }
            $('#member .w3-display-right').hide()

            $.ajax({
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: '/projectObject/getProjectsMemberedByUser/',
                data: {
                    study: false,
                    page: page
                },
                success: function(data) {
                    //console.log(data['projects'])
                    //console.log(data['projects'].length)

                    console.log(data);

                    data = data['projects']

                    if (nextPage != 0) {
                        $('#member .w3-display-right').show()
                    }
                    if (page != 1) {
                        $('#member .w3-display-left').show()
                    }
                    

                    i = 0;
                    for (i; i < data.length; i++) {
                        console.log(data[i]['imageFilePath'])
                        if (data[i]['imageFilePath'] == null) {
                            $('#member-' + i + ' .project-img img').attr("src", "/images/project-placeholder-image.png")
                        } else {
                            $('#member-' + i + ' .project-img img').attr("src", data[i]['imageFilePath'])
                        }
                        $('#member-' + i + ' .project-title a').text(data[i]['name'])
                        $('#member-' + i + ' .project-title a').attr("href", "/projectObject/view/"+data[i]['id'])
                        $('#member-' + i + ' .project-desc p').text(data[i]['description'])
                        $('#member-' + i).show()
                    }
                    for (i; i < 6; i++) {
                        $('#member-' + i + ' .project-img img').attr("src", "/images/project-placeholder-image.png")
                        $('#member-' + i + ' .project-title a').text('')
                        $('#member-' + i + ' .project-desc p').text('')
                        $('#member-' + i).hide()
                    }
                },
                error: function(a, b, c) {
                    console.log(">>>>>>>>>>>>>>>>>>>Nope");
                    console.log(a)
                    console.log(b)
                    console.log(c)

                }
            })

        }    


        function getOwnerProjects(page) {
            $.ajax({
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: '/projectObject/getProjectsOwnedByUser/',
                data: {
                    page: page
                },
                success: function(data) {
                    console.log(data)
                    nextPage = data['nextPage']
                    data = data['projects']
            
                    i = 0;
                    for (i; i < data.length; i++) {
                        console.log(data[i]['imageFilePath'])
                        if (data[i]['imageFilePath'] == null) {
                            $('#owner-' + i + ' .project-img img').attr("src", "/images/project-placeholder-image.png")
                        } else {
                            $('#owner-' + i + ' .project-img img').attr("src", data[i]['imageFilePath'])
                        }
                        $('#owner-' + i + ' .project-title a').text(data[i]['name'])
                        $('#owner-' + i + ' .project-title a').attr("href", "/projectObject/view/"+data[i]['id'])
                        $('#owner-' + i + ' .project-desc p').text(data[i]['description'])
                        $('#owner-' + i).show()
                    }
                    console.log(i)
                    for (i; i < 6; i++) {
                        $('#owner-' + i + ' .project-img img').attr("src", "/images/project-placeholder-image.png")
                        $('#owner-' + i + ' .project-title a').text('')
                        $('#owner-' + i + ' .project-desc p').text('')
                        $('#owner-' + i).hide()
                    }
                    console.log(i)
                },
                error: function(a, b, c) {
                    console.log(a)
                    console.log(b)
                    console.log(c)

                }
            })
            
        }    


        function getStudyProjects(page) {
            if (page == 1) {
                $('#study .w3-display-left').hide()
            }
            $('#study .w3-display-right').hide()

            $.ajax({
                method: 'post',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                dataType: 'json',
                url: '/projectObject/getProjectsMemberedByUser/',
                data: {
                    study: true
                },
                success: function(data) {
                    console.log("qweqweqwewq");
                    console.log(data);
                    // clear progetti pubblici personali and esterni
                    $('#projects-public-mine li:not([template])').remove();
                    $('#projects-public-other li:not([template])').remove();
                    // progetti pubblici personali
                    personalPrjs = data['projects-mine'];
                    for (i = 0; i < personalPrjs.length; i++) {
                        console.log(personalPrjs[i]['imageFilePath'])
                        // pick details from ajax call
                        imageFilePath = 'https://www.socialibreria.com/wp-content/uploads/2017/03/1-2.png';
                        if (personalPrjs[i]['imageFilePath'] != null) {
                            imageFilePath = personalPrjs[i]['imageFilePath']
                        }
                        name = personalPrjs[i]['name'];
                        viewHref = "/projectObject/view/"+personalPrjs[i]['id'];
                        // create node
                        node = $('#projects-public-mine .template').first().clone()[0];
                        // define node properties
                        $(node).find('img').attr('src', imageFilePath);
                        $(node).find('a').attr('href', viewHref);
                        $(node).find('a').html(name);
                        // show and append the new element
                        $(node).removeClass('template');
                        $(node).removeAttr('template');
                        $(node).appendTo('#projects-public-mine');
                    }

                    // progetti pubblici esterni
                    otherPrjs = data['projects-other'];
                    for (i = 0; i < otherPrjs.length; i++) {
                        console.log(otherPrjs[i]['imageFilePath'])
                        // pick details from ajax call
                        imageFilePath = 'https://www.socialibreria.com/wp-content/uploads/2017/03/1-2.png';
                        if (otherPrjs[i]['imageFilePath'] != null) {
                            imageFilePath = otherPrjs[i]['imageFilePath']
                        }
                        name = otherPrjs[i]['name'];
                        viewHref = "/projectObject/view/"+otherPrjs[i]['id'];
                        // create node
                        node = $('#projects-public-other .template').first().clone()[0];
                        // define node properties
                        $(node).find('img').attr('src', imageFilePath);
                        $(node).find('a').attr('href', viewHref);
                        $(node).find('a').html(name);
                        console.log(node);
                        // show and append the new element
                        $(node).removeClass('template');
                        $(node).removeAttr('template');
                        $(node).appendTo('#projects-public-other');
                    }

                    
                },
                error: function(a, b, c) {

                    console.log("cxzczxcxzc");
                    console.log(a)
                    console.log(b)
                    console.log(c)

                }
            })
            
        }  

        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n, type) {
        showDivs(slideIndex += n, type);
        }

        function showDivs(n, type = 'member') {

            if (n == 1) {
                slideIndex = 1;
            }
        
            if (type == 'member') {

                //getMemberProjects(n);

            } else if (type == 'owner') {

                //getOwnerProjects(n);

            } else if (type == 'study') {

                getStudyProjects(n);

            }

        } 

        showProjectMessages();

        function showProjectMessages(scroll = false) {

            $.ajax({
                method: 'post',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                dataType: 'json',
                url: '/projectMessage/getMessages',
                data: {
                    'fromPage': 'GOindex'
                },
                success: function(data) {
                    console.log(data)
                    console.log('ciao')

                    html = "";

                    for (i = 0; i < data.length; i++) {

                        if (data[i]['favorite'] == 0) {
                            favorite = ""
                        } else {
                            favorite = "1"
                        }

                        html += '<div class="project-comment" id="comment' + data[i]['projectId'] + '-' + data[i]['senderId'] + '" style="border-bottom: 0px; padding: 2rem 2.3rem">'    
                        html +=     '<div class="img-wrapper">'
                        html +=         '<div class="img" style="background:url(\'/img/profilephotoimages/user-<?= $userId ?>.jpg?refresh=<?= time() ?>\'); background-size:cover">'
                        //html +=             '<img src="" alt="username" title="username">'
                        html +=         '</div>'
                        html +=     '</div>'
                        html +=     '<div class="details">'
                        html +=         '<div class="title">' + data[i]['go']['name'] + ' --- ' + data[i]['u']['firstname'] + ' ' + data[i]['u']['lastname'] + '</div>'
                        html +=         '<div class="description">' + data[i]['text'].replace(/</g, "&lt").replace(/>/g, "&gt") + '</div>'
                        if (data[i]['attachment'][0] != null) {
                            html +=     '<div class="attachment" onclick="startDownload(\'' +  data[i]['attachment'][0]['fileMarker'] + '\', \'' + data[i]['attachment'][0]['fileCnt'] + '\')"><i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i><p class="attachmentName">' + data[i]['attachment'][0]['fo']['displayFileName'] + '</p></div>'
                        }
                        var dataPostDay = new Date(data[i]['createDate']).getDate() + "";
                        var dataPostMonth = new Date(data[i]['createDate']).getMonth() + 1 + "";
                        if (dataPostDay.length == 1) dataPostDay = "0" + dataPostDay
                        if (dataPostMonth.length == 1) dataPostMonth = "0" + dataPostMonth
                        var dataPostYear = new Date(data[i]['createDate']).getFullYear();
                        var dataPostHour = new Date(data[i]['createDate']).getHours();
                        var dataPostMinute = new Date(data[i]['createDate']).getMinutes();
                        var fullDate = dataPostDay + "-" + dataPostMonth + "-" + dataPostYear + " " + dataPostHour + ":" + dataPostMinute;
                        html +=         '<div class="date">' + fullDate + '</div>'
                        html +=         '<div class="comment-actions" style="display:block!important">'
                        html +=             '<div class="share-like-wrapper">'
                        html +=                 '<a href="#" onclick="likeComment(event, ' + data[i]['projectId'] + ', ' + data[i]['senderId'] + ', \'' + data[i]['createDate'] + '\')"><span class="img-wrapper"><img id="like-image-' + data[i]['projectId'] + '-' + data[i]['senderId'] + '-' + data[i]['createDate'] + '" src="/images/like-icon' + favorite + '.png" alt="like" title="like" width="25"> </span> <span>Like</span></a>'
                        html +=                 '<a href="#"><span class="img-wrapper"><img src="/images/share-icon-gray.png" alt="Share" title="Share" width="19"> </span> <span>Share</span></a>'
                        html +=             '</div>'
                        html +=             '<div class="comment-wrapper">'
                        html +=                 '<input id="input-' + i + '" class="form-control slcomment" type="text" placeholder="Insert your text here" style="border-radius:1.5rem">'
                        html +=                 '<div class="btn-wrapper">'
                        html +=                     '<button class="btn btn-secondary" onClick="sendMessage(' + true + ',' + data[i]['senderId'] + ', ' + data[i]['projectId'] + ', \'' + data[i]['createDate'] + '\', ' + i + ')">Comment</button>'
                        html +=                 '</div>'
                        html +=             '</div>'
                        html +=         '</div>'
                        html +=     '</div>'
                        html += '</div>'
                        html += '<div class="sub-project-comments" id="subcomments' + data[i]['projectId'] + '-' + data[i]['senderId'] + '">' 

                        for (j = 0; j < data[i]['responses'].length; j++) {
                            html += '<div class="sub-project-comment" id="subcomment' + data[i]['responses'][j]['projectId'] + '-' + data[i]['responses'][j]['senderId'] + '">' 
                            html += '<p style="font-size: 0.75em; margin-bottom:0.5em">' + data[i]['responses'][j]['u']['firstname'] + ' ' + data[i]['responses'][j]['u']['lastname'] + '</p>'
                            //html += '</br>'
                            html += data[i]['responses'][j]['text'].replace(/</g, "&lt").replace(/>/g, "&gt")
                            html += '</div>'
                            

                        }   
                        html += '</div>'


                    }
                    html += '<div id="bottom" style="display: hidden"></div>'

                    $('.project-comments-wrapper').html(html)

                    if (scroll) {
                        location.href = '#bottom'
                    }
                },
                error: function(a, b, c) {
                    console.log(a)
                    console.log(b)
                    console.log(c)
                }
            })

        }


        function sendMessage(subMessage = false, idSender = null, idProject = null, createDate = null, index = null) {
            console.log(subMessage)

            if (index != null && subMessage) {
                textPost = $('#input-' + index).val()
            } else {
                textPost = $('#textPost').val()
            }

            $.ajax({
                method: 'post',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                dataType: 'json',
                url: '/projectMessage/add',
                data: {
                    'idProject': idProject,
                    'textPost': textPost,
                    'subMessage': subMessage,
                    'idSender': idSender,
                    'createDate': createDate
                },
                success: function(data) {
                    console.log(data)
                    if (data == 'No text') {
                        location.reload();
                        return false;
                    }
                    $('#textPost').val('')
                    showProjectMessages(!subMessage);
                },
                error: function(a, b, c) {
                    console.log(a)
                    console.log(b)
                    console.log(c)
                }
            })
        
       }

       function likeComment(e, projectId = null, senderId = null, createDate = null) {

            e.preventDefault();

            if (projectId != null && senderId != null && createDate != null) {
                $.ajax({
                    method: 'post',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    dataType: 'json',
                    url: '/projectMessage/likeComment',
                    data: {
                        'projectId': projectId,
                        'senderId': senderId,
                        'createDate': createDate
                    },
                    success: function(data) {
                        console.log(data[2])
                        if (data[0] == 0 && data[1] == 1) {
                            console.log('like-image-' + projectId + '-' + senderId + '-' + createDate)
                            //$('#like-image-' + projectId + '-' + senderId + '-' + createDate).removeAttr('src')
                            //$('#like-image-' + projectId + '-' + senderId + '-' + createDate).attr('src', '/images/like-icon1.png')
                            document.getElementById('like-image-' + projectId + '-' + senderId + '-' + createDate).src = "/images/like-icon1.png";
                        } else if (data[0] == 1 && data [1] == 1) {
                            //$('#like-image-' + projectId + '-' + senderId + '-' + createDate).removeAttr('src')
                            //$('#like-image-' + projectId + '-' + senderId + '-' + createDate).attr('src', '/images/like-icon.png')
                            document.getElementById('like-image-' + projectId + '-' + senderId + '-' + createDate).src = "/images/like-icon.png";
                        }
                        
                    },
                    error: function(a, b, c) {
                        console.log(a)
                        console.log(b)
                        console.log(c)
                    }
                })
            }

        }


        

        function startDownload(marker, cnt) 
        { 
            
            //var final = file.replace(/\\/g,"/");
            location.href = '/projectMessage/downloadFile/' + marker + '/' + cnt
        } 


        toggleTabList()

        function toggleTabList(type = 'inviti') {

            invito = 0;
            richiesta = 0;
            evento = 0;

            if (type == 'inviti') {
                invito = 1
                //error = "<?= __("There aren\'t any invites") ?>"
                console.log('iii')
            } else if (type == 'richieste') {
                richiesta = 1
                error = "<?= __('There aren\'t any requests') ?>"
                console.log('rrr')
            } else if (type == 'eventi') {
                evento = 1
            }

            $.ajax({
                method: 'post',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                dataType: 'json',
                url: '/projectObject/getProjectTabList',
                data: {
                    'page': 'index',
                    'invito': invito,
                    'richiesta': richiesta,
                    'evento': evento
                },
                success: function(data) {
                    console.log(data)
                    var onclick = ''
                    //console.log('onclickprima ' + onclick)
                    

                    html = '<ul class="list-unstyled">'

                    if (data.length == 0) {
                        html += '<li>' + error + '</li>'
                    }
                    
                    for (i = 0; i < data.length; i++) {


                        if (type == 'inviti') {
                            date = 'invitationDate'
                            onclick = 'acceptInvitation(' + data[i]['memberId'] + ', ' + data[i]['projectId'] +  ', \'' + data[i]['memberType'] + '\')'
                            button = '<button class="btn btn-sm btn-secondary" onclick="' + onclick + '">Accetta</button>'
                        } else if (type == 'richieste') {
                            date = 'membershipRequestDate'
                            onclick = 'acceptRequest()'
                            button = ''
                        }

                        var dataPostDay = new Date(data[i][date]).getDate() + "";
                        var dataPostMonth = new Date(data[i][date]).getMonth() + 1 + "";
                        if (dataPostDay.length == 1) dataPostDay = "0" + dataPostDay
                        if (dataPostMonth.length == 1) dataPostMonth = "0" + dataPostMonth
                        var dataPostYear = new Date(data[i][date]).getFullYear();
                        var dataPostHour = new Date(data[i][date]).getHours();
                        var dataPostMinute = new Date(data[i][date]).getMinutes();
                        var fullDate = dataPostDay + "-" + dataPostMonth + "-" + dataPostYear + " " + dataPostHour + ":" + dataPostMinute;

                        html +=     '<li>'
                        html +=         '<div class="img-wrapper">'
                        html +=             '<div class="img">'                
                        html +=             '</div>'
                        html +=         '</div>'
                        html +=         '<div class="details">'
                        html +=             '<div class="title">' + data[i]['go']['name'] + '</div>'
                        html +=             '<div class="date">' + fullDate + '</div>'
                        html +=         '</div>'
                        html +=         '<div class="btn-wrapper">'
                        html +=         button
                        html +=         '</div>'
                        html +=     '</li>'            
                        
                    }
                    
                    html += '</ul>'
                    $('#' + type).html(html)
                    
                },
                error: function(a, b, c) {
                    console.log(a)
                    console.log(b)
                    console.log(c)
                }
            })

        }


        function acceptInvitation (memberId, projectId, memberType) {

            $.ajax({
                method: 'post',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                dataType: 'json',
                url: '/projectObject/acceptInvitation',
                data: {
                    'projectId': projectId,
                    'memberId': memberId,
                    'memberType': memberType
                },
                success: function(data) {
                    
                    console.log(data)
                    location.reload()
                    
                },
                error: function(a, b, c) {
                    console.log(a)
                    console.log(b)
                    console.log(c)
                }
            })

        }


        function validateFileSize(){
            $('#errorFileSize').text("");
            var fileTag = document.getElementById('postAttachment');
            
            
            for(var i=0; i<fileTag.files.length; i++){
                var fileName = fileTag.value.split('\\')[2];
                console.log(fileName)
                $('#hiddenFileName').text(fileName)
                $('#hiddenFileName').show()
                if(fileTag.files[i].size>1048576){
                    $('#projectIMG').val('');
                    $('#errorFileSize').text("<?= __('File size is too big') ?>");
                }
            }

        }

        $('#modCreateProject').click(function(){ modCreateProject(); });


                



    </script>

    <script>
        $( function() {
        
    
            $( "#searchBoxInput" ).autocomplete({
            source: function( request, response ) {
                $.ajax( {
                url: "/projectObject/searchProject",
                dataType: "json",
                method: 'post',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                data: {
                    'term': request.term
                },
                success: function( data ) {
                    //response( data );
                    console.log('data')
                    
                    response(data)
                    
                }
                } );
            },
            minLength: 2,
            select: function( event, ui ) {
                location.href = '/projectObject/view/' + ui.item.id
                console.log(ui.item.value)
                console.log(ui.item.id)
            }
            } );
        } );
    </script>

    <script type="text/javascript">

        $(document).ready(function(){
          $('.owl-carousel').owlCarousel({
            loop:true,
            margin:30,
            responsiveClass:true,
            autoplay:false,
            autoplayHoverPause:true,
            nav:false,
            mouseDrag:false,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                576:{
                    items:2,
                    nav:true
                },                
                768:{
                    items:4,
                    nav:true
                }
            }
        })
        });

        getOwnerProjects(1);
</script>


  <!--</body>
</html>-->
