<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午4:03
 */
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="personal exercise"/>
    <meta name="keywords" content="example"/>
    <title>PHP-MySQL forum</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>My forum</h1>
<div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Home</a>
        <?php
        if ($_SESSION['signedIn']) {
            echo ' - <a class="item" href="createTopic.php">Create a topic</a>';
            if ($_SESSION['userLevel'] == 0) {
                echo ' - <a class="item" href="createCat.php">Create a category</a> ';
            }
        }
        ?>


        <div id="userbar">
            <?php
            if ($_SESSION['signedIn']) {
                echo 'Hello, ' . $_SESSION['userName'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                    <a class="item" href="signout.php">Sign Out</a>';
            } else {
                echo '<a class="item" href="signin.php">Sign in</a> or
                      <a class="item" href="signup.php">Sign up</a>';
            }
            ?>
        </div>
    </div>
    <div id="content">