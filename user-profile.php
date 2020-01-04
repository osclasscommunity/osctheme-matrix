<?php
osc_add_hook('header', 'mtx_nofollow_construct');
mtx_add_body_class('user user-profile');

osc_current_web_theme_path('header.php');
UserForm::location_javascript();
$u = osc_user();
?>
<div class="container-fluid">
    <div class="row">
        <?php osc_current_web_theme_path('user-sidebar.php'); ?>
        <div class="bg-lighter col-md-9 col-xl-10">
            <section class="container user-account">
                <h1 class="title cl-accent-dark"><?php _e('My account', 'matrix'); ?></h1>
                <p class="subtitle cl-darker"><?php _e('Manage your account information.', 'matrix'); ?></p>

                <ul class="user-subnav nav nav-pills flex-column flex-lg-row mb-4">
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent-dark text-white" href="#"><?php _e('My account', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_email_url(); ?>"><?php _e('Change email', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_password_url(); ?>"><?php _e('Change password', 'matrix'); ?></a>
                    </li>
                    <li class="flex-sm-fill text-center nav-link">
                        <a class="nav-link btn-mtx bg-accent text-white" href="<?php echo osc_change_user_username_url(); ?>"><?php _e('Change username', 'matrix'); ?></a>
                    </li>
                </ul>

                <form action="<?php echo osc_base_url(1); ?>" method="POST">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="profile_post" />
                    <input type="hidden" name="b_company" id="company" value="<?php echo $u['b_company']; ?>" />

                    <div class="mtx-form-group">
                        <?php FormMatrix::input('text', 's_name', 'name', $u['s_name'], __('Name', 'matrix'), true); ?>
                    </div>
                    <div class="mtx-form-row">
                        <div class="col">
                            <?php FormMatrix::input('text', 's_phone_mobile', 'phone', $u['s_phone_mobile'], __('Mobile phone', 'matrix'), false, 'numeric'); ?>
                        </div>
                        <div class="col">
                            <?php FormMatrix::input('text', 's_phone_land', 'landline', $u['s_phone_land'], __('Phone', 'matrix'), false, 'numeric'); ?>
                        </div>
                    </div>

                    <div class="mtx-form-row">
                        <?php $countries = osc_get_countries(); ?>
                        <?php if(count($countries) > 1) { ?>
                            <div class="col">
                                <?php FormMatrix::select('countryId', 'countryId', $countries, 'pk_c_code', 's_name', $u['fk_c_country_code'], __('Country', 'matrix')); ?>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="countryId" id="countryId" value="" />
                            <div class="col">
                                <?php FormMatrix::input('text', 'country', 'country', ($u['s_country'] != '' ? $u['s_country'] : $countries[0]['s_name']), __('Country', 'matrix')); ?>
                            </div>
                        <?php } ?>

                        <?php $regions = osc_get_regions(); ?>
                        <?php if(count($regions) >= 1) { ?>
                            <div class="col">
                                <?php FormMatrix::select('regionId', 'regionId', $regions, 'pk_i_id', 's_name', $u['fk_i_region_id'], __('Region', 'matrix')); ?>
                            </div>
                        <?php } else { ?>
                            <div class="col">
                                <?php FormMatrix::input('text', 'region', 'regionId', $u['s_region'], __('Region', 'matrix')); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mtx-form-row">
                        <?php $cities = osc_get_cities(); ?>
                        <?php if(count($cities) >= 1) { ?>
                            <div class="col">
                                <?php FormMatrix::select('cityId', 'cityId', $cities, 'pk_i_id', 's_name', $u['fk_i_city_id'], __('City', 'matrix')); ?>
                            </div>
                        <?php } else { ?>
                            <div class="col">
                                <?php FormMatrix::input('text', 'city', 'cityId', $u['s_city'], __('City', 'matrix')); ?>
                            </div>
                        <?php } ?>

                        <div class="col">
                            <?php FormMatrix::input('text', 'cityArea', 'cityArea', $u['s_city_area'], __('City area', 'matrix')); ?>
                        </div>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::input('text', 'address', 'address', $u['s_address'], __('Address', 'matrix')); ?>
                    </div>

                    <div class="mtx-form-row">
                        <div class="col">
                            <?php FormMatrix::input('url', 's_website', 'website', $u['s_website'], __('Website', 'matrix')); ?>
                        </div>
                        <div class="col">
                            <label for="companySwitch"><?php _e('User type', 'matrix'); ?></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="companySwitch" <?php echo ($u['b_company']) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="companySwitch"><?php _e('Company', 'matrix'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="mtx-form-group">
                        <?php FormMatrix::textarea('s_info', 'description', $u['locale'][osc_locale_code()]['s_info'], __('Description', 'matrix')); ?>
                    </div>

                    <?php osc_run_hook('user_profile_form', $u); ?>
                    <?php osc_run_hook('user_form', $u); ?>

                    <div class="mtx-form-group form-submit">
                        <button type="submit" class="btn btn-mtx bg-accent"><?php _e('Update', 'matrix'); ?></button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script>
$(function() {
    $('#companySwitch').change(function() {
        $('#company').attr('value', + this.checked);
    });
});
</script>
<?php osc_current_web_theme_path('footer.php'); ?>
