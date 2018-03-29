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
            <?php use src\App\Blackboard\Form\EntryForm;

            /** @var EntryForm $entryForm */
            $entryForm = $arr['formData'];
            ?>
            Editiere den Block Eintrag.
            <span class="back_to_show spacer_horizontal"><a class="delete_entry" href="/blackboard.php/delete/<?= $entryForm->getId() ?>">löschen</a></span>
            <br>
            <br>
            <div class="form_wrapper">
                <form method="POST" action="/blackboard.php/store">
                    <div class="entry">
                        
                        <input type="hidden" name="id" value="<?= $entryForm->getId() ?>" />
                        <div id="time">
                            <span><?= $entryForm->getTime() ?></span>
                        </div>
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
                            $checkBoxOn = $danceForm->getDanceType()->getValue();
                            ?>
                            <span class="dance_type">
                                <label><?= $type ?></label>
                                <input type="hidden" name="dance[<?= $typeIdentifier ?>][dance]" value="<?= $type ?>"/>
                                <?php if (!$checkBoxOn): ?>
                                    <input type="checkbox" name="dance[<?= $typeIdentifier ?>][type]"/>
                                <?php else: ?>
                                    <input checked="1" type="checkbox" name="dance[<?= $typeIdentifier ?>][type]"/>
                                <?php endif ?>
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
                            </br>
                            <?php endforeach ?>
                        </div>
                        <input class="submit_entry" type="submit" name="submit_entry"/>
                        <span class="back_to_show"><a class="edit_entry" href="/blackboard.php/show">Übersicht</a></span>
                    </div>
                    </br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

