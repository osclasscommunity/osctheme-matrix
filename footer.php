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
                            <?php $i = 1; $categories = mtx_popular_categories(); ?>
                            <?php foreach($categories as $data) { ?>
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
    <?php /*if ( osc_count_web_enabled_locales() > 1) { ?>
        <?php osc_goto_first_locale(); ?>
        <strong><?php _e('Language:', 'matrix'); ?></strong>
        <?php $i = 0;  ?>
        <?php while ( osc_has_web_enabled_locales() ) { ?>
        <span><a id="<?php echo osc_locale_code(); ?>" href="<?php echo osc_change_language_url ( osc_locale_code() ); ?>"><?php echo osc_locale_name(); ?></a></span><?php if( $i == 0 ) { echo " &middot; "; } ?>
            <?php $i++; ?>
        <?php } ?>
    <?php } */ ?>
</footer>
<?php osc_run_hook('footer'); ?>
</body>
</html>
