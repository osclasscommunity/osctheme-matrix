<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-items');

osc_current_web_theme_path('header.php');

View::newInstance()->_exportVariableToView('listAdmin', 1);
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="col-md-9 col-xl-10 bg-lighter">
            <section class="user-items">
                <?php osc_run_hook('search_ads_listing_top'); ?>
                <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('My ads', 'matrix'); ?></h1>
                <p class="text-center cl-darker mb-5 col-12"><?php _e('Manage the ads you have posted.', 'matrix'); ?></p>
                <?php osc_current_web_theme_path('loop.php'); ?>
                <div class="paginate">
                    <?php echo osc_pagination_items(); ?>
                </div>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
