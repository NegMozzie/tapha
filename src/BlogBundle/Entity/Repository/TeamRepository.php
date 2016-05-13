<?php
namespace BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Taxonomy;
/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

class TeamRepository extends EntityRepository
{
	public function findByTaxonomy($taxonomySlug, $type, $limit = null)
    {
    	$teamClass = $this->_entityName;
        $query = "SELECT a FROM $teamClass a";

        if ($type == Taxonomy::TYPE_TAG)
        {
            $query.=" INNER JOIN a.tags tr";
        }else
        {
            $query.=" INNER JOIN a.categories tr";
        }

        $query.=" INNER JOIN tr.term t
                  WHERE tr.type=:type AND t.slug=:taxonomySlug
                  ORDER BY a.name DESC"
        ;

        $query = $this->getEntityManager()
            ->createQuery($query)
            ->setParameter("type",$type)
            ->setParameter('taxonomySlug',$taxonomySlug);

        if($limit)
        {
            $query->setMaxResults($limit);
        }

        $teams = $query->useQueryCache(true)->setQueryCacheLifetime(60)->getResult();

        return $teams;
    }
}