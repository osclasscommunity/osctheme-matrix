<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('ad ad-post');


if(Params::getParam('action') == 'item_add') {
    $action = 'item_add_post';
    $edit = 0;
} else {
    $action = 'item_edit_post';
    $edit = 1;
}

osc_current_web_theme_path('header.php');

ItemForm::location_javascript();
?>
<section class="login bg-lighter">
    <div class="container">
        <div class="row">
            <h1 class="title cl-accent-dark"><?php _e('Post an ad', 'matrix'); ?></h1>
            <p class="subtitle cl-darker"><?php _e('Publish your ad on our site and get hundreds of views.', 'matrix'); ?></p>
        </div>

        <div class="row justify-content-center">
            <div class="col-9">
                <form action="<?php echo osc_base_url(1); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="page" value="item" />
                    <input type="hidden" name="action" value="<?php echo $action; ?>" />
                    <?php if($edit) { ?>
                        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                        <input type="hidden" name="secret" value="<?php echo osc_item_secret(); ?>" />
                    <?php } ?>

                    <section class="adpost-category border">
                        <h3 class="bg-darker"><?php _e('Category', 'matrix'); ?></h3>
                        <label><?php _e('Pick a category that best suits your product or service.', 'matrix'); ?></label>
                        <div class="mtx-form-group single">
                            <?php FormMatrix_Item::category_select(); ?>
                        </div>
                    </section>

                    <section class="adpost-description border">
                        <h3 class="bg-darker"><?php _e('Description', 'matrix'); ?></h3>
                        <label><?php _e('Describe your product or service to the seller.', 'matrix'); ?></label>
                        <div class="mtx-form-group single">
                            <?php FormMatrix_Item::title_description(); ?>
                        </div>
                    </section>

                    <?php if(osc_price_enabled_at_items()) { ?>
                        <section class="adpost-price border">
                            <h3 class="bg-darker"><?php _e('Price', 'matrix'); ?></h3>
                            <label><?php _e('Price your product or service.', 'matrix'); ?></label>
                            <div class="mtx-form-row single">
                                <?php FormMatrix_Item::price(); ?>
                            </div>
                        </section>
                    <?php } ?>

                    <?php if(osc_images_enabled_at_items()) { ?>
                        <section class="adpost-photos border">
                            <h3 class="bg-darker"><?php _e('Photos', 'matrix'); ?></h3>
                            <label><?php _e('Still not sure what I will do with photo uploader. Perhaps a custom uploader is too much. Fineuploader 3.8 sucks tho.', 'matrix'); ?></label>
                            <div class="mtx-form-row single">
                                <?php // ItemForm::ajax_photos(); ?>
                            </div>
                        </section>
                    <?php } ?>

                    <section class="adpost-location border">
                        <h3 class="bg-darker"><?php _e('Location', 'matrix'); ?></h3>
                        <label><?php _e('Where are you located?', 'matrix'); ?></label>
                        <div class="mtx-form-group">
                            <?php FormMatrix_Item::country(); ?>
                        </div>
                        <div class="mtx-form-group">
                            <?php FormMatrix_Item::region(); ?>
                        </div>
                        <div class="mtx-form-row">
                            <div class="col-6">
                                <?php FormMatrix_Item::city(); ?>
                            </div>
                            <div class="col-6">
                                <?php FormMatrix_Item::zip(); ?>
                            </div>
                        </div>
                        <div class="mtx-form-row">
                            <div class="col-6">
                                <?php FormMatrix_Item::cityArea(); ?>
                            </div>
                            <div class="col-6">
                                <?php FormMatrix_Item::address(); ?>
                            </div>
                        </div>
                    </section>

                    <section class="adpost-author border">
                        <h3 class="bg-darker"><?php _e('Author', 'matrix'); ?></h3>
                        <label><?php _e('Your contact info', 'matrix'); ?></label>
                        <div class="mtx-form-row">
                            <div class="col-4">
                                <?php FormMatrix_Item::author(); ?>
                            </div>
                            <div class="col-4">
                                <?php FormMatrix_Item::phone(); ?>
                            </div>
                            <div class="col-4">
                                <?php FormMatrix_Item::email(); ?>
                            </div>
                        </div>
                    </section>

                    <section class="adpost-plugins border">
                        <h3 class="bg-darker"><?php _e('Details', 'matrix'); ?></h3>
                        <label><?php _e('More info about the ad', 'matrix'); ?></label>
                        <?php
                        if($edit) {
                            ItemForm::plugin_edit_item();
                        } else {
                            ItemForm::plugin_post_item();
                        }
                        ?>
                    </section>

                    <?php if(osc_recaptcha_items_enabled()) { ?>
                        <div class="mtx-form-group form-captcha">
                            <?php osc_show_recaptcha(); ?>
                        </div>
                    <?php } ?>

                    <div class="mtx-form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php echo (!$edit) ? __('Publish', 'matrix') : __('Save', 'matrix'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('#price').bind('hide-price', function(){
        $('.control-group-price').hide();
    });

    $('#price').bind('show-price', function(){
        $('.control-group-price').show();
    });

    <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
        $().ready(function(){
            $("#price").blur(function(event) {
                var price = $("#price").prop("value");
                <?php if(osc_locale_thousands_sep()!='') { ?>
                while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                    price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
                }
                <?php }; ?>
                <?php if(osc_locale_dec_point()!='') { ?>
                var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
                if(tmp.length>2) {
                    price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
                }
                <?php }; ?>
                $("#price").prop("value", price);
            });
        });
    <?php }; ?>
</script>
<?php osc_current_web_theme_path('footer.php'); ?>
