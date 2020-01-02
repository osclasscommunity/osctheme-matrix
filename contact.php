<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('contact');

osc_current_web_theme_path('header.php');
?>
<section class="login bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Contact', 'matrix'); ?></h1>
            <p class="text-center cl-darker mb-5 col-12"><?php _e('Send us a message.', 'matrix'); ?></p>
            <div class="small-container col-md-6 col-12 bg-lighty">
                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="contact" />
                    <input type="hidden" name="action" value="contact_post" />

                    <div class="mtx-form-group">
                        <?php FormMatrix::input('text', 'yourName', 'name', Session::newInstance()->_get('yourName'), __('Name (optional)', 'matrix')); ?>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::input('email', 'yourEmail', 'mail', Session::newInstance()->_get('yourEmail'), __('E-mail', 'matrix'), true); ?>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::input('text', 'subject', 'subject', Session::newInstance()->_get('subject'), __('Subject (optional)', 'matrix')); ?>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::textarea('message_body', 'message', Session::newInstance()->_get('message'), __('Message', 'matrix'), true, 'minlength="15"'); ?>
                    </div>

                    <?php osc_run_hook('contact_form'); ?>

                    <div class="form-group captcha">
                        <?php osc_show_recaptcha('register'); ?>
                    </div>

                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Send', 'matrix'); ?></button>
                    </div>

                    <?php osc_run_hook('admin_contact_form'); ?>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
