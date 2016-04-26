<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PagePagination
 *
 * @author rostom
 */
class PagePagination {

    //put your code here

    public $_queries;
    public $_page;
    public $_limit;
    public $_results;
    public $_total;

    public function __construct() {
        $this->_queries = new queries();
    }

    public function GetPageData(array $data = NULL) {

        if ($data != NULL) {
            $this->_limit = $data['limit'];
            $this->_page = $data['page'];

            $l = ($this->_page - 1) * $this->_limit;

            /*
             * First get total
             */


            $fields = array(
                "field1" => $data['field1'],
                "field2" => $data['field2']
            );
            $values = array(
                "value1" => $data['value1'],
                "value2" => $data['value2'],
                "value3" => $l,
                "value4" => $this->_limit
            );
            /*
             * Number of rows
             */
            $table = $data['table'];
            $get_num_rows = $this->_queries->GetData($table, $fields, $values, $data['option1']);
            $this->_total = $get_num_rows;
            /*
             * Data
             */
            $this->_queries->_res = NULL;
            $get_page_data = $this->_queries->GetData($table, $fields, $values, $data['option2']);
            $get_page_data = $this->_queries->RetData();

            $this->_results[] = $get_page_data;
        }
    }

    public function createLinks($links, $list_class) {
        if ($this->ReturnLimit() == 'all') {
            return '';
        }

        $last = ceil($this->ReturnTotal() / $this->ReturnLimit());

        $start = ( ( $this->ReturnPage() - $links ) > 0 ) ? $this->ReturnPage() - $links : 1;
        $end = ( ( $this->ReturnPage() + $links ) < $last ) ? $this->ReturnPage() + $links : $last;

        $html = '<ul class="' . $list_class . '">';

        $class = ( $this->ReturnPage() == 1 ) ? "disabled" : "";
        $disabled = ( $this->ReturnPage() == 1 ) ? "onclick='return false'" : "";
        $html .= '<li class="' . $class . '"><a href="?p=' . ( $this->ReturnPage() - 1 ) . '" '.$disabled.'>&laquo;</a></li>';

        if ($start > 1) {
            $html .= '<li><a href="?p=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $class = ( $this->ReturnPage() == $i ) ? "active" : "";
            $html .= '<li class="' . $class . '"><a href="?p=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="?p=' . $last . '">' . $last . '</a></li>';
        }

        $class = ( $this->ReturnPage() == $last ) ? "disabled" : "";
        $disabled =  ( $this->ReturnPage() == $last ) ? "onclick='return false'" : "";
        $html .= '<li class="' . $class . '"><a href="?p=' . ( $this->ReturnPage() + 1 ) . '" '.$disabled.'>&raquo;</a></li>';

        $html .= '</ul>';

        return $html;
    }

    public function ReturnTotal() {
        return $this->_total;
    }

    public function ReturnLimit() {
        return $this->_limit;
    }

    public function ReturnPage() {
        return $this->_page;
    }

    public function RetPageData() {
        return $this->_results;
    }

}
