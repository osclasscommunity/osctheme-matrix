<?php
/**

DEFINES

*/
    define('MTX_VERSION', '100');
    if((string) osc_get_preference('keyword_placeholder', 'matrix') == "") {
        Params::setParam('keyword_placeholder', __('ie. PHP Programmer', 'matrix') ) ;
    }

    osc_register_script('jquery', 'https://code.jquery.com/jquery-3.4.1.slim.min.js');
    osc_register_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'));
    osc_register_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'));
    osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
    osc_enqueue_script('jquery');
    osc_enqueue_script('popper');
    osc_enqueue_script('bootstrap');
    osc_enqueue_script('fancybox');

    osc_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
    osc_enqueue_style('font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    osc_enqueue_style('matrix', osc_current_web_theme_url('css/main.css'));

    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('fancybox');

    // used for date/dateinterval custom fields
    osc_enqueue_script('php-date');
    osc_enqueue_script('jquery-fineuploader');


/**

FUNCTIONS

*/

    // install options
    if( !function_exists('mtx_theme_install') ) {
        function mtx_theme_install() {
            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'matrix');
            osc_set_preference('version', MTX_VERSION, 'matrix');
            osc_set_preference('footer_link', '1', 'matrix');
            osc_set_preference('donation', '0', 'matrix');
            osc_set_preference('defaultShowAs@all', 'list', 'matrix');
            osc_set_preference('defaultShowAs@search', 'list');
            osc_set_preference('defaultLocationShowAs', 'dropdown', 'matrix'); // dropdown / autocomplete
            osc_set_preference('rtl', '0', 'matrix');
            osc_reset_preferences();
        }
    }
    // update options
    if( !function_exists('mtx_theme_update') ) {
        function mtx_theme_update($current_version) {
            if($current_version==0) {
                mtx_theme_install();
            }
            osc_delete_preference('default_logo', 'matrix');

            $logo_prefence = osc_get_preference('logo', 'matrix');
            $logo_name     = 'mtx_logo';
            $temp_name     = WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.jpg';
            if( file_exists( $temp_name ) && !$logo_prefence) {

                $img = ImageResizer::fromFile($temp_name);
                $ext = $img->getExt();
                $logo_name .= '.'.$ext;
                $img->saveToFile(osc_uploads_path().$logo_name);
                osc_set_preference('logo', $logo_name, 'matrix');
            }
            osc_set_preference('version', '301', 'matrix');

            if($current_version<313 || $current_version=='3.0.1') {
                // add preferences
                osc_set_preference('defaultLocationShowAs', 'dropdown', 'matrix');
                osc_set_preference('version', '313', 'matrix');
            }
            osc_set_preference('version', '314', 'matrix');
            if($current_version<320 ) {
                // add preferences
                osc_set_preference('rtl', '0', 'matrix');
                osc_set_preference('version', '320', 'matrix');
            }
            osc_set_preference('version', '320', 'matrix');
            osc_reset_preferences();
        }
    }
    if(!function_exists('check_install_mtx_theme')) {
        function check_install_mtx_theme() {
            $current_version = osc_get_preference('version', 'matrix');
            //check if current version is installed or need an update<
            if( $current_version=='' ) {
                mtx_theme_update(0);
            } else if($current_version < MTX_VERSION){
                mtx_theme_update($current_version);
            }
        }
    }

    if(!function_exists('mtx_add_body_class_construct')) {
        function mtx_add_body_class_construct($classes){
            $matrixBodyClass = matrixBodyClass::newInstance();
            $classes = array_merge($classes, $matrixBodyClass->get());
            return $classes;
        }
    }
    if(!function_exists('mtx_body_class')) {
        function mtx_body_class($echo = true){
            /**
            * Print body classes.
            *
            * @param string $echo Optional parameter.
            * @return print string with all body classes concatenated
            */
            osc_add_filter('mtx_bodyClass','mtx_add_body_class_construct');
            $classes = osc_apply_filter('mtx_bodyClass', array());
            if($echo && count($classes)){
                echo 'class="'.implode(' ',$classes).'"';
            } else {
                return $classes;
            }
        }
    }
    if(!function_exists('mtx_add_body_class')) {
        function mtx_add_body_class($class){
            /**
            * Add new body class to body class array.
            *
            * @param string $class required parameter.
            */
            $matrixBodyClass = matrixBodyClass::newInstance();
            $matrixBodyClass->add($class);
        }
    }
    if(!function_exists('mtx_nofollow_construct')) {
        /**
        * Hook for header, meta tags robots nofollos
        */
        function mtx_nofollow_construct() {
            echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
            echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;

        }
    }
    if( !function_exists('mtx_follow_construct') ) {
        /**
        * Hook for header, meta tags robots follow
        */
        function mtx_follow_construct() {
            echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
            echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;

        }
    }
    /* logo */
    if( !function_exists('mtx_logo') ) {
        function mtx_logo($position = 'header') {
             $logo = osc_get_preference('logo','matrix');
             $html = '<img border="0" alt="' . osc_page_title() . '" src="' . mtx_logo_url() . '">';
             if( $logo!='' && file_exists( osc_uploads_path() . $logo ) ) {
                return $html;
             } else {
                return osc_page_title();
            }
        }
    }
    /* logo */
    if( !function_exists('mtx_logo_url') ) {
        function mtx_logo_url() {
            $logo = osc_get_preference('logo','matrix');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
            return false;
        }
    }
    if( !function_exists('mtx_draw_item') ) {
        function mtx_draw_item($class = false,$admin = false, $premium = false) {
            $filename = 'loop-single';
            if($premium){
                $filename .='-premium';
            }
            require WebThemes::newInstance()->getCurrentThemePath().$filename.'.php';
        }
    }
    if( !function_exists('mtx_show_as') ){
        function mtx_show_as(){

            $p_sShowAs    = Params::getParam('sShowAs');
            $aValidShowAsValues = array('list', 'gallery');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = mtx_default_show_as();
            }

            return $p_sShowAs;
        }
    }
    if( !function_exists('mtx_default_direction') ){
        function mtx_default_direction(){
            return getPreference('rtl','matrix');
        }
    }
    if( !function_exists('mtx_default_show_as') ){
        function mtx_default_show_as(){
            return getPreference('defaultShowAs@all','matrix');
        }
    }
    if( !function_exists('mtx_default_location_show_as') ){
        function mtx_default_location_show_as(){
            return osc_get_preference('defaultLocationShowAs','matrix');
        }
    }
    if( !function_exists('mtx_search_number') ) {
        /**
          *
          * @return array
          */
        function mtx_search_number() {
            $search_from = ((osc_search_page() * osc_default_results_per_page_at_search()) + 1);
            $search_to   = ((osc_search_page() + 1) * osc_default_results_per_page_at_search());
            if( $search_to > osc_search_total_items() ) {
                $search_to = osc_search_total_items();
            }

            return array(
                'from' => $search_from,
                'to'   => $search_to,
                'of'   => osc_search_total_items()
            );
        }
    }
    /*
     * Helpers used at view
     */
    if( !function_exists('mtx_item_title') ) {
        function mtx_item_title() {
            $title = osc_item_title();
            foreach( osc_get_locales() as $locale ) {
                if( Session::newInstance()->_getForm('title') != "" ) {
                    $title_ = Session::newInstance()->_getForm('title');
                    if( @$title_[$locale['pk_c_code']] != "" ){
                        $title = $title_[$locale['pk_c_code']];
                    }
                }
            }
            return $title;
        }
    }
    if( !function_exists('mtx_item_description') ) {
        function mtx_item_description() {
            $description = osc_item_description();
            foreach( osc_get_locales() as $locale ) {
                if( Session::newInstance()->_getForm('description') != "" ) {
                    $description_ = Session::newInstance()->_getForm('description');
                    if( @$description_[$locale['pk_c_code']] != "" ){
                        $description = $description_[$locale['pk_c_code']];
                    }
                }
            }
            return $description;
        }
    }
    if( !function_exists('related_listings') ) {
        function related_listings() {
            View::newInstance()->_exportVariableToView('items', array());

            $mSearch = new Search();
            $mSearch->addCategory(osc_item_category_id());
            $mSearch->addRegion(osc_item_region());
            $mSearch->addItemConditions(sprintf("%st_item.pk_i_id < %s ", DB_TABLE_PREFIX, osc_item_id()));
            $mSearch->limit('0', '3');

            $aItems      = $mSearch->doSearch();
            $iTotalItems = count($aItems);
            if( $iTotalItems == 3 ) {
                View::newInstance()->_exportVariableToView('items', $aItems);
                return $iTotalItems;
            }
            unset($mSearch);

            $mSearch = new Search();
            $mSearch->addCategory(osc_item_category_id());
            $mSearch->addItemConditions(sprintf("%st_item.pk_i_id != %s ", DB_TABLE_PREFIX, osc_item_id()));
            $mSearch->limit('0', '3');

            $aItems = $mSearch->doSearch();
            $iTotalItems = count($aItems);
            if( $iTotalItems > 0 ) {
                View::newInstance()->_exportVariableToView('items', $aItems);
                return $iTotalItems;
            }
            unset($mSearch);

            return 0;
        }
    }

    if( !function_exists('osc_is_contact_page') ) {
        function osc_is_contact_page() {
            if( Rewrite::newInstance()->get_location() === 'contact' ) {
                return true;
            }

            return false;
        }
    }

    if( !function_exists('get_breadcrumb_lang') ) {
        function get_breadcrumb_lang() {
            $lang = array();
            $lang['item_add']               = __('Publish a listing', 'matrix');
            $lang['item_edit']              = __('Edit your listing', 'matrix');
            $lang['item_send_friend']       = __('Send to a friend', 'matrix');
            $lang['item_contact']           = __('Contact publisher', 'matrix');
            $lang['search']                 = __('Search results', 'matrix');
            $lang['search_pattern']         = __('Search results: %s', 'matrix');
            $lang['user_dashboard']         = __('Dashboard', 'matrix');
            $lang['user_dashboard_profile'] = __("%s's profile", 'matrix');
            $lang['user_account']           = __('Account', 'matrix');
            $lang['user_items']             = __('Listings', 'matrix');
            $lang['user_alerts']            = __('Alerts', 'matrix');
            $lang['user_profile']           = __('Update account', 'matrix');
            $lang['user_change_email']      = __('Change email', 'matrix');
            $lang['user_change_username']   = __('Change username', 'matrix');
            $lang['user_change_password']   = __('Change password', 'matrix');
            $lang['login']                  = __('Login', 'matrix');
            $lang['login_recover']          = __('Recover password', 'matrix');
            $lang['login_forgot']           = __('Change password', 'matrix');
            $lang['register']               = __('Create a new account', 'matrix');
            $lang['contact']                = __('Contact', 'matrix');
            return $lang;
        }
    }

    if(!function_exists('user_dashboard_redirect')) {
        function user_dashboard_redirect() {
            $page   = Params::getParam('page');
            $action = Params::getParam('action');
            if($page=='user' && $action=='dashboard') {
                if(ob_get_length()>0) {
                    ob_end_flush();
                }
                header("Location: ".osc_user_list_items_url(), TRUE,301);
            }
        }
        osc_add_hook('init', 'user_dashboard_redirect');
    }

    if( !function_exists('get_user_menu') ) {
        function get_user_menu() {
            $options   = array();
            $options[] = array(
                'name' => __('Public Profile'),
                 'url' => osc_user_public_profile_url(),
               'class' => 'opt_publicprofile'
            );
            $options[] = array(
                'name'  => __('Listings', 'matrix'),
                'url'   => osc_user_list_items_url(),
                'class' => 'opt_items'
            );
            $options[] = array(
                'name' => __('Alerts', 'matrix'),
                'url' => osc_user_alerts_url(),
                'class' => 'opt_alerts'
            );
            $options[] = array(
                'name'  => __('Account', 'matrix'),
                'url'   => osc_user_profile_url(),
                'class' => 'opt_account'
            );
            $options[] = array(
                'name'  => __('Change email', 'matrix'),
                'url'   => osc_change_user_email_url(),
                'class' => 'opt_change_email'
            );
            $options[] = array(
                'name'  => __('Change username', 'matrix'),
                'url'   => osc_change_user_username_url(),
                'class' => 'opt_change_username'
            );
            $options[] = array(
                'name'  => __('Change password', 'matrix'),
                'url'   => osc_change_user_password_url(),
                'class' => 'opt_change_password'
            );
            $options[] = array(
                'name'  => __('Delete account', 'matrix'),
                'url'   => '#',
                'class' => 'opt_delete_account'
            );

            return $options;
        }
    }

    if( !function_exists('delete_user_js') ) {
        function delete_user_js() {
            $location = Rewrite::newInstance()->get_location();
            $section  = Rewrite::newInstance()->get_section();
            if( ($location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username',  'change_password', 'items'))) || (Params::getParam('page') ==='custom' && Params::getParam('in_user_menu')==true ) ) {
                osc_enqueue_script('delete-user-js');
            }
        }
        osc_add_hook('header', 'delete_user_js', 1);
    }

    if( !function_exists('user_info_js') ) {
        function user_info_js() {
            $location = Rewrite::newInstance()->get_location();
            $section  = Rewrite::newInstance()->get_section();

            if( $location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username',  'change_password', 'items')) ) {
                $user = User::newInstance()->findByPrimaryKey( Session::newInstance()->_get('userId') );
                View::newInstance()->_exportVariableToView('user', $user);
                ?>
<script type="text/javascript">
    matrix.user = {};
    matrix.user.id = '<?php echo osc_user_id(); ?>';
    matrix.user.secret = '<?php echo osc_user_field("s_secret"); ?>';
</script>
            <?php }
        }
        osc_add_hook('header', 'user_info_js');
    }

    function theme_mtx_actions_admin() {
        //if(OC_ADMIN)
        if( Params::getParam('file') == 'oc-content/themes/matrix/admin/settings.php' ) {
            if( Params::getParam('donation') == 'successful' ) {
                osc_set_preference('donation', '1', 'matrix');
                osc_reset_preferences();
            }
        }

        switch( Params::getParam('action_specific') ) {
            case('settings'):
                $footerLink  = Params::getParam('footer_link');

                osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'matrix');
                osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'matrix');
                osc_set_preference('defaultShowAs@all', Params::getParam('defaultShowAs@all'), 'matrix');
                osc_set_preference('defaultShowAs@search', Params::getParam('defaultShowAs@all'));

                osc_set_preference('defaultLocationShowAs', Params::getParam('defaultLocationShowAs'), 'matrix');

                osc_set_preference('header-728x90',         trim(Params::getParam('header-728x90', false, false, false)),                  'matrix');
                osc_set_preference('homepage-728x90',       trim(Params::getParam('homepage-728x90', false, false, false)),                'matrix');
                osc_set_preference('sidebar-300x250',       trim(Params::getParam('sidebar-300x250', false, false, false)),                'matrix');
                osc_set_preference('search-results-top-728x90',     trim(Params::getParam('search-results-top-728x90', false, false, false)),          'matrix');
                osc_set_preference('search-results-middle-728x90',  trim(Params::getParam('search-results-middle-728x90', false, false, false)),       'matrix');

                osc_set_preference('rtl', (Params::getParam('rtl') ? '1' : '0'), 'matrix');

                osc_add_flash_ok_message(__('Theme settings updated correctly', 'matrix'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/matrix/admin/settings.php'));
            break;
            case('upload_logo'):
                $package = Params::getFiles('logo');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'mtx_logo';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('logo', $logo_name, 'matrix');

                    osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'matrix'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'matrix'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/matrix/admin/header.php'));
            break;
            case('remove'):
                $logo = osc_get_preference('logo','matrix');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('logo','matrix');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The logo image has been removed', 'matrix'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'matrix'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/matrix/admin/header.php'));
            break;
        }
    }

    function mtx_redirect_user_dashboard()
    {
        if( (Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard') ) {
            header('Location: ' .osc_user_list_items_url());
            exit;
        }
    }

    function mtx_delete() {
        Preference::newInstance()->delete(array('s_section' => 'matrix'));
    }

    osc_add_hook('init', 'mtx_redirect_user_dashboard', 2);
    osc_add_hook('init_admin', 'theme_mtx_actions_admin');
    osc_add_hook('theme_delete_matrix', 'mtx_delete');
    osc_admin_menu_appearance(__('Header logo', 'matrix'), osc_admin_render_theme_url('oc-content/themes/matrix/admin/header.php'), 'header_matrix');
    osc_admin_menu_appearance(__('Theme settings', 'matrix'), osc_admin_render_theme_url('oc-content/themes/matrix/admin/settings.php'), 'settings_matrix');
/**

TRIGGER FUNCTIONS

*/
check_install_mtx_theme();

if(osc_is_home_page() || osc_is_search_page()){
    mtx_add_body_class('has-searchbox');
}


function mtx_sidebar_category_search($catId = null)
{
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

function mtx_print_sidebar_category_search($aCategories, $current_category = null, $i = 0)
{
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

/**

CLASSES

*/
class matrixBodyClass
{
    /**
    * Custom Class for add, remove or get body classes.
    *
    * @param string $instance used for singleton.
    * @param array $class.
    */
    private static $instance;
    private $class;

    private function __construct()
    {
        $this->class = array();
    }

    public static function newInstance()
    {
        if (  !self::$instance instanceof self)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($class)
    {
        $this->class[] = $class;
    }
    public function get()
    {
        return $this->class;
    }
}

/**

HELPERS

*/
if( !function_exists('osc_uploads_url')) {
    function osc_uploads_url($item = '') {
        $logo = osc_get_preference('logo', 'matrix');
        if ($logo != '' && file_exists(osc_uploads_path() . $logo)) {
            $path = str_replace(ABS_PATH, '', osc_uploads_path() . '/');
            return osc_base_url() . $path . $item;
        }
    }
}

/*

    ads  SEARCH

 */
if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn() {
        if(osc_get_preference('search-results-top-728x90', 'matrix')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-top-728x90', 'matrix');
            echo '</div>' . PHP_EOL;
        }
    }
}
//osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

if (!function_exists('search_ads_listing_medium_fn')) {
    function search_ads_listing_medium_fn() {
        if(osc_get_preference('search-results-middle-728x90', 'matrix')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-middle-728x90', 'matrix');
            echo '</div>' . PHP_EOL;
        }
    }
}
osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');

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

function mtx_loop_item($premium = false) {
  $file = 'loop-single';
  $file .= ($premium) ? '-premium' : '';

  require WebThemes::newInstance()->getCurrentThemePath().$file.'.php';
}
?>
