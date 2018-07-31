<?php 
namespace App\Form\dataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\TagsRepository;
use App\Entity\Tags;

/**
 * 
 */
class TagsTransformer implements DataTransformerInterface
{
	/**
	 * @var ObjectManager
	 */
	private $manager;
	function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;	
		
	}
	
    public function transform($value): string{
    	
    	return implode(',', $value);

    }

    
    public function reverseTransform($string): array{
    	$names = array_map('trim',explode(',', $string));

        
        $tags = $this->manager->getRepository(Tags::class)->findBy([
    		'name'=> $names
    	]);
    	$newNames = array_diff($names, $tags);
    	foreach ($newNames as $name ) {
    		$tag = new Tags();
    		$tag->setName($name);
    		$tags[] = $tag;
    	}
    	return $tags;
    }
}

