<?php


namespace BlogBundle\Entity\Repository;

use ED\BlogBundle\Interfaces\Repository\BlogUserRepositoryInterface;
use ED\BlogBundle\Model\Repository\UserRepository as BaseUserRepository;

class UserRepository extends BaseUserRepository implements BlogUserRepositoryInterface
{
}