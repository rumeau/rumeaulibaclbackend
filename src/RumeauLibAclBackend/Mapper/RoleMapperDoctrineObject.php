<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 22/10/2014
 * Time: 0:40
 */

namespace RumeauLibAclBackend\Mapper;

use Doctrine\ORM\EntityManager;
use RumeauLibAclBackend\Options\ModuleOptions;

class RoleMapperDoctrineObject implements RoleMapperInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ModuleOptions
     */
    protected $options;

    public function __construct($em, $options)
    {
        $this->em      = $em;
        $this->options = $options;
    }

    public function update($role)
    {
        return $this->persist($role);
    }

    public function insert($role)
    {
        return $this->persist($role);
    }

    public function find($roleId)
    {
        $role = $this->em->getRepository($this->options->getRoleEntityClass())->findOneBy([
            'roleId' => $roleId
        ]);

        return $role;
    }

    public function findIndexed($toArray = false)
    {
        $dql   = $this->em->createQuery(
            'SELECT r FROM ' . $this->options->getRoleEntityClass() . ' r INDEX BY r.roleId'
        );
        $roles = $dql->getArrayResult();

        return $roles;
    }

    protected function persist($role)
    {
        $this->em->persist($role);
        $this->em->flush();

        return $role;
    }
}
