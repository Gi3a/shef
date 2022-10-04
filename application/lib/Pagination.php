<?php

namespace application\lib;

class Pagination {
    
    private $max = 99;
    private $route;
    private $index = '';
    private $current_page;
    private $total;
    private $limit;

    public function __construct($route, $total, $limit = 3) {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->amount();
        $this->setCurrentPage();
    }
   
    public function get() {
        $links = null;
        $limits = $this->limits();
        $html = '<nav class="pagination">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<a class="page-link active">'.$page.'</a>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }
        $html .= $links.' </nav>';
        return $html;
    }

    private function generateHtml($page, $text = null) {
        if ($this->route['action'] == 'advertcategory') {
            $this->route['action'] = 'adverts';
        } elseif($this->route['action'] == 'ordercategory'){
            $this->route['action'] = 'orders';
        }elseif($this->route['action'] == 'allcategory'){
            $this->route['action'] = 'all';
        }


        if (!$text) {
            $text = $page;
        }
        if(isset($this->route['search'])){
            return '<a class="page-link" href="/'.$this->route['action'].'/'.$this->route['search'].'/'.$page.'">'.$text.'</a></li>';
        }
        elseif(($this->route['controller'] == 'user') and (($this->route['action'] == 'adverts') or ($this->route['action'] == 'orders') or ($this->route['action'] == 'routes'))){
            return '<a class="page-link" href="/profile/'.$this->route['action'].'/'.$page.'">'.$text.'</a></li>';
        }
        elseif(($this->route['controller'] == 'main') and (($this->route['action'] == 'adverts') or ($this->route['action'] == 'orders')) ){
            if ((empty($this->route['category'])) and (empty($this->route['sort']))) {
                return '<a class="page-link" href="/'.$this->route['action'].'/'.$page.'">'.$text.'</a></li>';  
            }
            elseif ((isset($this->route['category'])) and (isset($this->route['sort']))) {
                return '<a class="page-link" href="/'.$this->route['action'].'/'.$this->route['category'].'/'.$this->route['sort'].'/'.$page.'">'.$text.'</a></li>';   
            }
            elseif (isset($this->route['sort'])) {
                return '<a class="page-link" href="/'.$this->route['action'].'/'.$this->route['sort'].'/'.$page.'">'.$text.'</a></li>';   
            }
            elseif(isset($this->route['category'])){
                return '<a class="page-link" href="/'.$this->route['action'].'/'.$this->route['category'].'/'.$page.'">'.$text.'</a></li>';
            }
        }
        elseif($this->route['controller'] == 'admin'){
            return '<a class="page-link" href="/admin/'.$this->route['action'].'/'.$page.'">'.$text.'</a></li>';
        }
        elseif($this->route['controller'] == 'driver'){
            return '<a class="page-link" href="/driver/'.$this->route['action'].'/'.$page.'">'.$text.'</a></li>';
        }
        else{
            return '<a class="page-link" href="/'.$this->route['action'].'/'.$page.'">'.$text.'</a></li>';
        }
    }

    private function limits() {
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        }
        else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    private function setCurrentPage() {
        if (isset($this->route['page'])) {
            $currentPage = $this->route['page'];
        } else {
            $currentPage = 1;
        }
        $this->current_page = $currentPage;
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount) {
                $this->current_page = $this->amount;
            }
        } else {
            $this->current_page = 1;
        }
    }

    private function amount() {
        return ceil($this->total / $this->limit);
    }
}