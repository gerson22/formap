<?php

namespace App\Http\Libs\Frmapping\Src\Elements;

use App\Http\Libs\Frmapping\Config;

class Input implements Element
{
    private $layout;
    private $name,$type,$icon,$required,$alias;

    public function __construct(){
        $this->layout = Config::Layout()->Input;
    }
    public function create($dts){
        $this->required = self::NullToRequerided($dts->required);
        $this->name = $dts->name;
        $this->type = $dts->type;
        $this->icon = $dts->icon;
        $this->alias = $dts->alias;
        return $this;
    }
    public function toHTML(){
        return $this->compiler();
    }
    private static function NullToRequerided($val){
        return  ($val == 'NO') ? 'true' : 'false';
    }
    private function compiler(){
        $string = $this->layout;
        $patterns = array(
            '/:name/',
            '/:icon/',
            '/:type/',
            '/:required/',
            '/:alias/'
        );
        $bind = array(
            $this->name,
            $this->icon,
            $this->type,
            $this->required,
            $this->alias
        );
        return preg_replace($patterns, $bind, $string);
    }

}
