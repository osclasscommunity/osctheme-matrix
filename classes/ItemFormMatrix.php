<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class ItemFormMatrix extends FormMatrix {
    static public function title_description($locales = array(), $item = null) {
        if($locales == array()) {
            $locales = osc_get_locales();
        }
        if($item == null) {
            $item = osc_item();
        }

        foreach($locales as $locale) {
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
    }

    static protected function title($locale = 'en_US', $value, $locales) {
        $required = ($locales[0]['pk_c_code'] == $locale);
        parent::input('text', 'title['.$locale.']', $value, 'title_'.$locale, 'form-control', '', $required);
    }

    static protected function description($locale = 'en_US', $value, $locales) {
        $required = ($locales[0]['pk_c_code'] == $locale);
        parent::textarea('description['.$locale.']', $value, 'description_'.$locale, 'form-control', $required);
    }
}
?>
