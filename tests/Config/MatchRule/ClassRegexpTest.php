<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\ClassRegexp;
use PHPUnit\Framework\TestCase;

class ClassRegexpTest extends TestCase
{
    public function testMatching(): void
    {
        $tokenMock = self::createMock(TokenInterface::class);
        $tokenMock->expects($this->exactly(2))
            ->method('getClassName')
            ->willReturn(self::class);

        $correctRule = new ClassRegexp('/^' . preg_quote(self::class, '/') . '$/');
        $this->assertTrue($correctRule->isSatisfiedBy($tokenMock));

        $incorrectRule = new ClassRegexp('/^abcd$/');
        $this->assertFalse($incorrectRule->isSatisfiedBy($tokenMock));

        $nullTokenMock = self::createMock(TokenInterface::class);
        $nullTokenMock->expects($this->once())
            ->method('getClassName')
            ->willReturn(null);

        $this->assertFalse($incorrectRule->isSatisfiedBy($nullTokenMock));
    }
}
