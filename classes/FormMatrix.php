<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class FormMatrix {
    static function input($type, $name, $id = '', $value = '', $label = '', $required = false, $inputmode = '', $attributes = '') {
        $id_ = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $value = ($value != '') ? 'value="'.osc_esc_html($value).'"' : '';
        $required = ($required) ? 'required' : '';
        $inputmode = ($inputmode != '') ? 'inputmode="'.osc_esc_html($inputmode).'"' : '';
        $placeholder = 'placeholder="'.__('Fill me...', 'matrix').'"'; // mtx_pref('input_placeholder');

        if($type != 'hidden') {
            self::label($label, $id);
        }

        echo '<input type="'.osc_esc_html($type).'" name="'.osc_esc_html($name).'" '.$value.' '.$id_.' '.$required.' '.$inputmode.' '.$attributes.' '.$placeholder.'>';

        if($type != 'hidden') {
            self::line();
        }
    }

    static function textarea($name, $id = '', $value = '', $label = '', $required = false, $attributes = '') {
        $id_ = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $value = ($value != '') ? osc_esc_html($value) : '';
        $required = ($required) ? 'required' : '';

        self::label($label, $id);
        echo '<textarea name="'.osc_esc_html($name).'" '.$id_.' '.$required.' '.$attributes.'>'.$value.'</textarea>';
        self::line();
    }

    static function select($name, $id = '', $items, $i_key, $i_val, $i_sel = '', $label = '', $required = false, $attributes = '', $assoc = true) {
        $id_ = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $required = ($required) ? 'required' : '';

        self::label($label, $id);
        echo '<select name="'.osc_esc_html($name).'" '.$id_.' '.$required.' '.$attributes.'>';
        echo '<option value="">'.__('Select a option', 'matrix').'</option>';

        if($assoc) {
            foreach($items as $item) {
                $selected = ($i_sel == $item[$i_key]) ? 'selected' : '';
                echo '<option value="'.osc_esc_html($item[$i_key]).'" '.$selected.'>'.$item[$i_val].'</option>';
            }
        } else {
            foreach($items as $item) {
                $selected = ($i_sel == $item) ? 'selected' : '';
                echo '<option value="'.osc_esc_html($item).'" '.$selected.'>'.$item.'</option>';
            }
        }
        echo '</select>';
        self::line();
    }

    static function checkbox($name, $id = '', $checked = false, $label = '', $required = false, $attributes = '') {
        $id_ = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $for = ($id != '') ? 'for="'.osc_esc_html($id).'"' : '';
        $checked = ($checked) ? 'checked' : '';
        $required = ($required) ? 'required' : '';

        echo '<input type="checkbox" name="'.osc_esc_html($name).'" '.$id_.' '.$checked.' '.$required.' '.$attributes.' class="custom-control-input">';
        echo '<label class="custom-control-label" '.$for.'>'.$label.'</label>';
    }

    static function label($label = '', $id = '') {
        if($label == '') {
            return;
        }

        $for = ($id != '') ? 'for="'.osc_esc_html($id).'"' : '';
        echo '<label '.$for.'>'.$label.'</label>';
    }

    static function line() {
        echo '<span class="input-line bg-accent"></span>';
    }
}

class FormMatrix_Item extends FormMatrix {
    static public function category_select() {
        $category = Params::getParam('catId');
        if(Session::newInstance()->_getForm('catId') != '') {
            $category = Session::newInstance()->_getForm('catId');
        }

        if($cats == null) {
            if(View::newInstance()->_exists('categories')) {
                $cats = View::newInstance()->_get('categories');
            } else {
                $cats = osc_get_categories();
            }
        }

        if(count($cats) == 1) {
            $parent_selectable = 1;
        }

        $item = osc_item();

        parent::label(__('Category', 'matrix'), 'catId');
        echo '<select name="catId" id="catId" required>';
        echo '<option value="">'.__('Select a option', 'matrix').'</option>';
        foreach($cats as $cat) {
            if(!osc_selectable_parent_categories() && !$parent_selectable) {
                echo '<optgroup label="'.$cat['s_name'].'">';
                if(isset($cat['categories']) && is_array($cat['categories'])) {
                    FormMatrix_Item::subcategory_select($cat['categories'], $item, 1);
                }
            } else {
                $selected = ((isset($item['fk_i_category_id']) && $item['fk_i_category_id'] == $cat['pk_i_id']) || (isset($category) && $category == $cat['pk_i_id'])) ? 'selected' : '';
                echo '<option value="'.$cat['pk_i_id'].'" '.$selected.'>'.$cat['s_name'].'</option>';
                if(isset($cat['categories']) && is_array($cat['categories'])) {
                    FormMatrix_Item::subcategory_select($cat['categories'], $item, 1);
                }
            }
        }
        echo '</select>';
        parent::line();
    }

