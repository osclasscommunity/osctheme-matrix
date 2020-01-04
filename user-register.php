<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('register');

osc_current_web_theme_path('header.php');
?>
<section class="register bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="title cl-accent-dark"><?php _e('Register', 'matrix'); ?></h1>
            <p class="subtitle cl-darker"><?php _e('Create an account to gain access to more features.', 'matrix'); ?></p>
            <div class="small-container bg-lighty col-12 col-md-8 col-lg-6">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="register" />
                    <input type="hidden" name="action" value="register_post" />

                    <div class="mtx-form-group">
                        <?php FormMatrix::input('text', 's_name', 'name', '', __('Name', 'matrix'), true); ?>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::input('email', 's_email', 'mail', '', __('E-mail', 'matrix'), true); ?>
                    </div>
                    <div class="mtx-form-group pass-repeat">
                        <?php FormMatrix::input('password', 's_password', 'pass', '', __('Password', 'matrix'), true, '', 'minlength="8"'); ?>
                    </div>
                    <div class="mtx-form-group pass-repeat">
                        <?php FormMatrix::input('password', 's_password2', 'pass2', '', __('Repeat password', 'matrix'), true, '', 'minlength="8"'); ?>
                    </div>

                    <?php osc_run_hook('user_register_form'); ?>

                    <div class="mtx-form-group captcha">
                        <?php osc_show_recaptcha('register'); ?>
                    </div>

                    <div class="mtx-form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Register', 'matrix'); ?></button>
                    </div>

                    <div class="mtx-form-group-xt">
                        <a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'matrix'); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
