<?php

namespace EtudiantBundle\Controller;

use AppBundle\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
/**
 * Profil controller.
 *
 * @Route("etudiant")
 */
class DefaultController extends Controller
{
    /**
     * Lists all etudiant entities.
     *
     * @Route("/", name="etudiant_homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etudiant = $em->getRepository('AppBundle:Etudiant')->findOneBy(["user"=>$this->getUser()]);
        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        return $this->render('etudiant/profil/index.html.twig', array(
            'etudiant' => $etudiant
        ));
    }



    /**
     * Displays a form to edit an existing etudiant entity.
     *
     * @Route("/{id}/edit", name="etudiant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etudiant $etudiant)
    {
        $deleteForm = $this->createDeleteForm($etudiant);
        $editForm = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_edit', array('id' => $etudiant->getId()));
        }

        return $this->render('etudiant/profil/edit.html.twig', array(
            'etudiant' => $etudiant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etudiant entity.
     *
     * @Route("/{id}", name="etudiant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etudiant $etudiant)
    {
        $form = $this->createDeleteForm($etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }

    /**
     * Creates a form to delete a etudiant entity.
     *
     * @param Etudiant $etudiant The etudiant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etudiant $etudiant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etudiant_delete', array('id' => $etudiant->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
