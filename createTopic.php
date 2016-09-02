<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午7:42
 */
include 'connect.php';
include 'header.php';

echo '<h2>Create a topic</h2>';
if ($_SESSION['signedIn'] == false) {
    //the user is not signed in
    echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.';
} else {
    //the user is signed in
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sqlSelectCat = "select
                           catId,
                           catName,
                           catDescription
                        from
                           categories";

        $resultSelectCat = $db->query($sqlSelectCat);

        if (!$resultSelectCat) {
            //the query failed, uh-oh :-(
            echo 'Error while selecting from database. Please try again later.';
        } else {
            if ($resultSelectCat->num_rows == 0) {
                //there are no categories, so a topic can't be posted
                if ($_SESSION['userLevel'] == 0) {
                    echo "There is no category, please create one!";
                } else {
                    echo "There is no category, please wait the admin to create.";
                }
            } else {
                echo '<form method="post" action="">
                        <table style="width: 35%;">
                            <tr>
                            <td>Subject:</td>
                            <td><input type="text" name="topicSubject" /></td>
                            </tr>
                            <tr>
                            <td>Category:</td>
                            <td><select name = "topicCat" >';
                while ($rowSelectCat = $resultSelectCat->fetch_assoc()) {
                    echo '<option value="' . $rowSelectCat['catId'] . '">' . $rowSelectCat['catName'] . '</option>';
                }
                echo '</select>
                            </td>
                            </tr>
                            <tr><td>Message:</td></tr>
                        </table>
                        <textarea name = "postContent" /></textarea > 
                        <br/>
                        <button type="submit" style="width: 100px;margin-left: 10%;">Add Topic</button> 
                        </from>';
            }
        }
    } else {
        //fetch data from the form
        $topicSubject = trim($_POST['topicSubject']);
        $topicCat = trim($_POST['topicCat']);
        $postContent = trim($_POST['postContent']);

        //addslashes to the data before using for sql querry
        if (!get_magic_quotes_gpc()) {
            $topicSubject = addslashes($topicSubject);
            $topicCat = addslashes($topicCat);
            $postContent = addslashes($postContent);
        }
        //the form has been posted, so save it
        //insert the topic into the topics table first, then we'll save the post into the topics table

        //set the timestamp for getting topicId later
        $timeStamp = date("Y-m-d H:i:s");
        $sqlInsertTopic = "insert into 
                        topics(topicSubject,
                               topicDate,
                               topicCat,
                               topicBy)
                    values('" . $topicSubject . "', '" . $timeStamp . "', '" . $topicCat . "', '"
            . $_SESSION['userId'] . "')";

        $resultInsertTopic = $db->query($sqlInsertTopic);
        if (!$resultInsertTopic) {
            //something went wrong, display the error
            echo 'An error occured while inserting your data. Please try again later.';
        } else {
            //the first query worked, now start the second
            //retrieve the id of the freshly created topic for usage in the posts query
            $sqlGetTopicId = "select topicId from topics where topicBy = " . $_SESSION['userId'] . " and topicDate = '"
                . $timeStamp . "' ";

            $resultGetTopicId = $db->query($sqlGetTopicId);
            if (!$resultGetTopicId) {
                echo "There is something wrong while connecting to the database,please try again.";
            } else {
                $rowsGetTopicId = $resultGetTopicId->fetch_assoc();
                $topicId = $rowsGetTopicId['topicId'];
            }
            //topicId has been gotten, insert info into posts table
            $sqlInsertPost = "insert into
                            posts(postContent,
                                  postDate,
                                  postTopic,
                                  postBy)
                        values('" . $postContent . "', '" . date("Y-m-d H:i:s") . "', " . $topicId . ", "
                . $_SESSION['userId'] . ")";
            $resultInsertPost = $db->query($sqlInsertPost);

            if (!$resultInsertPost) {
                //something went wrong, display the error
                echo 'An error occured while inserting your post. Please try again later.';
            } else {
                //after a lot of work, the query succeeded!
                echo 'You have successfully created <a href="topic.php?id=' . $topicId . '">your new topic</a>.';
            }
        }
    }
}
include 'footer.php';
?>