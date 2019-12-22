<?php
osc_enqueue_script('jquery-validate'); // DEPRECATED! HTML5 validation used.
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('register');

osc_current_web_theme_path('header.php');
?>
<section class="register bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Register', 'matrix'); ?></h1>
            <p class="text-center cl-darker mb-5 col-12"><?php _e('Create an account to gain access to more features.', 'matrix'); ?></p>
            <div class="small-container col-md-6 col-12 bg-lighty">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="register" />
                    <input type="hidden" name="action" value="register_post" />

                    <div class="form-group">
                        <label for="name"><?php _e('Name', 'matrix'); ?></label>
                        <input type="text" name="s_name" class="form-control" id="name" placeholder="<?php _e('Your name, visible on ads.', 'matrix'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mail"><?php _e('E-mail', 'matrix'); ?></label>
                        <input type="email" name="s_email" class="form-control" id="mail" placeholder="<?php _e('Your email, used for contacting you.', 'matrix'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pass"><?php _e('Password', 'matrix'); ?></label>
                        <input type="password" name="s_password" class="repeat form-control" id="pass" placeholder="<?php _e('Your password, required to login.', 'matrix'); ?>" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="pass2"><?php _e('Password 2', 'matrix'); ?></label>
                        <input type="password" name="s_password2" class="repeat form-control" id="pass2" placeholder="<?php _e('Repeat your password.', 'matrix'); ?>" required minlength="8">
                    </div>

                    <?php osc_run_hook('user_register_form'); ?>

                    <div class="form-group captcha">
                        <?php osc_show_recaptcha('register'); ?>
                    </div>

                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Register', 'matrix'); ?></button>
                    </div>

                    <div class="form-group text-center">
                        <p><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Login', 'matrix'); ?></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
