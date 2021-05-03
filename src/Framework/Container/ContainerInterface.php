<?php

namespace Framework\Container;

interface ContainerInterface
{
    /**
     * @param $id
     * @return mixed
     * @throw NotFoundExceptionInterface
     */
    public function get($id);

    public function has($id): bool;
}