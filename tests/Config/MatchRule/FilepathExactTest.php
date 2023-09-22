<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Tests\Config\MatchRule;

use Ilyaplot\Architect\Application\TokenInterface;
use Ilyaplot\Architect\Config\MatchRule\ClassExact;
use Ilyaplot\Architect\Config\MatchRule\FilepathExact;
use PHPUnit\Framework\TestCase;

class FilepathExactTest extends TestCase
{
    public function testMatching(): void
    {
        $tokenMock = self::createMock(TokenInterface::class);
        $tokenMock->expects($this->exactly(2))
            ->method('getFilepath')
            ->willReturn(__FILE__);

        $correctRule = new FilepathExact(__FILE__);
        $this->assertTrue($correctRule->isSatisfiedBy($tokenMock));

        $incorrectRule = new FilepathExact(__DIR__);
        $this->assertFalse($incorrectRule->isSatisfiedBy($tokenMock));
    }
}
