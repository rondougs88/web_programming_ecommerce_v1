<?php

function get_users() 
{
   
    global $con;

        $get_users = "SELECT * from users";

        $run_q = mysqli_query($con, $get_users);

        while ($row_user = mysqli_fetch_array($run_q)) {

            $username = $row_user['username'];
            $email = $row_user['email'];
            $user_type = $row_user['user_type'];
            $fname = $row_user['fname'];
            $lname = $row_user['lname'];

            echo "
                <tr>
                    <td>$username</td>
                    <td>$fname $lname</td>
                    <td>$email</td>
                    <td>$user_type</td>
                    
                    <td><a href='#'>Edit</a></td>
                </tr>
            ";
        }

}
