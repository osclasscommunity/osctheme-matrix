<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('login');

osc_current_web_theme_path('header.php');
?>
<section class="login bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="cl-accent-dark"><?php _e('Login', 'matrix'); ?></h1>
            <p class="cl-darker"><?php _e('Login to see your ads and account.', 'matrix'); ?></p>
            <div class="small-container bg-lighty col-12 col-md-8 col-lg-6">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login_post" />

                    <div class="mtx-form-group">
                        <?php FormMatrix::input('text', 'email', 'mail', '', __('Username or e-mail', 'matrix'), true); ?>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::input('password', 'password', 'pass', '', __('Password', 'matrix'), true); ?>
                    </div>
                    <div class="mtx-form-group-cs custom-control custom-checkbox">
                        <?php FormMatrix::checkbox('remember', 'remember', false, __('Stay logged in', 'matrix')); ?>
                    </div>
                    <div class="mtx-form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Login', 'matrix'); ?></button>
                    </div>
                    <div class="mtx-form-group-xt">
                        <a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register', 'matrix'); ?></a>
                        <a href="<?php echo osc_recover_user_password_url(); ?>"><?php _e('Forgotten password?', 'matrix'); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
