<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title><?php echo meta_title() ; ?></title>
<meta name="title" content="<?php echo osc_esc_html(meta_title()); ?>" />
<?php if( meta_description() != '' ) { ?>
<meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
<?php } ?>
<?php if( meta_keywords() != '' ) { ?>
<meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
<?php } ?>
<?php if( osc_get_canonical() != '' ) { ?>
<!-- canonical -->
<link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
<!-- /canonical -->
<?php } ?>

<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- favicon -->
<link rel="shortcut icon" href="<?php echo osc_current_web_theme_url('favicon/favicon-48.png'); ?>">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo osc_current_web_theme_url('favicon/favicon-144.png'); ?>">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo osc_current_web_theme_url('favicon/favicon-114.png'); ?>">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo osc_current_web_theme_url('favicon/favicon-72.png'); ?>">
<link rel="apple-touch-icon-precomposed" href="<?php echo osc_current_web_theme_url('favicon/favicon-57.png'); ?>">
<!-- /favicon -->

<link href="<?php echo osc_current_web_theme_url('js/jquery-ui/jquery-ui-1.10.2.custom.min.css') ; ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    var matrix = window.matrix || {};
    matrix.base_url = '<?php echo osc_base_url(1); ?>';
    matrix.langs = <?php echo json_encode(array('delete' => __('Delete', 'matrix'), 'cancel' => __('Cancel', 'matrix'))); ?>;
    matrix.fancybox_prev = '<?php echo osc_esc_js(__('Previous image', 'matrix')); ?>';
    matrix.fancybox_next = '<?php echo osc_esc_js(__('Next image', 'matrix')); ?>';
    matrix.fancybox_closeBtn = '<?php echo osc_esc_js(__('Close', 'matrix')); ?>';
    matrix.repeat_password = '<?php echo osc_esc_js(__('Passwords aren\'t matching.', 'matrix')); ?>';
    matrix.confirm = '<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'matrix')); ?>';
</script>

<?php osc_run_hook('header') ; ?>

<!-- temporary -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Proza+Libre|Righteous&display=swap" rel="stylesheet">
