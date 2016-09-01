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

$sql = "select
            catId,
            catName,
            catDescription
        from
            categories";

$result = $db->query($sql);

if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if($result->num_rows == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>';

        while($row = $result->fetch_assoc())
        {
            echo '<tr>';
            echo '<td class="leftpart">';
            echo '<h3><a href="category.php?id">' . $row['catName'] . '</a></h3>' . $row['catDescription'];
            echo '</td>';
            echo '<td class="rightpart">';
            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
}

include 'footer.php';
?>