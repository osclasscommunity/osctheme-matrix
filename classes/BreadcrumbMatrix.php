<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class BreadcrumbMatrix extends Breadcrumb {
    public $data;

    function __construct() {
        parent::__construct();
        $this->init();
        $this->data = $this->aLevel;
        $this->home();
        $this->hook();
    }

    function home() {
        if(count($this->data) > 0) {
            if($this->data[0]['title'] == osc_page_title()) {
                $this->data[0] = array('url' => osc_base_url(), 'title' => __('Home', 'matrix'));
            }
        }
    }

    function hook() {
        $this->data = osc_apply_filter('matrix_breadcrumb', $this->data);
    }
}
?>
