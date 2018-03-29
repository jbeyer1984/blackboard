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
                        <?php use src\App\Blackboard\Form\EntryForm;

                        /** @var EntryForm $entryForm */
                        $entryForm = $arr['formData'];
                        ?>
                        <div id="form_personal">
                            <?php 
                            $labelIdentifier = $entryForm->getPersonal()->getLabel();
                            $typeIdentifier  = $entryForm->getPersonal()->getIdentifier();
                            $personalName    = $entryForm->getPersonal()->getValue();
                            ?>
                            <label><?= $labelIdentifier ?></label>
                            <?php if (empty($personalName)): ?>
                                <input type="text" name="personal[<?= $typeIdentifier ?>]" value=""/>
                            <?php else: ?>
                                <input type="text" name="personal[<?= $typeIdentifier ?>]" value="<?= $personalName ?>"/>
                            <?php endif ?>
                        </div>
                        <div id="form_dance">
                            <?php foreach ($entryForm->getDanceFormCollection()->getDanceFormArray() as $danceForm): ?>
                            <?php
                            $type = $danceForm->getDanceType()->getLabel();
                            $typeIdentifier = $danceForm->getDanceType()->getIdentifier();
                            ?>
                            <span class="dance_type">
                                <label><?= $type ?></label>
                                <input type="hidden" name="dance[<?= $typeIdentifier ?>][dance]" value="<?= $type ?>"/>
                                <input type="checkbox" name="dance[<?= $typeIdentifier ?>][type]"/>
                            </span>
                            <span class="dance_experience">
                                
                                <label><?= $danceForm->getDance()->getLabel() ?></label>
                                <select name="dance[<?= $typeIdentifier ?>][experience]">
                                    <?php foreach ($danceForm->getDance()->getOptionCollection()->getOptionsArray() as $index => $option): ?>
                                        <?php if (!$option->isOn()): ?>
                                            <option name="dance[<?= $typeIdentifier ?>][experience][<?= $index ?>]"><?= $option->getValue() ?></option>
                                        <?php else: ?>
                                            <option selected="on" name="dance[<?= $typeIdentifier ?>][experience][<?= $index ?>]"><?= $option->getValue() ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </span>
                            <br>
                            <?php endforeach ?>
                        </div>
                        <input class="submit_entry" type="submit" name="submit_entry"/>
                    </div>
                    <br>
                </form>
            </div>
            <br>
            <div class="spacer"></div>
            <div id="entries">
                <?php use src\App\Blackboard\Entity\EntryCollection;
                /** @var EntryCollection $entries */
                $entries = $arr['entries'];
                foreach ($entries->getEntryArray() as $entry):
                ?>
                <div class="entry">
                    <input type="hidden" name="entry_id" value="<?= $entry->getId() ?>"/>
                    <div id="time">
                        <span><?= $entry->getTime() ?></span>
                        <span><a class="edit_entry" href="/blackboard.php/edit/<?= $entry->getId() ?>">edit</a></span>
                    </div>
                    <div id="person">
                        Person:
                        <span class="name"><?= $entry->getPersonal()->getName() ?></span>
                    </div>
                    <div id="dance">
                        <?php foreach ($entry->getDanceCollection()->getDanceArray() as $dance): ?>
                            <span class="dance_type"><?= $dance->getDance() ?></span>
                            , <span class="dance_experience"><?= $dance->getExperience() ?></span>
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

