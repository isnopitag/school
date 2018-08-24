<?php

namespace App\Http\Transformers;

use App\Subcategory;

class SubcategoryTransformer extends BaseTransformer{
	
	protected $default = ['id', 'subcategory'];
	
	public function transform(Subcategory $subcategory)
	{
	    return $this->transformWithFieldFilter([
	        'id' => (int) $subcategory->id,
	        'subcategory' => $subcategory->subcategory,
	    ]);
    }
}