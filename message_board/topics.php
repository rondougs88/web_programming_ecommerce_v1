<?php include "../admin_area/includes/db.php"; ?>
<?php $pagetitle = "Message Board"; ?>
<?php include "../header.php"; ?>
<script>
    var isLoggedIn = '<?= isLoggedIn() ?>';
    var topic_id = '';
</script>
<link href="<?= $siteroot; ?>/css/forum.css" rel="stylesheet">

<?php include "../navigation.php"; ?>

<div class="container">
    <div class="row" style="margin-top:40px">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="ibox-content m-b-sm border-bottom">
                    <div class="p-xs">
                        <span>
                            <button class="btn btn-primary float-right create_post_btn" name="create_post_btn">Create a new post</button>
                        </span>
                        <div class="pull-left m-r-md">
                            <i class="fa fa-globe text-navy mid-icon"></i>
                        </div>
                        <h2>Welcome to our message board</h2>
                        <span>Feel free to choose topic you're interested in.</span>
                    </div>
                </div>

                <div class="ibox-content forum-container">
                    <?php get_forum_topics(); ?>
                </div>
                <?php if (isAdmin()) : ?>
                    <div class="row">
                        <div class="col-lg-6 col-mb-3">
                            <form style="margin-top:0px; width:100%" method="post" id="new_topic_form">
                                <h2>Create new topic</h2>
                                <p><small>(Only visible to admins.)</small></p>
                                <div class="form-group">
                                    <input type="text" id="new_topic" name="new_topic" placeholder="New Topic Name">
                                </div>
                                <div class="form-group">
                                    <textarea type="text" cols="100" rows="5" id="topic_desc" name="topic_desc" placeholder="Topic Description"></textarea>
                                </div>
                                <p style="margin-bottom:60px">
                                    <button type="submit" class="btn btn-primary float-left" name="new_topic_btn" id="new_topic_btn">Create</button>
                                </p>
                            </form>
                        </div>
                        <div class="col-lg-6 col-mb-3">
                            <form style="margin-top:0px; width:100%" method="post" id="edit_topic_form">
                                <h2>Edit/Delete existing topic</h2>
                                <p><small>(Only visible to admins.)</small></p>
                                <div class="form-group">
                                    <select class="form-control" type="text" id="existing_topic" name="existing_topic">
                                        <option value="">Select existing topic name</option>
                                        <?php
                                        $select_topics = "SELECT * FROM forum_categories";
                                        $run_q = mysqli_query($con, $select_topics);
                                        while ($row = mysqli_fetch_array($run_q)) {
                                            $topic_id = $row['cat_id'];
                                            $topic_name = $row['cat_name'];
                                            $topic_desc = $row['cat_description'];

                                            echo "
                                            <option value='$topic_id'>$topic_name</option>
                                            ";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="text" id="ch_topic_name" name="ch_topic_name" placeholder="New Topic Name">
                                </div>
                                <div class="form-group">
                                    <textarea type="text" cols="100" rows="5" id="ch_topic_desc" name="ch_topic_desc" placeholder="Topic Description"></textarea>
                                </div>
                                <p style="margin-bottom:60px">
                                    <button type="submit" class="btn btn-primary float-left" name="ch_topic_btn" id="ch_topic_btn">Save</button>
                                    <button type="submit" class="btn btn-danger float-right" name="del_topic_btn" id="del_topic_btn">Delete</button>
                                </p>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

</html>