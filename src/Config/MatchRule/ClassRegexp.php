<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRuleInterface;

final class ClassRegexp implements MatchRuleInterface
{
    /**
     * @psalm-param non-empty-string $pattern
     */
    public function __construct(
        private readonly string $pattern,
    ) {
    }

    public function isSatisfiedBy(TokenInterface $token): bool
    {
        $className = $token->getClassName();
        if ($className === null) {
            return false;
        }

        return preg_match($this->pattern, $className) === 1;
    }
}
