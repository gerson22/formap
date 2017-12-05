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
        return (object)array(
            'Input' => "<div class=\"md-form input-group\">
                          <span class=\"input-group-addon\" id=\"basic-addon1\"><span class='fa fa-:icon'></span></span>
                          <input type=\":type\" id=':name' name=':name' class=\"form-control\" placeholder=\":alias\" aria-describedby=\"basic-addon1\">
                      </div>",
            'Select' => "<div class='md-form'>
                            <select class='mdb-select colorful-select dropdown-warning' name=':name' id=':name'>
                                <option val='NULL' selected>Elige una opción</option>
                            </select>
                            <label>:alias</label>
                        </div>",
            "File"  =>  "<form id='frm_:name'>
                            <div class='file-field'>
                                <div class='btn btn-warning btn-sm yellow-main'>
                                    <span> :alias</span>
                                    <input type='file' name=':name' id=':name'>
                                </div>
                                <div class='file-path-wrapper'>
                                   <input class='file-path validate :name' type='text' placeholder='Nombre del archivo'>
                                </div>
                            </div>
                        </form><br><br>",
            'Form'  =>  "<form id=':name' method=':method' action=':action'>
                            <div>:fields</div>
                        </form>"
        );
    }

}
