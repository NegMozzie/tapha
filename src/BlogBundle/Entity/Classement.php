<?php


namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Eko\FeedBundle\Item\Writer\RoutedItem;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Table(name="classement")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\ClassementRepository")
 */
class Classement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column()
     * 
     */
    protected $name;
    

    /**
     * Articles in the taxonomy
     *
     * @ORM\Column(type="integer", nullable=true, options={"default" = 0})
     */
    protected $points;

    /**
     * Articles in the taxonomy
     *
     * @ORM\Column(type="integer", nullable=true, options={"default" = 0})
     */
    protected $rank;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $time;

     /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Pilot", inversedBy="classements")
     * @ORM\JoinColumn(name="pilot_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $pilot;
    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Team", inversedBy="classements")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $team;



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
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @param mixed $points
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    
     /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $parent
     */
    public function setTeam(Team $team=null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPilot()
    {
        return $this->pilot;
    }

    /**
     * @param mixed $parent
     */
    public function setPilot(Pilot $pilot=null)
    {
        $this->pilot = $pilot;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
