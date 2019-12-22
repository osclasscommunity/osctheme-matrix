<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('forgot');

osc_current_web_theme_path('header.php');
?>

<section class="forgot bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('New password', 'matrix'); ?></h1>
            <p class="text-center cl-darker mb-5 col-12"><?php _e('Create a new password for your account.', 'matrix'); ?></p>
            <div class="small-container col-md-6 col-12 bg-lighty">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="forgot_post" />
                    <input type="hidden" name="userId" value="<?php echo osc_esc_html(Params::getParam('userId')); ?>" />
                    <input type="hidden" name="code" value="<?php echo osc_esc_html(Params::getParam('code')); ?>" />

                    <div class="form-group">
                        <label for="pass"><?php _e('New password', 'matrix'); ?></label>
                        <input type="password" name="new_password" class="repeat form-control" id="pass" placeholder="<?php _e('Your new password.', 'matrix'); ?>" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="pass2"><?php _e('Repeat new password', 'matrix'); ?></label>
                        <input type="password" name="new_password2" class="repeat form-control" id="pass2" placeholder="<?php _e('Repeat your new password.', 'matrix'); ?>" required minlength="8">
                    </div>

                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Submit', 'matrix'); ?></button>
                    </div>

                    <div class="form-group text-center">
                        <p><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'matrix'); ?></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
