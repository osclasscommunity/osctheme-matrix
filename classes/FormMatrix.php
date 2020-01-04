<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class FormMatrix {
    static function input($type, $name, $id = '', $value = '', $label = '', $required = false, $inputmode = '', $attributes = '') {
        $id_ = ($id_ != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $value = ($value != '') ? 'value="'.osc_esc_html($value).'"' : '';
        $required = ($required) ? 'required' : '';
        $inputmode = ($inputmode != '') ? 'inputmode="'.osc_esc_html($inputmode).'"' : '';
        $placeholder = 'placeholder="'.__('Fill me...', 'matrix').'"'; // mtx_pref('input_placeholder');

        self::label($label, $id);
        echo '<input type="'.osc_esc_html($type).'" name="'.osc_esc_html($name).'" '.$value.' '.$id_.' '.$required.' '.$inputmode.' '.$attributes.' '.$placeholder.'>';
        self::line();
    }

    static function textarea($name, $id = '', $value = '', $label = '', $required = false, $attributes = '') {
        $id_ = ($id_ != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $value = ($value != '') ? osc_esc_html($value) : '';
        $required = ($required) ? 'required' : '';

        self::label($label, $id);
        echo '<textarea name="'.osc_esc_html($name).'" '.$id_.' '.$required.' '.$attributes.'>'.$value.'</textarea>';
        self::line();
    }

    static function select($name, $id = '', $items, $i_key, $i_val, $i_sel = '', $label = '', $required = false, $attributes = '') {
        $id_ = ($id_ != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $required = ($required) ? 'required' : '';

        self::label($label, $id);
        echo '<select name="'.osc_esc_html($name).'" '.$id_.' '.$required.' '.$attributes.'>';
        echo '<option value="">'.__('Select a option', 'matrix').'</option>';
        foreach($items as $item) {
            $selected = ($i_sel == $item[$i_key]) ? 'selected' : '';
            echo '<option value="'.osc_esc_html($item[$i_key]).'" '.$selected.'>'.$item[$i_val].'</option>';
        }
        echo '</select>';
        self::line();
    }

    static function checkbox($name, $id = '', $checked = false, $label = '', $required = false, $attributes = '') {
        $id_ = ($id_ != '') ? 'id="'.osc_esc_html($id).'"' : '';
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

        if($item == null) {
            $item = osc_item();
        }

        parent::label(__('Category', 'matrix'), 'catId');
        echo '<select name="catId" id="catId" required>';
        echo '<option value="">'.__('Select a option', 'matrix').'</option>';
        foreach($cats as $cat) {
            if(!osc_selectable_parent_categories() && !$parent_selectable) {
                echo '<optgroup label="'.$cat['s_name'].'">';
                if(isset($cat['categories']) && is_array($cat['categories'])) {
                    ItemForm::subcategory_select($cat['categories'], $item, 1);
                }
            } else {
                $selected = ((isset($item['fk_i_category_id']) && $item['fk_i_category_id'] == $cat['pk_i_id']) || (isset($category) && $category == $cat['pk_i_id'])) ? 'selected' : '';
                echo '<option value="'.$cat['pk_i_id'].'" '.$selected.'>'.$cat['s_name'].'</option>';
                if(isset($cat['categories']) && is_array($cat['categories'])) {
                    ItemForm::subcategory_select($cat['categories'], $item, 1);
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
                ItemForm::subcategory_select($cat['categories'], $item, $deep);
            }
        }
    }

    static public function title_description($locales = array(), $item = null) {
        if($locales == array()) {
            $locales = osc_get_locales();
        }
        if($item == null) {
            $item = osc_item();
        }

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

    static public function price($item, $currencies) {
        // if($item == null) {
        //     $item = osc_item();
        // }
        // if($currencies == null) {
        //     $currencies = osc_get_currencies();
        // }
        //
        // if(Session::newInstance()->_getForm('price') != '') {
        //     $item['i_price'] = Session::newInstance()->_getForm('price');
        // }
        // if(Session::newInstance()->_getForm('currency') != '') {
        //     $item['fk_c_currency_code'] = Session::newInstance()->_getForm('currency');
        // }
        //
        // parent::generic_input_text('price', (isset($item['i_price'])) ? osc_prepare_price($item['i_price']) : null);
        //
        // if(count($currencies) > 1) {
        //     $default_key = null;
        //     $currency = osc_get_preference('currency');
        //     if(isset($item['fk_c_currency_code'])) {
        //         $default_key = $item['fk_c_currency_code'];
        //     } elseif(isset($currency)) {
        //         $default_key = $currency;
        //     }
        //     parent::generic_select('currency', $currencies, 'pk_c_code', 's_description', null, $default_key);
        // } else if(count($currencies) == 1) {
        //     parent::generic_input_hidden("currency", $currencies[0]["pk_c_code"]);
        //     echo $currencies[0]['s_description'];
        // }
    }
}
?>
