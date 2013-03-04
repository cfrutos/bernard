<?php

namespace Raekke\Symfony;

use Raekke\Message;
use Symfony\Component\DependencyInjection\Container;

/**
 * @package Raekke
 */
class ContainerAwareResolver implements \Raekke\ServiceResolver
{
    protected $services = array();
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function register($name, $service)
    {
        $this->services[$name] = $service;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Message $message)
    {
        if (!isset($this->services[$message->getName()])) {
            throw new \InvalidArgumentException('No service registered for message "' . $message->getName() . '".');
        }

        return $this->container->get($this->services[$message->getName()]);
    }
}
