<?php


namespace Framework\Container;

use Psr\Container\ContainerInterface;


class Container implements ContainerInterface
{
    private $definitions = [];
    private $results = [];

    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    public  function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }
        if (!array_key_exists($id, $this->definitions)) {
            if (class_exists($id)) {
                $reflection = new \ReflectionClass($id);
                $arguments = [];
                if (($constructor = $reflection->getConstructor()) !== null) {
                    foreach ($constructor->getParameters() as $parameter) {
                        if ($paramClass = $parameter->getClass()) {
                            $arguments[] = $this->get($paramClass->getName());
                        } elseif ($parameter->isArray()) {
                            $arguments[] = [];
                        } else {
                            if (!$parameter->isDefaultValueAvailable()) {
                                throw new ServiceNotFoundException('Unable to resolve "' . $parameter->getName() . '"" in service "' .$id . '"');
                            }
                            $arguments[] = $parameter->getDefaultValue();
                        }
                        //$arguments[] = $this->get($paramClass->getName());
                    }
                }
                $this->results[$id] = $reflection->newInstanceArgs($arguments);
                return $this->results[$id];
            }
            throw new ServiceNotFoundException('Unknown service "' . $id . '"');
        }
        $definition = $this->definitions[$id];
        if ($definition instanceof \Closure) {
            $this->results[$id] = $definition($this);
        } else {
            $this->results[$id] = $definition;
        }
        return $this->results[$id];
    }

    public  function set($id, $value): void
    {
        if (array_key_exists($id, $this->results)) {
            unset($this->results[$id]);
        }
        $this->definitions[$id] = $value;
    }

    public function has($id): bool
    {
        return array_key_exists($id, $this->definitions) || class_exists($id);
    }
}