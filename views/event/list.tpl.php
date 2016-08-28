<script type="text/javascript"> var page = "event";</script>
<script type="text/javascript"> var sessionId = <?= $_SESSION["user_id"] ;?></script>

<div class="row">
        <p align="center"><a href="<?= WEBROOT;?>event/create"class="btn btn-primary">Créer le tien dès maintenant !</a></p>
        <div align="center">
            <h3 class="center header-li ">Ou trouves en un :</h3>
            <input type="text" id="search-content">
        </div>
        <div id="search-content-results"></div>

    <div class="col-sm-12" id="all-content">
          <?php foreach ($events as $key => $event): ?>
              <?php if (new Datetime($event->getToDate()) > new Datetime()): ?>
                <div class="col-sm-6">
                  <div class="panel panel-primary">
                      <div class="panel-heading"><?= $event->getName(); ?></div>
                      <div class="panel-body">
                          <div class="underlined" style="padding-bottom:20px">Crée par <a href="<?= WEBROOT?>user/show/<?= $event->getOwner()?>"><?= $event->getOwnerName(); ?></a>
                            <div class="vote_area<?= $event->getId()?> pull-right" >
                              <i href="#" data-url="event/like" aria-hidden="true" data-event="<?= $event->getId(); ?>" data-upordown="1" class="icons-primary3 btn-success fa fa-arrow-down fa-thumbs-o-up ajax-link" ></i>&nbsp;
                              <span id="compteurLike"><?= EventHasVote::getAllVotes($event->getId()) ?></span>
                              <i href="#" data-url="event/like" aria-hidden="true" data-event="<?= $event->getId(); ?>" data-upordown="0"class="icons-primary3 btn-danger fa fa-arrow-down fa-thumbs-o-down ajax-link" ></i>&nbsp;
                            </div>
                          </div>
                          <div class="row" style="padding-top:14px">
                              <div class="col-sm-6">
                                  <div class="tag-box">
                                      <?php foreach (explode(",", $event->getTags()) as $key => $tag): ?>
                                          <a href="#"><?= $tag ?></a>
                                      <?php endforeach; ?>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <?= $event->getDescription(); ?>
                              </div>
                          </div>
                          <ul class="item-list">
                              <li>Du <?= $event->getFromDate(); ?>
                               - au <?= $event->getToDate(); ?></li>
                              <li>Inscription ouverte jusqu'au <?= $event->getJoignableUntil(); ?></li>
                          </ul>
                          <p>Membres : </p>
                          <ul class="item-list">
                              <?php foreach ($event->gatherUsers() as $key => $user): ?>
                                  <li><?= $user["username"] ?></li>
                              <?php endforeach; ?>
                          </ul>
                      </div>
                      <div class="panel-footer">
                          <?php if (in_array($_SESSION["user_id"], $event->getUsersId()) && $event->getOwner() != $_SESSION["user_id"]): ?>
                              <a href="<?= WEBROOT; ?>event/leave/<?= $event->getId();?>/<?= $_SESSION['user_id']?>" class="btn btn-danger">Leave</a>
                          <?php elseif (!in_array($_SESSION["user_id"], $event->getUsersId())): ?>
                              <a href="<?= WEBROOT; ?>event/join/<?= $event->getId();?>" class="btn btn-success">Join</a>
                          <?php endif; ?>
                          <?php if ($event->getOwner() == $_SESSION["user_id"]): ?>
                              <a href="<?= WEBROOT; ?>event/update/<?= $event->getId() ?>" class="btn btn-primary">Manage</a>
                          <?php endif; ?>

                          <a href="<?= WEBROOT;?>event/show/<?= $event->getId() ?>" class="btn btn-primary pull-right">Details</a>
                      </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
    </div>
</div>
