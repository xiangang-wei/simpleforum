<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午6:59
 */
//signin.php
include 'connect.php';
include 'header.php';

echo '<h3>Sign in</h3>';

//first, check if the user is already signed in. If that is the case, there is no need to display this page
if ($_SESSION['signedIn'] == true) {
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
} else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */ ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table style="width: 35%;">
                <tr>
                    <td> Username:</td>
                    <td><input type="text" name="userName"/></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="userPass"></td>
                </tr>
            </table>
            <br/>
            <button type="submit" style="width: 100px;height: 30px;margin-left: 10%;">Sign in</button>
        </form> <?php
    } else {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */

        $userName = trim($_POST['userName']);
        $userPass = trim($_POST['userPass']);
        if (!get_magic_quotes_gpc()) {
            $userName = addslashes($userName);
            $userPass = addslashes($userPass);
        }
        $errors = array(); /* declare the array for later use */

        if ($userName == null) {
            $errors[] = 'The username field must not be empty.';
        }

        if ($userPass == null) {
            $errors[] = 'The password field must not be empty.';
        }
        /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        if (!empty($errors)) {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            /* walk through the array so all the errors get displayed */
            foreach ($errors as $key => $value) {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        } else {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sql = "select userId, userName, userLevel from users
                    where userName = '" . $userName . "' and
                    userPass = '" . sha1($userPass) . "'";

            $result = $db->query($sql);
            if (!$result) {
                //something went wrong, display the error
                echo 'Something went wrong while signing in. Please try again later.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            } else {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if ($result->num_rows == 0) {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                } else {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signedIn'] = true;

                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    $row = $result->fetch_assoc();
                    $_SESSION['userId'] = $row['userId'];
                    $_SESSION['userName'] = $row['userName'];
                    $_SESSION['userLevel'] = $row['userLevel'];

                    echo 'Welcome, ' . $_SESSION['userName']
                        . '. <a href="index.php">Proceed to the forum overview</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>