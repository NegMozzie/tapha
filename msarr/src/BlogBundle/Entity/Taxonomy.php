<?php

namespace BlogBundle\Entity;

use ED\BlogBundle\Interfaces\Model\BlogTaxonomyInterface;
use ED\BlogBundle\Model\Entity\Taxonomy as BaseTaxonomy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="taxonomy")
 * @ORM\Entity(repositoryClass="ED\BlogBundle\Model\Repository\TaxonomyRepository")
 */
class Taxonomy extends BaseTaxonomy implements BlogTaxonomyInterface
{
}