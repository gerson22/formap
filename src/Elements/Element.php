<?php

namespace App\Http\Libs\Frmapping\Src\Elements;


interface Element{

    public function create($dts);
    public function toHTML();
}
