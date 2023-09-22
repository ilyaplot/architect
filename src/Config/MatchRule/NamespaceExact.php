<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRuleInterface;

final class NamespaceExact implements MatchRuleInterface
{
    /**
     * @psalm-param non-empty-string $namespace
     */
    public function __construct(
        private readonly string $namespace,
    ) {
    }

    public function isSatisfiedBy(TokenInterface $token): bool
    {
        return $this->namespace === $token->getNamespace();
    }
}
