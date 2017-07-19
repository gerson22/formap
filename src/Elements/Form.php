<?php

namespace App\Http\Libs\Frmapping\Src\Elements;

use App\Http\Libs\Frmapping\Config;

class Form implements Element
{
    private $layout;
    private $name,$action,$method;

    public function __construct(){
        $this->layout = Config::Layout()->Form;
    }
    public function create($dts){
        $this->action = $dts->action;
        $this->method = $dts->method;
        $this->name = $dts->name;
        $this->fields = $dts->fields;
        return $this;
    }
    public function toHTML(){
        return $this->compiler();
    }
    private function compiler(){
        $string = $this->layout;
        $patterns = array(
            '/:action/',
            '/:method/',
            '/:name/',
            '/:fields/'
        );
        $bind = array(
            $this->action,
            $this->method,
            $this->name,
            $this->fields,
        );
        return preg_replace($patterns, $bind, $string);
    }

}
