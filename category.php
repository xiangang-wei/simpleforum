<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/2
 * Time: 下午2:08
 */
include 'connect.php';
include 'header.php';

//set the id for query
$catIdFromGet = trim($_GET['id']);
$catIdFromGet = intval($catIdFromGet);
if (!get_magic_quotes_gpc()) {
    $catIdFromGet = addslashes($catIdFromGet);
}
//first select the category based on $_GET['catId']
$sqlSelectCategoryForDisplay = "select
            catId,
            catName,
            catDescription
        from
            categories
        where
            catId = " . $catIdFromGet;

$resultSelectCategoryForDisplay = $db->query($sqlSelectCategoryForDisplay);

if (!$resultSelectCategoryForDisplay) {
    echo 'The category could not be displayed, please try again later.';
} else {
    if (($resultSelectCategoryForDisplay->num_rows) == 0) {
        echo 'This category does not exist.';
    } else {
        //display category data
        while ($rowSelectCategoryForDisplay = ($resultSelectCategoryForDisplay->fetch_assoc())) {
            echo '<h2>Topics in ' . $rowSelectCategoryForDisplay['catName'] . ' category</h2>';
        }

        //select all the topics of the category
        $sqlSelectTopicForDisplay = "select  
                    topicId,
                    topicSubject,
                    topicDate,
                    topicCat
                from
                    topics
                where
                    topicCat = " . $catIdFromGet;

        $resultSelectTopicForDisplay = $db->query($sqlSelectTopicForDisplay);

        if (!$resultSelectTopicForDisplay) {
            echo 'The topics could not be displayed, please try again later.';
        } else {
            if (($resultSelectTopicForDisplay->num_rows) == 0) {
                echo 'There are no topics in this category yet.';
            } else {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th>Topic</th>
                        <th>Created at</th>
                      </tr>';

                while ($rowSelectTopicForDisplay = ($resultSelectTopicForDisplay->fetch_assoc())) {
                    echo '<tr>';
                    echo '<td class="leftpart" style="width: auto;">';
                    echo '<h3><a href="topic.php?id=' . $rowSelectTopicForDisplay['topicId'] . '">'
                        . $rowSelectTopicForDisplay['topicSubject'] . '</a><h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y', strtotime($rowSelectTopicForDisplay['topicDate']));
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }
    }
}

include 'footer.php';

