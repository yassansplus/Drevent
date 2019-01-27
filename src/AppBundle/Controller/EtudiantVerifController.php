<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
class EtudiantVerifController extends Controller
{
    /**
     * Creates a new etudiant entity.
     *
     * @Route("/validation-etudiant", name="etudiant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etudiant = new Etudiant();
        $form = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dateString = $request->request->get('appbundle_etudiant')['birthday'];
            $date = \DateTime::createFromFormat('d/m/Y',$dateString);
            $etudiant->setBirthday($date);
            $etudiant->setUser($this->getUser());
            $user->addRole("ROLE_STUD");
            $user->removeRole("ROLE_STUD_OK");
            $em->persist($user);
            $em->persist($etudiant);
            $em->flush();
            $token = new UsernamePasswordToken(
                $user,
                null,
                'main',
                $user->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            return $this->redirectToRoute('etudiant_homepage', array('id' => $etudiant->getId()));
        }

        return $this->render('etudiant/profil/new.html.twig', array(
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ));
    }
}
