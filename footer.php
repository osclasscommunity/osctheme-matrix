</main>
<?php osc_run_hook('after-main'); ?>
<footer class="footer">
    <section class="footer footer-top bg-accent">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="footer-col text-white">
                        <h3 class="footer-title"><?php _e('Info', 'matrix'); ?></h3>
                        <div class="footer-text">
                            <p>Company Name Ltd.</p>
                            <p>Unknown Road 100</p>
                            <p>Wonderland</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="footer-col text-white">
                        <h3 class="footer-title"><?php _e('Menu', 'matrix'); ?></h3>
                        <div class="footer-text">
                            <p><a href="<?php echo osc_base_url(); ?>"><?php _e('Home', 'matrix'); ?></a></p>

                            <?php if(osc_users_enabled() || (!osc_users_enabled() && !osc_reg_user_post())) { ?>
                                <p><a href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e('Post an ad', 'matrix'); ?></a></p>
                            <?php } ?>

                            <?php if(osc_users_enabled()) { ?>
                                <?php if(osc_is_web_user_logged_in()) { ?>
                                    <p><a href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My account', 'matrix'); ?></a></p>
                                    <p><a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'matrix'); ?></a></p>
                                <?php } else { ?>
                                    <p><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'matrix'); ?></a></p>
                                    <?php if(osc_user_registration_enabled()) { ?>
                                        <p><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register', 'matrix'); ?></a></p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                            <?php osc_reset_static_pages(); ?>
                            <?php while(osc_has_static_pages()) { ?>
                                <p><a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a></p>
                            <?php } ?>

                            <p><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'matrix'); ?></a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="footer-col text-white">
                        <h3 class="footer-title"><?php _e('Popular categories', 'matrix'); ?></h3>
                        <div class="footer-text">
                            <?php $i = 1; ?>
                            <?php foreach(mtx_popular_categories() as $data) { ?>
                                <p><a href="<?php echo osc_search_url(array('sCategory' => $data['category_id'])); ?>"><?php echo $data['category_name']; ?></a></p>
                                <?php if($i > 5) break; else $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="footer-col text-white">
                        <h3 class="footer-title"><?php _e('Popular locations', 'matrix'); ?></h3>
                        <div class="footer-text">
                            <?php $i = 1; $locations = mtx_popular_locations(); ?>
                            <?php foreach($locations['data'] as $location) { ?>
                                <?php $data = mtx_popular_locations_parse($location, $locations['type']); ?>
                                <p><a href="<?php echo $data['s_url']; ?>"><?php echo $data['s_name']; ?></a></p>
                                <?php if($i > 5) break; else $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php osc_show_widgets('footer'); ?>
            </div>
        </div>
    </section>
    <section class="footer footer-bottom bg-accent-dark">
        <div class="container">
            <div class="row">
                <div class="footer-bar">
                    <div class="footer-left">
                        <p class="text-white m-0">©<?php echo date('Y'); ?> <?php _e('All rights reserved.', 'matrix'); ?></p>
                    </div>
                    <div class="footer-center">
                        <a class="navbar-brand text-white mr-2" href="#"><?php echo mtx_logo('footer'); ?></a>
                    </div>
                    <div class="footer-right">
                        <p class="text-white m-0"><?php _e('Powered by Osclass Community | WEBmods', 'matrix'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>

<?php if(mtx_pref('ad_contact_form') && osc_is_ad_page()) { ?>
    <div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="contact-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-darker text-white">
                    <h5 class="modal-title" id="contact-modal-title"><?php _e('Message seller', 'matrix'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-lighty">
                    <form action="<?php echo osc_base_url(1); ?>" method="POST" class="contact-form">
                        <input type="hidden" name="page" value="item">
                        <input type="hidden" name="action" value="contact_post">
                        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>">
                        <?php if(osc_is_web_user_logged_in()) { ?>
                            <input type="hidden" name="yourName" value="<?php echo osc_esc_html(osc_logged_user_name()); ?>" />
                            <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email(); ?>" />
                        <?php } ?>

                        <?php if(!osc_is_web_user_logged_in()) { ?>
                            <div class="form-row">
                                <div class="col">
                                        <label for="name"><?php _e('Your name', 'matrix'); ?></label>
                                    <input type="text" name="yourName" class="form-control" id="name" placeholder="<?php _e('Your name, required to reply you.', 'matrix'); ?>" required>
                                </div>
                                <div class="col">
                                    <label for="mail"><?php _e('Your e-mail', 'matrix'); ?></label>
                                    <input type="email" name="yourEmail" class="form-control" id="mail" placeholder="<?php _e('Your e-mail, required to reply you.', 'matrix'); ?>" required>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="phone"><?php _e('Phone (optional)', 'matrix'); ?></label>
                            <input type="text" name="phoneNumber" class="form-control" id="phone" placeholder="<?php _e('Your phone number, optional.', 'matrix'); ?>" inputmode="numeric">
                        </div>
                        <div class="form-group">
                            <label for="message"><?php _e('Message', 'matrix'); ?></label>
                            <textarea name="message" class="form-control" id="message" required minlength="15"></textarea>
                        </div>

                        <button type="submit" class="submit d-none"></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-mtx bg-darker" data-dismiss="modal"><?php _e('Close', 'matrix'); ?></button>
                    <button type="button" class="btn btn-mtx bg-accent" onclick="$('.contact-form .submit').click();"><?php _e('Send', 'matrix'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if((osc_reg_user_post_comments() && osc_is_web_user_logged_in() || !osc_reg_user_post_comments()) && osc_is_ad_page()) { ?>
    <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="comment-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-darker text-white">
                    <h5 class="modal-title" id="comment-modal-title"><?php _e('Add a comment', 'matrix'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-lighty">
                    <form action="<?php echo osc_base_url(1); ?>" method="POST" class="comment-form">
                        <input type="hidden" name="page" value="item">
                        <input type="hidden" name="action" value="add_comment">
                        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>">
                        <?php if(osc_is_web_user_logged_in()) { ?>
                            <input type="hidden" name="authorName" value="<?php echo osc_esc_html(osc_logged_user_name()); ?>" />
                            <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email(); ?>" />
                        <?php } ?>

                        <?php if(!osc_is_web_user_logged_in()) { ?>
                            <div class="form-row">
                                <div class="col">
                                    <label for="name"><?php _e('Your name (optional)', 'matrix'); ?></label>
                                    <input type="text" name="authorName" class="form-control" id="name" placeholder="<?php _e('Your name, optional.', 'matrix'); ?>" required>
                                </div>
                                <div class="col">
                                    <label for="mail"><?php _e('Your e-mail', 'matrix'); ?></label>
                                    <input type="email" name="authorEmail" class="form-control" id="mail" placeholder="<?php _e('Your e-mail, required to reply you.', 'matrix'); ?>" required>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="subject"><?php _e('Title (optional)', 'matrix'); ?></label>
                            <input type="text" name="title" class="form-control" id="subject" placeholder="<?php _e('Title of the comment, not required.', 'matrix'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="message"><?php _e('Comment', 'matrix'); ?></label>
                            <textarea name="body" class="form-control" id="message" required minlength="15"></textarea>
                        </div>

                        <?php osc_run_hook('advcaptcha_hook_comment'); ?>

                        <button type="submit" class="submit d-none"></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-mtx bg-darker" data-dismiss="modal"><?php _e('Close', 'matrix'); ?></button>
                    <button type="button" class="btn btn-mtx bg-accent" onclick="$('.comment-form .submit').click();"><?php _e('Add', 'matrix'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php osc_run_hook('footer'); ?>
</body>
</html>
