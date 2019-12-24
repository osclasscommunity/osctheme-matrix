<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-3">
    <div class="card ad <?php osc_run_hook('highlight_class'); ?> mb-3 h-100">
        <div class="card-img-wrap">
            <?php if(osc_item_is_premium()) { ?>
                <span class="ad-premium badge bg-accent text-white p-2"><?php _e('Premium', 'matrix'); ?></span>
            <?php } ?>
            <?php if(osc_images_enabled_at_items()) { ?>
                <div class="card-img-wrap">
                    <a href="<?php echo osc_item_url(); ?>">
                        <?php if(osc_count_item_resources()) { ?>
                            <img src="<?php echo osc_resource_thumbnail_url(); ?>" class="card-img-top" alt="<?php echo osc_esc_html(osc_item_title()); ?>">
                        <?php } else { ?>
                            <img src="<?php echo osc_current_web_theme_url('images/nophoto.svg'); ?>" class="card-img-top" alt="<?php echo osc_esc_html(osc_item_title()); ?>">
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="card-body text-center">
            <h5 class="card-title"><a href="<?php echo osc_item_url(); ?>" class="cl-darker"><?php echo osc_highlight(osc_item_title(), 100); ?></a></h5>
            <div class="card-text">
                <p class="ad-location"><?php echo mtx_loop_item_location(); ?></p>
                <p class="ad-price"><?php echo osc_item_formated_price(); ?></p>
            </div>
        </div>
        <div class="card-footer ad-actions">
            <?php if(View::newInstance()->_get('listAdmin')) { ?>
                <a href="<?php echo osc_item_delete_url(); ?>" class="btn btn-mtx bg-accent text-white w-50 h-100" onclick="javascript: return confirm(matrix.confirm);"><?php _e('Delete', 'matrix'); ?></a>
                <a href="<?php echo osc_item_edit_url(); ?>" class="btn btn-mtx bg-accent text-white w-50 h-100"><?php _e('Edit', 'matrix'); ?></a>
            <?php } else { ?>
                <a href="<?php echo osc_item_url(); ?>" class="btn btn-mtx bg-accent text-white w-50 h-100"><?php _e('More info', 'matrix'); ?></a>
                <a href="<?php echo osc_item_url(); ?>" class="btn btn-mtx bg-accent text-white w-50 h-100"><?php _e('Add to favorites', 'matrix'); ?></a>
            <?php } ?>
        </div>
    </div>
</div>
