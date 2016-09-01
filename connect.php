<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午4:16
 */
define("LOCALHOST", "127.0.0.1");
define("USERNAME", "root");
define("PASSWORD", "wxg/*945518");
define("DATABASE", "forum");
@ $db = new mysqli(LOCALHOST, USERNAME, PASSWORD, DATABASE);

if (mysqli_connect_errno()) {
    echo "can't connect to the database,please try again!";
    exit;
}