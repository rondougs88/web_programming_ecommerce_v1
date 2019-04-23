<?php

// Post forum message.
if (isset($_POST['post_reply'])) {
    post_forum_message($_POST['subject_id'], $_POST['message'], $_POST['userid']);
}

// Create new post
if (isset($_POST['new_post'])) {
    create_new_post($_POST['topic'], $_POST['subject'], $_POST['message'], $_POST['userid']);
}

// Delete post
if (isset($_POST['del_post'])) {
    delete_post($_POST['post_id']);
}

// Delete subject
if (isset($_POST['del_subj'])) {
    delete_subject($_POST['subj_id']);
}

// Create new topic
if (isset($_POST['new_topic'])) {
    create_new_topic($_POST['topic_name'], $_POST['topic_desc']);
}

// Edit topic
if (isset($_POST['ch_topic'])) {
    change_topic($_POST['topic_name'], $_POST['topic_desc'], $_POST['topic_id']);
}

// Get details
if (isset($_POST['get_topic_det'])) {
    get_topic_details($_POST['topic_id']);
}

// Edit topic
function change_topic($topic_name, $topic_desc, $topic_id)
{
    include_once "../admin_area/includes/db.php";
    $new_topic = "UPDATE forum_categories SET cat_name = '$topic_name', cat_description = '$topic_desc' WHERE cat_id = '$topic_id'";
    $run_q = mysqli_query($con, $new_topic);
    if (empty($run_q->error)) {
        echo "Topic has been updated.";
    } else {
        echo "Topic cannot be updated.";
    }
}

// Create new topic
function create_new_topic($topic_name, $topic_desc)
{
    include_once "../admin_area/includes/db.php";
    $new_topic = "INSERT INTO forum_categories (cat_name, cat_description) VALUES ('$topic_name','$topic_desc')";
    $run_q = mysqli_query($con, $new_topic);
    if (empty($run_q->error)) {
        echo "New topic has been posted in the forum.";
    } else {
        echo "New topic cannot be posted in the forum.";
    }
}

// Delete post
function delete_post($post_id)
{
    include_once "../admin_area/includes/db.php";
    $del_post = "DELETE FROM posts WHERE post_id = '$post_id'";
    mysqli_query($con, $del_post);

    if ($con->error) {
        echo "Error deleting post.";
    } else {
        echo "Successfully deleted post.";
    }
}

// Get details
function get_topic_details($topic_id) {
    include_once "../admin_area/includes/db.php";
    $get_topic = "SELECT * FROM forum_categories WHERE cat_id = '$topic_id'";
    $run_q = mysqli_query($con, $get_topic);

    while ($row = mysqli_fetch_array($run_q)) {
        $topic_name = $row['cat_name'];
        $topic_description = $row['cat_description'];
        echo json_encode($row);
        // echo "{"name":" $topic_name, description: $topic_description}";
    }
}

// Delete subject
function delete_subject($subj_id)
{
    include_once "../admin_area/includes/db.php";
    $del_subj = "DELETE FROM topics WHERE topic_id = '$subj_id'";
    mysqli_query($con, $del_subj);

    if ($con->error) {
        echo "Error deleting subject.";
    } else {
        echo "Successfully deleted subject.";
    }
}

// create new post
function create_new_post($topic, $subject, $message, $userid)
{
    include_once "../admin_area/includes/db.php";
    date_default_timezone_set('NZ');
    $created_on = date("Y-m-d H:i:s");

    mysqli_real_escape_string($con, $topic);
    mysqli_real_escape_string($con, $subject);
    mysqli_real_escape_string($con, $message);

    // Check first if subject already exists
    $get_subj = "SELECT * FROM topics WHERE topic_subject = '$subject' AND topic_cat = '$topic'";
    $run_q = mysqli_query($con, $get_subj);

    if ($run_q->num_rows > 0) { //Entry alrady exists
        while ($row = mysqli_fetch_array($run_q)) {
            $subject_id = $row['topic_id'];
        }
    } else { // We need to create a new subject
        $new_subj = "INSERT INTO topics (topic_subject, topic_date, topic_cat, topic_by) VALUES ('$subject','$created_on','$topic','$userid')";
        // global $con;
        $run_q2 = mysqli_query($con, $new_subj);
        $subject_id = $con->insert_id;
    }

    // Create entry for the post message itself.
    $new_post = "INSERT INTO posts (post_content, post_date, post_topic, post_by) VALUES ('$message','$created_on','$subject_id','$userid')";
    $run_q3 = mysqli_query($con, $new_post);
    if (empty($run_q3->error)) {
        echo "New message has been posted in the forum.";
    } else {
        echo "New message cannot be posted in the forum.";
    }
}

// Post messages.
function post_forum_message($subject_id, $message, $userid)
{
    include_once "../admin_area/includes/db.php";
    date_default_timezone_set('NZ');
    $created_on = date("Y-m-d H:i:s");

    $post_msg = "INSERT INTO `posts` (`post_content`, `post_date`, `post_topic`, `post_by`) VALUES ('$message', '$created_on', '$subject_id', '$userid')";

    $run_q = mysqli_query($con, $post_msg);

    if (empty($run_q->error)) {
        echo "Message has been successfully posted.";
    } else {
        echo "Cannot post message right now.";
    }
}
