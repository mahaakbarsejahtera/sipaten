<?php 

namespace Template;

class Table 
{

    private $data = [];

    private $columns = [];

    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function renderHeader() {

        $html = "<thead>";
        $html .= "<tr>";
        
        foreach($this->columns as $columns) {
            $name = isset($columns['name']) ? $columns['name'] : false;
            $field = isset($columns['field']) ? $columns['field'] : false;
            $sort = isset($columns['sort']) ? $columns['sort'] : false;
            $html .= "<th>";

            if($sort) {
                $html .= "
                
                <div>
                    <a href=\"javascript:void(0)\" data-toggle=\"sort\" data-sort=\"desc\" data-field=\"{$field}\">
                        <div class=\"d-flex justify-content-between align-items-center\">
                            <span>{$name}</span>
                            <span class=\"fas fa-sort-amount-down\"></span>
                        </div>
                    </a>
                </div>
                
                ";
            } else {
                $html .= $name;
            }


            $html .= "</th>";
        }

        $html .= "</tr>";
        $html .= "</thead>";
        return $html;

    }

    public function renderBody()
    {

        $html = "<tbody>";
        foreach($this->data as $data) {

        }
        $html .= "</tbody>";

        return $html;
    }



    public function render($id_table = "") 
    {

        $html = "<div class=\"table-responsive\">";
        $html .= "<table class=\"table table-bordered\" id=\"{$id_table}\">";
        $html .= $this->renderHeader();
        $html .= $this->renderBody();
        $html .= "</table>";
        $html .= "</div>";
        return $html;

    }

}