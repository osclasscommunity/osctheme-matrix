<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('recover');

osc_current_web_theme_path('header.php');
?>

<section class="recover bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Recover password', 'matrix'); ?></h1>
            <p class="text-center cl-darker mb-5 col-12"><?php _e('Request a new password for your account.', 'matrix'); ?></p>
            <div class="small-container col-md-6 col-12 bg-lighty">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="recover_post" />

                    <div class="form-group">
                        <label for="mail"><?php _e('E-mail', 'matrix'); ?></label>
                        <input type="email" name="email" class="form-control" id="mail" placeholder="<?php _e('Email for your account.', 'matrix'); ?>" required>
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