    static public function subcategory_select($cats, $item, $deep = 0) {
        $category = Params::getParam('catId');
        if(Session::newInstance()->_getForm('catId') != '') {
            $category = Session::newInstance()->_getForm('catId');
        }

        $deep_string = '';
        for($n = 0; $n < $deep; $n++) {
            $deep_string .= '&nbsp;&nbsp;';
        }
        $deep++;

        foreach($cats as $cat) {
            $selected = ((isset($item['fk_i_category_id']) && $item['fk_i_category_id'] == $cat['pk_i_id']) || (isset($category) && $category == $cat['pk_i_id'])) ? 'selected' : '';
            echo '<option value="'.$cat['pk_i_id'].'" '.$selected.'>'.$deep_string.$cat['s_name'].'</option>';
            if(isset($cat['categories']) && is_array($cat['categories'])) {
                FormMatrix_Item::subcategory_select($cat['categories'], $item, $deep);
            }
        }
    }

    static public function title_description() {
        $locales = osc_get_locales();
        $item = osc_item();

        if(count($locales) == 1) {
            self::title_description_single($locales, $item);
        } else {
            echo '<ul class="nav nav-tabs justify-content-end" role="tablist">';
            foreach($locales as $key => $locale) {
                $code = $locale['pk_c_code'];
                $active = ($key == 0) ? 'active' : '';
                echo '<li class="nav-item">';
                echo '<a class="nav-link '.$active.'" id="locale-'.$code.'" data-toggle="tab" href="#input-'.$code.'" role="tab">'.$locale['s_name'].'</a>';
                echo '</li>';
            }
            echo '</ul>';
            echo '<div class="tab-content">';
            foreach($locales as $key => $locale) {
                $code = $locale['pk_c_code'];
                $active = ($key == 0) ? 'show active' : '';
                echo '<div class="tab-pane fade '.$active.'" id="input-'.$code.'" role="tabpanel">';

                $title = '';
                if(Session::newInstance()->_getForm('title') != '') {
                    $session = Session::newInstance()->_getForm('title');
                    if($session[$code] != '') {
                        $title = $session[$code];
                    }
                }
                if(is_array($item)) {
                    if(isset($item['locale'][$code]) && isset($item['locale'][$code]['s_title'])) {
                        $title = $item['locale'][$code]['s_title'];
                    }
                }

                self::title($code, $title, $locales);

                $description = '';
                if(Session::newInstance()->_getForm('description') != '') {
                    $session = Session::newInstance()->_getForm('description');
                    if($session[$code] != '') {
                        $description = $session[$code];
                    }
                }
                if(is_array($item)) {
                    if(isset($item['locale'][$code]) && isset($item['locale'][$code]['s_description'])) {
                        $description = $item['locale'][$code]['s_description'];
                    }
                }

                self::description($locale['pk_c_code'], $description, $locales);

                echo '</div>';
            }
            echo '</div>';
        }
    }

