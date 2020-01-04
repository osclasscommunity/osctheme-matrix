<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('recover');

osc_current_web_theme_path('header.php');
?>

<section class="recover bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="title cl-accent-dark"><?php _e('Recover password', 'matrix'); ?></h1>
            <p class="subtitle cl-darker"><?php _e('Request a new password for your account.', 'matrix'); ?></p>
            <div class="small-container bg-lighty col-12 col-md-8 col-lg-6">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="recover_post" />

                    <div class="mtx-form-group">
                        <?php FormMatrix::input('email', 's_email', 'mail', '', __('E-mail', 'matrix'), true); ?>
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
