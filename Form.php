<?php

namespace App\Http\Libs\Frmapping;

use App\Http\Libs\Frmapping\Src\Elements\Input;
use App\Http\Libs\Frmapping\Src\Elements\Select;
use App\Http\Libs\Frmapping\Src\Elements\File;
use App\Http\Libs\Frmapping\Src\Elements\Form as Frm;
use App\Http\Libs\Frmapping\Src\Base\Model;

class Form
{

    /**
     * Object model (Class:Model).
     *
     * @var Object
     */
    protected $model,


    /**
     * fields's form default.
     *
     * @var array
     */
    $fields,

     /**
     * fields's Input form default.
     *
     * @var array
     */
    $fieldsInput,

    /**
     * field's form selected.
     *
     * @var Object
     */
    $selected_fields,

    /**
     * extra field to add to form.
     *
     * @var Object
     */
    $extraFields;

    /**
     * Form formatted to HTML.
     *
     * @var string
     */
    private $frmHTML,

    /**
     * Attributte id.
     *
     * @var string
     */
    $id,

    /**
     * Attributte method.
     *
     * @var string
     */
    $method,

    /**
     * Attributte action.
     *
     * @var string
     */
    $action;

    /**
     * Cast types SQL to types HTML.
     *
     * @var string
     */
    private $types = [
        'default'   => 'text',
        'file'  => 'file',
        'password'  => 'password',
        'email'  => 'email',
        'int(11)'  => 'number'
    ];


    public function __construct($class){
        $this->model = new Model($class);
        $this->fieldsInput = [];
        $this->selected_fields = (object)[
            'self'=>null,
            'visibility'=>false
        ];
    }

    public function setId($id){
        $this->id = $id;
        return $this->reBuild();
    }

    public function setMethod($method){
        $this->method = $method;
        return $this->reBuild();
    }

    public function setAction($id){
        $this->action = $id;
        return $this->reBuild();
    }

    public function add($ef){
      $this->extraFields = $ef;
      return $this->specifyFields($this->selected_fields->self,$this->selected_fields->visibility);
    }

    public function only($sf = []){
        return $this->specifyFields($sf,true);
    }
    public function except($sf = []){
        return $this->specifyFields($sf);
    }
    public function all(){
        return $this->specifyFields([]);
    }
    private function specifyFields($sf,$visibility=false){
        $this->selected_fields->self = $sf;
        $this->selected_fields->visibility = $visibility;
        $this->model->setExtraFields($this->extraFields);
        $this->fields = $this->model->filterFields($this->selected_fields->self,$this->selected_fields->visibility);
        return $this->reBuild();
    }
    private function build(){
        $id = isset($this->id) ? $this->id : "frm_{$this->model->getName()}";
        $method = isset($this->method) ? $this->method : "";
        $action = isset($this->action) ? $this->action : "";
        $this->fieldsInput = [];
        foreach($this->fields as $field){
            $input = new Input();
            $dts = (object)array(
                'name' => $field->Field,
                'type' => $this->types['default'],
                'icon' => $field->Icon,
                'required' => $field->Null,
                'alias' => $field->As
            );
            switch($field->Field){
                case 'email':
                    $dts->type = $dts->name;
                    array_push($this->fieldsInput,$input->create($dts));
                break;
                case 'password':
                    $dts->type = $dts->name;
                    array_push($this->fieldsInput,$input->create($dts));
                break;
                default:
                    switch($field->Type){
                        case 'int(11)':
                            if($field->Key !== 'PRI'){
                                if($field->Key === 'MUL'){
                                    $select = new Select();
                                    $dts = (object)array(
                                        'name' => $field->Field,
                                        'icon' => $field->Icon,
                                        'alias' => $field->As
                                    );
                                    array_push($this->fieldsInput,$select->create($dts));
                                }else{
                                    $dts->type = $this->types[$field->Type];
                                    array_push($this->fieldsInput,$input->create($dts));
                                }
                            }
                            break;
                        case 'file':
                            $file = new File();
                            $dts->type = $field->Type;
                            array_push($this->fieldsInput,$file->create($dts));
                        break;
                        case 'email':
                            $dts->type = $field->Type;
                            array_push($this->fieldsInput,$input->create($dts));
                        break;
                        case 'password':
                            $dts->type = $field->Type;
                            array_push($this->fieldsInput,$input->create($dts));
                        break;
                        default:
                            array_push($this->fieldsInput,$input->create($dts));
                            break;
                    }
                break;
            }
        }
        return $this;
    }
    public function reBuild(){
        if(!is_null($this->selected_fields->self)){
            return $this->build();
        }
        return $this;
    }

    public function toHTML(){
        if(count($this->fieldsInput) > 0){
            $html = "";
            foreach($this->fieldsInput as $field){
                $html .= $field->toHTML();
            }
            $html .= "\n";
            $frm = new Frm();
            $dts = (object)array(
                'name' => $this->id,
                'method' => $this->method,
                'action' => $this->action,
                'fields' => $html
            );
            $this->frmHTML = $frm->create($dts)->toHTML();
        }
        return $this->frmHTML;
    }


}
