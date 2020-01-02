<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class ModelMatrix_Helper extends DAO {
    private static $instance;

    public static function newInstance() {
        if(!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct();
    }

    public function popularCategories($limit = 5) {
        $tCat = DB_TABLE_PREFIX.'t_category';
        $tStats = DB_TABLE_PREFIX.'t_category_stats';
        $tDesc = DB_TABLE_PREFIX.'t_category_description';

        $this->dao->select($tStats.'.fk_i_category_id as category_id, '.$tStats.'.i_num_items as items, '.$tDesc.'.s_name as category_name');
        $this->dao->from($tStats);
        $this->dao->join($tCat, $tStats.'.fk_i_category_id = '.$tCat.'.pk_i_id');
        $this->dao->join($tDesc, $tStats.'.fk_i_category_id = '.$tDesc.'.fk_i_category_id');
        $this->dao->where($tCat.'.fk_i_parent_id IS NULL');
        $this->dao->where($tStats.'.i_num_items > 0');
        $this->dao->where($tDesc.'.fk_c_locale_code', osc_current_user_locale());
        $this->dao->orderBy($tStats.'.i_num_items', 'DESC');
        $this->dao->limit(5);

        $result = $this->dao->get();
        if($result === false) {
            return array();
        }
        return $result->result();
    }

    public function categoryName($id) {
        $this->dao->select('s_name');
        $this->dao->from(DB_TABLE_PREFIX.'t_category_description');
        $this->dao->where('fk_i_category_id', $id);
        $this->dao->where('fk_c_locale_code', osc_current_user_locale());

        $result = $this->dao->get();
        if($result === false) {
            return array('s_name' => '');
        }

        return $result->row();
    }

    public function userSecret($id) {
        $this->dao->select('s_secret');
        $this->dao->from(DB_TABLE_PREFIX.'t_user');
        $this->dao->where('pk_i_id', $id);

        $result = $this->dao->get();
        if($result === false) {
            return array('s_secret' => '');
        }

        return $result->row();
    }
}
?>
