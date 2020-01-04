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
                <h1 class="title cl-accent-dark"><?php _e('My account', 'matrix'); ?></h1>
                <p class="subtitle cl-darker"><?php _e('Manage your account information.', 'matrix'); ?></p>

                <ul class="user-subnav nav nav-pills flex-column flex-lg-row mb-4">
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_user_profile_url(); ?>"><?php _e('My account', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_email_url(); ?>"><?php _e('Change email', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent-dark text-white" href="#"><?php _e('Change password', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_username_url(); ?>"><?php _e('Change username', 'matrix'); ?></a>
                    </li>
                </ul>

                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="change_password_post" />

                    <div class="form-group">
                        <label for="currpass"><?php _e('Current password', 'matrix'); ?></label>
                        <input type="password" name="password" class="form-control" id="currpass" placeholder="<?php _e('Your current password.', 'matrix'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pass"><?php _e('Password', 'matrix'); ?></label>
                        <input type="password" name="new_password" class="repeat form-control" id="pass" placeholder="<?php _e('Your new password.', 'matrix'); ?>" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="pass2"><?php _e('Repeat password', 'matrix'); ?></label>
                        <input type="password" name="new_password2" class="repeat form-control" id="pass2" placeholder="<?php _e('Repeat your new password.', 'matrix'); ?>" required minlength="8">
                    </div>

                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Update', 'matrix'); ?></button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
