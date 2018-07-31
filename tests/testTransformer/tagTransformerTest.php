<?php 

namespace App\tests\testTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\dataTransformer\TagsTransformer;

/**
 * 
 */
class tagTransformerTest extends \PHPUnit\framework\TestCase 
{
	
	public function testCreateTagsArrayFromString()
	{
		$transformer = $this->getMockedTransformer(); 
		$tags = $transformer->reverseTransform('hello, bonjour');
		$this->assertCount(2,$tags);
		$this->assertSame('bonjour', $tags[1]->getName());
	}


	
	private function getMockedTransformer()
	{
		$tagRepository = $this->getMockBuilder(EntityRepository::class)
		->disableOriginalConstructor()
		->getMock();
		$tagRepository->expects($this->any())
			->method('findBy')
			->will($this->returnValue([]));
		$entityManager = $this->getMockBuilder(ObjectManager::class)
		->disableOriginalConstructor()
		->getMock();
		$entityManager->expects($this->any())
			->method('getRepository')
			->will($this->returnValue($tagRepository));
		return new TagsTransformer($entityManager);

	}
}