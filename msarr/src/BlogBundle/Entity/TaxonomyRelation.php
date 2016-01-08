<?php

namespace BlogBundle\Entity;

use ED\BlogBundle\Interfaces\Model\TaxonomyRelationInterface;
use ED\BlogBundle\Model\Entity\TaxonomyRelation as BaseTaxonomyRelation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="taxonomy_relation")
 * @ORM\Entity()
 */
class TaxonomyRelation extends BaseTaxonomyRelation implements TaxonomyRelationInterface
{
}