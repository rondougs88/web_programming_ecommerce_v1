<?php include "../admin_area/includes/db.php"; ?>
<?php $pagetitle = "Message Board"; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    global $con, $siteroot;

    $get_topic = "SELECT * FROM topics WHERE topic_id = '$id'";

    $run_q = mysqli_query($con, $get_topic);

    while ($topic = mysqli_fetch_array($run_q)) {

        $topic_subject = $topic['topic_subject'];
        // $catname = $topic['cat_name'];
        // $catdesc = $topic['cat_description'];
    }
}
?>
<?php include "../header.php"; ?>
<script>
var subject_id = '<?php echo $_GET['id'] ?>';
var userid = '<?php echo $_SESSION['user']['id']?>';
</script>

<link href="<?= $siteroot; ?>/css/forum.css" rel="stylesheet">

<?php include "../navigation.php"; ?>

<div class="container">

    <h2 style="margin-top:40px" class="text-center"><?= $topic_subject ?></h2>

    <div class="card">
        <div class="card-body">
            <?php get_subject_messages($id); ?>
            <div id="post_reply">
                <?php if (isLoggedIn()) : ?>
                    <textarea type="text" cols="100" rows="5" id="post_msg" name="post_msg" placeholder="Post a message here."></textarea>
                    <p>
                        <button type="submit" class="btn btn-primary float-left" name="post_reply_btn" id="post_reply_btn">Post Message</button>
                    </p>
                <?php else : ?>
                    <textarea disabled type="text" cols="100" rows="5" name="post_msg" placeholder="You must be logged in to post a message."></textarea>
                    <p>
                        <button disabled type="submit" class="btn btn-primary float-left" name="post_reply_btn">Post Message</button>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php include "../footer.php"; ?>

</html>