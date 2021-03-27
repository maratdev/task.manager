<?php
session_name('session_id');
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/include/function.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/login_form.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="/styles.css" rel="stylesheet" />
    <title>Project - ведение списков</title>
    <style>
        .hidden{
            display: none;
        };
        .visible{

        }
    </style>
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'].'/templates/header.php' ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">
            <h1>Возможности проекта — <?=isCurrentUrl($_SERVER['REQUEST_URI'], $menu)?></h1>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/templates/auth.php'; ?>
            <h2><?php if(isset($true_form_set)){ include $_SERVER['DOCUMENT_ROOT'].'/posts/success.php';}
            if(isset($view)){include $_SERVER['DOCUMENT_ROOT'].'/include/error.php';} ?> </h2>
        </td>
            <?php if($_GET['login'] == 'yes'){ include $_SERVER['DOCUMENT_ROOT'].'/templates/form.php';} ?>
    </tr>
</table>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/templates/footer.php' ?>

<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" project-folders-v-active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " project-folders-v-active";
    }
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>
</body>
</html>