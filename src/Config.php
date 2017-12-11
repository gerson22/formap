<?php
namespace Formap;

class Config {
    /*
    * There are differents params
    * :name => column name
    * :type => type field
    * :alias => aka field
    * :required => if column´s database is not null this field will be required
    * :fields => fields form such as select, input,file etc
    */
    public static function Layout(){
        $input = "<input type=\":type\" id=':name' name=':name' class=\"form-control\" placeholder=\":alias\">";
        $select = "<selectname=':name' id=':name'>
                    <option val='NULL' selected>Elige una opción</option>
                  </select>";
        $file = "<input type='file' name=':name'>";
        return (object)array(
            'Input' =>  isset(get_defined_constants(true)['user']['LAYOUT_INPUT']) ? LAYOUT_INPUT : $input,
            'Select' => isset(get_defined_constants(true)['user']['LAYOUT_SELECT']) ? LAYOUT_SELECT : $select,
            "File"  =>  isset(get_defined_constants(true)['user']['LAYOUT_FILE']) ? LAYOUT_FILE : $input,
            'Form'  =>  "<form id=':name' method=':method' action=':action'>
                            <div>:fields</div>
                        </form>"
        );
    }

}
