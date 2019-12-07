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
                <div class="col-md-3">
                    <div class="categories-item bg-lighty">
                        <span class="categories-count badge bg-accent text-white p-2 col-3"><?php echo osc_category_total_items(); ?> ads</span>
                        <div class="categories-icon mt-2 mb-4">
                            <i class="fa fa-group cl-accent"></i>
                        </div>
                        <p class="categories-title"><?php echo osc_category_name(); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>











<div class="clear"></div>
<div class="latest_ads">
<h1><strong><?php _e('Latest Listings', 'matrix') ; ?></strong></h1>
 <?php if( osc_count_latest_items() == 0) { ?>
    <div class="clear"></div>
    <p class="empty"><?php _e("There aren't listings available at this moment", 'matrix'); ?></p>
<?php } else { ?>
    <div class="actions">
      <span class="doublebutton <?php echo $buttonClass; ?>">
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=list" class="list-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('List', 'matrix'); ?></span></a>
           <a href="<?php echo osc_base_url(true); ?>?sShowAs=gallery" class="grid-button" data-class-toggle="listing-grid" data-destination="#listing-card-list"><span><?php _e('Grid', 'matrix'); ?></span></a>
      </span>
    </div>
    <?php
    View::newInstance()->_exportVariableToView("listType", 'latestItems');
    View::newInstance()->_exportVariableToView("listClass",$listClass);
    osc_current_web_theme_path('loop.php');
    ?>
    <div class="clear"></div>
    <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
        <p class="see_more_link"><a href="<?php echo osc_search_show_all_url() ; ?>">
            <strong><?php _e('See all listings', 'matrix') ; ?> &raquo;</strong></a>
        </p>
    <?php } ?>
<?php } ?>
</div>
</div><!-- main -->
<div id="sidebar">
    <?php if( osc_get_preference('sidebar-300x250', 'matrix') != '') { ?>
    <!-- sidebar ad 350x250 -->
    <div class="ads_300">
        <?php echo osc_get_preference('sidebar-300x250', 'matrix'); ?>
    </div>
    <!-- /sidebar ad 350x250 -->
    <?php } ?>
    <div class="widget-box">
        <?php if(osc_count_list_regions() > 0 ) { ?>
        <div class="box location">
            <h3><strong><?php _e("Location", 'matrix') ; ?></strong></h3>
            <ul>
            <?php while(osc_has_list_regions() ) { ?>
                <li><a href="<?php echo osc_list_region_url(); ?>"><?php echo osc_list_region_name() ; ?> <em>(<?php echo osc_list_region_items() ; ?>)</em></a></li>
            <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
</div>
<div class="clear"><!-- do not close, use main clossing tag for this case -->
<?php if( osc_get_preference('homepage-728x90', 'matrix') != '') { ?>
<!-- homepage ad 728x60-->
<div class="ads_728">
    <?php echo osc_get_preference('homepage-728x90', 'matrix'); ?>
</div>
<!-- /homepage ad 728x60-->
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>
