<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午7:49
 */
include 'header.php';
include 'connect.php';
session_destroy();
header("location:index.php"); //to redirect back to "index.php" after logging out
exit();
