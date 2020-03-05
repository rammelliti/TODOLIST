<?php

namespace App\Controller ;

use App\Entity\Listing;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route ("/", name="listing_")
*/
class ListingController extends AbstractController {

    /**
    * @Route ("/{listingId}", name="show", requirements = {"listingId"="\d+"})
    */
    public function show (EntityManagerInterface $entityManager, $listingId=null) {

    $listings = $entityManager->getRepository(Listing::class)->findAll();

        if (!empty ($listingId)) {
        $currentlisting = $entityManager->getRepository(Listing::class)->find($listingId);
        }
        if 
            (empty ($currentlisting)){
            $currentlisting=current($listings);
        }
        return $this->render ('listing.html.twig',[
            'listings' => $listings,
            'currentlisting'=>$currentlisting
            ]);
    ;
}

    /**
    * @Route ("/new", methods="POST", name="create")
    */
    public function create (Request $request, EntityManagerInterface $entityManager) {
    
    $name = $request->get ('name');
        if (empty($name)){
        $this->addFlash ("warning", "Le nom du listing est obligatoire");
        return $this->redirectToRoute ('listing_show');
        }
    $listing = new Listing ();
    $listing->setName ($name);
    try {
        $entityManager->persist ($listing);
        $entityManager->flush ();
        $this->addFlash ("success", "Votre liste « $name » a été créée avec succès");
    }
    catch (UniqueConstraintViolationException $e)
        {
            $this->addFlash ("double", "Le nom du listing est existe déjà");
        }
    return $this->redirectToRoute ('listing_show');
    }

    /**
    * @Route ("/{listingId}/delete", name="delete", requirements = {"listingId"="\d+"})
    */
    public function delete ($listingId, EntityManagerInterface $entityManager){
      
        $listing = $entityManager->getRepository(Listing::class)->find($listingId);

            if 
                (empty ($listing)){
                    $this->addFlash ("warning", "Votre liste n'a pu être supprimée, car elle n'existe pas");
            }
            else {
                    $entityManager->remove ($listing);
                    $entityManager->flush ();
                    $name = $listing->getName();
                    $this->addFlash ("success-recycle", "Votre liste « $name » a été supprimée avec succès");
            }
                return $this->redirectToRoute ('listing_show');
                }
            }