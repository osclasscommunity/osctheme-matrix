<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-3">
    <div class="card ad premium <?php osc_run_hook('highlight_class'); ?> mb-3 h-100">
        <span class="ad-premium badge bg-accent text-white p-2"><?php _e('Premium', 'matrix'); ?></span>
        <?php if(osc_images_enabled_at_items()) { ?>
            <?php if(osc_count_premium_resources()) { ?>
                <img src="<?php echo osc_resource_thumbnail_url(); ?>" class="card-img-top" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>">
            <?php } else { ?>
                <img src="<?php echo osc_current_web_theme_url('images/nophoto.svg'); ?>" class="card-img-top" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>">
            <?php } ?>
        <?php } ?>
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

<!-- <li class="listing-card <?php echo $class; ?> premium">
    <div class="listing-detail">
        <div class="listing-cell">
            <div class="listing-data">
                <div class="listing-basicinfo">
                    <a href="<?php echo osc_premium_url() ; ?>" class="title" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><?php echo osc_premium_title() ; ?></a>
                    <div class="listing-attributes">
                        <span class="category"><?php echo osc_premium_category() ; ?></span> -
                        <span class="location"><?php echo osc_premium_city(); ?> <?php if(osc_premium_region()!='') { ?>(<?php echo osc_premium_region(); ?>)<?php } ?></span> <span class="g-hide">-</span> <?php echo osc_format_date(osc_premium_pub_date()); ?>
                        <?php if( osc_price_enabled_at_items() ) { ?><span class="currency-value"><?php echo osc_format_price(osc_premium_price(),osc_premium_currency_symbol()); ?></span><?php } ?>
                    </div>
                    <p><?php echo osc_highlight( osc_premium_description(), 250 ); ?></p>
                </div>
                <?php if($admin){ ?>
                    <span class="admin-options">
                        <a href="<?php echo osc_premium_edit_url(); ?>" rel="nofollow"><?php _e('Edit item', 'matrix'); ?></a>
                        <span>|</span>
                        <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'matrix')); ?>')" href="<?php echo osc_premium_delete_url();?>" ><?php _e('Delete', 'matrix'); ?></a>
                        <?php if(osc_premium_is_inactive()) {?>
                        <span>|</span>
                        <a href="<?php echo osc_premium_activate_url();?>" ><?php _e('Activate', 'matrix'); ?></a>
                        <?php } ?>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
</li> -->
