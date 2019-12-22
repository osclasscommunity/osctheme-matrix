<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('login');

osc_current_web_theme_path('header.php');
?>
<section class="login bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Login', 'matrix'); ?></h1>
            <p class="text-center cl-darker mb-5 col-12"><?php _e('Login to see your ads and account.', 'matrix'); ?></p>
            <div class="small-container col-md-6 col-12 bg-lighty">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login_post" />

                    <div class="form-group">
                        <label for="mail"><?php _e('E-mail', 'matrix'); ?></label>
                        <input type="email" name="email" class="form-control" id="mail" placeholder="<?php _e('Email for your account.', 'matrix'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pass"><?php _e('Password', 'matrix'); ?></label>
                        <input type="password" name="password" class="form-control" id="pass" placeholder="<?php _e('Password for your account.', 'matrix'); ?>" required>
                    </div>
                    <div class="form-group custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                        <label class="custom-control-label" for="remember"><?php _e('Stay logged in', 'matrix'); ?></label>
                    </div>
                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Login', 'matrix'); ?></button>
                    </div>

                    <div class="form-group text-center">
                        <p><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register', 'matrix'); ?></a></p>
                        <p><a href="<?php echo osc_recover_user_password_url(); ?>"><?php _e('Forgotten password?', 'matrix'); ?></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
