<?php

namespace App\Http\Transformers;

use App\Publication;

class PublicationTransformer extends BaseTransformer
{

    //this Come from Agronexo's Project maybe will be deleted soon.
    protected $default = ['id','name', 'description', 'principal_image'];
    protected $availableIncludes = ['subcategory'];

	public function transform(Publication $publication)
	{
	    return $this->transformWithFieldFilter([
	        'id' => (int) $publication->id,
	        'name' => $publication->name,
            'description' => $publication->description,
            'principal_image' => $publication->principal_image,
            'privacy' => (int) $publication->privacy,
            'highlight' => (int) $publication->highlight,
        ]);
    }

    public function includeSubcategory(Publication $publication)
    {
        return $this->item($publication->subcategory, new SubcategoryTransformer);
    }
}