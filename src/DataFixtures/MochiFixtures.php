<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Mochi;

class MochiFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	for ($i=1; $i <=10 ; $i++) { 
    		$film = new Mochi();
    		$film->setTitle('titre'.$i)
    		->setSynopsis('synopsis'.$i)
    		->setCountry('pays'.$i)
    		->setImage('http://via.placeholder.com/350x150')
    		->setCategory('categorie'.$i);
    		$manager->persist($film);
    	}
    	$manager->flush();
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