    static protected function title_description_single($locales, $item) {
        $locale = $locales[0];
        $code = $locale['pk_c_code'];

        $title = '';
        if(Session::newInstance()->_getForm('title') != '') {
            $session = Session::newInstance()->_getForm('title');
            if($session[$code] != '') {
                $title = $session[$code];
            }
        }
        if(is_array($item)) {
            if(isset($item['locale'][$code]) && isset($item['locale'][$code]['s_title'])) {
                $title = $item['locale'][$code]['s_title'];
            }
        }
        self::title($code, $title, $locales);

        $description = '';
        if(Session::newInstance()->_getForm('description') != '') {
            $session = Session::newInstance()->_getForm('description');
            if($session[$code] != '') {
                $description = $session[$code];
            }
        }
        if(is_array($item)) {
            if(isset($item['locale'][$code]) && isset($item['locale'][$code]['s_description'])) {
                $description = $item['locale'][$code]['s_description'];
            }
        }
        self::description($locale['pk_c_code'], $description, $locales);
    }

    static protected function title($locale = 'en_US', $value, $locales) {
        $required = ($locales[0]['pk_c_code'] == $locale);
        echo '<div class="desc-title">';
        parent::input('text', 'title['.$locale.']', 'title_'.$locale, $value, __('Title', 'matrix'), $required);
        echo '</div>';
    }

    static protected function description($locale = 'en_US', $value, $locales) {
        $required = ($locales[0]['pk_c_code'] == $locale);
        echo '<div>';
        parent::textarea('description['.$locale.']', 'description_'.$locale, $value, __('Description', 'matrix'), $required, 'rows="8"');
        echo '</div>';
    }

    static public function price() {
        $item = osc_item();
        $currencies = osc_get_currencies();

        if(Session::newInstance()->_getForm('price') != '') {
            $item['i_price'] = Session::newInstance()->_getForm('price');
        }
        if(Session::newInstance()->_getForm('currency') != '') {
            $item['fk_c_currency_code'] = Session::newInstance()->_getForm('currency');
        }

        echo '<div class="col-10">';
        parent::input('text', 'price', 'price', $item['i_price'], __('Price', 'matrix'), osc_price_enabled_at_items(), 'numeric');
        echo '</div>';

        echo '<div class="col-2">';
        if(count($currencies) > 1) {
            $default_key = null;
            $currency = osc_get_preference('currency');
            if(isset($item['fk_c_currency_code'])) {
                $default_key = $item['fk_c_currency_code'];
            } elseif(isset($currency)) {
                $default_key = $currency;
            }
            parent::select('currency', 'currency', $currencies, 'pk_c_code', 's_description', $default_key, __('Currency', 'matrix'), true);
        } else if(count($currencies) == 1) {
            parent::input('text', 'currency', 'currency', $currencies[0]['pk_c_code'], __('Currency', 'matrix'), true, 'numeric', 'disabled');
        }
        echo '</div>';
    }

    static public function country() {
        $item = osc_item();
        $countries = osc_get_countries();
        $required = mtx_pref('ad_required_country');

        if(count($countries) == 1) {
            $item['fk_c_country_code'] = $countries[0]['pk_c_code'];
        } else if(Session::newInstance()->_getForm('countryId') != '') {
            $item['fk_c_country_code'] = Session::newInstance()->_getForm('countryId');
        }
        if(Session::newInstance()->_getForm('country') != '') {
            $item['s_country'] = Session::newInstance()->_getForm('country');
        }

        if(count($countries) == 1) {
            parent::input('hidden', 'countryId', 'countryId', (isset($item['fk_c_country_code'])) ? $item['fk_c_country_code'] : null);
        } else if(count($countries) > 1) {
            parent::select('countryId', 'countryId', $countries, 'pk_c_code', 's_name', (isset($item['fk_c_country_code'])) ? $item['fk_c_country_code'] : null, __('Country', 'matrix'), $required);
        } else {
            parent::input('text', 'country', 'country', (isset($item['s_country'])) ? $item['s_country'] : null, __('Country', 'matrix'), $required);
        }
    }

