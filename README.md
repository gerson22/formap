# Formap

[![Latest Stable Version](https://poser.pugx.org/gerson22/formap/v/stable)](https://packagist.org/packages/gerson22/formap)
[![Total Downloads](https://poser.pugx.org/gerson22/formap/downloads)](https://packagist.org/packages/gerson22/formap)
[![Latest Unstable Version](https://poser.pugx.org/gerson22/formap/v/unstable)](https://packagist.org/packages/gerson22/formap)
[![License](https://poser.pugx.org/gerson22/formap/license)](https://packagist.org/packages/gerson22/formap)

Librería para mapeo de campos de la base de datos y generar formularios automáticamente

## Installation

### With Composer

```
$ composer require gerson22/formap
```

```json
{
    "require": {
        "gerson22/formap": "0.3.0"
    }
}
```


## Getting Started

### Create files on root directory
global.php
```php
<?php

$input = "<input type=\":type\" id=':name' name=':name' class=\"form-control\" placeholder=\":alias\">";
define('LAYOUT_INPUT',$input);//text,number,date,color etc

$select = "<selectname=':name' id=':name'>
            <option val='NULL' selected>Elige una opción</option>
          </select>";
define('LAYOUT_SELECT',$select);

$file = "<input type='file' name=':name'>";
define('LAYOUT_FILE',$file);
```
.env
```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=auditoria
  DB_USERNAME=root
  DB_PASSWORD=
```

```php
<?php
require 'global.php';
require 'vendor/autoload.php';

use Formap\Form;

$tableName = 'users';
/*
* @params String $tableName
*/
$frm = new Form($tableName);

/*
* @return String
*/
$frm->all()->toHTML();
```

## Documentation

### Methods
setId()

* @string
* Establece el atributo id del formulario

```php
/*
* @return Formap\Form
*/
$frm->setId("frmUsers")
```

setMethod()

* @string
* Establece el atributo method del formulario

```php
/*
* @return Formap\Form
*/
$frm->setMethod("POST")
```

setAction()

* @string
* Establece el atributo action del formulario

```php
/*
* @return Formap\Form
*/
$frm->setAction("/action.php")
```

only()
* @array
* Campos que serán visibles

```php
/*
* @param  Array
* @return Formap\Form
*/
$frm->only(
       array(
          ['name' => 'cantidad', 'as' => 'Cantidad'],
          ['name' => 'producto_id', 'as' => 'Producto']
));
```

except()
* @array
* Campos que no serán visible

```php
/*
* @param  Array
* @return Formap\Form
*/
$frm->except(
       array(
          ['name' => 'producto_id']
));
```

all()
* @void
* Mapea todos los campos

```php
/*
* @return Formap\Form
*/
$frm->all();
```

add()
* @array
* Agrega fields externos a la tabla mapeada

```php
/*
* @param  Array
* @return Formap\Form
*/
$frm->add(array(
       ['name'=>'email','as' => 'Correo electronico', 'icon' => 'envelope'],
       ['name'=>'password_confirmation','as' => 'Repetir contraseña', 'type' => 'password' , 'icon' => 'lock']
));
```

toHTML()
* @void
* Después de especificar los campos a mapear convertir el Form en HTML

```php
/*
* @return String
*/
$frm->all()->toHtml();
```

