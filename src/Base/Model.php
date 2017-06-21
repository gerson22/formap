<?php

namespace App\Http\Libs\Frmapping\Src\Base;

use DB;

class Model
{

    protected $name;//plural

    public function __construct($name){
        $this->name = $name;
    }

    public function getFields(){
        return (array)DB::select("SHOW COLUMNS FROM {$this->name}");
    }

    public function getName(){
        return $this->name;
    }

    public function filterFields($fss,$allowed){
        $realFields = [];
        $fds = $this->getFields();
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
                                        'Icon' => isset($fs['icon']) ? $fs['icon'] : '',
                                        'As' => isset($fs['as']) ? $fs['as'] : $fd->Field,
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
                                        'Icon' => '',
                                        'As' => $fd->Field,
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
                $fdNew = (object)array(
                    'Icon' => '',
                    'As' => $fd->Field,
                    'Field' => $fd->Field,
                    'Type' => $fd->Type,
                    'Null' => $fd->Null,
                    'Key' => $fd->Key,
                    'Default' => $fd->Default,
                    'Extra' => $fd->Extra
                );
                array_push($realFields,$fdNew);
            }
        }
        return $realFields;
    }

}
