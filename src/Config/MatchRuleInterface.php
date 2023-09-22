<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config;

use Ilyaplot\Architect\Application\TokenInterface;

interface MatchRuleInterface
{
    public function isSatisfiedBy(TokenInterface $token): bool;
}
