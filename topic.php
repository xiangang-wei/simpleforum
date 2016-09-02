<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/2
 * Time: 下午2:57
 */
include 'connect.php';
include 'header.php';

$topicIdFromGet = intval(trim($_GET['id']));
if (!get_magic_quotes_gpc()) {
    $topicIdFromGet = addslashes($topicIdFromGet);
}
$topicsSqlSelectTopics = "select topicId,topicSubject from topics where topics.topicId = " . $topicIdFromGet;
$resulttopicsSqlSelectTopics = $db->query($topicsSqlSelectTopics);
if (($resulttopicsSqlSelectTopics->num_rows) == 0) {
    echo "Sorry, there is no ralated topics!";
} else {
    $rowtopicsSqlSelectTopics = $resulttopicsSqlSelectTopics->fetch_assoc();
    echo '<table border="1">
            <th colspan="2" style="text-align: center;">' . $rowtopicsSqlSelectTopics['topicSubject'] . '</th>';
    //fetch all the posts related to the topic
    $topicSqlSelectAllPosts = "select posts.postTopic,
                                      posts.postContent,
                                      posts.postDate,
                                      posts.postBy,
                                      users.userId,
                                      users.userName
                                from
                                      posts
                                left join
                                      users
                                on
                                      posts.postBy = users.userId
                                where
                                      posts.postTopic = " . $topicIdFromGet;
    $resulttopicSqlSelectAllPosts = $db->query($topicSqlSelectAllPosts);
    if (($resulttopicSqlSelectAllPosts->num_rows) == 0) {
        echo "There is no post related to this topic!";
    } else {
        while ($rowtopicSqlSelectAllPosts = ($resulttopicSqlSelectAllPosts->fetch_assoc())) {
            echo '<tr>';
            echo '<td style="text-align: center;width: 100px;">' . $rowtopicSqlSelectAllPosts['userName'] . '<br/>'
                . $rowtopicSqlSelectAllPosts['postDate'] . '</td>';
            echo '<td>' . $rowtopicSqlSelectAllPosts['postContent'] . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';

    echo '<br/>';
    echo '<h3>Relpy:</h3>';
    echo '<br/>';
    echo '<form method="post"'.'action="reply.php?id=' . $topicIdFromGet . '">';
    echo '<textarea name="replyContent"></textarea>';
    echo '<br/>';
    echo '<button type="submit">Reply</button>';
    echo '</form>';
}
include 'footer.php';