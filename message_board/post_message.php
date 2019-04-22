<?php

// Post forum message.
if (isset($_POST['post_reply'])) {
    post_forum_message($_POST['subject_id'], $_POST['message'], $_POST['userid']);
}

// Post messages.
function post_forum_message($subject_id, $message, $userid) {
    include_once "../admin_area/includes/db.php";
    date_default_timezone_set('NZ');
    $created_on = date("Y-m-d H:i:s");

    $post_msg = "INSERT INTO `posts` (`post_content`, `post_date`, `post_topic`, `post_by`) VALUES ('$message', '$created_on', '$subject_id', '$userid')";

    $run_q = mysqli_query($con, $post_msg);

    if (empty($run_q->error)) {
        echo "Message has been successfully posted.";
    }
    else {
        echo "Cannot post message right now.";
    }
}
