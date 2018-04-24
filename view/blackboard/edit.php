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
            <?php
            $entryId = $arr['entryFormId'];
            $entryForm = $arr['formData'];
            ?>
            Editiere den Block Eintrag.
            <span class="back_to_show spacer_horizontal"><a class="delete_entry" href="/blackboard.php/delete/<?= $entryId ?>">löschen</a></span>
            <br>
            <br>
            <div class="form_wrapper">
                <form method="POST" action="/blackboard.php/store">
                    <div class="entry">
                        <?= $entryForm ?>
                        <input class="submit_entry" type="submit" name="submit_entry"/>
                        <span class="back_to_show"><a class="edit_entry" href="/blackboard.php/show">Übersicht</a></span>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

