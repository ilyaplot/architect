<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Application;

interface LayerInterface
{
    public function getToken(): TokenInterface;

    /**
     * @psalm-return list<LayerInterface>
     */
    public function getDependingOn(): array;
}
