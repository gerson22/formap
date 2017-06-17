# Frmapping
Librería para mapeo de campos de la base de datos y crear formulario automático

La libreria tiene que ser guardada en la carpeta app/Http => Laravel 5.*
Se utiliza el use para mandarla llamar

`use App\Http\Libs\Frmapping\Form;`


`$frm = new Form('users');`


* @array
* El primer parametro es un array son los campos que serán visible o no visibles
* @bool
* El segundo parametro es el que decide si el primer parametro serán visibles o no 


`$frm_created = $frm->generate(
[
    ['name'=>'username','icon'=>'user'],
    ['name'=>'email','icon'=>'envelope']
],
true);`



Nota:
Por el momento solo genera inputs[text,password,email,number,e.t.c]
Aun falta que pueda generar input[radio,checkbox,color,range] ó select