    static public function region() {
        $item = osc_item();
        $required = mtx_pref('ad_required_region');
        if(Session::newInstance()->_getForm('countryId') != '') {
            $regions = Region::newInstance()->findByCountry(Session::newInstance()->_getForm('countryId'));
        } else if($item['fk_c_country_code'] != null) {
            $regions = Region::newInstance()->findByCountry($item['fk_c_country_code']);
        } else {
            $regions = Region::newInstance()->findByCountry(osc_get_countries()[0]['pk_c_code']); // mtx_def_country_code() !!!
        }

        if(Session::newInstance()->_getForm('regionId') != '') {
            $item['fk_i_region_id'] = Session::newInstance()->_getForm('regionId');
        }
        if(Session::newInstance()->_getForm('region') != '') {
            $item['s_region'] = Session::newInstance()->_getForm('region');
        }

        if(count($regions) == 1) {
            parent::input('hidden', 'regionId', 'regionId', (isset($item['fk_i_region_id'])) ? $item['fk_i_region_id'] : null);
        } else if(count($regions) > 1) {
            parent::select('regionId', 'regionId', $regions, 'pk_i_id', 's_name', (isset($item['fk_i_region_id'])) ? $item['fk_i_region_id'] : null, __('Region', 'matrix'), $required);
        } else {
            parent::input('text', 'region', 'region', (isset($item['s_region'])) ? $item['s_region'] : null, __('Region', 'matrix'), $required);
        }
    }

    static public function city() {
        $item = osc_item();
        $required = mtx_pref('ad_required_city');
        if(Session::newInstance()->_getForm('regionId') != '') {
            $cities = City::newInstance()->findByRegion(Session::newInstance()->_getForm('regionId'));
        } else if($item['fk_i_region_id'] != null) {
            $cities = City::newInstance()->findByRegion($item['fk_i_region_id']);
        } else {
            $cities = City::newInstance()->findByRegion(Region::newInstance()->findByCountry(osc_get_countries()[0]['pk_c_code'])[0]['pk_i_id']); // mtx_def_region_id() !!!
        }

        if(Session::newInstance()->_getForm('cityId') != '') {
            $item['fk_i_city_id'] = Session::newInstance()->_getForm('cityId');
        }
        if(Session::newInstance()->_getForm('city') != '') {
            $item['s_city'] = Session::newInstance()->_getForm('city');
        }

        if(count($cities) == 1) {
            parent::input('hidden', 'cityId', 'cityId', (isset($item['fk_i_city_id'])) ? $item['fk_i_city_id'] : null);
        } else if(count($cities) > 1) {
            parent::select('cityId', 'cityId', $cities, 'pk_i_id', 's_name', (isset($item['fk_i_city_id'])) ? $item['fk_i_city_id'] : null, __('City', 'matrix'), $required);
        } else {
            parent::input('text', 'city', 'city', (isset($item['s_city'])) ? $item['s_city'] : null, __('City', 'matrix'), $required);
        }
    }

    static public function cityArea() {
        $item = osc_item();
        $required = mtx_pref('ad_required_cityarea');

        if(Session::newInstance()->_getForm('cityArea') != '') {
            $item['s_city_area'] = Session::newInstance()->_getForm('cityArea');
        }

        parent::input('hidden', 'cityAreaId', 'cityAreaId', (isset($item['fk_i_city_area_id'])) ? $item['fk_i_city_area_id'] : null);
        parent::input('text', 'cityArea', 'cityArea', (isset($item['s_city_area'])) ? $item['s_city_area'] : null, __('City area', 'matrix'), $required);
    }

    static public function address() {
        $item = osc_item();
        $required = mtx_pref('ad_required_address');

        if(Session::newInstance()->_getForm('address') != '') {
            $item['s_address'] = Session::newInstance()->_getForm('address');
        }

        parent::input('text', 'address', 'address', (isset($item['s_address'])) ? $item['s_address'] : null, __('Address', 'matrix'), $required);
    }

    static public function zip() {
        $item = osc_item();
        $required = mtx_pref('ad_required_zip');

        if(Session::newInstance()->_getForm('zip') != '') {
            $item['s_zip'] = Session::newInstance()->_getForm('zip');
        }

        parent::input('text', 'zip', 'zip', (isset($item['s_zip'])) ? $item['s_zip'] : null, __('ZIP code', 'matrix'), $required);
    }

