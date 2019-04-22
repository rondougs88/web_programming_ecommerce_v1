<?php include "../admin_area/includes/db.php"; ?>
<?php 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    global $con, $siteroot;

    $get_topic = "SELECT * FROM forum_categories WHERE cat_id = '$id'";

    $run_q = mysqli_query($con, $get_topic);

    while ($topics = mysqli_fetch_array($run_q)) {

        // $id = $topics['cat_id'];
        $catname = $topics['cat_name'];
        $catdesc = $topics['cat_description'];
    }
}
?>
<?php $pagetitle = "Topic subjects"; ?>
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
                            <i class="fa fa-commenting text-navy mid-icon" aria-hidden="true"></i>
                        </div>
                        <h2><?php global $catname; echo $catname ?></h2>
                        <span><?php global $catdesc; echo $catdesc ?></span>
                    </div>
                </div>

                <div class="ibox-content forum-container">
                    <?php get_forum_subjects($id); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

</html>