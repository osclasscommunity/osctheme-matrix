<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class FormMatrix {
    static protected function input($type, $name, $value = '', $id = '', $class = 'form-control', $placeholder = '', $required = false, $inputmode = '', $attributes = '') {
        $value = ($value != '') ? 'value="'.osc_esc_html($value).'"' : '';
        $id = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $class = ($class != '') ? 'class="'.osc_esc_html($class).'"' : '';
        $placeholder = ($placeholder != '') ? 'placeholder="'.osc_esc_html($placeholder).'"' : '';
        $required = ($required) ? 'required' : '';
        $inputmode = ($inputmode != '') ? 'inputmode="'.osc_esc_html($inputmode).'"' : '';
        $attributes = ($attributes != '') ? osc_esc_html($attributes) : '';
        echo '<input type="'.osc_esc_html($type).'" name="'.osc_esc_html($name).'" '.$value.' '.$id.' '.$class.' '.$placeholder.' '.$required.' '.$inputmode.' '.$attributes.'>';
    }

    static protected function textarea($name, $value = '', $id = '', $class = 'form-control', $required = false, $attributes = '') {
        $value = ($value != '') ? 'value="'.osc_esc_html($value).'"' : '';
        $id = ($id != '') ? 'id="'.osc_esc_html($id).'"' : '';
        $class = ($class != '') ? 'class="'.osc_esc_html($class).'"' : '';
        $required = ($required) ? 'required' : '';
        $attributes = ($attributes != '') ? osc_esc_html($attributes) : '';
        echo '<textarea name="'.osc_esc_html($name).'" '.$id.' '.$class.' '.$required.' '.$attributes.'>'.$value.'</textarea>';
    }
}
?>
