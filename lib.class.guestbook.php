<?php

$path_core = __DIR__.'/../wbs_core/include_all.php';
if (file_exists($path_core )) include($path_core );
else echo "<script>console.log('Модуль wbs_guestbook требует модуль wbs_core')</script>";

if (!class_exists('ModGuestbook')) {
class ModGuestbook extends Addon {

    function __construct($page_id, $section_id) {
        parent::__construct('wbs_guestbook', $page_id, $section_id);
        $this->tbl_guestbook = "`".TABLE_PREFIX."mod_wbs_guestbook`";
        $this->tbl_rate = "`".TABLE_PREFIX."mod_wbs_guestbook_rate`";
        $this->tbl_settings = "`".TABLE_PREFIX."mod_wbs_guestbook_settings`";
    }

    function install() {
    }
    
    function uninstall() {
    }

    function add() {
        return insert_row($this->tbl_settings, ['section_id'=>$this->section_id, 'page_id'=>$this->page_id]);
    }
    
    function delete() {
        return delete_row($this->tbl_settings, glue_fields(['section_id'=>$this->section_id, 'page_id'=>$this->page_id], ' AND '));
    }
    
    /*function get_messages($sets, $only_count=false) {
    
        $tables = [$this->tbl_guestbook, $this->tbl_rate];
        
        $where = [$this->tbl_guestbook.".`rate_id`=".$this->tbl_rate.".`rate_id`"];
        
        if (isset($sets['is_active'])) $where[] = $this->tbl_guestbook.".`is_active`=".process_value($sets['is_active']);
        if (isset($sets['is_deleted'])) $where[] = $this->tbl_guestbook.".`is_deleted`=".process_value($sets['is_deleted']);
        if (isset($sets['rate_id']))   $where[] = $this->tbl_guestbook.".`rate_id`=".process_value($sets['rate_id']);
        if (isset($sets['guestbook_id']))   $where[] = $this->tbl_guestbook.".`guestbook_id`=".process_value($sets['guestbook_id']);
        if (isset($sets['section_id']))   $where[] = $this->tbl_guestbook.".`section_id`=".process_value($sets['section_id']);
        if (isset($sets['page_id']))   $where[] = $this->tbl_guestbook.".`page_id`=".process_value($sets['page_id']);
        if (isset($sets['obj_id']))   $where[] = $this->tbl_guestbook.".`obj_id`=".process_value($sets['obj_id']);
        
        $tables = implode(',', $tables);
        $where = implode(' AND ', $where);
        $order_limit = getobj_order_limit($sets);
        $select = $only_count ? "COUNT($this->tbl_guestbook.guestbook_id) AS count" : "*";
        $sql = "SELECT $select FROM $tables WHERE $where $order_limit";

        return getobj_return($sql, $only_count);
    }*/

   function get_messages($sets=[], $only_count=false) {

        $tables = [$this->tbl_guestbook, $this->tbl_rate];

        $where = [$this->tbl_guestbook.".`rate_id`=".$this->tbl_rate.".`rate_id`"];

        $where_opts = [
                'is_active'=>$this->tbl_guestbook.".`is_active`",
                'is_deleted'=>$this->tbl_guestbook.".`is_deleted`",
                'rate_id'=>$this->tbl_guestbook.".`rate_id`",
                'guestbook_id'=>$where[] = $this->tbl_guestbook.".`guestbook_id`",
                'section_id'=>$this->tbl_guestbook.".`section_id`",
                'page_id'=>$this->tbl_guestbook.".`page_id`",
                'obj_id'=>$this->tbl_guestbook.".`obj_id`",
        ];
        
        $where_find = ['title'=>"{$this->tbl_blog}.`title`", 'text'=>"{$this->tbl_blog}.`text`"];
        
        return get_obj($tables, $where, $where_opts, $where_find, $sets, $only_count);
    }
    
}
}
?>