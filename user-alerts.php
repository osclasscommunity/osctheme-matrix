<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-alerts');

osc_current_web_theme_path('header.php');
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="col-md-9 col-xl-10 bg-lighter">
            <section class="user-alerts">
                <?php osc_run_hook('search_ads_listing_top'); ?>
                <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('My alerts', 'matrix'); ?></h1>
                <p class="text-center cl-darker mb-5 col-12"><?php _e('Manage searches you subscribed to.', 'matrix'); ?></p>
                <?php if(osc_count_alerts() == 0) { ?>
                    <h3><?php _e('You do not have any alerts yet', 'matrix'); ?>.</h3>
                <?php } else { ?>
                    <?php
                    $i = 1;
                    while(osc_has_alerts()) { ?>
                        <div class="userItem" >
                            <div class="title-has-actions">
                                <h3><?php _e('Alert', 'matrix'); ?> <?php echo $i; ?></h3> <a onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'matrixw')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url(); ?>"><?php _e('Delete this alert', 'matrix'); ?></a><div class="clear"></div></div>
                            <div>
                            <?php osc_current_web_theme_path('loop.php') ; ?>
                            <?php if(osc_count_items() == 0) { ?>
                                    <br />
                                    0 <?php _e('Listings', 'matrix'); ?>
                            <?php } ?>
                            </div>
                        </div>
                        <br />
                    <?php
                    $i++;
                    }
                    ?>
                <?php  } ?>
                <div class="paginate">
                    <?php echo osc_pagination_items(); ?>
                </div>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
