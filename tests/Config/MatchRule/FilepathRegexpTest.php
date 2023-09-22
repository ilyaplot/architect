<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\FilepathRegexp;
use PHPUnit\Framework\TestCase;

class FilepathRegexpTest extends TestCase
{
    public function testMatching(): void
    {
        $tokenMock = self::createMock(TokenInterface::class);
        $tokenMock->expects($this->exactly(2))
            ->method('getFilepath')
            ->willReturn(__FILE__);

        $correctRule = new FilepathRegexp('/^' . preg_quote(__FILE__, '/') . '$/');
        $this->assertTrue($correctRule->isSatisfiedBy($tokenMock));

        $incorrectRule = new FilepathRegexp('/^abcd$/');
        $this->assertFalse($incorrectRule->isSatisfiedBy($tokenMock));

        $nullTokenMock = self::createMock(TokenInterface::class);
        $nullTokenMock->expects($this->once())
            ->method('getFilepath')
            ->willReturn(null);

        $this->assertFalse($incorrectRule->isSatisfiedBy($nullTokenMock));
    }
}
