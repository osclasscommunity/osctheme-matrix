<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-dashboard');

osc_current_web_theme_path('header.php');

View::newInstance()->_exportVariableToView('listAdmin', 1);
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="col-md-9 col-xl-10 bg-lighter">
            <section class="user-items">
                <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('Dashboard', 'matrix'); ?></h1>
                <p class="text-center cl-darker mb-5 col-12"><?php _e('Manage your account.', 'matrix'); ?></p>
            </section>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
