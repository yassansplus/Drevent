<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="commentary", type="text")
     */
    private $commentary;

    /**
     * @var bool
     *
     * @ORM\Column(name="isImportant", type="boolean")
     */
    private $isImportant;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsAutor", type="boolean")
     */
    private $isAutor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $date_publication;

    /**
     * @ORM\ManyToOne(targetEntity="Etudiant")
     * @ORM\JoinColumn(name="etudiant_id", referencedColumnName="id")
     */
    private $etudiant;
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Publication", inversedBy="commentaires")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id")
     */
    private $publication;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set commentary
     *
     * @param string $commentary
     *
     * @return Commentaire
     */
    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;

        return $this;
    }

    /**
     * Get commentary
     *
     * @return string
     */
    public function getCommentary()
    {
        return $this->commentary;
    }

    /**
     * Set isImportant
     *
     * @param boolean $isImportant
     *
     * @return Commentaire
     */
    public function setIsImportant($isImportant)
    {
        $this->isImportant = $isImportant;

        return $this;
    }

    /**
     * Get isImportant
     *
     * @return boolean
     */
    public function getIsImportant()
    {
        return $this->isImportant;
    }

    /**
     * Set isAutor
     *
     * @param boolean $isAutor
     *
     * @return Commentaire
     */
    public function setIsAutor($isAutor)
    {
        $this->isAutor = $isAutor;

        return $this;
    }

    /**
     * Get isAutor
     *
     * @return boolean
     */
    public function getIsAutor()
    {
        return $this->isAutor;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Commentaire
     */
    public function setDatePublication($datePublication)
    {
        $this->date_publication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->date_publication;
    }

    /**
     * Set etudiant
     *
     * @param \AppBundle\Entity\Etudiant $etudiant
     *
     * @return Commentaire
     */
    public function setEtudiant(\AppBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \AppBundle\Entity\Etudiant
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set publication
     *
     * @param \AppBundle\Entity\Publication $publication
     *
     * @return Commentaire
     */
    public function setPublication(\AppBundle\Entity\Publication $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \AppBundle\Entity\Publication
     */
    public function getPublication()
    {
        return $this->publication;
    }
}
