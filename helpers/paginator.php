<?php
/**
 * Pagination 
 */
class Paginator {

    public $paging_url = '';

    function __construct($total, $current_page, $per_page = 9, $paging_url = '') {
        $this->total = $total;
        $this->set_page($current_page);
        $this->per_page = $per_page;
        $this->paging_url = $paging_url;
    }

    public function has_next_page() {
        return $this->current_page < $this->number_of_pages();
    }

    public function has_previous_page() {
        return $this->current_page > 1;
    }

    public function number_of_pages() {
        return ceil($this->total / $this->per_page);
    }

    public function offset() {
        return ($this->current_page - 1) * $this->per_page;
    }

    private function set_page($page) {
        $page = empty($page) ? 1 : $page;
        $page = $page < 1 ? 1 : $page;
        $this->current_page = $page;
    }

    public function get_next_page() {
        return $this->has_next_page() ? $this->current_page + 1 : $this->current_page;
    }

    public function get_prev_page() {
        return $this->has_previous_page() ? $this->current_page - 1 : $this->current_page;
    }

    /**
     *
     * @param type $query 
     */
    public function prep_query($query = "") {
        return $query . " LIMIT " . $this->offset() . " , " . $this->per_page . " ";
    }

    public function display($view = 'elements/flatlab_paginator') {
        Load::assign('paginator', $this);
        Load::view($view);
    }

}
?>