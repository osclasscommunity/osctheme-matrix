<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('forgot');

osc_current_web_theme_path('header.php');
?>
<section class="forgot bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="title cl-accent-dark"><?php _e('New password', 'matrix'); ?></h1>
            <p class="subtitle cl-darker"><?php _e('Create a new password for your account.', 'matrix'); ?></p>
            <div class="small-container bg-lighty col-12 col-md-8 col-lg-6">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="forgot_post" />
                    <input type="hidden" name="userId" value="<?php echo osc_esc_html(Params::getParam('userId')); ?>" />
                    <input type="hidden" name="code" value="<?php echo osc_esc_html(Params::getParam('code')); ?>" />

                    <div class="mtx-form-group pass-repeat">
                        <?php FormMatrix::input('password', 'new_password', 'pass', '', __('New password', 'matrix'), true, '', 'minlength="8"'); ?>
                    </div>
                    <div class="mtx-form-group pass-repeat">
                        <?php FormMatrix::input('password', 'new_password2', 'pass2', '', __('Repeat new password', 'matrix'), true, '', 'minlength="8"'); ?>
                    </div>

                    <div class="mtx-form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Submit', 'matrix'); ?></button>
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
