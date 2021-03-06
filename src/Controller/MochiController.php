<?php

namespace App\Controller;

use App\Entity\Mochi;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\MochiType as filmForm;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MochiRepository;
use Symfony\Component\HttpFoundation\File\File;


class MochiController extends Controller
{
    /**
     * @Route("/create", name="createFilm")
     * @Route("/edit/{id}", name="editFilm")
     * @return Response
     */
    public function create(Mochi $mochi = null, Request $request, ObjectManager $manager)
    {
      
        if (!$mochi ) {
        $mochi = new Mochi();
        }else {

        $oldFile = $this->getParameter('image_directory').'/'.$mochi->getImage();
        
        }
        $form = $this->createForm(filmForm::class, $mochi);

      
          
        $form = $this->createForm(filmForm::class, $mochi);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if (!(preg_match("#http#", $oldFile))) {
                unlink($oldFile);
            }
            
            //upload file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('image')->getData();

            //nom du file
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            //deplacement du file
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            //nommage du file dans la bdd
            $mochi->setImage($fileName);

           
            $manager->persist($mochi);
            $manager->flush();
            return $this->redirectToRoute('suite',['id'=> $mochi->getId()]);
        }
        return $this->render('mochi/create.html.twig', [
            'form'=>$form->createView()
        ]);
        
        
    }


  
    

    /**
     * @Route("/", name="show_film")
     */
    public function index(MochiRepository $repo)
    {
    	$films = $repo->findAll();
        return $this->render('mochi/index.html.twig', [
            'film'=>$films
        ]);
    }

    /**
     * @Route("/search", name="searchBar")
     */
    public function searching(MochiRepository $repo, Request $request)
    {
    	 //get('title') c'est le name a mettre dans le input search,
                //$key recupere l'entréee de l'mochi
                $key = $request->get('title');

                
                $search = $repo->findByWord($key);
                if (!($search)) {
                    $search = 'la recherche sur '.$key.' n\'a donnée aucun résultat';
                }elseif ($key === '') {
                    $search = 'veuillez entrez une recherche';
                }
        return $this->render('mochi/search.html.twig', [
            'film'=>$search
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteMovie")
     */
    public function delete($id, ObjectManager $manager, MochiRepository $repo)
    {
    	$film = $repo->find($id);
    	$manager->remove($film);
    	$manager->flush();
    	return $this->redirectToRoute('show_film');

    }

    /**
     * @Route("/suite/{id}", name="suite")
     */
    public function suite($id, MochiRepository $repo)
    {
        $film = $repo->find($id);
         return $this->render('mochi/suite.html.twig', [
            'film'=>$film 
        ]);
        

    }


     private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


        


}
