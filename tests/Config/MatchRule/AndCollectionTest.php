<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\AndCollection;
use Ilyaplot\Architect\Config\MatchRuleInterface;
use PHPUnit\Framework\TestCase;

class AndCollectionTest extends TestCase
{
    public function testMatching(): void
    {
        $firstMock = $this->createMock(MatchRuleInterface::class);
        $firstMock->expects($this->once())
            ->method('isSatisfiedBy')
            ->willReturn(true);

        $secondMock = $this->createMock(MatchRuleInterface::class);
        $secondMock->expects($this->once())
            ->method('isSatisfiedBy')
            ->willReturn(false);

        $thirdMock = $this->createMock(MatchRuleInterface::class);
        $thirdMock->expects($this->never())
            ->method('isSatisfiedBy');

        $successfulRule = new AndCollection([
            $firstMock,
            $secondMock,
            $thirdMock
        ]);

        $tokenMock = $this->createMock(TokenInterface::class);

        $this->assertFalse($successfulRule->isSatisfiedBy($tokenMock));

        $emptyRule = new AndCollection([]);
        $this->assertFalse($emptyRule->isSatisfiedBy($tokenMock));

    }
}
