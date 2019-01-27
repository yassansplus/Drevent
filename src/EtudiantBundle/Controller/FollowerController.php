<?php

namespace EtudiantBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Association;
use AppBundle\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
/**
 * Profil controller.
 *
 * @Route("etudiant/follower")
 */
class FollowerController extends Controller
{
    /**
     * Lists all etudiant entities.
     *
     * @Route("/association/{id}", name="follower", options={"expose"=true})
     */
    public function indexAction(Association $association,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->getRepository("AppBundle:Etudiant")->findOneBy(["user"=>$this->getUser()]);
        $etudiant->addAssociation($association);
        $em->persist($etudiant);
        $em->flush();
        return new JsonResponse("ok");


    }
    /**
     * Lists all etudiant entities.
     *
     * @Route("/association/publication/{name}", name="association-followed", options={"expose"=true})
     */
    public function associationFollowedAction(Association $association,Request $request)
    {

        return $this->render('association/profil/index.html.twig', ['association' => $association]);



    }


}
