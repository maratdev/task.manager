<?php
session_name('session_id');
session_start();
include_once $_SERVER['DOCUMENT_ROOT']. '/include/function.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="../../styles.css" rel="stylesheet" />
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

<?php include_once $_SERVER['DOCUMENT_ROOT']. '/templates/header.php' ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">
            <h1>Возможности проекта — <? h1($menu)?></h1>
            <h2><?= page_title($menu, $sort); ?></h2>

            <?php include_once $_SERVER['DOCUMENT_ROOT']. '/templates/auth.php'; ?>
            <h2><?php if(isset($true_form_set)){ require $_SERVER['DOCUMENT_ROOT'].'/include/success.php';}
            if(isset($view)){require $_SERVER['DOCUMENT_ROOT'].'/include/error.php';}; ?> </h2>
        </td>
            <?php if($_GET['login'] == 'yes'){ include_once $_SERVER['DOCUMENT_ROOT']. '/templates/form.php';}; ?>
    </tr>
</table>
            <?php include_once $_SERVER['DOCUMENT_ROOT']. '/templates/footer.php' ?>

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