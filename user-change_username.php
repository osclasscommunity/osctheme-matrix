<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-profile');

osc_current_web_theme_path('header.php');
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="bg-lighter col-md-9 col-xl-10">
            <section class="container user-account">
                <h1 class="cl-accent-dark"><?php _e('My account', 'matrix'); ?></h1>
                <p class="cl-darker"><?php _e('Manage your account information.', 'matrix'); ?></p>

                <ul class="user-subnav nav nav-pills flex-column flex-lg-row mb-4">
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_user_profile_url(); ?>"><?php _e('My account', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_email_url(); ?>"><?php _e('Change email', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_password_url(); ?>"><?php _e('Change password', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent-dark text-white" href="#"><?php _e('Change username', 'matrix'); ?></a>
                    </li>
                </ul>

                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="change_username_post" />

                    <div class="form-group">
                        <label for="currusername"><?php _e('Current username', 'matrix'); ?></label>
                        <input type="text" class="form-control" id="currusername" value="<?php echo osc_user()['s_username']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username"><?php _e('New username', 'matrix'); ?></label>
                        <input type="text" name="s_username" class="form-control" id="username" placeholder="<?php _e('Your new username.', 'matrix'); ?>" required>
                        <small class="form-text text-muted" id="available"><?php _e('Username availability checker.', 'matrix'); ?></small>
                    </div>

                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Update', 'matrix'); ?></button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script>
$(function() {
    var cInterval;
    $('#username').keydown(function(event) { console.info('test');
        if($('#username').val() != '') {
            clearInterval(cInterval);
            cInterval = setInterval(function() {
                $.getJSON(
                    '<?php echo osc_base_url(true); ?>?page=ajax&action=check_username_availability',
                    {'s_username': $('#username').val()},
                    function(data){
                        clearInterval(cInterval);
                        if(data.exists == 0) {
                            $("#available").text('<?php echo osc_esc_js(__('The username is available.','matrix')); ?>');
                            document.querySelector('#username').setCustomValidity('');
                        } else {
                            $("#available").text('<?php echo osc_esc_js(__('The username is <strong>not</strong> available.', 'matrix')); ?>');
                            document.querySelector('#username').setCustomValidity('<?php echo osc_esc_js(__('The username is <strong>not</strong> available.', 'matrix')); ?>')
                        }
                    }
                );
            }, 500);
        }
    });
});
</script>
<?php osc_current_web_theme_path('footer.php'); ?>
