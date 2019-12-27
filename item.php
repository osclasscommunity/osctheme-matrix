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
                <section class="ad-description border mt-3">
                    <p class="mb-0"><?php echo osc_item_description(); ?></p>
                </section>
                <section class="ad-meta border mt-3">
                    <?php while (osc_has_item_meta()) { ?>
                        <?php if(osc_item_meta_value() != '') { ?>
                            <div class="meta">
                                <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </section>
                <section class="ad-plugin border mt-3">
                    <?php osc_run_hook('item_detail', osc_item()); ?>
                </section>
                <section class="ad-location border mt-3">
                    <?php osc_run_hook('location'); ?>
                </section>
            </div>
            <div class="col-md-4">
                <section class="ad-contact border">
                    <p>Content...</p>
                </section>
            </div>
        </div>
    </div>
</div>






<div id="item-content">
    <?php if( osc_comments_enabled() ) { ?>
        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
        <div id="comments">
            <h2><?php _e('Comments', 'matrix'); ?></h2>
            <ul id="comment_error_list"></ul>
            <?php if( osc_count_item_comments() >= 1 ) { ?>
                <div class="comments_list">
                    <?php while ( osc_has_item_comments() ) { ?>
                        <div class="comment">
                            <h3><strong><?php echo osc_comment_title(); ?></strong> <em><?php _e("by", 'matrix'); ?> <?php echo osc_comment_author_name(); ?>:</em></h3>
                            <p><?php echo nl2br( osc_comment_body() ); ?> </p>
                            <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                            <p>
                                <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'matrix'); ?>"><?php _e('Delete', 'matrix'); ?></a>
                            </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="paginate" style="text-align: right;">
                        <?php echo osc_comments_pagination(); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="form-container form-horizontal">
                <div class="header">
                    <h3><?php _e('Leave your comment (spam and offensive messages will be removed)', 'matrix'); ?></h3>
                </div>
                <div class="resp-wrapper">
                    <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                        <fieldset>

                            <input type="hidden" name="action" value="add_comment" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <?php if(osc_is_web_user_logged_in()) { ?>
                                <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                                <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                            <?php } else { ?>
                                <div class="control-group">
                                    <label class="control-label" for="authorName"><?php _e('Your name', 'matrix'); ?></label>
                                    <div class="controls">
                                        <?php CommentForm::author_input_text(); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="authorEmail"><?php _e('Your e-mail', 'matrix'); ?></label>
                                    <div class="controls">
                                        <?php CommentForm::email_input_text(); ?>
                                    </div>
                                </div>
                            <?php }; ?>
                            <div class="control-group">
                                <label class="control-label" for="title"><?php _e('Title', 'matrix'); ?></label>
                                <div class="controls">
                                    <?php CommentForm::title_input_text(); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="body"><?php _e('Comment', 'matrix'); ?></label>
                                <div class="controls textarea">
                                    <?php CommentForm::body_input_textarea(); ?>
                                </div>
                            </div>
                            <div class="actions">
                                <button type="submit"><?php _e('Send', 'matrix'); ?></button>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
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
