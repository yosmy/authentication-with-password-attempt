<?php

namespace Yosmy\Test;

use Yosmy;
use PHPUnit\Framework\TestCase;

class AnalyzePostFinishAuthenticationWithPasswordSuccessToControlAttemptTest extends TestCase
{
    public function testAnalyze()
    {
        $device = 'device';
        $country = 'country';
        $prefix = 'prefix';
        $number = 'number';

        $deleteAttempt = $this->createMock(Yosmy\DeleteAttempt::class);

        $deleteAttempt->expects($this->once())
            ->method('delete')
            ->with(
                'yosmy.finish_authentication_with_password',
                sprintf('phone-%s-%s-%s', $country, $prefix, $number)
            );

        $analyzePostFinishAuthenticationWithPasswordSuccessToControlAttempt = new Yosmy\AnalyzePostFinishAuthenticationWithPasswordSuccessToControlAttempt(
            $deleteAttempt
        );

        $analyzePostFinishAuthenticationWithPasswordSuccessToControlAttempt->analyze(
            $device,
            $country,
            $prefix,
            $number
        );
    }
}