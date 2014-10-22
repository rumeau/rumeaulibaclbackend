<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 21/10/2014
 * Time: 23:17
 */

namespace RumeauLibAclBackend\Controller;


use BjyAuthorize\Provider\Role\Config;
use BjyAuthorize\Provider\Role\ObjectRepositoryProvider;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use RumeauLibAclBackend\Mapper\RoleMapperInterface;
use Zend\Permissions\Acl\Role\RoleInterface;

class RolesController extends AbstractActionController implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    /**
     * @return array
     */
    public function indexAction()
    {
        $roleProvider = $this->getServiceLocator()->get('BjyAuthorize\RoleProviders');
        $roles = [];
        foreach ($roleProvider as $provider) {
            $providedRoles = $provider->getRoles();
            $hard = true;
            if (!$provider instanceof Config) {
                $hard = false;
            }
            /**
             * @var \BjyAuthorize\Acl\HierarchicalRoleInterface $role
             */
            foreach ($providedRoles as $role) {
                $roles[$role->getRoleId()] = [
                    'hard' => $hard,
                    'role' => $role
                ];
            }
        }

        $roles = $this->mergeDescription($roles, $roleProvider);

        return [
            'roles' => $roles,
        ];
    }

    /**
     *
     */
    public function createAction()
    {
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        /**
         * @var \RumeauLibAclBackend\Form\Role $form
         */
        $form        = $formManager->get('RumeauLibAclBackend\Form\Role');

        $url         = $this->url()->fromRoute(
            'admin/rumeaulibaclbackend-acl',
            ['controller' => 'roles', 'action' => 'create']
        );

        $prg         = $this->prg($url, true);
        if ($prg instanceof Response) {
            return $prg;
        } elseif (is_array($prg)) {
            $form->setData($prg);
            if ($form->isValid()) {
                /**
                 * @var RoleMapperInterface $roleMapper
                 */
                $roleMapper = $this->getServiceLocator()->get('RumeauLibAclBackend\Mapper\Role');
                $result = $roleMapper->insert($form->getObject());
                if ($result instanceof RoleInterface) {
                    $this->flashMessenger()->addSuccessMessage('The Role has been created');
                    return $this->redirect()->toRoute(
                        'admin/rumeaulibaclbackend-acl',
                        ['controller' => 'roles']
                    );
                }
            }
        }

        $form->setAttribute('action', $url);
        $form->setAttribute('class', 'horizontal');
        $form->prepare();

        return [
            'form' => $form,
        ];
    }

    /**
     *
     */
    public function editAction()
    {
        $roleId     = $this->params()->fromQuery('id');
        /**
         * @var RoleMapperInterface $roleMapper
         */
        $roleMapper = $this->getServiceLocator()->get('RumeauLibAclBackend\Mapper\Role');
        $role       = $roleMapper->find($roleId);

        if (!$role instanceof RoleInterface) {
            $this->flashMessenger()->addErrorMessage('The Role requested for edit was not found');
            return $this->redirect()->toRoute(
                'admin/rumeaulibaclbackend-acl',
                ['controller' => 'roles']
            );
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form        = $formManager->get('RumeauLibAclBackend\Form\Role');
        $form->bind($role);

        $url         = $this->url()->fromRoute(
            'admin/rumeaulibaclbackend-acl',
            ['controller' => 'roles', 'action' => 'edit'],
            ['query' => ['id' => $role->getRoleId()]]
        );

        $prg         = $this->prg($url, true);
        if ($prg instanceof Response) {
            return $prg;
        } elseif (is_array($prg)) {
            $form->setData($prg);
            if ($form->isValid()) {
                $result = $roleMapper->update($role);
                if ($result instanceof RoleInterface) {
                    $this->flashMessenger()->addSuccessMessage('The Role has been updated');
                    return $this->redirect()->toRoute(
                        'admin/rumeaulibaclbackend-acl',
                        ['controller' => 'roles']
                    );
                }
            }
        }

        $form->setAttribute('action', $url);
        $form->setAttribute('class', 'horizontal');
        $form->prepare();

        return [
            'form' => $form,
        ];
    }

    protected function mergeDescription($roles)
    {
        $roleMapper = $this->getServiceLocator()->get('RumeauLibAclBackend\Mapper\Role');
        $dbRoles    = $roleMapper->findIndexed(true);
        foreach ($roles as $key => $role) {
            if (isset($dbRoles[$role['role']->getRoleId()])) {
                $roles[$key]['description'] = $dbRoles[$role['role']->getRoleId()]['description'];
            }
        }

        return $roles;
    }
}
