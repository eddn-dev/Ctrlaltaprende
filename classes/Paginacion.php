<?php

namespace Classes;

class Paginacion{
    public $current_page;
    public $rows_per_page;
    public $total;

    public function __construct($current_page = 1, $rows_per_page = 10, $total = 0)
    {
        $this->current_page = (int)$current_page;
        $this->rows_per_page = (int)$rows_per_page;
        $this->total = (int)$total;
    }

    public function offset(){
        return $this->rows_per_page * ($this->current_page - 1);
    }

    public function total_pages(){
        return ceil($this->total / $this->rows_per_page);
    }

    public function previous_page(){
        $previous = $this->current_page - 1;
        return ($previous > 0) ? $previous : false;
    }

    public function next_page(){
        $next = $this->current_page + 1;
        return ($next <= $this->total_pages() ) ? $next : false;
    }

    public function previous_link(){
        $html ='';
        if($this->previous_page()){
            $html .= "<a class=\"paginacion__link paginacion__link--text\" href=\"?page=". $this->previous_page() ."\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function next_link(){
        $html = '';
        if($this->next_page()){
            $html .= "<a class=\"paginacion__link paginacion__link--text\" href=\"?page=". $this->next_page() ."\">Siguente &raquo;</a>";
        }
        return $html;
    }

    public function number_pages(){
        $html = '';
        for($i = 1; $i <= $this->total_pages(); $i++){
            if($i === $this->current_page){
                $html .= "<span class=\"paginacion__link paginacion__link--current\">" . $i . "</span>";
            }else{
                $html .= "<a class=\"paginacion__link paginacion__link--number\" href=\"?page=" . $i ."\">". $i ."</a>";
            }
        }
        return $html;
    }

    public function paginacion(){
        $html = '';
        if($this->total_pages() > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->previous_link();
            $html .= $this->number_pages();
            $html .= $this->next_link();
            $html .= '</div>';
        }

        return $html;
    }
}