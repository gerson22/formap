<?php

namespace App\Http\Libs\Frmapping\Src;

class Input
{

    public static function create($name,$type,$icon,$if_null){
        $required = self::NullToRequerided($if_null);
        return "<div class='md-form'>
                       <i class='fa fa-{$icon} prefix'></i>
                       <input type='{$type}' id='{$name}' name='{$name}' required='{$required}' class='form-control'>
                       <label for='form3'>{$name}</label>
                </div>";
    }
    private static function NullToRequerided($val){
        return  ($val == 'NO') ? 'true' : 'false';
    }

}
