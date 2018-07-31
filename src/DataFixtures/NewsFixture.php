<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class NewsFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($j=0; $j <= 3; $j++) { 
            $category = new Category();
            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());
                $manager->persist($category);
        

        for ($i=1; $i < mt_rand(4,6) ; $i++) { 
    		$article = new Article();
            
            $content = '<p>'.join($faker->paragraphs(5), '</p><p> '). '</p>';
    		$article->setTitle($faker->sentence())
    		->setContent($content)
    		->setImage($faker->imageUrl())
    		->setCreatedAt($faker->dateTimeBetween('-6 months'))
            ->setCategory($category);
    		$manager->persist($article);

            for ($k=0; $k <= mt_rand(4,10) ; $k++) { 

                $content = '<p>'.join($faker->paragraphs(3), '</p><p> '). '</p>';
                $comment = new Comment();
                $comment->setAuthor($faker->name)
                ->setContent($content)
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setArticle($article);
                $manager->persist($comment);

            }
    	  }
        }
        $manager->flush();
    }
}
