<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-profile');
osc_add_hook('before-main', function() {
    osc_current_web_theme_path('user-sidebar.php');
});


osc_add_filter('meta_title_filter', function($data) {
    return __('Alerts', 'matrix');

});


osc_current_web_theme_path('header.php');
$osc_user = osc_user();
?>
<h1><?php _e('Alerts', 'matrix'); ?></h1>
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
<?php osc_current_web_theme_path('footer.php') ; ?>
