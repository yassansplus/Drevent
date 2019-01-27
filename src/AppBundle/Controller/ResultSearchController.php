<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Association;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Profil controller.
 *
 * @Route("resultat-recherche")
 */
class ResultSearchController extends Controller
{
    /**
     * @Route("/", name="result", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');

        if ($securityContext->isGranted('ROLE_STUD')) {

            $userTags = $this->getUser()->getTags();

            $userTagsCount = count($userTags->getValues());
            $em = $this->getDoctrine()->getManager();
            $associations = $em->getRepository(Association::class)->findAll();
            $bestResult = [];
            $tt = 0;

            for ($tt; $tt < $userTagsCount; $tt++) {

                foreach ($associations as $association) {

                    $diff = array_udiff($userTags->getValues(), $association->getUser()->getTags()->getValues(),
                        function ($obj_a, $obj_b) {
                            return $obj_a->getId() - $obj_b->getId();
                        }
                    );


                    $res = count($diff);
                    if ($res == $tt) {
                        array_push($bestResult, $association);
                    }

                }

            }
            $etudiant = $em->getRepository('AppBundle:Etudiant')->findOneBy(["user" => $this->getUser()]);
            return $this->render('etudiant/profil/index.html.twig', array(
                'etudiant' => $etudiant, 'associations' => $bestResult
            ));
        }
        return $this->redirectToRoute('homepage');
        // replace this example code with whatever you need
    }


}
