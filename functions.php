<?php
define('MTX_VERSION', '100');
require 'classes/ModelMatrix.php';
require 'classes/BreadcrumbMatrix.php';
require 'classes/BodyClassMatrix.php';

if(!OC_ADMIN) {
    osc_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js');
    osc_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', array('jquery'));
    osc_register_script('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'));
    osc_register_script('matrix', osc_current_web_theme_js_url('global.js'), 'jquery');
    osc_enqueue_script('jquery');
    osc_enqueue_script('jquery-ui');
    osc_enqueue_script('popper');
    osc_enqueue_script('bootstrap');
    osc_enqueue_script('fancybox');
    osc_enqueue_script('matrix');

    osc_enqueue_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css');
    osc_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css');
    osc_enqueue_style('matrix', osc_current_web_theme_url('css/main.css'));
}
osc_enqueue_script('php-date');


function mtx_theme_install() {
    osc_set_preference('version', MTX_VERSION, 'matrix');
    osc_reset_preferences();
}

function mtx_theme_update($current_version) {
    if($current_version == 0) {
        mtx_theme_install();
    }
}

function check_install_mtx_theme() {
    $current_version = osc_get_preference('version', 'matrix');
    if($current_version == '') {
        mtx_theme_update(0);
    } else if($current_version < MTX_VERSION){
        mtx_theme_update($current_version);
    }
}

function mtx_body_class($echo = true) {
    $classes = BodyClassMatrix::newInstance()->get();
    $classes = osc_apply_filter('mtx_body_class', $classes);

    if(count($classes)) {
        echo 'class="'.implode(' ',$classes).'"';
    } else {
        echo 'page';
    }
}

function mtx_add_body_class($class) {
    BodyClassMatrix::newInstance()->add($class);
}

function mtx_nofollow_construct() {
    echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
    echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;

}

function mtx_follow_construct() {
    echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
    echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;
}

function mtx_logo($position = 'header') {
    $logo = osc_get_preference('logo', 'matrix');
    if($logo != '' && file_exists(osc_uploads_path().$logo)) {
        return '<img border="0" alt="'.osc_page_title().'" src="'.osc_uploads_url($logo).'">';
    } else {
        return osc_page_title();
    }
}

function mtx_draw_item($class = '', $admin = false, $premium = false) {
    $filename = 'loop-single';
    if($premium){
        $filename .= '-premium';
    }

    require WebThemes::newInstance()->getCurrentThemePath().$filename.'.php';
}

function mtx_search_number() {
    $search_from = ((osc_search_page() * osc_default_results_per_page_at_search()) + 1);
    $search_to = ((osc_search_page() + 1) * osc_default_results_per_page_at_search());
    if($search_to > osc_search_total_items()) {
        $search_to = osc_search_total_items();
    }

    return array('from' => $search_from, 'to' => $search_to, 'of' => osc_search_total_items());
}

if(!function_exists('osc_is_contact_page') ) {
    function osc_is_contact_page() {
        return Rewrite::newInstance()->get_location() === 'contact';
    }
}


check_install_mtx_theme();


function mtx_sidebar_category_search($catId = null) {
    $aCategories = array();
    if($catId==null) {
        $aCategories[] = Category::newInstance()->findRootCategoriesEnabled();
    } else {
        // if parent category, only show parent categories
        $aCategories = Category::newInstance()->toRootTree($catId);
        end($aCategories);
        $cat = current($aCategories);
        // if is parent of some category
        $childCategories = Category::newInstance()->findSubcategoriesEnabled($cat['pk_i_id']);
        if(count($childCategories) > 0) {
            $aCategories[] = $childCategories;
        }
    }

    if(count($aCategories) == 0) {
        return "";
    }

    mtx_print_sidebar_category_search($aCategories, $catId);
}

