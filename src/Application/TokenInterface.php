<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Application;

use Stringable;

interface TokenInterface extends Stringable
{
    public function getFilepath(): ?string;

    /**
     * @psalm-return ?class-string
     */
    public function getClassName(): ?string;

    public function getNamespace(): ?string;

    public function equals(TokenInterface $token): bool;
}
