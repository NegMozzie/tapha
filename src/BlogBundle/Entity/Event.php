<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * 
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="starts_at", type="datetime")
     */
    protected $startsAt;

    /**
     * @ORM\Column(name="ends_at", type="datetime")
     */
    protected $endsAt;

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Event", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Event", mappedBy="parent")
     */
    protected $children;
    /**
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Team", inversedBy="events")
     * @ORM\JoinTable(name="event_team_relation",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")})
     *
     */
    protected $teams;
    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Taxonomy")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $category;

    /**
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Classement", inversedBy="events")
     * @ORM\JoinTable(name="event_classement_relation",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classement_id", referencedColumnName="id")})
     *
     */
    private $classements;

    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Comment", mappedBy="article")
     */
    protected $comments;
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="excerpt_photo_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $excerptPhoto;
    

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->classements = new ArrayCollection();

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
    /**
     * Set endsAt.
     *
     * @param \DateTime $endsAt
     *
     * @return AbstractEvent
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    /**
     * Get endsAt.
     *
     * @return \DateTime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * Set startsAt.
     *
     * @param \DateTime $startsAt
     *
     * @return AbstractEvent
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * Get startsAt.
     *
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param Event $child
     *
     * @deprecated only used by the AdminHelper
     */
    public function addChildren(Event $child)
    {
        $this->addChild($child, true);
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(Event $child)
    {
        $this->children[] = $child;
        $child->setParent($this, true);
        
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(Event $childToDelete)
    {
        foreach ($this->getChildren() as $pos => $child) {
            if ($childToDelete->getId() && $child->getId() === $childToDelete->getId()) {
                unset($this->children[$pos]);

                return;
            }

            if (!$childToDelete->getId() && $child === $childToDelete) {
                unset($this->children[$pos]);

                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren($children)
    {
        $this->children = new ArrayCollection();

        foreach ($children as $category) {
            $this->addChild($category);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasChildren()
    {
        return count($this->children) > 0;
    }
    
     /**
     * @return mixed
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;

        return $this;
    }

    public function addTeam(Team $team)
    {
        if(!$this->teams->contains($team))
        {
            $team->setEvent($this);
            $this->teams->add($team);
        }
    }

    public function removeTeam(Team $team)
    {
        if($this->teams->contains($team))
        {
            $team->setEvent(null);
            $this->teams->removeElement($team);
        }
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
    public function setParent(Event $parent=null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(Taxonomy $category)
    {
        $this->category = $category;

        return $this;
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
            $comment->setArticle($this);
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comment $comment)
    {
        if($this->comments->contains($comment))
        {
            $comment->setArticle(null);
            $this->comments->removeElement($comment);
        }
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param BClassement $classements
     */
    public function addClassement(Classement $classement) {
        $classement->setEvent($this);
 
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

    /**
     * (Add this method into your class)
     *
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->name;
    }

}