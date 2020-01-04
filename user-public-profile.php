<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('user user-public-profile');

osc_add_hook('mtx_jumbo', function() {
    osc_current_web_theme_path('user-public-profile-jumbo.php');
});

osc_current_web_theme_path('header.php');

$ads_class = 'bg-ligter';
?>
    <?php if(osc_user_info() != '') { ?>
        <?php $ads_class = ''; ?>
        <section class="about bg-lighter">
            <div class="container">
                <div class="row">
                    <h2 class="title cl-accent-dark"><?php _e('About', 'matrix'); ?></h2>
                    <p class="subtitle cl-darker"><?php printf(__('More information about %s.', 'matrix'), osc_highlight(osc_user_name(), 20)); ?></p>
                    <p class="mb-5"><?php echo nl2br(osc_user_info()); ?></p>
                </div>
            </div>
        </section>
    <?php } ?>

    <section class="ads <?php echo $ads_class; ?>">
        <div class="container">
            <div class="row">
                <h2 class="title cl-accent-dark"><?php _e('Latest ads', 'matrix'); ?></h2>
                <p class="subtitle cl-darker"><?php printf(__('Browse latest ads by %s.', 'matrix'), osc_highlight(osc_user_name(), 20)); ?></p>
                <?php if(osc_count_items() == 0) { ?>
                    <p class="text-center cl-darker"><?php _e('No items, yet.', 'matrix'); ?></p>
                <?php } else { ?>
                    <?php while(osc_has_items()) {
                        mtx_loop_item(false);
                    } ?>
                    <p class="text-center cl-darker mt-3 mb-4 col-12">
                        <a class="btn btn-mtx bg-darker" href="<?php echo osc_search_url(array('sUser' => osc_user_id())); ?>"><?php _e('Show all', 'matrix'); ?></a>
                    </p>
                <?php } ?>
            </div>
        </div>
    </section>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
