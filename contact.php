<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('contact');

osc_current_web_theme_path('header.php');
?>
<section class="login bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="title cl-accent-dark"><?php _e('Contact', 'matrix'); ?></h1>
            <p class="subtitle cl-darker"><?php _e('Send us a message.', 'matrix'); ?></p>
            <div class="small-container bg-lighty col-12 col-md-8 col-lg-6">
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

                    <div class="mtx-form-group captcha">
                        <?php osc_show_recaptcha('register'); ?>
                    </div>

                    <div class="mtx-form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Send', 'matrix'); ?></button>
                    </div>

                    <?php osc_run_hook('admin_contact_form'); ?>
                </form>
            </div>
        </div>
    </div>
</section>
<?php osc_current_web_theme_path('footer.php'); ?>
