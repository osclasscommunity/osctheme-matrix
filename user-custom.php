<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-custom');

osc_add_hook('before-main', function() {
    osc_current_web_theme_path('user-sidebar.php');
});


osc_current_web_theme_path('header.php');
osc_render_file();
osc_current_web_theme_path('footer.php');
?>
