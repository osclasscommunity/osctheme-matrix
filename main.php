<?php
osc_add_hook('header', 'mtx_follow_construct');
mtx_add_body_class('home');

$buttonClass = '';
$listClass   = '';
if(mtx_show_as() == 'gallery') {
    $listClass = 'listing-grid';
    $buttonClass = 'active';
}
?>
<?php osc_current_web_theme_path('header.php'); ?>

<section class="categories bg-lighter">
    <div class="container">
        <div class="row">
            <h2 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Categories', 'matrix'); ?></h2>
            <p class="text-center cl-darker mb-5 col-12"><?php _e('Browse our selection of ads through various categories.', 'matrix'); ?></p>
            <?php while(osc_has_categories()) { ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="category bg-lighty" onclick="window.location.href='<?php echo osc_search_url(['sCategory' => osc_category_id()]); ?>';">
                        <span class="category-count badge bg-accent text-white p-2"><?php echo osc_category_total_items(); ?> ads</span>
                        <div class="category-icon mt-4 mt-sm-2 mb-4">
                            <i class="fa fa-group cl-accent"></i>
                        </div>
                        <p class="category-title"><?php echo osc_category_name(); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php osc_get_premiums(8); ?>
<?php if(osc_count_premiums() > 0) { ?>
    <section class="spotlight">
        <div class="container">
            <div class="row">
                <h2 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Spotlight', 'matrix'); ?></h2>
                <p class="text-center cl-darker mb-5 col-12"><?php _e('Check our featured ads.', 'matrix'); ?></p>
                <?php while(osc_has_premiums()) { ?>
                    <?php mtx_loop_item(true); ?>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<section class="ribbon bg-darker">
    <div class="container">
        <div class="row">
            <h2 class="text-center text-white mt-5 col-12"><?php _e('Ribbon', 'matrix'); ?></h2>
            <p class="text-center cl-lighty mb-5 col-12"><?php _e('Because what\'s a modern theme without one?.', 'matrix'); ?></p>
            <div class="col-md-3 mb-10">
                <div class="ribbon-stat text-center text-white">
                    <span class="ribbon-count">61989</span>
                    <p class="ribbon-text">total ads</p>
                </div>
            </div>
            <div class="col-md-3 mb-10">
                <div class="ribbon-stat text-center text-white">
                    <span class="ribbon-count">79128</span>
                    <p class="ribbon-text">total users</p>
                </div>
            </div>
            <div class="col-md-3 mb-10">
                <div class="ribbon-stat text-center text-white">
                    <span class="ribbon-count">589</span>
                    <p class="ribbon-text">premium ads</p>
                </div>
            </div>
            <div class="col-md-3 mb-10">
                <div class="ribbon-stat text-center text-white">
                    <span class="ribbon-count">250000</span>
                    <p class="ribbon-text">monthly views</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(osc_count_latest_items() > 0) { ?>
    <section class="latest">
        <div class="container">
            <div class="row">
                <h2 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Newly added', 'matrix'); ?></h2>
                <p class="text-center cl-darker mb-5 col-12"><?php _e('Latest ads submitted by our users..', 'matrix'); ?></p>
                <?php while(osc_has_latest_items()) { ?>
                    <?php mtx_loop_item(false); ?>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php osc_current_web_theme_path('footer.php'); ?>
