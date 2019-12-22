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
        <div class="col-md-9 col-xl-10 bg-lighter">
            <section class="container user-account">
                <h1 class="text-center cl-accent-dark mt-5 col-12"><?php _e('My account', 'matrix'); ?></h1>
                <p class="text-center cl-darker mb-5 col-12"><?php _e('Manage your account information.', 'matrix'); ?></p>

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

                    <div class="form-group">
                        <label for="name"><?php _e('Name', 'matrix'); ?></label>
                        <input type="text" name="s_name" class="form-control" id="name" placeholder="<?php _e('Your name, visible on ads.', 'matrix'); ?>" required value="<?php echo $u['s_name']; ?>">
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="phone"><?php _e('Phone', 'matrix'); ?></label>
                            <input type="text" name="s_phone_mobile" class="form-control" id="phone" placeholder="<?php _e('Your mobile phone number, visible on ads.', 'matrix'); ?>" inputmode="numeric" required value="<?php echo $u['s_phone_mobile']; ?>">
                        </div>
                        <div class="col">
                            <label for="landline"><?php _e('Landline', 'matrix'); ?></label>
                            <input type="text" name="s_phone_land" class="form-control" id="landline" placeholder="<?php _e('Your phone number, visible on ads.', 'matrix'); ?>" inputmode="numeric" value="<?php echo $u['s_phone_land']; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <?php $countries = osc_get_countries(); ?>
                        <?php if(count($countries) > 1) { ?>
                            <div class="col">
                                <label for="country"><?php _e('Country', 'matrix'); ?></label>
                                <select name="countryId" class="form-control" id="country">
                                    <option value=""><?php _e('Select a country', 'matrix'); ?></option>
                                    <?php foreach($countries as $country) { ?>
                                        <option value="<?php echo $country['pk_c_code']; ?>" <?php echo ($u['fk_c_country_code'] == $country['pk_c_code']) ? 'selected' : ''; ?>><?php echo $country['s_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="countryId" value="" />
                            <div class="col">
                                <label for="country"><?php _e('Country', 'matrix'); ?></label>
                                <input type="text" name="country" class="form-control" id="country" placeholder="<?php _e('Your country, visible on public profile.', 'matrix'); ?>" value="<?php echo ($u['s_country'] != '') ? $u['s_country'] : $countries[0]['s_name']; ?>">
                            </div>
                        <?php } ?>

                        <?php $regions = osc_get_regions(); ?>
                        <?php if(count($regions) >= 1) { ?>
                            <div class="col">
                                <label for="region"><?php _e('Region', 'matrix'); ?></label>
                                <select name="regionId" class="form-control" id="region">
                                    <option value=""><?php _e('Select a region', 'matrix'); ?></option>
                                    <?php foreach($regions as $region) { ?>
                                        <option value="<?php echo $region['pk_i_id']; ?>" <?php echo ($u['fk_i_region_id'] == $region['pk_i_id']) ? 'selected' : ''; ?>><?php echo $region['s_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="col">
                                <label for="region"><?php _e('Region', 'matrix'); ?></label>
                                <input type="text" name="region" class="form-control" id="region" placeholder="<?php _e('Your region, visible on public profile.', 'matrix'); ?>" value="<?php echo $u['s_country']; ?>">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-row">
                        <?php $cities = osc_get_cities(); ?>
                        <?php if(count($cities) >= 1) { ?>
                            <div class="col">
                                <label for="city"><?php _e('City', 'matrix'); ?></label>
                                <select name="cityId" class="form-control" id="city">
                                    <option value=""><?php _e('Select a city', 'matrix'); ?></option>
                                    <?php foreach($cities as $city) { ?>
                                        <option value="<?php echo $city['pk_i_id']; ?>" <?php echo ($u['fk_i_city_id'] == $city['pk_i_id']) ? 'selected' : ''; ?>><?php echo $city['s_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="col">
                                <label for="city"><?php _e('City', 'matrix'); ?></label>
                                <input type="text" name="city" class="form-control" id="city" placeholder="<?php _e('Your city, visible on public profile.', 'matrix'); ?>" value="<?php echo $u['s_city']; ?>">
                            </div>
                        <?php } ?>

                        <div class="col">
                            <label for="cityArea"><?php _e('City area', 'matrix'); ?></label>
                            <input type="text" name="cityArea" class="form-control" id="cityArea" placeholder="<?php _e('Your city area, visible on public profile.', 'matrix'); ?>" value="<?php echo $u['s_city_area']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address"><?php _e('Address', 'matrix'); ?></label>
                        <input type="text" name="address" class="form-control" id="address" placeholder="<?php _e('Your address, visible on public profile.', 'matrix'); ?>" value="<?php echo $u['s_address']; ?>">
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="website"><?php _e('Website', 'matrix'); ?></label>
                            <input type="url" name="s_website" class="form-control" id="website" placeholder="<?php _e('Your website, visible on public profile.', 'matrix'); ?>" value="<?php echo $u['s_website']; ?>">
                        </div>
                        <div class="col">
                            <label for="companySwitch"><?php _e('User type', 'matrix'); ?></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="companySwitch" <?php echo ($u['b_company']) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="companySwitch"><?php _e('Company', 'matrix'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description"><?php _e('Description', 'matrix'); ?></label>
                        <textarea name="s_info" class="form-control" id="description"><?php echo $u['locale'][osc_locale_code()]['s_info']; ?></textarea>
                    </div>

                    <?php osc_run_hook('user_profile_form', $u); ?>
                    <?php osc_run_hook('user_form', $u); ?>

                    <div class="form-group form-submit">
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
