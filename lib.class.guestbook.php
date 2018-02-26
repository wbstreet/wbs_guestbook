<?php

$path_core = __DIR__.'/../wbs_core/include_all.php';
if (file_exists($path_core )) include($path_core );
else echo "<script>console.log('Модуль wbs_guestbook требует модуль wbs_core')</script>";

if (!class_exists('ModGuestbook')) {
class ModGuestbook extends Addon {

    function __construct($page_id, $section_id) {
        parent::__construct('wbs_guestbook', $page_id, $section_id);
        $this->tbl_guestbook = "`".TABLE_PREFIX."mod_wbs_guestbook`";
        $this->tbl_guestbook_rate = "`".TABLE_PREFIX."mod_wbs_guestbook_rate`";
    }

    function install() {
    }
    
    function uninstall() {
    }
    
    function get_messages($sets, $only_count) {
    
        $tables = [$this->tbl_guestbook, $this->tbl_guestbook_rate];
        
        $where = [$this->tbl_guestbook.".`rate_id`=".$this->tbl_guestbook_rate.".`rate_id`"];
        
        if (isset($sets['is_active'])) $where[] = $this->tbl_guestbook.".`is_active`=".process_value($sets['is_active']);
        if (isset($sets['rate_id']))   $where[] = $this->tbl_guestbook.".`rate_id`=".process_value($sets['rate_id']);
        if (isset($sets['guestbook_id']))   $where[] = $this->tbl_guestbook.".`guestbook_id`=".process_value($sets['guestbook_id']);
        if (isset($sets['section_id']))   $where[] = $this->tbl_guestbook.".`section_id`=".process_value($sets['section_id']);
        if (isset($sets['page_id']))   $where[] = $this->tbl_guestbook.".`page_id`=".process_value($sets['page_id']);
        
        $tables = implode(',', $tables);
        $where = implode(' AND ', $where);
        $order_limit = $this->_getobj_order_limit($sets);
        $select = $only_count ? "COUNT($this->tbl_guestbook.guestbook_id) AS count" : "*";
        $sql = "SELECT $select FROM $tables WHERE $where $order_limit";

        return $this->_getobj_return($sql, $only_count);
    }
  
}
}
?>