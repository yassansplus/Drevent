<?php

namespace AssociationBundle\Controller;


use AppBundle\Entity\Association;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Profil controller.
 *
 * @Route("association")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="association_homepage")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $association = $em->getRepository('AppBundle:Association')->findOneBy(['user' => $this->getUser()]);


        return $this->render('association/profil/index.html.twig', array(
            'association' => $association,
        ));
    }


    /**
     * Finds and displays a association entity.
     *
     * @Route("/{id}", name="association_show")
     * @Method("GET")
     */
    public function showAction(Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);

        return $this->render('association/profil/show.html.twig', array(
            'association' => $association,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing association entity.
     *
     * @Route("/{id}/edit", name="association_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);
        $editForm = $this->createForm('AppBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('association_edit', array('id' => $association->getId()));
        }

        return $this->render('association/profil/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a association entity.
     *
     * @Route("/{id}", name="association_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Association $association)
    {
        $form = $this->createDeleteForm($association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($association);
            $em->flush();
        }

        return $this->redirectToRoute('association_index');
    }

    /**
     * Creates a form to delete a association entity.
     *
     * @param Association $association The association entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Association $association)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('association_delete', array('id' => $association->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
