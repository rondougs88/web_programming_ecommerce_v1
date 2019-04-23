<?php include "../admin_area/includes/db.php"; ?>
<?php $pagetitle = "Create new post"; ?>

<?php include "../header.php"; ?>
<?php
if (!isset($_SESSION['user'])) {
    header("location: $siteroot/index.php");
    exit();
}
?>
<script>
    var userid = '<?php echo $_SESSION['user']['id'] ?>';
</script>
<link href="<?= $siteroot; ?>/css/forum.css" rel="stylesheet">

<?php include "../navigation.php"; ?>

<div class="container">

    <div class="text-center" style="margin-top:20px">
        <h2>Create new post</h2>
        <p class="lead">Please fill out the details below.</p>
    </div>

    <form style="margin-top:0" method="post" id="new-post-form" action="">
        <div class="form-group">
            <label for="topic">Topic</label>
            <select type="text" class="form-control" name="topic" id="topic">
                <option value="">Choose...</option>
                <?php get_select_topics(); ?>
            </select>
        </div>
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject">
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea type="text" cols="100" rows="5" id="message" name="message"></textarea>
        </div>
        <button class="btn btn-primary" name="submit-post" id="submit-post" type="submit">Submit</button>
    </form>

</div>

<?php include "../footer.php"; ?>

</html>