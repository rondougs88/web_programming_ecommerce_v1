<?php include "../admin_area/includes/db.php"; ?>
<?php $pagetitle = "Message Board"; ?>
<?php include "../header.php"; ?>

<link href="<?= $siteroot; ?>/css/forum.css" rel="stylesheet">

<?php include "../navigation.php"; ?>

<div class="container">
    <div class="row" style="margin-top:40px">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="ibox-content m-b-sm border-bottom">
                    <div class="p-xs">
                        <div class="pull-left m-r-md">
                            <i class="fa fa-globe text-navy mid-icon"></i>
                        </div>
                        <h2>Welcome to our forum</h2>
                        <span>Feel free to choose topic you're interested in.</span>
                    </div>
                </div>

                <div class="ibox-content forum-container">
                    <!-- <div class="forum-item ">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="forum-icon">
                                    <i class="fa fa-shield"></i>
                                </div>
                                <a href="forum_post.html" class="forum-item-title">General Discussion</a>
                                <div class="forum-sub-title">Talk about sports, entertainment, music, movies, your favorite color, talk about enything.</div>
                            </div>
                        </div>
                    </div> -->
                    <?php get_forum_topics(); ?>



                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

</html>