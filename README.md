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

```php
<?php
require 'vendor/autoload.php';

use Formap\Form;

$frm = new Form('users');//table name
$frm->all()->toHTML();
```

## Documentation

### Methods
setId()

* @string
* Establece el atributo id del formulario

```php
$frm->setId("frmUsers")
```

setMethod()

* @string
* Establece el atributo method del formulario

```php
$frm->setMethod("POST")
```

setAction()

* @string
* Establece el atributo action del formulario

```php
$frm->setAction("/action.php")
```

only()
* @array
* Campos que serán visibles

```php
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
$frm->except(
       array(
          ['name' => 'producto_id']
));
```

all()
* @void
* Mapea todos los campos

```php
$frm->all();
```

add()
* @array
* Agrega fields externos a la tabla mapeada

```php
$frm->add(array(
       ['name'=>'email','as' => 'Correo electronico', 'icon' => 'envelope'],
       ['name'=>'password_confirmation','as' => 'Repetir contraseña', 'type' => 'password' , 'icon' => 'lock']
));
```

toHTML()
* @void
* Después de especificar los campos a mapear convertir el Form en HTML

```php
$frm->all()->toHtml();
```

