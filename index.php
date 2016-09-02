<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午7:43
 */
?>
<?php
//index.php
include 'connect.php';
include 'header.php';

echo '<h2>Forum</h2>';
$sql = "select
            catId,
            catName,
            catDescription
        from
            categories";

$result = $db->query($sql);

if (!$result) {
    echo 'The categories could not be displayed, please try again later.';
} else {
    if ($result->num_rows == 0) {
        echo 'No categories defined yet.';
    } else {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="leftpart">';
            echo '<h3><a href="category.php?id='.$row['catId'].'">' . $row['catName'] . '</a></h3>' . $row['catDescription'];
            echo '</td>';
            echo '<td class="rightpart">';
            //find the latest topic in the category
            $sqlFindLatestTopic= "select topicId,topicSubject from topics where topicCat ="
                .$row['catId']." order by topicId desc";
            $resultsqlFindLatestTopic=$db->query($sqlFindLatestTopic);
            if(($resultsqlFindLatestTopic->num_rows)==0){
                echo "There is no topics in the category!";
            }else{
                $rowsqlFindLatestTopic=($resultsqlFindLatestTopic->fetch_assoc());
                echo '<a href="topic.php?id='.$rowsqlFindLatestTopic['topicId'].'">'
                    .$rowsqlFindLatestTopic['topicSubject'].'</a>';
            }

            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}

include 'footer.php';
?>
