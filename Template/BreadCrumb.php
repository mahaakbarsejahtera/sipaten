<?php 

namespace Template;

class BreadCrumb {

    private $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
        return $this;
    }

    public function set($data) {
        $this->data = $data;
        return $this;
    }

    public function render() {
        $html = "";

        $html .= "<ol class=\"breadcrumb float-sm-right\">";


        foreach($this->data as $data)
        {
            $url  = isset($data['url']) ? $data['url'] : '#';
            $name = isset($data['name']) ? $data['name'] : '';
            $active = isset($data['active']) ? 'active' : '';
            $html .= "<li class=\"breadcrumb-item {$active}\"><a href=\"{$url}\">{$name}</a></li>";


        } 
        
        $html .= "</ol>";


        return $html;
    }

}