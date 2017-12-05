<?php

namespace Formap\Base;

use Formap\Base\PDO\Config;
use Formap\Base\PDO\Datos;

class Model
{

    protected $name,$fields,$extraFields;//plural

    public function __construct($name){
        $this->name = $name;
    }

    public function getFields(){
      $datos = new Datos();
      $this->fields = (array)$datos->select("SHOW COLUMNS FROM {$this->name}");
      return $this->fields;
    }

    public function getName(){
        return $this->name;
    }

    public function setExtraFields($extraFields){
      $this->extraFields = $extraFields;
    }

    public function filterFields($fss,$allowed){
        $realFields = [];
        $fds = $this->getFieldsWithFX($this->extraFields);
        $fss = $this->addSelectedFields($fss);
        $this->validateFieldSelected($fss);
        foreach($fds as $fieldDefault){
            $fd = (object)$fieldDefault;
            $count = count($fss);
            $it = 0;
            $disallowed = 0;
            $asDefault = ucfirst(str_replace("id","",str_replace("_"," ",$fd->Field)));
            if(count($fss) > 0){
                foreach($fss as $fs){
                    $it++;
                    if($fd->Field === $fs['name']){
                        if($allowed){
                            $fdNew = (object)array(
                                        'Icon' => isset($fs['icon']) ? $fs['icon'] : '',
                                        'As' => isset($fs['as']) ? $fs['as'] : $asDefault,
                                        'Field' => $fd->Field,
                                        'Type' => $this->filterTypes(isset($fs['type']) ? $fs['type'] : null ,$fd->Type),
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
                                        'As' => $asDefault,
                                        'Field' => $fd->Field,
                                        'Type' => $this->filterTypes(isset($fs['type']) ? $fs['type'] : null ,$fd->Type),
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
                    'As' => $asDefault,
                    'Field' => $this->filterTypes(isset($fs['type']) ? $fs['type'] : null ,$fd->Type),
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

    private function addSelectedFields($fs = []){
      if(count($this->extraFields)){
        if(is_array($this->extraFields)){
          foreach($this->extraFields as $f){
            $lng = isset($af['size']) ? $af['size'] : '60';
            $field = [
              'name' => isset($f['name']) ? $f['name'] : 'undefined',
              'icon' => isset($f['icon']) ? $f['icon'] : '',
              'as' => isset($f['as']) ? $f['as'] : $f['name']
            ];
            array_push($fs,$field);
          }
        }
      }
      return $fs;
    }

    private function getFieldsWithFX($afs = []){
      $this->getFields();
      if(count($afs)){
        if(is_array($afs)){
          foreach($afs as $af){
            $lng = isset($af['size']) ? $af['size'] : '60';
            $field = (object)[
              'Field' => isset($af['name']) ? $af['name'] : 'undefined',
              'Type' => isset($af['type']) ? ($af['type'] == 'select') ? 'int(11)' : $af['type']  : "varchar($lng)",
              'Null' => isset($af['required']) ? $af['required'] : 'no',
              'Key' => isset($af['type']) ? ($af['type'] == 'select') ? 'MUL' : $af['type'] : '',
              'Default' => isset($af['default']) ? $af['default'] : '',
              'Extra' => isset($af['extra']) ? $af['extra'] : ''
            ];
            array_push($this->fields,$field);
          }
        }
      }
      return $this->fields;
    }

    private function filterTypes($ts,$td){
      $tf = is_null($ts) ? $td : $ts;
      return $tf;
    }

    private function validateFieldSelected($fss){
      if(is_array($fss)){
        if(count($fss) > 0){
          foreach($fss as $fs){
            if(!is_array($fs))
              throw new \Exception('The parameters must be arrays that contain arrays to identify columns');
          }
        }
      }
    }

}
