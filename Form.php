<?php

namespace App\Http\Libs\Frmapping;

use App\Http\Libs\Frmapping\Src\Input;
use DB;

class Form
{

    protected $model;

    private $types = [
        'default'   => 'text',
        'int(11)'  => 'number'
    ];

    public function __construct($class){
        $this->model = $class;
    }
    public function generate($sf = [],$allowed = false){
        $fields = (array)DB::select("SHOW COLUMNS FROM {$this->model}");
        $fields = $this->filterFields($fields,$sf,$allowed);
        $form = "<form id='frm_{$this->model}'>\n";
        foreach($fields as $field){
            if(isset($field->Icon)){
                switch($field->Field){
                    case 'email':
                        $form .= Input::create($field->Field,$field->Field,$field->Icon,$field->Null);
                    break;
                    case 'password':
                        $form .= Input::create($field->Field,$field->Field,$field->Icon,$field->Null);
                    break;
                    default:
                        switch($field->Type){
                            case 'int(11)':
                                if($field->Key !== 'PRI')
                                    $form .= Input::create($field->Field,$this->types[$field->Type],$field->Icon,$field->Null);
                                break;
                            default:
                                $form .= Input::create($field->Field,$this->types['default'],$field->Icon,$field->Null);
                                break;
                        }
                    break;
                }
                $form .= "\n";
            }
        }
        $form .= '</form>';
        return $form;
    }
    private function filterFields($fds,$fss,$allowed){
        $realFields = [];
        foreach($fds as $fd){
            $count = count($fss);
            $it = 0;
            $disallowed = 0;
            if(count($fss) > 0){
                foreach($fss as $fs){
                    $it++;
                    if($fd->Field === $fs['name']){
                        if($allowed){
                            $fdNew = (object)array(
                                        'Icon' => $fs['icon'],
                                        'Field' => $fd->Field,
                                        'Type' => $fd->Type,
                                        'Null' => $fd->Null,
                                        'Key' => $fd->Key,
                                        'Default' => $fd->Default,
                                        'Extra' => $fd->Extra
                                    );
                            array_push($realFields,$fdNew);
                        }else{
                           $disallowed = 1;
                        }
                    }else{
                        if(!$allowed){
                           if($it == ($count)){
                                if($disallowed < 1){
                                    $fdNew = (object)array(
                                        'Icon' => 'arrow-right',
                                        'Field' => $fd->Field,
                                        'Type' => $fd->Type,
                                        'Null' => $fd->Null,
                                        'Key' => $fd->Key,
                                        'Default' => $fd->Default,
                                        'Extra' => $fd->Extra
                                    );
                                    array_push($realFields,$fdNew);
                                    $it = 0;
                                    $disallowed = 0;
                                }
                           }
                        }
                    }

                }
            }else{

            }
        }
        return $realFields;
    }

}