function mtx_print_sidebar_category_search($aCategories, $current_category = null, $i = 0) {
    $class = '';
    if(!isset($aCategories[$i])) {
        return null;
    }

    if($i===0) {
        $class = 'class="category"';
    }

    $c   = $aCategories[$i];
    $i++;
    if(!isset($c['pk_i_id'])) {
        echo '<ul '.$class.'>';
        if($i==1) {
            echo '<li><a href="'.osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))).'">'.__('All categories', 'matrix')."</a></li>";
        }
        foreach($c as $key => $value) {
    ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($value['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $value['pk_i_id'], 'iPage'=>null))); ?>">
                <?php if(isset($current_category) && $current_category == $value['pk_i_id']){ echo '<strong>'.$value['s_name'].'</strong>'; }
                else{ echo $value['s_name']; } ?>
                </a>

            </li>
    <?php
        }
        if($i==1) {
        echo "</ul>";
        } else {
        echo "</ul>";
        }
    } else {
    ?>
    <ul <?php echo $class;?>>
        <?php if($i==1) { ?>
        <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=>null, 'iPage'=>null))); ?>"><?php _e('All categories', 'matrix'); ?></a></li>
        <?php } ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($c['pk_i_id']);?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory'=> $c['pk_i_id'], 'iPage'=>null))); ?>">
                <?php if(isset($current_category) && $current_category == $c['pk_i_id']){ echo '<strong>'.$c['s_name'].'</strong>'; }
                      else{ echo $c['s_name']; } ?>
                </a>
                <?php mtx_print_sidebar_category_search($aCategories, $current_category, $i); ?>
            </li>
        <?php if($i==1) { ?>
        <?php } ?>
    </ul>
<?php
    }
}


if(!function_exists('osc_uploads_url')) {
    function osc_uploads_url($item = '') {
        $path = str_replace(ABS_PATH, '', osc_uploads_path().'/');
        return osc_base_url() . $path . $item;
    }
}


if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn() {
        return false;
    }
}

/**
 * Does the defined category have subcategories?
 *
 * @param array $category Category.
 *
 * @return boolean Has categories.
 */
