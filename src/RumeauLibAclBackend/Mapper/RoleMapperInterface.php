<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 22/10/2014
 * Time: 0:37
 */

namespace RumeauLibAclBackend\Mapper;

/**
 * Interface RoleMapperInterface
 * @package RumeauLibAclBackend\Mapper
 */
interface RoleMapperInterface
{
    public function update($role);

    public function insert($role);

    public function find($roleId);

    public function findIndexed($toArray = false);
} 