    static public function author() {
        $item = osc_item();
        $required = true;
        $attributes = '';

        if(Session::newInstance()->_getForm('contactName') != '') {
            $item['s_contact_name'] = Session::newInstance()->_getForm('contactName');
        } else if(osc_is_web_user_logged_in()) {
            $item['s_contact_name'] = osc_logged_user_name();
            $attributes = 'disabled';
        }

        parent::input('text', 'contactName', 'contactName', (isset($item['s_contact_name'])) ? $item['s_contact_name'] : null, __('Name', 'matrix'), $required, '', $attributes);
    }

    static public function phone() {
        $item = osc_item();
        $required = true;

        if(Session::newInstance()->_getForm('contactEmail') != '') {
            $item['s_contact_email'] = Session::newInstance()->_getForm('contactEmail');
        } else if(osc_is_web_user_logged_in()) {
            $item['s_contact_email'] = osc_logged_user_name();
            $attributes = 'disabled';
        }

        parent::input('text', 'contactPhone', 'contactPhone', (isset($item['s_contact_email'])) ? $item['s_contact_email'] : null, __('Phone', 'matrix'), $required, '', $attributes);
    }

    static public function email() {
        $item = osc_item();
        $required = true;

        if(Session::newInstance()->_getForm('contactEmail') != '') {
            $item['s_contact_email'] = Session::newInstance()->_getForm('contactEmail');
        } else if(osc_is_web_user_logged_in()) {
            $item['s_contact_email'] = osc_logged_user_name();
            $attributes = 'disabled';
        }

        parent::input('text', 'contactEmail', 'contactEmail', (isset($item['s_contact_email'])) ? $item['s_contact_email'] : null, __('E-mail', 'matrix'), $required, '', $attributes);
    }

    static public function meta($cat = null, $item = null) {
        $fields = Field::newInstance()->findByCategoryItem($cat, $item);
        if(count($fields) > 0) {
            echo '<div class="col meta">';
            foreach($fields as $field) {
                $class = ($field['e_type'] === 'CHECKBOX') ? 'mtx-form-group-cs custom-control custom-checkbox' : 'mtx-form-group';
                echo '<div class="'.$class.'">';
                self::metaField($field);
                echo '</div>';
            }
            echo '</div>';
        }
    }

