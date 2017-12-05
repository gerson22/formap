<?php

namespace Formap\Elements;


interface Element{
    public function create($dts);
    public function toHTML();
}
