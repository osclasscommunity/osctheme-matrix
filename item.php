<?php
if(osc_item_is_spam() || !osc_item_is_enabled()) {
    osc_add_hook('header', 'mtx_nofollow_construct');
} else {
    osc_add_hook('header', 'mtx_follow_construct');
}

osc_enqueue_script('bxslider');
osc_enqueue_script('lightgallery');

mtx_add_body_class('item');

osc_current_web_theme_path('header.php');

if(osc_item_user_id() != null) {
    $user = User::newInstance()->findByPrimaryKey(osc_item_user_id());
    View::newInstance()->_exportVariableToView('user', $user);
}
?>
<div class="container-fluid bg-lighter">
    <div class="container">
        <div class="row">
            <?php if(osc_price_enabled_at_items()) { ?>
                <div class="col-8 ad-heading-col">
                    <section class="ad-heading bg-white">
                        <h1 class="cl-accent-dark"><?php echo osc_item_title(); ?></h1>
                        <p class="text-center cl-darker"><?php echo mtx_loop_item_location(); ?></p>
                    </section>
                </div>
                <div class="col-4 ad-price-col">
                    <section class="ad-price bg-darker">
                        <h2 class="text-center"><?php echo osc_item_formated_price(); ?></h2>
                    </section>
                </div>
            <?php } else { ?>
                <div class="col-12 ad-heading-col">
                    <section class="ad-heading bg-white">
                        <h1 class="cl-accent-dark"><?php echo osc_item_title(); ?></h1>
                        <p class="text-center cl-darker"><?php echo mtx_loop_item_location(); ?></p>
                    </section>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-8">
                <section class="ad-photos border">
                    <?php if(osc_images_enabled_at_items()) { ?>
                        <?php if(osc_count_item_resources() > 0 ) { ?>
                            <div class="ad-gallery">
                                <ul class="list gallery-slider">
                                    <?php for($x = 0; osc_has_item_resources(); $x++) { ?>
                                        <li>
                                            <a href="<?php echo osc_resource_url(); ?>">
                                                <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo $x + 1;?> / <?php echo osc_esc_html(osc_item_title()); ?>"/>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <?php if(osc_count_item_resources() > 1) { ?>
                                    <div class="row m-0 gallery-thumbs">
                                        <?php osc_reset_resources(); ?>
                                        <?php for($x = 1; osc_has_item_resources(); $x++) { ?>
                                            <a data-slide-index="<?php echo $x - 1; ?>" href="#" class="col-2 p-1 navi<?php if($x == 0) { ?> first<?php } ?><?php if($x - 1 == osc_count_item_resources()) { ?> last<?php } ?>">
                                                <img class="img-fluid" src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo $x; ?> / <?php echo osc_esc_html(osc_item_title()); ?>"/>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </section>
                <section class="ad-description border">
                    <h3 class="bg-darker"><?php _e('Description', 'matrix'); ?></h3>
                    <p class="mb-0"><?php echo osc_item_description(); ?></p>
                </section>
                <section class="ad-plugin border">
                    <h3 class="bg-darker"><?php _e('More information', 'matrix'); ?></h3>
                    <?php while (osc_has_item_meta()) { ?>
                        <?php if(osc_item_meta_value() != '') { ?>
                            <div class="meta">
                                <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php osc_run_hook('item_detail', osc_item()); ?>
                </section>

                <?php if(osc_comments_enabled()) { ?>
                    <section class="ad-comments border">
                        <h3 class="bg-darker"><?php _e('Comments', 'matrix'); ?></h3>

                        <?php while(osc_has_item_comments()) { ?>
                            <div class="comment">
                                <?php echo osc_comment_title(); ?>
                                <?php if(osc_comment_author_name() == '') { _e('Anonymous', 'matrix'); } else { echo osc_comment_author_name(); } ?>

                                <?php echo osc_comment_body(); ?>

                                <?php if(osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id())) { ?>
                                    <a href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete', 'matrix')); ?>"></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="pagination"><?php echo osc_comments_pagination(); ?></div>

                        <?php if(osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments()) { ?>
                            <!-- form -->
                        <?php } ?>
                    </section>
                <?php } ?>
            </div>
            <div class="col-md-4 pl-0">
                <section class="ad-contact border mb-3">
                    <h3 class="bg-darker"><?php _e('Contact', 'matrix'); ?></h3>

                    <?php $cover_phone = mtx_pref('item_cover_phone'); $cover_email = mtx_pref('item_cover_email'); ?>

                    <?php if(mtx_item_phone() != '') { ?>
                        <p class="mb-0">
                            <?php if($cover_phone) { ?>
                                <a class="phone hidden" href="javascipt:void();" data-value="<?php echo mtx_item_phone(); ?>"><?php echo substr(mtx_item_phone(), 0, 3); ?>XXXXXX</a>
                            <?php } else { ?>
                                <a class="phone" href="tel:<?php echo mtx_item_phone(); ?>"><?php mtx_item_phone(); ?></a>
                            <?php } ?>
                        </p>
                    <?php } ?>

                    <?php if(osc_item_user_id() != null) { ?>
                        <p class="mb-0">
                            <?php if(osc_user_phone_mobile() != '') { ?>
                                <?php if($cover_phone) { ?>
                                    <a class="phone hidden" href="javascipt:void();" data-value="<?php echo osc_user_phone_mobile(); ?>"><?php echo substr(osc_user_phone_mobile(), 0, 3); ?>XXXXXX</a>
                                <?php } else { ?>
                                    <a class="phone" href="tel:<?php echo osc_user_phone_mobile(); ?>"><?php osc_user_phone_mobile(); ?></a>
                                <?php } ?>
                            <?php } ?>
                            <?php if(osc_user_phone_land() != '') { ?>
                                <?php if($cover_phone) { ?>
                                    <a class="phone hidden" href="javascipt:void();" data-value="<?php echo osc_user_phone_land(); ?>"><?php echo substr(osc_user_phone_land(), 0, 3); ?>XXXXXX</a>
                                <?php } else { ?>
                                    <a class="phone" href="tel:<?php echo osc_user_phone_land(); ?>"><?php osc_user_phone_land(); ?></a>
                                <?php } ?>
                            <?php } ?>
                        </p>
                    <?php } ?>

                    <?php if(osc_item_show_email()) { ?>
                        <p class="mb-0">
                            <?php if($cover_email) { ?>
                                <a class="email hidden" href="javascipt:void();" data-value="<?php echo osc_item_contact_email(); ?>"><?php echo substr(osc_item_contact_email(), 0, 3); ?>@XXX.XXX</a>
                            <?php } else { ?>
                                <a class="email" href="mailto:<?php echo osc_item_contact_email(); ?>"><?php osc_item_contact_email(); ?></a>
                            <?php } ?>
                        </p>
                    <?php } ?>
                </section>
                <section class="ad-user border">
                    <h3 class="bg-darker"><?php _e('User', 'matrix'); ?></h3>

                    <div class="user-card text-center">
                        <div class="user-img d-flex justify-content-center mb-3">
                            <img class="img-fluid" width="70" src="<?php echo mtx_user_profilepic_url(osc_item_user_id()); ?>" alt="<?php echo osc_item_contact_name(); ?>">
                        </div>
                        <?php if(osc_item_user_id() == null) { ?>
                            <p><?php echo osc_item_contact_name(); ?></p>
                        <?php } else { ?>
                            <p class="mb-1"><a href="<?php echo osc_user_public_profile_url(); ?>"><?php echo osc_item_contact_name(); ?></a></p>
                            <p><a href="<?php echo osc_user_public_profile_url(); ?>" class="cl-accent"><?php _e('View profile', 'matrix'); ?></a></p>
                            <p><?php echo mtx_loop_item_location(false, true); ?></p>
                        <?php } ?>
                    </div>
                </section>
                <section class="ad-location border">
                    <h3 class="bg-darker"><?php _e('Map', 'matrix'); ?></h3>
                    <?php osc_run_hook('location'); ?>
                </section>
            </div>
        </div>
    </div>
</div>
<?php if(osc_count_item_resources() > 0) { ?>
    <script>
        $(function() {
            $('.gallery-slider').lightGallery({
                mode: 'lg-slide',
                thumbnail: true,
                selector: 'a',
                download: true,
                share: true,
                thumbWidth: 90,
                thumbContHeight: 80
            });

            $('.gallery-slider').bxSlider({
                slideWidth: $(window).outerWidth(),
                infiniteLoop: false,
                slideMargin: 0,
                pager: true,
                pagerCustom: '.gallery-thumbs',
                infiniteLoop: true,
                nextText: '<i class="fa fa-angle-right"></i>',
                prevText: '<i class="fa fa-angle-left"></i>'
            });

            if($('ul.gallery-slider').find('li').length <= 1) {
                $('.bx-controls').hide(0);
            }
        });
    </script>
<?php } ?>
<?php osc_current_web_theme_path('footer.php'); ?>
