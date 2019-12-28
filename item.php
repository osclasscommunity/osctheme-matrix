<?php
if(osc_item_is_spam() || !osc_item_is_enabled()) {
    osc_add_hook('header', 'mtx_nofollow_construct');
} else {
    osc_add_hook('header', 'mtx_follow_construct');
}

osc_enqueue_script('bxslider');
osc_enqueue_script('lightgallery');
mtx_add_body_class('ad');
osc_current_web_theme_path('header.php');

if(osc_item_user_id() != null) {
    $user = User::newInstance()->findByPrimaryKey(osc_item_user_id());
    View::newInstance()->_exportVariableToView('user', $user);
}

// item_detail hook
ob_start();
osc_run_hook('item_detail', osc_item());
$item_detail = ob_get_clean();
// location hook
ob_start();
osc_run_hook('location');
$location = ob_get_clean();
?>
<div class="container-fluid bg-lighter">
    <div class="container">
        <div class="row">
            <?php if(osc_price_enabled_at_items()) { ?>
                <div class="col-12 col-md-8 col-lg-9 ad-heading">
                    <section class="bg-white">
                        <h1 class="cl-accent-dark"><?php echo osc_item_title(); ?></h1>
                        <p class="cl-darker"><?php echo mtx_loop_item_location(); ?></p>
                    </section>
                </div>
                <div class="col-12 col-md-4 col-lg-3 ad-price">
                    <section class="bg-darker">
                        <h2><?php echo osc_item_formated_price(); ?></h2>
                    </section>
                </div>
            <?php } else { ?>
                <div class="col-12 ad-heading mb-3 mb-md-0">
                    <section class="bg-white">
                        <h1 class="cl-accent-dark"><?php echo osc_item_title(); ?></h1>
                        <p class="cl-darker"><?php echo mtx_loop_item_location(); ?></p>
                    </section>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-9">
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
                                            <div class="thumb col-4 col-sm-3 col-md-2">
                                                <a data-slide-index="<?php echo $x - 1; ?>" href="#">
                                                    <img class="img-fluid" src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo $x; ?> / <?php echo osc_esc_html(osc_item_title()); ?>"/>
                                                    <div class="thumb-border"></div>
                                                </a>
                                            </div>
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
                <?php if(osc_count_item_meta() > 0 || $item_detail != '') { ?>
                    <section class="ad-plugin border">
                        <h3 class="bg-darker"><?php _e('More information', 'matrix'); ?></h3>

                        <?php $item_detail_margin = '0'; ?>
                        <?php if(osc_count_item_meta() > 0) { ?>
                            <?php $item_detail_margin = '1rem'; ?>
                            <ul class="meta list-group list-group-flush">
                                <?php while (osc_has_item_meta()) { ?>
                                    <li class="list-group-item">
                                        <span class="name"><?php echo osc_item_meta_name(); ?></span>
                                        <span class="value"><?php echo mtx_item_meta_value(); ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>

                        <?php if($item_detail != '') { ?>
                            <div style="margin-top: <?php echo $item_detail_margin; ?>">
                                <?php echo $item_detail; ?>
                            </div>
                        <?php } ?>
                    </section>
                <?php } ?>

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

                        <?php if(osc_reg_user_post_comments() && osc_is_web_user_logged_in() || !osc_reg_user_post_comments()) { ?>
                            <div class="form-container bg-lighty">
                                <form action="<?php echo osc_base_url(1); ?>" method="POST" class="comment_form">
                                    <input type="hidden" name="page" value="item" />
                                    <input type="hidden" name="action" value="add_comment" />
                                    <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                                    <?php if(osc_is_web_user_logged_in()) { ?>
                                        <input type="hidden" name="authorName" value="<?php echo osc_esc_html(osc_logged_user_name()); ?>" />
                                        <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                                    <?php } ?>

                                    <?php if(!osc_is_web_user_logged_in()) { ?>
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="name"><?php _e('Your name (optional)', 'matrix'); ?></label>
                                                <input type="text" name="authorName" class="form-control" id="name" placeholder="<?php _e('Your name, not required.', 'matrix'); ?>">
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

                                    <div class="form-group form-submit">
                                    	<button type="submit" class="btn btn-mtx bg-accent"><?php _e('Post', 'matrix'); ?></button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </section>
                <?php } ?>
            </div>
            <div class="col-md-4 col-lg-3 pl-md-0">
                <section class="ad-contact border">
                    <h3 class="bg-darker"><?php _e('Contact', 'matrix'); ?></h3>
                    <?php $cover_phone = mtx_pref('ad_cover_phone'); $cover_email = mtx_pref('ad_cover_email'); ?>

                    <?php if(mtx_item_phone() != '') { ?>
                        <p>
                            <?php if($cover_phone) { ?>
                                <i class="fa fa-phone-square fa-fw cl-accent"></i> <a class="phone hidden" href="javascipt:void();" data-value="<?php echo osc_esc_html(mtx_item_phone()); ?>"><?php echo substr(mtx_item_phone(), 0, 3); ?>XXXXXX</a>
                            <?php } else { ?>
                                <i class="fa fa-phone-square fa-fw cl-accent"></i> <a class="phone" href="tel:<?php echo osc_esc_html(mtx_item_phone()); ?>"><?php mtx_item_phone(); ?></a>
                            <?php } ?>
                        </p>
                    <?php } ?>

                    <?php if(osc_item_user_id() != null) { ?>
                        <p>
                            <?php if(osc_user_phone_mobile() != '') { ?>
                                <?php if($cover_phone) { ?>
                                    <i class="fa fa-phone-square fa-fw cl-accent"></i> <a class="phone hidden" href="javascipt:void();" data-value="<?php echo osc_esc_html(osc_user_phone_mobile()); ?>"><?php echo substr(osc_user_phone_mobile(), 0, 3); ?>XXXXXX</a>
                                <?php } else { ?>
                                    <i class="fa fa-phone-square fa-fw cl-accent"></i> <a class="phone" href="tel:<?php echo osc_esc_html(osc_user_phone_mobile()); ?>"><?php osc_user_phone_mobile(); ?></a>
                                <?php } ?>
                            <?php } ?>
                            <?php if(osc_user_phone_land() != '') { ?>
                                <?php if($cover_phone) { ?>
                                    <i class="fa fa-home fa-fw cl-accent"></i> <a class="phone hidden" href="javascipt:void();" data-value="<?php echo osc_esc_html(osc_user_phone_land()); ?>"><?php echo substr(osc_user_phone_land(), 0, 3); ?>XXXXXX</a>
                                <?php } else { ?>
                                    <i class="fa fa-home fa-fw cl-accent"></i> <a class="phone" href="tel:<?php echo osc_esc_html(osc_user_phone_land()); ?>"><?php osc_user_phone_land(); ?></a>
                                <?php } ?>
                            <?php } ?>
                        </p>
                    <?php } ?>

                    <?php if(osc_item_show_email()) { ?>
                        <p>
                            <?php if($cover_email) { ?>
                                <i class="fa fa-envelope fa-fw cl-accent"></i> <a class="email hidden" href="javascipt:void();" data-value="<?php echo osc_esc_html(osc_item_contact_email()); ?>"><?php echo substr(osc_item_contact_email(), 0, 3); ?>@XXX.XXX</a>
                            <?php } else { ?>
                                <i class="fa fa-envelope fa-fw cl-accent"></i> <a class="email" href="mailto:<?php echo osc_esc_html(osc_item_contact_email()); ?>"><?php osc_item_contact_email(); ?></a>
                            <?php } ?>
                        </p>
                    <?php } ?>

                    <?php if(mtx_pref('ad_contact_form')) { ?>
                        <p class="mt-2 mb-0">
                            <a href="#" class="btn btn-mtx bg-darker" data-toggle="modal" data-target="#contact-modal"><?php _e('Message seller', 'matrix'); ?></a>
                        </p>
                    <?php } ?>
                </section>
                <section class="ad-user border">
                    <h3 class="bg-darker"><?php _e('User', 'matrix'); ?></h3>
                    <div class="user-card text-center">
                        <div class="user-img d-flex justify-content-center mb-3">
                            <img class="img-fluid" width="70" src="<?php echo mtx_user_profilepic_url(osc_item_user_id()); ?>" alt="<?php echo osc_esc_html(osc_item_contact_name()); ?>">
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
                <section class="ad-share border">
                    <?php $share_url = urlencode(osc_item_url()); ?>
                    <a class="btn-mtx bg-accent" href="https://facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" title="<?php echo osc_esc_html(sprintf(__('Share on %s', 'matrix'), 'Facebook')); ?>"><i class="fab fa-facebook"></i></a>
                    <a class="btn-mtx bg-accent" href="https://twitter.com/intent/tweet?text=<?php echo osc_esc_html(osc_item_title()).' - '.$share_url; ?>" title="<?php echo osc_esc_html(sprintf(__('Share on %s', 'matrix'), 'Twitter')); ?>"><i class="fab fa-twitter"></i></a>
                    <a class="btn-mtx bg-accent" href="https://pinterest.com/pin/create/button?url=<?php echo $share_url; ?>&media=<?php echo osc_resource_url(); ?>&description=<?php echo htmlspecialchars(osc_item_title()); ?>" title="<?php echo osc_esc_html(sprintf(__('Share on %s', 'matrix'), 'Pinterest')); ?>"><i class="fab fa-pinterest"></i></a>
                </section>
                <?php if($location != '') { ?>
                    <section class="ad-location border">
                        <h3 class="bg-darker"><?php _e('Map', 'matrix'); ?></h3>
                        <?php echo $location; ?>
                    </section>
                <?php } ?>
                <?php if((!osc_is_web_user_logged_in() || osc_logged_user_id() != osc_item_user_id()) && mtx_pref('ad_markas')) { ?>
                    <section class="ad-markas border">
                        <form action="<?php echo osc_base_url(1); ?>" method="POST" class="markas_form">
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="action" value="mark" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <select class="form-control" name="as" required onchange="$('.markas_form').submit();">
                                <option value=""><?php _e('Mark ad as...', 'matrix'); ?></option>
                                <option value="spam"><?php _e('Spam', 'matrix'); ?></option>
                                <option value="badcat"><?php _e('Misclassified', 'matrix'); ?></option>
                                <option value="repeated"><?php _e('Duplicated', 'matrix'); ?></option>
                                <option value="expired"><?php _e('Expired', 'matrix'); ?></option>
                                <option value="offensive"><?php _e('Offensive', 'matrix'); ?></option>
                            </select>
                        </form>
                    </section>
                <?php } ?>
                <section class="ad-misc border">
                    <h3 class="bg-darker"><?php _e('Misc info', 'matrix'); ?></h3>
                    <p class="mb-0"><i class="fa fa-hashtag fa-fw cl-accent"></i> <span><?php _e('ID', 'matrix'); ?></span>: #<?php echo osc_item_id(); ?></p>
                    <p class="mb-0"><i class="fa fa-calendar-alt fa-fw cl-accent"></i> <span><?php _e('Published', 'matrix'); ?></span>: <?php echo osc_format_date(osc_item_pub_date()); ?></p>
                    <p class="mb-0"><i class="fa fa-eye fa-fw cl-accent"></i> <span><?php _e('Views', 'matrix'); ?></span>: <?php echo osc_item_views(); ?></p>
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
