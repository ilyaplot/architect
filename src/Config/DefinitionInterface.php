<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config;

use Ilyaplot\Architect\Application\LayerInterface;

interface DefinitionInterface
{
    public function getLayer(): LayerInterface;

    /**
     * @psalm-return iterable<MatchRuleInterface>
     */
    public function getInclusionRules(): iterable;

    /**
     * @psalm-return iterable<MatchRuleInterface>
     */
    public function getExclusionRules(): iterable;
}
