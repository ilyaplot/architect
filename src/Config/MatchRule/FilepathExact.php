<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRuleInterface;

final class FilepathExact implements MatchRuleInterface
{
    /**
     * @psalm-param non-empty-string $filepath
     */
    public function __construct(
        private readonly string $filepath,
    ) {
    }

    public function isSatisfiedBy(TokenInterface $token): bool
    {
        return $this->filepath === $token->getFilepath();
    }
}
