<?php 

namespace Template;

class Signature
{

    private $persons    = [];
    private $template   = "";
    private $data       = [];

    private $except     = [];


    

    public function delete($name) 
    {

        if(isset($this->persons[$name])) 
        {

            unset($this->persons[$name]);

        }

        return $this;

    }

    public function add($data)
    {

        $this->persons[] = $data;

        return $this;

    }

    public function setData($data) 
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function template($sebagai, $nama_lengkap, $role)
    {
        $template = "<div class=\"float-left col-4\">
            <div>{$sebagai}</div>


            <div style=\"margin-top: 80px\">
                <div>{$nama_lengkap}</div>
                <div>{$role}</div>
            </div>
        </div>";

        return $template;

    }

    public function hasPerson($name) 
    {
        return isset($this->persons[$name]);
    }

    public function hasAttribute($name, $attr)
    {

        return isset($this->persons[$name][$attr]);
    }

    public function getPersons()
    {
        return $this->persons;
    }

    public function getPerson($name) 
    {
        if(isset($this->persons[$name])) return $this->persons[$name];

        return false;

    }

    public function hasRole($name, $role) 
    {

        if(!$this->hasPerson($name)) return false; 

        if(!$this->hasAttribute($name, 'role')) return false;

        if(!in_array($role, $this->persons[$name]['roles'])) return false;
    
        return true;

    }


}