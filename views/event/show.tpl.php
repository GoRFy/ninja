
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading"><?= $event->getName(); ?></div>
            <div class="panel-body">
                <ul class="item-list">
                    <li>
                        <h3><?= $event->getDescription(); ?></h3>
                    </li>
                    <?php
                    $dateFrom = $event->getFromDate();
                    $dateTo = $event->getToDate();
                    $dateUntil = $event->getJoignableUntil();
                    $mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
                    $dateFrom = date("d ",strtotime($dateFrom)). $mois[(date("n ",strtotime($dateFrom))- 1)]. date(" Y à H:i",strtotime($dateFrom));
                    $dateTo = date("d ",strtotime($dateTo)). $mois[(date("n ",strtotime($dateTo))- 1)]. date(" Y à H:i",strtotime($dateTo));
                    $dateUntil = date("d ",strtotime($dateUntil)). $mois[(date("n ",strtotime($dateUntil))- 1)]. date(" Y à H:i",strtotime($dateUntil));
                     ?>
                    <li>Du : <?= $dateFrom; ?></li>
                    <li>Jusqu'au : <?= $dateTo; ?></li>
                    <li>S'inscrire avant le <?= $dateUntil; ?></li>
                </ul>
                <div class="">
                    <h3>Participants :</h3>
                    <ul>
                        <?php foreach ($users as $user): ?>
                            <a href="<?= WEBROOT;?>user/show/<?= $user['id'] ?>"><?= $user["username"]; ?></a><br>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="text-right">
                    <a href="<?= WEBROOT ?>event/list" class="btn btn-primary">Revenir à la liste</a>
                </div>
            </div>
        </div>
    </div>
</div>
