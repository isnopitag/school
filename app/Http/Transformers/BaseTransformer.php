<?php

namespace App\Http\Transformers;

use League\Fractal;

class BaseTransformer extends Fractal\TransformerAbstract
{
    protected $default = ['id'];
    private $fields = [];

    public function __construct($fields = [])
    {
        $fields = is_array($fields) ? $fields : [$fields];
        $this->fields = array_unique(array_merge($fields, $this->default));
    }
    
    protected function transformWithFieldFilter($data)
    {
        if (is_null($this->fields)) {
            return $data;
        }

        $arr = array_intersect_key($data, array_flip((array) $this->fields));
        $arr = array_map(function($v) { return is_callable($v) ? $v() : $v; }, $arr);

        return $arr;
    }
}