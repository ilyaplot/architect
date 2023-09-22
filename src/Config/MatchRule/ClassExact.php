<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRuleInterface;

final class ClassExact implements MatchRuleInterface
{
    /**
     * @psalm-param class-string $className
     */
    public function __construct(
        private readonly string $className,
    ) {
    }

    public function isSatisfiedBy(TokenInterface $token): bool
    {
        return $this->className === $token->getClassName();
    }
}
