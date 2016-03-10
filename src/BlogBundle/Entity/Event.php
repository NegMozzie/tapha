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
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Season", inversedBy="events")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $season;

    /**
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Team", inversedBy="events")
     * @ORM\JoinTable(name="event_team_relation",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")})
     *
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Comment", mappedBy="event")
     */
    protected $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="excerpt_photo_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $excerptPhoto;
    
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
     * @var ArrayCollection $classements
     *
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Classement", mappedBy="event", cascade={"persist", "remove", "merge"})
     */
    protected $classements;
    
    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Taxonomy")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $category;

    

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->c_pilot = new ArrayCollection();

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
    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    /**
     * Set name
     *
     * @param Season $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }
    /**
     * Get name
     *
     * @return string 
     */
    public function getSeason()
    {
        return $this->season;
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
     * @return AbstractSeasonevent
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
     * @return AbstractSeasonevent
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
    public function addCPilot(Classement $classement) {
        $classement->setSeasonevent($this);
 
        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->classements->contains($classement)) {
            $this->classements->add($classement);
        }
    }
 
    /**
     * @return ArrayCollection $classements
     */
    public function getCPilots() {
        return $this->cPilots;
    }

    /**
     * @param mixed $categories
     */
    public function setCPilot($classements)
    {
        $this->classements = $classements;

        return $this;
    }

    public function removeCPilot(Classement $classement)
    {
        if($this->classements->contains($classement))
        {
            $this->classements->removeElement($classement);
        }
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
            $team->setSeasonevent($this);
            $this->teams->add($team);
        }
    }

    public function removeTeam(Team $team)
    {
        if($this->teams->contains($team))
        {
            $team->setSeasonevent(null);
            $this->teams->removeElement($team);
        }
    }

    /**
     * (Add this method into your class)
     *
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->name.'('.$this->season.')';
    }

}