<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\NamespaceExact;
use PHPUnit\Framework\TestCase;

class NamespaceExactTest extends TestCase
{
    public function testMatching(): void
    {
        $tokenMock = self::createMock(TokenInterface::class);
        $tokenMock->expects($this->exactly(2))
            ->method('getNamespace')
            ->willReturn(__NAMESPACE__);

        $correctRule = new NamespaceExact(__NAMESPACE__);
        $this->assertTrue($correctRule->isSatisfiedBy($tokenMock));

        $incorrectRule = new NamespaceExact('PHPUnit\Framework');
        $this->assertFalse($incorrectRule->isSatisfiedBy($tokenMock));
    }
}
