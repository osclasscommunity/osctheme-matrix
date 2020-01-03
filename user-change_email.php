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
                        <a class="nav-link btn-mtx bg-accent-dark text-white" href="#"><?php _e('Change email', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_password_url(); ?>"><?php _e('Change password', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_username_url(); ?>"><?php _e('Change username', 'matrix'); ?></a>
                    </li>
                </ul>

                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="change_email_post" />

                    <div class="form-group">
                        <label for="email1"><?php _e('Current e-mail', 'matrix'); ?></label>
                        <input type="email" class="form-control" id="email1" value="<?php echo osc_user()['s_email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email2"><?php _e('New e-mail', 'matrix'); ?></label>
                        <input type="email" name="new_email" class="form-control" id="email2" placeholder="<?php _e('Your new email.', 'matrix'); ?>" required>
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
