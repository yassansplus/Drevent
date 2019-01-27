<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Association;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('vitrine/page/index.html.twig');
    }


    /**
     * @Route("/whatsRole", name="whatsRole")
     */
    public function roleRedirectionAction(Request $request)
    {


        if (in_array('ROLE_STUD', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('etudiant_homepage');
        } else if (in_array('ROLE_ASSOC', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('association_homepage');
        } else if (in_array('ROLE_ASSOC_OK', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('association_new');
        } else if (in_array('ROLE_STUD_OK', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('etudiant_new');
        }
        // replace this example code with whatever you need
        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/sendMail", name="sendMail")
     */
    public function sendMailAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        //send mail
        if (isset($nom, $prenom, $email, $message)) {
            $content = (new \Swift_Message('Meessage de ' . $prenom . ' ' . strtoupper($nom)))
                ->setFrom($email)
                ->setTo('contact@efreihub.com')
                ->setBody($message);
            $mailer->send($content);
        } else {
        }

        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route("/comment-ca-marche", name="ccm")
     */
    public function ccmAction(Request $request)
    {
        return $this->render('vitrine/page/ccm.html.twig');
    }

    /**
     * @Route("/association-promo", name="assoc-promo")
     */
    public function assocVitrineAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Association::class);

        $query = $repository->createQueryBuilder('association')
            ->orderBy('association.id', 'ASC')
            ->setMaxResults(6)
            ->getQuery();

        $associations = $query->getResult();

        $associationsWithPicture = [];
        foreach ($associations as $association) {
            if (dump($association->getUser()->getPicture()) != NULL) {
                array_push($associationsWithPicture, $association);
            }

        }
        return $this->render('vitrine/page/association.html.twig', ['associations' => $associationsWithPicture]);

    }

    /**
     * @Route("/tag-ajax", options={"expose"=true}, name="tag_ajax")
     */
    public function tagAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Tag");
        $tags = $repo->createQueryBuilder('q')
            ->getQuery()
            ->getArrayResult();
        return new JsonResponse($tags);
    }

    /**
     * @Route("/association-ajax", options={"expose"=true}, name="association_ajax")
     */
    public function assocAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $associations = $qb->select("a.name")->from("AppBundle:Association", "a")->getQuery()->getResult();

        return new JsonResponse($associations);
    }

    /**
     * @Route("/tag-ajax-set", options={"expose"=true}, name="tag_ajax_set")
     */
    public function tagLiaisongAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $tagsUser = explode(",", array_keys($request->request->all())[0]);
        $excludeTag = [];
        foreach ($this->getUser()->getTags() as $userTag) {

            array_push($excludeTag, "" . $userTag->getId() . "");
        }
        $goodTag = array_diff($tagsUser, $excludeTag);

        foreach ($goodTag as $tag) {
            $Thistag = $em->getRepository("AppBundle:Tag")->find(intval($tag));
            $user = $this->getUser()->addTag($Thistag);
            $em->persist($user);
            $em->flush();
        }
        return new JsonResponse("ok");
    }
}
