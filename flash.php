<section class="flash bg-accent-dark text-white pb-2 pl-4 pr-4 pt-4">
    <div class="container">
        <?php foreach ($messages as $message) { ?>
            <?php if (isset($message['msg']) && $message['msg'] != '') { ?>
                <p class="<?php echo strtolower($class); ?> <?php echo strtolower($class).'-'.$message['type']; ?>">
                    <?php echo mtx_flash_icon($message); ?>
                    <span><?php echo osc_apply_filter('flash_message_text', $message['msg']); ?></span>
                </p>
            <?php } else if($message != '') { ?>
                <p class="<?php echo strtolower($class); ?>">
                    <?php echo mtx_flash_icon($message); ?>
                    <span><?php echo osc_apply_filter('flash_message_text', $message); ?></span>
                </p>
            <?php } ?>
        <?php } ?>
    </div>
</section>
