<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRuleInterface;

final class OrCollection implements MatchRuleInterface
{
    /**
     * @param list<MatchRuleInterface> $matchRules
     */
    public function __construct(
        private readonly array $matchRules,
    ) {
    }

    public function isSatisfiedBy(TokenInterface $token): bool
    {
        foreach ($this->matchRules as $matchRule) {
            if ($matchRule->isSatisfiedBy($token) === true) {
                return true;
            }
        }

        return false;
    }
}
