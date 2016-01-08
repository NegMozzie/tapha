<?php


namespace BlogBundle\Entity;

use ED\BlogBundle\Interfaces\Model\ArticleInterface;
use ED\BlogBundle\Model\Entity\Article as BaseArticle;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="article")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="ED\BlogBundle\Model\Repository\ArticleRepository")
 */
class Article extends BaseArticle implements ArticleInterface
{

    /**
     * @ORM\ManyToMany(targetEntity="ED\BlogBundle\Interfaces\Model\BlogTaxonomyInterface", inversedBy="articles")
     * @ORM\JoinTable(name="article_category_relation",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     *
     */
    protected $categories;

    /**
     * @ORM\ManyToMany(targetEntity="ED\BlogBundle\Interfaces\Model\BlogTaxonomyInterface", inversedBy="tagged")
     * @ORM\JoinTable(name="article_tags_relation",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")})
     *
     */
    protected $tags;
    /**
     * Use this over getExcept in frontend display
     * @return mixed
     */
    public function getText()
    {
        
        $rowExcerpt = strip_tags($this->content);

            if( strlen($rowExcerpt) > self::EXCERPT_LENGTH)
            {
                $break = strpos($rowExcerpt, ' ', self::EXCERPT_LENGTH - 10);
                $rowExcerpt = substr($rowExcerpt, 0, $break) . '...';
            }

            return $rowExcerpt;
    }
}