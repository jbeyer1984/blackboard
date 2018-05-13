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
            Login<br>
            <br>
            <div class="form_wrapper">
                <form method="POST" action="/blackboard.php/login/login">
                    <div class="entry">
                        <?= $arr['formData'] ?>
                        <input class="submit_entry" type="submit" name="submit_entry"/>
                    </div>
                </form>
            </div>
            <br>
            <div class="spacer"></div>
        </div>
    </div>
</body>
</html>

