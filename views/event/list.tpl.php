<script type="text/javascript"> var page = "event";</script>
<script type="text/javascript"> var sessionId = <?= $_SESSION["user_id"] ;?></script>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Manage events</div>
            <div class="panel-body">
                <a class="btn btn-success" href="<?= WEBROOT ?>event/create">Create Event</a>
            </div>
        </div>

        <div align="center">
            <h3 class="center header-li ">Or find one :</h3>
            <input type="text" id="search-content">
            <select id="select-criteria">
                <option value="1" selected>By name</option>
                <option value="2">By owner</option>
                <option value="3">By tag</option>
            </select>
        </div>
        <div id="search-content-results"></div>

    <div class="col-sm-12" id="all-content">
          <?php foreach ($events as $key => $event): ?>
              <?php if (new Datetime($event->getToDate()) > new Datetime()): ?>
                  <div class="panel panel-success">
                      <div class="panel-heading"><?= $event->getName(); ?></div>
                      <div class="panel-body">
                          <p class="underlined">Owner : <?= $event->getOwnerName(); ?></p>
                          <div class="row">
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
                              <li>From : <?= $event->getFromDate(); ?></li>
                              <li>To : <?= $event->getToDate(); ?></li>
                              <li>Joignable until <?= $event->getJoignableUntil(); ?></li>
                          </ul>
                          <p>People : </p>
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
                          <a href="<?= WEBROOT;?>event/show/<?= $event->getId() ?>" class="btn btn-success pull-right">Details</a>
                      </div>
                  </div>
              <?php endif; ?>
            <?php endforeach; ?>
    </div>
</div>
