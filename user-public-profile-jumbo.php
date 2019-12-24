<?php
$user_type = (osc_user_is_company()) ? __('company', 'matrix') : __('user', 'matrix');
?>
<section class="jumbo">
    <div class="jumbotron bg-darker text-white mb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-3 jumbo-margin">
                    <img src="//placehold.it/250x250" class="img-fluid"/>
                </div>
                <div class="col-md-9">
                    <h1 class="display-5"><?php printf(__('%s\'s profile', 'matrix'), osc_highlight(osc_user_name(), 20)); ?></h1>
                    <p class="lead"><?php printf(__('%s is a %s on %s.', 'matrix'), osc_user_name(), $user_type, osc_page_title()); ?></p>
                    <p class="mt-3"><?php echo mtx_loop_item_location(0, 1); ?></p>
                    <?php if(osc_user_address() != '') { ?>
                        <p><?php echo osc_user_address(); ?></p>
                    <?php } ?>
                    <?php if(osc_user_email() != '') { ?>
                        <p><a href="mailto:<?php echo osc_user_email(); ?>" rel="nofollow" target="_blank"><?php echo str_replace('@', ' (at) ', osc_user_email()); ?></a></p>
                    <?php } ?>
                    <?php if(osc_user_website() != '') { ?>
                        <p><a href="<?php echo osc_user_website(); ?>" rel="nofollow" target="_blank"><?php echo osc_user_website(); ?></a></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
