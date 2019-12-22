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

                    <div class="form-group">
                        <label for="name"><?php _e('Your name (optional)', 'matrix'); ?></label>
                        <input type="text" name="yourName" class="form-control" id="name" placeholder="<?php _e('Your name, not required.', 'matrix'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="mail"><?php _e('E-mail', 'matrix'); ?></label>
                        <input type="email" name="yourEmail" class="form-control" id="mail" placeholder="<?php _e('Your e-mail, required to reply you.', 'matrix'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="subject"><?php _e('Subject (optional)', 'matrix'); ?></label>
                        <input type="text" name="subject" class="form-control" id="subject" placeholder="<?php _e('Subject of the message, not required.', 'matrix'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="message"><?php _e('Message', 'matrix'); ?></label>
                        <textarea name="subject" class="form-control" id="message" required minlength="15"></textarea>
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
