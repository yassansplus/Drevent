<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Association;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
class AssociationVerifController extends Controller
{

    /**
     * Creates a new association entity.
     *
     * @Route("/validation-association", name="association_new")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $association = new Association();
        $form = $this->createForm('AppBundle\Form\AssociationType', $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $request->request->get('user_input_username');
            if (!isset($username)){
                    $this->addFlash(
                        'notice',
                        'Aïe, il semble qu\'il y ai une erreur de saisie!'
                    );
                    return $this->redirectToRoute('association_new');
                }
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $user->removeRole("ROLE_ASSOC_OK");
            $user->addRole("ROLE_ASSOC");

            $user->setUsername($username);
            $association->setUser($user);
            $em->persist($user);
            $em->persist($association);
            $em->flush();
            $token = new UsernamePasswordToken(
                $user,
                null,
                'main',
                $user->getRoles());
// give it to the security context
            $this->container->get('security.token_storage')->setToken($token);
            $this->addFlash('success','Tadam! tout est prêt maintenant, à vous de jouer');
            return $this->redirectToRoute('association_homepage');
        }

        return $this->render('association/profil/new.html.twig', array(
            'association' => $association,
            'form' => $form->createView(),
        ));
    }
}
