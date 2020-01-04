<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-alerts');

osc_current_web_theme_path('header.php');

$alerts = View::newInstance()->_get('alerts');
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="bg-lighter col-md-9 col-xl-10">
            <section class="user-alerts">
                <h1 class="title cl-accent-dark"><?php _e('My alerts', 'matrix'); ?></h1>
                <p class="subtitle cl-darker"><?php _e('Manage searches you subscribed to.', 'matrix'); ?></p>
                <div class="container">
                    <?php if(osc_count_alerts() == 0) { ?>
                        <p class="text-center cl-darker"><?php _e('No alerts, yet.', 'matrix'); ?></p>
                    <?php } else { ?>
                        <?php $i = 0; ?>
                        <?php foreach($alerts as $alert) { ?>
                            <?php $i++; $details = mtx_user_alert_parse_details($alert); ?>
                            <div class="bg-light col-12 p-3">
                                <div>
                                    <h4><?php printf(__('Alert no. %s', 'matrix'), $i); ?></h4>
                                    <?php foreach($details as $detail) { ?>
                                        <p class="mb-0"><strong><?php echo $detail['name']; ?>:</strong> <?php echo $detail['value']; ?></p>
                                    <?php } ?>
                                    <a href="<?php echo osc_user_unsubscribe_alert_url($alert['pk_i_id'], $alert['s_email'], $alert['s_secret']); ?>" class="btn btn-mtx bg-accent text-white mt-3 mb-3" onclick="javascript: return confirm(matrix.confirm);"><?php _e('Unsubscribe', 'matrix'); ?></a>
                                </div>
                                <div class="row">
                                    <?php View::newInstance()->_exportVariableToView('items', $alert['items']); ?>
                                    <?php while(osc_has_items()) { ?>
                                        <?php mtx_loop_item(false); ?>
                                        <?php mtx_loop_item(false); ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
