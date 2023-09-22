<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRuleInterface;

final class FilepathRegexp implements MatchRuleInterface
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
        $filepath = $token->getFilepath();
        if ($filepath === null) {
            return false;
        }

        return preg_match($this->pattern, $filepath) === 1;
    }
}
