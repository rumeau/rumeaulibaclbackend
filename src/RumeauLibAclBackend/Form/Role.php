<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 22/10/2014
 * Time: 0:59
 */

namespace RumeauLibAclBackend\Form;

use Application\Entity\Role as RoleEntity;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * This form can be overrided by adding an alias to RumeauLibAclBackend\Form\Role
 * as it is loaded through the FormElementManager
 *
 * Class Role
 * @package RumeauLibAclBackend\Form
 */
class Role extends Form implements ServiceLocatorAwareInterface, ObjectManagerAwareInterface
{
    use ServiceLocatorAwareTrait;
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineObject($this->getObjectManager()));
        $this->setObject(new RoleEntity());

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'roleId',
            'options' => [
                'label' => 'Role ID',
                'label_attributes' => ['class' => 'col-md-3'],
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-9 col-md-9'
            ],
            'attributes' => [
                'placeholder' => 'Role ID',
            ],
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'parent',
            'options' => [
                'label' => 'Parent Role',
                'label_attributes' => ['class' => 'col-md-3'],
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Application\Entity\Role',
                'property' => 'roleId',
                'display_empty_item' => true,
                'empty_item_label' => 'No Parent',
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-9 col-md-9',
            ],
            'attributes' => [

            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => [
                'label' => 'Description',
                'label_attributes' => ['class' => 'col-md-3'],
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-9 col-md-9'
            ],
            'attributes' => [
                'rows' => 3,
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'formcsrf',
        ]);
    }
}
