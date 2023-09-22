<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\ClassExact;
use PHPUnit\Framework\TestCase;

class ClassExactTest extends TestCase
{
    public function testMatching(): void
    {
        $tokenMock = self::createMock(TokenInterface::class);
        $tokenMock->expects($this->exactly(2))
            ->method('getClassName')
            ->willReturn(self::class);

        $correctRule = new ClassExact(self::class);
        $this->assertTrue($correctRule->isSatisfiedBy($tokenMock));

        $incorrectRule = new ClassExact(TestCase::class);
        $this->assertFalse($incorrectRule->isSatisfiedBy($tokenMock));
    }
}
