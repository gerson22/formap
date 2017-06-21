# Frmapping
Librería para mapeo de campos de la base de datos y crear formularios automático

La libreria tiene que ser guardada en la carpeta app/Http => Laravel 5.*
Se utiliza el use para mandarla a llamar

`use App\Http\Libs\Frmapping\Form;`

Se realiza la instancia:
`$frm = new Form('users');`

setId()

* @string
* Establece el atributo id del formulario

`frm->setId("frmUsers")`

setMethod()

* @string
* Establece el atributo method del formulario

`frm->setMethod("POST")`

setAction()

* @string
* Establece el atributo action del formulario

`frm->setAction("/action.php")`

only()
* @array
* Campos que serán visible

`$frm->only(
       array(
          ['name' => 'fecha', 'as' => 'Fecha'],
          ['name' => 'cantidad', 'as' => 'Cantidad'],
          ['name' => 'total', 'as' => 'Total'],
          ['name' => 'user_id', 'as' => 'Usuario'],
          ['name' => 'producto_id', 'as' => 'Producto']
));`

except()
* @array
* Campos que no serán visible

`$frm->except(
       array(
          ['name' => 'producto_id']
));`

all()
* @void
* Mapea todos los campos

`$frm->all();`

