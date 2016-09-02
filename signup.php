<?php
/**
 * Created by PhpStorm.
 * User: xiangang
 * Date: 16/9/1
 * Time: 下午4:29
 */
//signup.php
include 'connect.php';
include 'header.php';

echo '<h2>Sign up</h2>';
if ($_SESSION['signedIn'] == true) {
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table style="width: 35%;">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="userName"/></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="userPass"></td>
                </tr>
                <tr>
                    <td>Password again:</td>
                    <td><input type="password" name="userPassCheck"></td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="email" name="userEmail"></td>
                </tr>
            </table>
            <br/>
            <button type="submit" style="width: 100px;height: 30px;margin-left: 10%;">Sign Up</button>
        </form>
        <?php
    } else {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Process and check the data from the form
            2.  Let the user refill the wrong fields (if necessary)
            3.  Save the data
        */
        $userName = trim($_POST['userName']);
        $userPass = trim($_POST['userPass']);
        $userPassCheck = trim($_POST['userPassCheck']);
        $userEmail = trim($_POST['userEmail']);

        if (!get_magic_quotes_gpc()) {
            $userName = addslashes($userName);
            $userPass = addslashes($userPass);
            $userPassCheck = addslashes($userPassCheck);
            $userEmail = addslashes($userEmail);
        }

        $errors = array(); /* declare the array for later use */

        if ($userName != null) {
            //the user name exists
            if (!ctype_alnum($userName)) {
                $errors[] = 'The username can only contain letters and digits.';
            }
            if (strlen($userName) > 30) {
                $errors[] = 'The username cannot be longer than 30 characters.';
            }
        } else {
            $errors[] = 'The username field must not be empty.';
        }


        if ($userPass != null) {
            if ($userPass != $userPassCheck) {
                $errors[] = 'The two passwords did not match.';
            }
        } else {
            $errors[] = 'The password field cannot be empty.';
        }

        /* check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        if (!empty($errors)) {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            /* walk through the array so all the errors get displayed */
            foreach ($errors as $key => $value) {
                echo '<li>' . $value . '</li>';     /* this generates a nice error list */
            }
            echo '</ul>';
        } else {
            //the form has been posted without, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sqlInsert = "insert into users (userName,userPass,userEmail,userDate,userLevel) values 
                      ('" . $userName . "', '" . sha1($userPass) . "', '" . $userEmail . "', '"
                . date("Y-m-d H:i:s") . "', 1) ";
            $result = $db->query($sqlInsert);
            if (!$result) {
                //something went wrong, display the error
                echo 'Something went wrong while registering. Please try again later.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            } else {
                echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
            }
        }
    }
}
include 'footer.php';
?>