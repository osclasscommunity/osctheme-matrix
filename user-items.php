<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-items');

osc_current_web_theme_path('header.php');

View::newInstance()->_exportVariableToView('listAdmin', 1);
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="bg-lighter col-md-9 col-xl-10">
            <section class="user-items">
                <?php osc_run_hook('search_ads_listing_top'); ?>
                <h1 class="cl-accent-dark"><?php _e('My ads', 'matrix'); ?></h1>
                <p class="cl-darker"><?php _e('Manage the ads you have posted.', 'matrix'); ?></p>
                <?php if(osc_count_items() == 0) { ?>
                    <p class="text-center cl-darker"><?php _e('No items, yet.', 'matrix'); ?></p>
                <?php } else { ?>
                    <div class="container">
                        <div class="row">
                            <?php while(osc_has_items()) {
                                mtx_draw_item(false);
                            } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="paginate">
                    <?php echo osc_pagination_items(); ?>
                </div>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
