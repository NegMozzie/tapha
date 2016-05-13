<?php


namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use BlogBundle\Model\Event;
use BlogBundle\Entity\GrandPrix;
use BlogBundle\Entity\Comment;
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
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Classement")
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

    public function __construct()
    {
        parent::__construct();
        $this->comments = new ArrayCollection();
    }
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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function addComment(Comment $comment)
    {
        if(!$this->comments->contains($comment))
        {
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comment $comment)
    {
        if($this->comments->contains($comment))
        {
            $this->comments->removeElement($comment);
        }
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

    public function getDay($month)
    {
        $stringmonth= "";
        $month = date('w', $month);


        switch($month)
        {
            case "1" :
                $stringmonth = "Lundi";
                break;
            case "2" :
                $stringmonth = "Mardi";
                break;
            case "3" :
                $stringmonth = "Mercredi";
                break;
            case "4" :
                $stringmonth = "Jeudi";
                break;
            case "5" :
                $stringmonth = "Vendredi";
                break;
            case "6" :
                $stringmonth = "Samedi";
                break;
            case "7" :
                $stringmonth = "Dimanche";
                break;
        }

        return $stringmonth;
    }

}