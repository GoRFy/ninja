<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SPORT NATION</title>
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/grid.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/global.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/panel.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/button.css">
    <link rel="stylesheet" type="text/css" href="<?= WEBROOT;?>public/css/landing.css">
  </head>
  <body>

    <header class="header">
      <div class="img-header">
        <?php if (User::isConnected()): ?>
          <a href="<?= WEBROOT; ?>index/index"><img alt="Sport Nation Logo" src="<?= WEBROOT ?>public/img/logo_SNWW_light.png"></a>
        <?php else: ?>
        <img alt="Sport Nation Logo" src="<?= WEBROOT ?>public/img/logo_SNWW_light.png">
        <?php endif; ?>
      </div>
      <div class="actions">
        <?php if (!User::isConnected()): ?>
          <p>
            <a href="<?= WEBROOT ?>user/login" type="button" class="btn btn-success">Se connecter</a>
            <a href="<?= WEBROOT ?>user/subscribe" type="button" class="btn btn-success">S'inscrire</a>
          </p>
        <?php else: ?>
          <p>
            <a href="<?= WEBROOT ?>index/index" type="button" class="btn btn-success">Accueil</a>
            <a href="<?= WEBROOT ?>user/logout" type="button" class="btn btn-warning">Se déconnecter</a>
          </p>
        <?php endif; ?>
      </div>
    </header>

    <div class="block-img" style="background-image: url('<?= WEBROOT?>public/img/sports/soccer_alone.jpg')">
      <div class="slogan-box">
        <h1>Vous ne manquerez plus jamais de JOUEUR.</h1>
        <h2>Rejoignez la NATION et trouvez des matchs et des joueurs autour de vous.</h2>
        <p>
          <a href="<?= WEBROOT ?>user/subscribe" type="button" class="btn btn-success">JOUEZ MAINTENANT</a>
        </p>
      </div>
    </div>

    <div class="block-grey">
      <h2>Votre équipe est incomplète ?</h2>

      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <p>
            Vous êtes sur le point de jouer mais il vous manque un joueur ? Sport Nation vous permet de faire savoir aux joueurs autour de vous qu'il vous reste une ou plusieurs places.
          </p>
          <p>
            Deux clics et c'est parti !
          </p>
        </div>
      </div>
    </div>

    <div class="block-primary">
      <h2>Vous cherchez une équipe ?</h2>
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <p>
            Trouvez des évenements sportifs autour de vous en quelques clics ! Vous pouvez filtrer avec vos disciplines préférées ou tenter de nouvelles chose.
          </p>
          <p>
            Deux clics et c'est parti !
          </p>
        </div>
      </div>
    </div>

    <div class="block">
      <div class="article">
        <div class="article-img">
          <img src="<?= WEBROOT ?>public/img/sports/basket.jpg" alt="Basket" />
        </div>
        <div class="content">
          <h2>Ouvert à toutes et tous</h2>
          <p>
            Sport Nation ne fait pas de différences entre les sportifs. Organisez des match, des tournois, des ligues, créez et animez des communautés... Un monde de sport vous attend !
          </p>
        </div>
      </div>
      <div class="article-reverse">
        <div class="content">
          <h2>Entièrement gratuit !</h2>
          <p>
            L'application et son versant mobile (à venir) sont et seront toujours entièrement gratuites.
          </p>
        </div>
        <div class="article-img">
          <img src="<?= WEBROOT ?>public/img/sports/soccer_outdoor.jpg" alt="Soccer Outdoor" />
        </div>
      </div>
    </div>

    <div class="block-grey">
      <h2>Fabriqué en France, sans ogm.</h2>
      <p>
        Autoproclamée Team Ninja, voici l'équipe qui a réalisé ce projet :
      </p>
      <div class="teammates">
        <div class="teammate-box">
          <p>Gauthier Cornette</p>
          <div class="profile-pic-box">
            <img alt="Gauthier" src="<?= WEBROOT ?>public/img/gauthier.jpg">
          </div>
        </div>
        <div class="teammate-box">
          <p>Nicolas Cherridi</p>
          <div class="profile-pic-box">
            <img alt="Gauthier" src="<?= WEBROOT ?>public/img/nicolas.jpg">
          </div>
        </div>
        <div class="teammate-box">
          <p>Renaud Bellec</p>
          <div class="profile-pic-box">
            <img alt="Gauthier" src="<?= WEBROOT ?>public/img/renaud.jpg">
          </div>
        </div>
        <div class="teammate-box">
          <p>Romain Lambot</p>
          <div class="profile-pic-box">
            <img alt="Gauthier" src="<?= WEBROOT ?>public/img/romain.jpg">
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="copyright">
        <p>
          <div>
          <a href="<?= WEBROOT ?>landing/legals">Mentions légales</a> -
          <a href="<?= WEBROOT ?>landing/plan">Plan du site</a>
        </div>
          Copyrigth Sports Nation© | All rights reserved
        </p>
      </div>
    </footer>

  </body>
</html>
