<?php
namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;

class CategoryTransformer implements DataTransformerInterface

{
  
    public function transform($value){

    	var_dump($value);
    	return '';
    	
    }

    public function reverseTransform($value){

    }
}
