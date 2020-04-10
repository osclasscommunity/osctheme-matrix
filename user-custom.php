<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-custom');
osc_current_web_theme_path('header.php');
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="bg-lighter col-md-9 col-xl-10">
            <section class="user-custom">
                <?php osc_render_file(); ?>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
