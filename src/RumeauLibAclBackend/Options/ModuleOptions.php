<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 22/10/2014
 * Time: 0:49
 */

namespace RumeauLibAclBackend\Options;


class ModuleOptions
{
    /**
     * @var
     */
    protected $roleEntityClass;

    public function __construct($config)
    {
        if (isset($config['role_entity_class'])) {
            $this->setRoleEntityClass($config['role_entity_class']);
        }
    }

    public function setRoleEntityClass($roleEntityClass)
    {
        $this->roleEntityClass = $roleEntityClass;
    }

    public function getRoleEntityClass()
    {
        return $this->roleEntityClass;
    }
}
