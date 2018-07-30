<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="de">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="/public/css/blackboard.css">
    <script src="/public/js/lib/jquery-1.11.3.js"></script>
    <script type="application/javascript" src="/public/js/a_load/a_load.js"></script>
<!--    <script src="/public/js/a_load/project.js"></script>-->
<!--    <script src="/public/js/main.js"></script>-->
</head>
<body>
    <div id="page_wrapper">
        <div id="page_content">
            Füge einen neuen Block Eintrag hinzu.<br>
            <br>
            <div class="form_wrapper">
                <form method="POST" action="/blackboard.php/add">
                    <div class="entry">
                        <?= $arr['formData'] ?>
                        <input class="submit_entry" type="submit" name="submit_entry"/>
                    </div>
                    <br/>
                </form>
            </div>
            <div class="spacer"></div>
            <div id="search" class="extract">
                <input class="reset_button" type="button" value="reset search"/>
                <div class="spacer small"></div>
                <div class="dance_type left spacer_horizontal">
                <?php
                    use src\App\Blackboard\Entity\DanceEntityCollection;
                    $danceCollection = $arr['danceEntityCollection'];
                    /** @var DanceEntityCollection $danceCollection */
                ?>
                <?php foreach ($danceCollection->getCollection() as $danceEntity): ?>
                    <input type="checkbox" value="<?= $danceEntity->getName()?>" />
                    <label><?= $danceEntity->getName()?></label>
                    <br/>
                <?php endforeach ?>
                    <div class="spacer small"></div>
                    <input class="search_button" type="button" value="search"/>
                </div>
               
                <div class="search_type left">
                    <label>number:</label>
                    <input class="search_text" type="text" value="0406474756"/>
                    <div class="spacer small"></div>
                    <input class="search_button" type="button" value="search"/>
                </div>
            </div>
            <div class="spacer"></div>
            <div id="entries">
                <?php use src\App\Blackboard\Entity\EntryCollection;
                use src\Core\Utitlity\UrlHelper;

                /** @var EntryCollection $entries */
                $entries = $arr['entries'];
                foreach ($entries->getCollection() as $entry): ?>
                <div class="entry">
                    <input type="hidden" name="entry_id" value="<?= $entry->getId() ?>"/>
                    <div class="time">
                        <span><?= $entry->getTime() ?></span>
                        <?php
                        $editUrl = UrlHelper::getCreatedUrl(
                            '/blackboard.php/edit',
                             ['id' => $entry->getId()]
                        );
                        ?>
                        <span><a class="edit_entry" href="<?= $editUrl ?>">edit</a></span>
                    </div>
                    <div id="person">
                        Person:
                        <span class="name_type"><?= $entry->getPerson()->getName() ?></span>
                        <br>
                        Number:
                        <span class="number_type"><?= $entry->getPerson()->getNumber() ?></span>
                        <br>
                        Sonstiges:
                        <span class="optional_type"><?= $entry->getPerson()->getOptional() ?></span>
                    </div>
                    <div id="dance">
                        <?php foreach ($entry->getDanceCollection()->getCollection() as $dance): ?>
                            <span class="dance_type"><?= $dance->getName() ?></span>
                            <?php foreach ($dance->getExperienceEntityCollection()->getCollection() as $experience): ?>
                            , <span class="dance_experience"><?= $experience->getName() ?></span>
                            <?php endforeach ?>
                        <br>
                        <?php endforeach ?>
                    </div>
                </div>
                <div id="separator_line"></div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</body>
</html>

