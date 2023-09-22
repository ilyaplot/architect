<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\OrCollection;
use Ilyaplot\Architect\Config\MatchRuleInterface;
use PHPUnit\Framework\TestCase;

class OrCollectionTest extends TestCase
{
    public function testMatching(): void
    {
        $firstMock = $this->createMock(MatchRuleInterface::class);
        $firstMock->expects($this->once())
            ->method('isSatisfiedBy')
            ->willReturn(false);

        $secondMock = $this->createMock(MatchRuleInterface::class);
        $secondMock->expects($this->once())
            ->method('isSatisfiedBy')
            ->willReturn(true);

        $thirdMock = $this->createMock(MatchRuleInterface::class);
        $thirdMock->expects($this->never())
            ->method('isSatisfiedBy');

        $successfulRule = new OrCollection([
            $firstMock,
            $secondMock,
            $thirdMock
        ]);

        $tokenMock = $this->createMock(TokenInterface::class);

        $this->assertTrue($successfulRule->isSatisfiedBy($tokenMock));

        $emptyRule = new OrCollection([]);
        $this->assertFalse($emptyRule->isSatisfiedBy($tokenMock));
    }
}
