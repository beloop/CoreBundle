<?php

/*
 * This file is part of the Beloop package.
 *
 * Copyright (c) 2016 AHDO Studio B.V.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Arkaitz Garro <arkaitz.garro@gmail.com>
 */

namespace Beloop\Bundle\CoreBundle\Container\Traits;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Beloop\Component\Core\Factory\Abstracts\AbstractFactory;
use Beloop\Component\Core\Services\ObjectDirector;

/**
 * Trait ContainerAccessorTrait.
 */
trait ContainerAccessorTrait
{
    /**
     * @var ContainerInterface
     *
     * Container
     */
    protected static $container;

    /**
     * Get manager given its its entity name.
     *
     * @param string $entityName Entity name
     *
     * @return ObjectManager Manager
     */
    public function getObjectManager($entityName)
    {
        return self::$container->get('beloop.object_manager.' . $entityName);
    }

    /**
     * Get entity repository given its entity name.
     *
     * @param string $entityName Entity name
     *
     * @return EntityRepository Repository
     */
    public function getRepository($entityName)
    {
        return self::$container->get('beloop.repository.' . $entityName);
    }

    /**
     * Get factory given its its entity name.
     *
     * @param string $entityName Entity name
     *
     * @return AbstractFactory Factory
     */
    public function getFactory($entityName)
    {
        return self::$container->get('beloop.factory.' . $entityName);
    }

    /**
     * Get director given its its entity name.
     *
     * @param string $entityName Entity name
     *
     * @return ObjectDirector Director
     */
    public function getDirector($entityName)
    {
        return self::$container->get('beloop.director.' . $entityName);
    }

    /**
     * Get container service.
     *
     * @param string $serviceName Container service name
     *
     * @return mixed The associated service
     */
    public function get($serviceName)
    {
        return self::$container->get($serviceName);
    }

    /**
     * Get container parameter.
     *
     * @param string $parameterName Container parameter name
     *
     * @return mixed The required parameter value
     */
    public function getParameter($parameterName)
    {
        return self::$container->getParameter($parameterName);
    }

    /**
     * Get the entity instance with id $id.
     *
     * @param string $entityName Entity name
     * @param mixed  $id         Instance id
     *
     * @return mixed Entity
     */
    public function find($entityName, $id)
    {
        return $this
            ->getRepository($entityName)
            ->find($id);
    }

    /**
     * Get all entity instances.
     *
     * @param string $entityName Entity name
     *
     * @return array Result
     */
    public function findAll($entityName)
    {
        return $this
            ->getRepository($entityName)
            ->findAll();
    }

    /**
     * Save an entity. To ensure the method is simple, the entity will be
     * persisted always.
     *
     * @param mixed $entity Entity
     *
     * @return $this Self object
     */
    public function flush($entity)
    {
        /**
         * @var ObjectManager $objectManager
         */
        $objectManager = $this
            ->get('beloop.provider.manager')
            ->getManagerByEntityNamespace(get_class($entity));

        $objectManager->persist($entity);
        $objectManager->flush($entity);

        return $this;
    }

    /**
     * Remove an entity from ORM map.
     *
     * @param mixed $entity Entity
     *
     * @return $this Self object
     */
    public function clear($entity)
    {
        /**
         * @var ObjectManager $objectManager
         */
        $objectManager = $this
            ->get('beloop.provider.manager')
            ->getManagerByEntityNamespace(get_class($entity));

        $objectManager->clear($entity);

        return $this;
    }
}