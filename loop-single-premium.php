<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-3">
    <div class="card ad premium <?php osc_run_hook('highlight_class'); ?> mb-3 h-100">
        <div class="card-img-wrap">
            <span class="ad-premium badge bg-accent text-white p-2"><?php _e('Premium', 'matrix'); ?></span>
            <?php if(osc_images_enabled_at_items()) { ?>
                <a href="<?php echo osc_item_url(); ?>">
                    <?php if(osc_count_premium_resources()) { ?>
                        <img src="<?php echo osc_resource_thumbnail_url(); ?>" class="card-img-top" alt="<?php echo osc_esc_html(osc_premium_title()); ?>">
                    <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/nophoto.svg'); ?>" class="card-img-top" alt="<?php echo osc_esc_html(osc_premium_title()); ?>">
                    <?php } ?>
                </a>
            <?php } ?>
        </div>
        <div class="card-body text-center">
            <h5 class="card-title"><a href="<?php echo osc_premium_url(); ?>" class="cl-darker"><?php echo osc_highlight(osc_premium_title(), 100); ?></a></h5>
            <div class="card-text">
                <p class="ad-location"><?php echo mtx_loop_item_location(1); ?></p>
                <p class="ad-price"><?php echo osc_premium_formated_price(); ?></p>
            </div>
        </div>
        <div class="card-footer ad-actions">
            <a href="<?php echo osc_premium_url(); ?>" class="btn btn-mtx bg-accent text-white w-50 h-100"><?php _e('More info', 'matrix'); ?></a>
            <a href="<?php echo osc_premium_url(); ?>" class="btn btn-mtx bg-accent text-white w-50 h-100"><?php _e('Add to favorites', 'matrix'); ?></a>
        </div>
    </div>
</div>
