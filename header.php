<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo mtx_default_direction()=='0' ? 'ltr': 'rtl'; ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
    </head>
    <body <?php mtx_body_class(); ?>>
        <header class="header">
            <nav class="navbar navbar-expand-lg navbar-dark bg-accent">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo osc_base_url(); ?>"><?php echo mtx_logo('header'); ?></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="<?php _e('Toggle navigation', 'matrix'); ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNav">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="<?php echo osc_base_url(); ?>"><?php _e('Home', 'matrix'); ?> <span class="sr-only">(<?php _e('current', 'matrix'); ?>)</span></a>
                            </li>

                            <li class="nav-item nav-contact">
                                <a class="nav-link" href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'matrix'); ?></a>
                            </li>

                            <?php if(osc_users_enabled() || (!osc_users_enabled() && !osc_reg_user_post())) { ?>
                                <li class="nav-item nav-publish">
                                    <a class="nav-link" href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e('Post an ad', 'matrix'); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <ul class="navbar-nav my-2 my-lg-0">
                            <?php if(osc_users_enabled()) { ?>
                                <?php if(osc_is_web_user_logged_in()) { ?>
                                    <li class="nav-item nav-welcome">
                                        <?php echo sprintf(__('Hi %s', 'matrix'), osc_logged_user_name() . '!'); ?>
                                    </li>
                                    <li class="nav-item nav-account">
                                        <a href="<?php echo osc_user_dashboard_url(); ?>" class="nav-link"><?php _e('My account', 'matrix'); ?></a>
                                    </li>
                                    <li class="nav-item nav-logout">
                                        <a href="<?php echo osc_user_logout_url(); ?>" class="nav-link"><?php _e('Logout', 'matrix'); ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="nav-item nav-login">
                                        <a href="<?php echo osc_user_login_url(); ?>" class="nav-link text-white"><?php _e('Login', 'matrix'); ?></a>
                                    </li>
                                    <?php if(osc_user_registration_enabled()) { ?>
                                        <li class="nav-item nav-register">
                                            <a href="<?php echo osc_register_account_url(); ?>" class="nav-link text-white"><?php _e('Register', 'matrix'); ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php mtx_flash(); ?>

            <section class="jumbo">
                <div class="jumbotron bg-darker text-white mb-0">
                    <div class="container">
                        <div class="row">
                            <div class="jumbo-text col-md-8">
                                <h1 class="display-4"><?php _e('Modern & open-source', 'matrix'); ?></h1>
                                <p class="lead"><?php _e('Osclass theme', 'matrix'); ?></p>
                                <p class="mt-5"><?php _e('What are you waiting for?', 'matrix'); ?></p>
                                <p class="lead">
                                    <a class="btn btn-lg btn-mtx bg-accent text-white" href="#" role="button"><?php _e('Post an ad', 'matrix'); ?></a>
                                </p>
                            </div>
                            <div class="jumbo-search col-md-4">
                                <form action="<?php echo osc_base_url(1); ?>" method="GET" class="nocsrf text-white bg-accent">
                                    <input type="hidden" name="page" value="search"/>
                                    <div class="p-4">
                                        <div class="form-group">
                                            <label for="sPattern"><?php _e('Query', 'matrix'); ?></label>
                                            <input type="text" class="form-control" id="sPattern" name="sPattern" placeholder="<?php echo osc_esc_html(osc_get_preference('keyword_placeholder', 'matrix')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="sCategory"><?php _e('Category', 'matrix'); ?></label>
                                            <?php mtx_search_category_select(); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-mtx bg-accent-dark text-white w-100"><?php _e('Search', 'matrix'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </header>

        <?php osc_show_widgets('header'); ?>

        <?php osc_run_hook('before-main'); ?>
        <main class="main">
            <?php osc_run_hook('inside-main'); ?>