    static public function metaField($field = null, $search = null) {
        if($field != null) {
            if($field['e_type'] === 'DATEINTERVAL') {
                $field['s_value'] = array('from' => '', 'to' => '');

                if(!$search) {
                    $aInterval = Field::newInstance()->getDateIntervalByPrimaryKey($field['fk_i_item_id'], $field['pk_i_id']);
                    if(is_array($aInterval) && !empty($aInterval) ) {
                        $temp['from'] = @$aInterval['from'];
                        $temp['to'] = @$aInterval['to'];
                        $field['s_value'] = $temp;
                    }
                } else {
                    $_meta = Params::getParam('meta');
                    $temp['from']= @(int) $_meta[$field['pk_i_id']]['from'];
                    $temp['to'] = @(int) $_meta[$field['pk_i_id']]['to'];
                    $field['s_value'] = $temp;
                }
            }

            if(Session::newInstance()->_getForm('meta_'.$field['pk_i_id']) != ''){
                $field['s_value'] = Session::newInstance()->_getForm('meta_'.$field['pk_i_id']);
            } else if(!isset($field['s_value']) || $field['s_value']=='') {
                $s_value = Params::getParam('meta');
                $field['s_value'] = '';
                if(isset($s_value[$field['pk_i_id']])) {
                    $field['s_value'] = $s_value[$field['pk_i_id']];
                }
            }

            switch($field['e_type']) {
                case 'TEXTAREA':
                    $field_textarea_value = isset($field['s_value']) ? $field['s_value'] : '';
                    $field_textarea_value = osc_apply_filter('osc_item_edit_meta_textarea_value_filter', $field_textarea_value, $field);
                    parent::textarea('meta['.$field['pk_i_id'].']', 'meta_'.$field['s_slug'], $field_textarea_value, $field['s_name'], $field['b_required']);
                break;
                case 'DROPDOWN':
                    parent::select('meta['.$field['pk_i_id'].']', 'meta_'.$field['s_slug'], explode(',', $field['s_options']), '', '', $field['s_value'], $field['s_name'], $field['b_required'], '', false);
                break;
                case 'RADIO':
                    if($search) {
                        // echo '<h6>'.$field['s_name'].'</h6>';
                        // if(isset($field) && isset($field['s_options'])) {
                        //     $options = explode( ',' , $field['s_options']);
                        //     if(count($options)>0) {
                        //         foreach($options as $key => $option) {
                        //             echo '<label for="meta_' . $field['s_slug'] . '_'.$key.'"><input type="radio" name="meta['.$field['pk_i_id'].']" id="meta_' . $field['s_slug'] . '_'.$key.'" value="'.osc_esc_html($option).'"'.($field['s_value']==$option?' checked="checked"':'').' />'.$option.'</label><br/>';
                        //         }
                        //     }
                        // }
                    } else {
                        // echo '<label for="meta_'.$field['s_slug'].'">'.$field['s_name'].': </label>';
                        // if(isset($field) && isset($field['s_options'])) {
                        //     $options = explode( ',' , $field['s_options']);
                        //     if(count($options)>0) {
                        //         echo '<ul>';
                        //         foreach($options as $key => $option) {
                        //             echo '<li><input type="radio" name="meta['.$field['pk_i_id'].']" id="meta_' . $field['s_slug'] . '_'.$key.'" value="'.osc_esc_html($option).'"'.($field['s_value']==$option?' checked="checked"':'').' /><label for="meta_' . $field['s_slug'] . '_'.$key.'">'.$option.'</label></li>';
                        //         }
                        //         echo '</ul>';
                        //     }
                        // }
                    }
                break;
                case 'CHECKBOX':
                    parent::checkbox('meta['.$field['pk_i_id'].']', 'meta_'.$field['s_slug'], $field['s_value'], $field['s_name'], $field['b_required']);
                break;
                case 'DATE':
                    /*
                    if($search) {
                        echo '<h6>'.$field['s_name'].'</h6>';
                    } else {
                        echo '<label for="meta_'.$field['s_slug'].'">'.$field['s_name'].': </label>';
                    }
                    // timestamp/1000 (javascript timestamp)
                    echo '<input type="hidden" id="meta_'.$field['s_slug'].'" name="meta['.$field['pk_i_id'].']" value="" />';
                    echo '<input type="text" id="" class="meta_'.$field['s_slug'].' cf_date" value="" />';
                    self::initDatePicker( 'meta_' . $field[ 's_slug' ] , osc_date_format() , $field[ 's_value' ] );
                    */
                break;
                case 'DATEINTERVAL':
                    /*
                    if($search) {
                        echo '<h6>'.$field['s_name'].'</h6>';
                    } else {
                        echo '<label for="meta_'.$field['s_slug'].'">'.$field['s_name'].': </label>';
                    }

                    echo __('from'). ' ';
                    echo '<input type="hidden" id="meta_'.$field['s_slug'].'_from" name="meta['.$field['pk_i_id'].'][from]" value="'.$field['s_value']['from'].'" />';
                    echo '<input type="text" id="" class="meta_'.$field['s_slug'].'_from cf_date_interval" value="" />';
                    self::initDatePicker( 'meta_' . $field[ 's_slug' ] . '_from' , osc_date_format() , $field[ 's_value' ][ 'from' ] , 'from' );

                    echo ' ' . __('to'). ' ';
                    echo '<input type="hidden" id="meta_'.$field['s_slug'].'_to" name="meta['.$field['pk_i_id'].'][to]" value="'.$field['s_value']['to'].'" />';
                    echo '<input type="text" id="" class="meta_'.$field['s_slug'].'_to cf_date_interval" value="" />';
                    self::initDatePicker( 'meta_' . $field[ 's_slug' ] . '_to' , osc_date_format() , $field[ 's_value' ][ 'to' ] , 'to' );
                    */
                break;
                default:
                    parent::input('text', 'meta['.$field['pk_i_id'].']', 'meta_'.$field['s_slug'].'', $field['s_value'], $field['s_name'], $field['b_required']);
                break;
            }
        }
    }
}
?>
