<?php
// src/AppBundle/Entity/User.php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use ReflectGen\Bundle\Entity\Traits\PlatformAwareTrait;
use ReflectGen\Bundle\Framework\Validator\Constraints as ReflectGenAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="pilotes")
 */
class Pilot extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = "1",
     *     max = "128",
     *     minMessage = "The first name must be at least {{ limit }} characters length",
     *     maxMessage = "The first name cannot be longer than {{ limit }} characters length"
     * )
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = "1",
     *     max = "128",
     *     minMessage = "The last name must be at least {{ limit }} characters length",
     *     maxMessage = "The last name cannot be longer than {{ limit }} characters length"
     * )
     */
    private $lastName;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;
     /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="excerpt_photo_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $excerptPhoto;
     /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $team;

     /**
     * @var ArrayCollection $classements
     *
     * @ORM\OneToMany(targetEntity="Classement", mappedBy="pilot", cascade={"persist", "remove", "merge"})
     */
    private $classements;
   

    public function __construct()
    {
        parent::__construct();
        $this->classements = new ArrayCollection();

        // your own logic
    }

   
    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam(Team $team=null)
    {
        $this->team = $team;

        return $this;
    }
    
    public function __toString()
    {
        return $this->getFullName() ?: 'n/a';
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * @return mixed
     */
    public function getExcerptPhoto()
    {
        return $this->excerptPhoto;
    }

    /**
     * @param mixed $excerptPhoto
     */
    public function setExcerptPhoto($excerptPhoto)
    {
        $this->excerptPhoto = $excerptPhoto;

        return $this;
    }


    public function setBiography($biography)
    {
        $this->biography = $biography;
        return $this;
    }
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param BClassement $classements
     */
    public function addClassement(Classement $classement) {
        $classement->setPilot($this);
 
        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->classements->contains($classement)) {
            $this->classements->add($classement);
        }
    }
 
    /**
     * @return ArrayCollection $classements
     */
    public function getClassements() {
        return $this->classements;
    }

    /**
     * @param mixed $categories
     */
    public function setClassement($classements)
    {
        $this->classements = $classements;

        return $this;
    }

    public function removeClassement(Classement $classement)
    {
        if($this->classements->contains($classement))
        {
            $this->classements->removeElement($classement);
        }
    }

}