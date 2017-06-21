<?php
namespace App\Http\Libs\Frmapping;

class Config {

    public static function Layout(){
        return (object)array(
            'Input' => "<div class='md-form'>
                           <i class='fa fa-icon prefix'></i>
                           <input type=':type' id=':name' name=':name' required=':required' class='form-control'>
                           <label for='form3'>:alias</label>
                        </div>",
            'Select' => "<div class='md-form'>
                            <select class='mdb-select colorful-select dropdown-warning' name=':name' id=':name'>
                                <option val='NULL' selected>Elige una opción</option>
                            </select>
                            <label>:alias</label>
                        </div>"
        );
    }

}
