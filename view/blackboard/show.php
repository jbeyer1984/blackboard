<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="de">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="/public/css/blackboard.css">
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
                    <br>
                </form>
            </div>
            <br>
            <div class="spacer"></div>
            <div id="entries">
                <?php use src\App\Blackboard\Entity\EntryCollection;
                use src\Core\Utitlity\UrlHelper;

                /** @var EntryCollection $entries */
                $entries = $arr['entries'];
                foreach ($entries->getCollection() as $entry): ?>
                <div class="entry">
                    <input type="hidden" name="entry_id" value="<?= $entry->getId() ?>"/>
                    <div id="time">
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
                        <span class="name"><?= $entry->getPerson()->getName() ?></span>
                        <br>
                        Number:
                        <span class="name"><?= $entry->getPerson()->getNumber() ?></span>
                        <br>
                        Sonstiges:
                        <span class="name"><?= $entry->getPerson()->getOptional() ?></span>
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

