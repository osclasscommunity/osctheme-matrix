<div class="col-md-3 col-xl-2 bg-light">
    <section class="sidebar account-sidebar">
        <div class="p-3 pt-4 mb-4">
            <div class="media d-flex align-items-center"><img src="https://res.cloudinary.com/mhmd/image/upload/v1556074849/avatar-1_tcnd60.png" alt="..." width="65" class="mr-3 rounded-circle img-thumbnail shadow-sm">
                <div class="media-body">
                    <h4 class="m-0"><?php echo osc_user_name(); ?></h4>
                </div>
            </div>
        </div>

        <ul class="nav flex-column mb-0">
            <?php $skip = mtx_user_menu_skip(); ?>
            <?php foreach(mtx_user_menu_items(get_user_menu()) as $item) { ?>
                <?php if(in_array($item['class'], $skip)) continue; ?>
                <li class="nav-item">
                    <a href="<?php echo $item['url']; ?>" class="nav-link <?php echo $item['class']; ?>">
                        <i class="fa fa-th-large mr-3 text-primary fa-fw"></i> <?php echo $item['name']; ?>
                    </a>
                </li>
            <?php } ?>
            <?php osc_run_hook('user_menu'); ?>
        </ul>
    </section>
</div>