function mtx_category_has_sub($category) {
    if(array_key_exists('categories', $category)) {
        if(is_array($category['categories'])) {
            if(count($category['categories'])) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Renders search category select.
 *
 * @param int $selected Selected category ID.
 *
 * @return string Formatted item location.
 */
function mtx_search_category_select($selected = null) {
    ?>
    <select name="sCategory" id="sCategory" class="form-control">
        <option value=""><?php _e('Select a category', 'matrix'); ?></option>
        <?php foreach(Category::newInstance()->toTree() as $category) { ?>
            <option value="<?php echo $category['pk_i_id']; ?>" <?php echo ($category['pk_i_id'] == $selected) ? 'selected' : ''; ?> class="categoryselect-parent"><?php echo $category['s_name']; ?></option>
            <?php mtx_search_category_select_sub($category, $selected, 1); ?>
        <?php } ?>
    </select>
    <?php
}

/**
 * Renders search subcategory select.
 *
 * @param array $category Parent category.
 * @param int $selected Selected category ID.
 * @param int $deep Subcategory level.
 *
 * @return string Formatted item location.
 */
function mtx_search_category_select_sub($category, $selected, $deep) {
    if(mtx_category_has_sub($category)) {
        $deep_string = '';
        for($n = 0; $n < $deep; $n++) {
            $deep_string .= '&nbsp;&nbsp;';
        }
        $deep++;

        foreach($category['categories'] as $category) { ?>
            <option value="<?php echo $category['pk_i_id']; ?>" <?php echo ($category['pk_i_id'] == $selected) ? 'selected' : ''; ?>><?php echo $deep_string.$category['s_name']; ?></option>
            <?php mtx_search_category_select_sub($category, $selected, $deep); ?>
        <?php }
    }
}

/**
 * Renders a single item in a loop.
 *
 * @param boolean $premium Is item premium.
 */
function mtx_loop_item($premium = false) {
    $file = 'loop-single';
    $file .= ($premium) ? '-premium' : '';

    require WebThemes::newInstance()->getCurrentThemePath().$file.'.php';
}

/**
 * Gets formatted item location.
 *
 * @param boolean $premium Is item premium.
 *
 * @return string Formatted item location.
 */
function mtx_loop_item_location($premium = false, $user = false) {
    if(!$user) {
        if(!$premium) {
            $country = osc_item_country();
            $region = osc_item_region();
            $city = osc_item_city();
        } else {
            $country = osc_premium_country();
            $region = osc_premium_region();
            $city = osc_premium_city();
        }
    } else {
        $country = osc_user_country();
        $region = osc_user_region();
        $city = osc_user_city();
    }

    if($country != '') {
        if(strlen($country) == 2) {
            $country = Country::newInstance()->findByCode($country)['s_name'];
        }

        if($region != '') {
            if($city != '') {
                return $city. ' '.__('in', 'matrix').' '.$region.' ('.$country.')';
            } else {
                return $region.' ('.$country.')';
            }
        } else {
            if($city != '') {
                return $city.' ('.$country.')';
            } else {
                return $country;
            }
        }
    } else {
        if($region != '') {
            if($city != '') {
                return $city.' '.__('in', 'matrix').' '.$region;
            } else {
                return $region;
            }
        } else {
            if($city != '') {
                return $city;
            } else {
                return __('Unknown location', 'matrix');
            }
        }
    }
}

/**
 * Renders flash message (modified HTML).
 *
 * @param string $section Message section (Osclass default param).
 * @param string $class HTML class (Osclass default param).
 */
function mtx_flash($section = 'pubMessages', $class = 'flashmessage') {
	$messages = Session::newInstance()->_getMessage($section);
	if(is_array($messages)) {
        require WebThemes::newInstance()->getCurrentThemePath().'flash.php';
	}

	Session::newInstance()->_dropMessage($section);
}

/**
 * Gets HTML for flash message icon.
 *
 * @param array $message Message array. Required for type.
 *
 * @return string Icon HTML.
 */
function mtx_flash_icon($message) {
    if(isset($message['type'])) {
        switch($message['type']) {
            case 'error':
                return '<i class="fa fa-fw fa-exclamation-circle"></i>';
            break;
            case 'ok':
                return '<i class="fa fa-fw fa-check-circle"></i>';
            break;
            case 'info':
                return '<i class="fa fa-fw fa-info-circle"></i>';
            break;
            case 'warning':
                return '<i class="fa fa-fw fa-exclamation-triangle"></i>';
            break;
        }
    }

    return '<i class="fa fa-fw fa-info-circle"></i>';
}

/**
 * Gets most popular locations.
 *
 * Are there any regions? Return the most popular ones. Are there any cities? Return the most popular ones. Are there any countries? Return the most popular ones.
 * Otherwise return 'empty' array.
 *
 * @return array
 */
function mtx_popular_locations() {
    $data = RegionStats::newInstance()->listRegions('%%%%', '>', 'i_num_items DESC');
    if(count($data)) {
        return array('type' => 'region', 'data' => $data);
    }

    $data = CityStats::newInstance()->listCities(null, '>', 'i_num_items DESC');
    if(count($data)) {
        return array('type' => 'city', 'data' => $data);
    }

    $data = CountryStats::newInstance()->listCountries('>', 'i_num_items DESC');
    if(count($data)) {
        return array('type' => 'country', 'data' => $data);
    }

    return array('type' => null, 'data' => array(array('null' => null)));
}

/**
 * Parses a popular location.
 *
 * Returns name and URL of a popular location in popular locations loop.
 *
 * @param array $location Location data.
 * @param string $type Type of location. Can be sCountry, sRegion, sCity or null if there are no locations.
 *
 * @return array
 */
function mtx_popular_locations_parse($location, $type) {
    $data = array();
    switch($type) {
        case 'country':
            $data['s_name'] = $location['country_name'];
            $data['s_url'] = osc_search_url(array('sCountry' => $location['country_code']));
        break;
        case 'region':
            $data['s_name'] = $location['region_name'];
            $data['s_url'] = osc_search_url(array('sRegion' => $location['region_id']));
        break;
        case 'city':
            $data['s_name'] = $location['city_name'];
            $data['s_url'] = osc_search_url(array('sCity' => $location['city_id']));
        break;
        default:
            $data['s_name'] = __('No locations', 'matrix');
            $data['s_url'] = osc_search_url();
        break;
    }

    return $data;
}

/**
 * Gets most popular categories.
 *
 * @return array
 */
function mtx_popular_categories() {
    $data = ModelMatrix_Helper::newInstance()->popularCategories();
    if(count($data)) {
        return $data;
    }

    return array();
}

/**
 * Gets user account menu items.
 *
 * Based on osc_private_user_menu from helpers/hUtils.php
 *
 * @param array $menu Menu items.
 *
 * @return array
 */
function mtx_user_menu_items() {
    $action = Params::getParam('action');
    $menu = array();
    $menu[] = array(
        'name' => __('Ads'),
        'url' => osc_user_list_items_url(),
        'class' => 'opt_items',
        'icon' => 'fa-list-alt',
        'active' => ($action == 'items')
    );
    $menu[] = array(
        'name' => __('Alerts'),
        'url' => osc_user_alerts_url(),
        'class' => 'opt_alerts',
        'icon' => 'fa-clock',
        'active' => ($action == 'alerts')
    );
    $menu[] = array(
        'name' => __('Account'),
        'url' => osc_user_profile_url(),
        'class' => 'opt_account',
        'icon' => 'fa-cog',
        'active' => ($action == 'profile')
    );

    $menu = osc_apply_filter('user_menu_filter', $menu);

    $menu[] = array(
        'name' => __('Public Profile'),
        'url' => osc_user_public_profile_url(osc_logged_user_id()),
        'class' => 'opt_publicprofile',
        'icon' => 'fa-globe-europe',
        'active' => 0
    );
    $menu[] = array(
        'name' => __('Delete account'),
        'url' => osc_base_url(1).'?page=user&action=delete&id='.osc_user_id().'&secret='.osc_user()['s_secret'],
        'class' => 'opt_delete_account',
        'icon' => 'fa-user-times',
        'attr' => 'onclick="javascript: return confirm(matrix.confirm);"',
        'active' => 0
    );
    $menu[] = array(
        'name' => __('Logout'),
        'url' => osc_user_logout_url(),
        'class' => 'opt_logout',
        'icon' => 'fa-sign-out-alt',
        'active' => 0
    );

    return $menu;
}

/**
 * Returns class for menu item if active.
 *
 * @param array $item Menu item.
 *
 * @return string
 */
function mtx_user_menu_active($item) {
    if(isset($item['active'])) {
        return ($item['active']) ? 'bg-accent-dark' : '';
    } else {
        return '';
    }
}

/**
 * Returns attributes for menu item if exist.
 *
 * @param array $item Menu item.
 *
 * @return string
 */
function mtx_user_menu_attr($item) {
    if(isset($item['attr'])) {
        return $item['attr'];
    } else {
        return '';
    }
}

/**
 * Returns icon for menu item if exists, otherwise returns default icon.
 *
 * @param array $item Menu item.
 *
 * @return string
 */
function mtx_user_menu_icon($item) {
    if(isset($item['icon'])) {
        return $item['icon'];
    } else {
        return 'fa-chevron-right';
    }
}

/**
 * Sets user account items per page to 12.
 */
function mtx_user_items_perpage() {
    if(Params::getParam('action') == 'items') {
        Params::setParam('itemsPerPage', 12);
    }
}
osc_add_hook('init_user', 'mtx_user_items_perpage');

/**
 * Sets public profile items per page to 12.
 */
function mtx_profile_items_perpage() {
     if(Params::getParam('action') == 'pub_profile') {
         Params::setParam('itemsPerPage', 12);
     }
 }
 osc_add_hook('init_user_non_secure', 'mtx_profile_items_perpage');

/**
 * Redirects user dashboard to items page.
 */
function mtx_user_dashboard_redirect() {
    if(Params::getParam('action') == 'dashboard') {
        osc_redirect_to(osc_user_list_items_url());
    }
}
osc_add_hook('init_user', 'mtx_user_dashboard_redirect');

/**
 * Parses alert record from database into (some) search parameters.
 *
 * @param array $alert Alert object.
 *
 * @return array Formatted data.
 */
function mtx_user_alert_parse_details($alert) {
     $details = (array) json_decode($alert['s_search']);
     $formatted = array();

     $formatted[] = array('name' => __('Created', 'matrix'), 'value' => osc_format_date($alert['dt_date']));

     if($details['sPattern'] != null) {
         $formatted[] = array('name' => __('Keywords', 'matrix'), 'value' => $details['sPattern']);
     }

     if($details['price_min'] != 0) {
         $formatted[] = array('name' => __('Min price', 'matrix'), 'value' => $details['price_min']);
     }

     if($details['price_max'] != 0) {
         $formatted[] = array('name' => __('Max price', 'matrix'), 'value' => $details['price_max']);
     }

     if(count($details['aCategories']) > 0) {
         $name = ModelMatrix_Helper::newInstance()->categoryName($details['aCategories'][0]);
         $formatted[] = array('name' => __('Category', 'matrix'), 'value' => $name['s_name']);
     }

     return $formatted;
}
