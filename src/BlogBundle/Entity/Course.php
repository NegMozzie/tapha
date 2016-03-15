<?php


namespace BlogBundle\Entity;

use BlogBundle\Model\Event;
use BlogBundle\Entity\GrandPrix;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\CourseRepository")
 */
class Course extends Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\GrandPrix", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    
    protected $parent;
    
    /**
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Comment")
     * @ORM\JoinTable(name="course_classement_relation",
     *      joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classement_id", referencedColumnName="id")})
     *
     */
    protected $classement;

    /**
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Comment")
     * @ORM\JoinTable(name="course_comment_relation",
     *      joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id")})
     *
     */
    protected $comments;


    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent(Grandprix $parent=null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * (Add this method into your class)
     *
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->name.'('.$this->parent.')';
    }

}