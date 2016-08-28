<!DOCTYPE html>
<html>
<head>
    <title>SPORT NATION | WORLD WIDE</title>
    <meta charset="UTF-8">
    <?php if(isset($feed)): ?>
    <link rel='alternate' href="<?= WEBROOT; ?>rss/feeds/" title="My RSS" type="application/rss+xml">
    <?php endif; ?>
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/grid.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/global.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/panel.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/button.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/landing.css">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'> -->

    <!-- scripts -->
    <script type="text/javascript"> var webrootJs = "<?= WEBROOT; ?>"; var gblCurrentUserId = "<?= $_SESSION['user_id']; ?>";</script>
    <!--<script type="text/javascript" src="<?= WEBROOT;?>public/bower_components/jquery/dist/jquery.min.js"></script>-->
    <script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= WEBROOT;?>public/js/all.js"></script>
</head>

<body>
  <?php if(User::isConnected()): ?>
    <header>
      <div class="dropdown header-burger icon">
          <span class="icon-menu fa fa-bars"></span>
          <ul class="dropdown-menu right">
              <?php if(User::isAdmin()):  ?>
                  <li><a href="<?= WEBROOT;?>admin/global">Admin</a></li>
              <?php endif; ?>
              <li><a href="<?= WEBROOT;?>landing/legals">Mentions légales</a></li>
              <li><a href="<?= WEBROOT; ?>landing/plan">Plan du site</a></li>
              <?php if(User::isConnected()):  ?>
                  <li><a href="<?= WEBROOT;?>user/logout">Se déconnecter</a></li>
              <?php endif; ?>
          </ul>
      </div>
        <a style="float:left" href="<?= WEBROOT; ?>"><img src="<?= WEBROOT;?>public/img/logo_SNWW_light.png" alt="Play Now" class="app-logo" height="80px"></a>
        <?php if(User::isConnected()):?>
        <div class="item dropdown header-burger icon" id="popin-notifications">
            <?php if (User::hasNotif() == 0): ?>
             <span class="icon-menu fa fa-bell-o" id="notification-icon"></span>
           <?php else: ?>
             <span class="icon-menu fa fa-bell-o" style="color:red" id="notification-icon"></span><span style="color:red;font-size:12px;bottom:0;position:absolute;right:0"><?= User::hasNotif(); ?></span>
           <?php endif; ?>
       </div>
        <div class="item dropdown header-burger icon">
            <a href="<?= WEBROOT; ?>user/show/<?php if(isset($_SESSION["user_id"])){ echo $_SESSION["user_id"]; } ?>" class="item">
                <span class="fa fa-user"></span>
            </a>
       </div>
     <?php endif; ?>
     <div class="icon2">
         <?php if (User::isConnected()): ?>
           <?php
             if($_SESSION['controller'] == "index"){
               $informationHeader = "Bonjour ".$_SESSION["username"];
             }else if($_SESSION['controller'] == "team"){
               $informationHeader = "Equipe";
             }else if($_SESSION['controller'] == "user"){
               $informationHeader = "Utilisateur";
             }else if($_SESSION['controller'] == "event"){
               $informationHeader = "Evenement";
             }else if($_SESSION['controller'] == "contact"){
               $informationHeader = "Contact";
             }else{
               $informationHeader ="";
             }
           ?>
             <span ><?= $informationHeader; ?></span>
         <?php endif; ?>
     </div>
    </header>
  <?php else: ?>
    <header class="header">
      <div class="img-header">
        <a href="<?= WEBROOT; ?>" ><img alt="Sport Nation Logo" src="<?= WEBROOT ?>public/img/logo_SNWW_light.png">
      </div>
      <div class="actions">
        <?php if (!User::isConnected()): ?>
          <p>
            <a href="<?= WEBROOT ?>user/login" type="button" class="btn btn-success">Se connecter</a>
            <a href="<?= WEBROOT ?>user/subscribe" type="button" class="btn btn-success">S'inscrire</a>
          </p>
        <?php endif; ?>
      </div>
    </header>
  <?php endif; ?>
    <div class="app-content">
        <?php if (User::isConnected()): ?>
          <div class="sidebar">
            <div class="items-up items">
              <a href="<?= WEBROOT; ?>landing/welcome" class="item">
                <span class="fa fa-question-circle-o hoverWelcome"></span>
              </a>
              <a href="<?= WEBROOT; ?>user/list/" class="item">
                <span class="fa fa-book hoverUsers" ></span>
              </a>
              <a href="<?= WEBROOT; ?>team/list" class="item">
                <span class="fa fa-users hoverTeams"></span>
              </a>
              <a href="<?= WEBROOT; ?>event/list" class="item">
                <span class="fa fa-calendar-check-o hoverEvents"></span>
              </a>
              <a href="<?= WEBROOT; ?>contact/create" class="item">
                <span class="fa fa-at hoverContact"></span>
              </a>
            </div>
            <p id="hoverWelcome" style="display:none;position:absolute;left:50px;top:1px;width:90px;font-size:14px;padding-left:10px;padding-top:5px;background-color:#6C6599;height:45px;color:white">Que faisons-nous ?</p>
            <p id="hoverUsers" style="display:none;position:absolute;left:50px;top:66px;width:90px;font-size:14px;padding-left:10px;padding-top:5px;background-color:#6C6599;height:45px;color:white">Annuaire d'utilisateurs</p>
            <p id="hoverTeams" style="display:none;position:absolute;left:50px;top:131px;width:90px;font-size:14px;padding-left:10px;padding-top:5px;background-color:#6C6599;height:45px;color:white">Annuaire d'équipes</p>
            <p id="hoverEvents" style="display:none;position:absolute;left:50px;top:196px;width:90px;font-size:14px;padding-left:10px;padding-top:5px;background-color:#6C6599;height:45px;color:white">Annuaire d'évènements</p>
            <p id="hoverContact" style="display:none;position:absolute;left:50px;top:261px;width:90px;font-size:14px;padding-left:10px;padding-top:5px;background-color:#6C6599;height:45px;color:white">Nous contacter</p>

            <div class="items-down items">

            </div>
          </div>
        <?php endif; ?>
        <div class="grid-container">
            <div class="msg-box">
                <p class="text">
                    <span class="text-content"></span>
                    <span class="fa fa-times js-close-msg-box"></span>
                </p>
            </div>
            <div class="grid-content">
                <?php include $this->view; ?>
            </div>
        </div> <!-- END GRID CONTAINER -->
    </div>


</body>


</html>
