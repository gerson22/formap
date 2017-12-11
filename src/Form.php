<?php

namespace Formap;

use Formap\Elements\Input;
use Formap\Elements\Select;
use Formap\Elements\File;
use Formap\Elements\Form as Frm;
use Formap\Base\Model;

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
        'int'  => 'number'
    ];


    public function __construct($class){
        $this->model = new Model($class);
        $this->fieldsInput = [];
        $this->selected_fields = (object)[
            'self'=>null,
            'visibility'=>false
        ];
    }
    /*
    * @params
    * - String
    * @return
    * - Form
    */
    public function setId($id) : Form
    {
        $this->id = $id;
        return $this->reBuild();
    }
/*
    * @params
    * - String
    * @return
    * - Form
    */
    public function setMethod($method) : Form
    {
        $this->method = $method;
        return $this->reBuild();
    }

    /*
    * @params
    * - String
    * @return
    * - Form
    */
    public function setAction($id) : Form
    {
        $this->action = $id;
        return $this->reBuild();
    }

    /*
    * @params
    * - Array
    * @return
    * - Form
    */
    public function add(array ...$ef) : Form
    {
      $this->extraFields = $ef;
      return $this->specifyFields($this->selected_fields->self,$this->selected_fields->visibility);
    }

    /*
    * @params
    * - Array
    * @return
    * - Form
    */
    public function only(array ...$sf): Form
    {
        return $this->specifyFields($sf,true);
    }

    /*
    * @params
    * - Array
    * @return
    * - Form
    */
    public function except(array ...$sf): Form
    {
        return $this->specifyFields($sf);
    }

    /*
    * @return
    * - Form
    */
    public function all(): Form
    {
        return $this->specifyFields([]);
    }

    /*
    * @params
    * - String
    * @return
    * - Form
    */
    private function specifyFields($sf,$visibility=false) : Form
    {
        $this->selected_fields->self = $sf;
        $this->selected_fields->visibility = $visibility;
        $this->model->setExtraFields($this->extraFields);
        $this->fields = $this->model->filterFields($this->selected_fields->self,$this->selected_fields->visibility);
        return $this->reBuild();
    }
    /*
    * @return
    * - Form
    */
    private function build() : Form
    {
        $this->id = isset($this->id) ? $this->id : "frm_{$this->model->getName()}";
        $this->method = isset($this->method) ? $this->method : "POST";//Default value is POST
        $this->action = isset($this->action) ? $this->action : "";
        $this->fieldsInput = [];
        $this->fieldAssigment($this->fields);
        return $this;
    }

    private function fieldAssigment($fields,$index = 0){
      $field = $fields[$index];
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
          case 'correo'://Translate Spanish
              $dts->type = $dts->name;
              array_push($this->fieldsInput,$input->create($dts));
          break;
          case 'password':
          case 'pass':
          case 'pwd':
              $dts->type = $dts->name;
              array_push($this->fieldsInput,$input->create($dts));
          break;
          default:
              switch($field->Type){
                  case (preg_match('/^int/', $field->Type) ? true : false):
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
                              $dts->type = $this->types[substr($field->Type,0,3)];
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
                  case 'password':
                  case 'color':
                  case 'date':
                  case 'datetime-local':
                  case 'email':
                  case 'month':
                  case 'number':
                  case 'range':
                  case 'search':
                  case 'tel':
                  case 'time':
                  case 'range':
                  case 'url':
                  case 'week':
                      $dts->type = $field->Type;
                      array_push($this->fieldsInput,$input->create($dts));
                  break;
                  default:
                      array_push($this->fieldsInput,$input->create($dts));
                      break;
              }
          break;
      }
      $index++;
      if(count($fields) > $index){
        $this->fieldAssigment($fields,$index);
      }
    }
    /*
    * @return
    * - Form
    */
    public function reBuild() : Form
    {
        if(!is_null($this->selected_fields->self)){
            return $this->build();
        }
        return $this;
    }

    public function toHTML() : String
    {
        if($this->selected_fields->self == null){
          $this->all();
        }
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
