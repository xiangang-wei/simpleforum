<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/2
 * Time: 下午4:19
 */
include 'connect.php';
include 'header.php';


//prepare the data from get
$topicIdFromGet = intval(trim($_GET['id']));
if (!get_magic_quotes_gpc()) {
    $topicIdFromGet = addslashes($topicIdFromGet);
}
//check for sign in status
if (!$_SESSION['signedIn']) {
    echo 'You must be signed in to post a reply.';
} else {
    //a real user posted a real reply
    $sqlInsertReply = "insert into posts
                          (
                            postContent,
                            postDate,
                            postTopic,
                            postBy
                          ) values ('" . $_POST['replyContent'] . "', '" . date("Y-m-d H:i:s") . "', "
        . $topicIdFromGet . ", " . intval($_SESSION['userId']) . ")";

    $resultInsertReply = $db->query($sqlInsertReply);

    if (!$resultInsertReply) {
        echo 'Your reply has not been saved, please try again later.';
    } else {
        echo 'Your reply has been saved, check out <a href="topic.php?id=' . $topicIdFromGet . '">the topic</a>.';
    }

}
include 'footer.php';

