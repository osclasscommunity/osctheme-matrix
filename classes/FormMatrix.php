<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class FormMatrix {
    static function input($type, $name, $id = '', $value = '', $label = '', $required = false, $inputmode = '', $attributes = '') {
        $value = ($value != '') ? 'value="'.osc_esc_html($value).'"' : '';
        $for = ($id != '') ? 'for="'.osc_esc_html($id).'"' : '';
        $id = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $required = ($required) ? 'required' : '';
        $inputmode = ($inputmode != '') ? 'inputmode="'.osc_esc_html($inputmode).'"' : '';

        echo '<label '.$for.'>'.$label.'</label>';
        echo '<input type="'.osc_esc_html($type).'" name="'.osc_esc_html($name).'" '.$value.' '.$id.' '.$required.' '.$inputmode.' '.$attributes.'>';
        echo '<span class="input-line bg-accent"></span>';
    }

    static function textarea($name, $id = '', $value = '', $label = '', $required = false, $attributes = '') {
        $value = ($value != '') ? osc_esc_html($value) : '';
        $for = ($id != '') ? 'for="'.osc_esc_html($id).'"' : '';
        $id = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $required = ($required) ? 'required' : '';

        echo '<label '.$for.'>'.$label.'</label>';
        echo '<textarea name="'.osc_esc_html($name).'" '.$id.' '.$required.' '.$attributes.'>'.$value.'</textarea>';
        echo '<span class="input-line bg-accent"></span>';
    }

    static function select($name, $id = '', $items, $i_key, $i_val, $i_sel = '', $label = '', $required = false, $attributes = '') {
        $for = ($id != '') ? 'for="'.osc_esc_html($id).'"' : '';
        $id = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $required = ($required) ? 'required' : '';

        echo '<label '.$for.'>'.$label.'</label>';
        echo '<select name="'.osc_esc_html($name).'" '.$id.' '.$required.' '.$attributes.'>';
        echo '<option value="">'.__('Select a option', 'matrix').'</option>';
        foreach($items as $item) {
            $selected = ($i_sel == $item[$i_key]) ? 'selected' : '';
            echo '<option value="'.osc_esc_html($item[$i_key]).'" '.$selected.'>'.$item[$i_val].'</option>';
        }
        echo '</select>';
        echo '<span class="input-line bg-accent"></span>';
    }
}

class ItemFormMatrix extends FormMatrix {
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
        parent::input('text', 'title['.$locale.']', $value, 'title_'.$locale, 'form-control', __('Title', 'matrix'), $required);
    }

    static protected function description($locale = 'en_US', $value, $locales) {
        $required = ($locales[0]['pk_c_code'] == $locale);
        $value = ($value != '') ? $value : __('Description', 'matrix');
        parent::textarea('description['.$locale.']', $value, 'description_'.$locale, 'form-control', $required);
    }
}
?>
