<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午4:30
 */
//create_cat.php
include 'connect.php';
include 'header.php';
if(!$_SESSION['signedIn']){
    echo 'You have not sign in, please <a href="signin.php">sign in';
}else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        //the form hasn't been posted yet, display it
        ?>
        <br/>
        <h3>Create Category!</h3><br/>
        <form method="post" action="">
            <table style="width: 35%;">
                <tr>
                    <td>Category name:</td>
                    <td><input type="text" name="catName"/></td>
                </tr>
                <tr>
                    <td>Category description:</td>
                </tr>
            </table>
            <textarea name="catDescription"/></textarea>
            <br/>
            <button type="submit" style="width: 100px;margin-left: 10%;">Add a Category</button>
        </form>
        <?php
    } else {
        $catName = trim($_POST['catName']);
        $catDescription = trim($_POST['catDescription']);

        if (!get_magic_quotes_gpc()) {
            $catName = addslashes($catName);
            $catDescription = addslashes($catDescription);
        }
        //the form has been posted, so save it
        $sql = "insert into categories(catName, catDescription) values
          ('" . $catName . "', '" . $catDescription . "' )";
        $result = $db->query($sql);
        if (!$result) {
            //something went wrong, display the error
            echo 'Error';
        } else {
            echo 'New category successfully added . ';
        }
    }
}
include 'footer.php';
?>