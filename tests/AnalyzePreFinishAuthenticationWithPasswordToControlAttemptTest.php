<?php

namespace Yosmy\Test;

use Yosmy;
use PHPUnit\Framework\TestCase;
use LogicException;

class AnalyzePreFinishAuthenticationWithPasswordToControlAttemptTest extends TestCase
{
    public function testAnalyze()
    {
        $device = 'device';
        $country = 'country';
        $prefix = 'prefix';
        $number = 'number';

        $increaseAttempt = $this->createMock(Yosmy\IncreaseAttempt::class);

        $increaseAttempt->expects($this->once())
            ->method('increase')
            ->with(
                'yosmy.finish_authentication_with_password',
                sprintf('phone-%s-%s-%s', $country, $prefix, $number),
                3,
                '1 day'
            );

        $analyzePreFinishAuthenticationWithPasswordToControlAttempt = new Yosmy\AnalyzePreFinishAuthenticationWithPasswordToControlAttempt(
            $increaseAttempt
        );

        try {
            $analyzePreFinishAuthenticationWithPasswordToControlAttempt->analyze(
                $device,
                $country,
                $prefix,
                $number
            );
        } catch (Yosmy\DeniedAuthenticationException $e) {
            throw new LogicException();
        }
    }

    public function testAnalyzeHavingExceededAttemptException()
    {
        $device = 'device';
        $country = 'country';
        $prefix = 'prefix';
        $number = 'number';

        $increaseAttempt = $this->createMock(Yosmy\IncreaseAttempt::class);

        $increaseAttempt->expects($this->once())
            ->method('increase')
            ->with(
                'yosmy.finish_authentication_with_password',
                sprintf('phone-%s-%s-%s', $country, $prefix, $number),
                3,
                '1 day'
            )
            ->willThrowException(new Yosmy\BaseExceededAttemptException());

        $analyzePreFinishAuthenticationWithPasswordToControlAttempt = new Yosmy\AnalyzePreFinishAuthenticationWithPasswordToControlAttempt(
            $increaseAttempt
        );

        $this->expectException(Yosmy\DeniedAuthenticationException::class);

        $analyzePreFinishAuthenticationWithPasswordToControlAttempt->analyze(
            $device,
            $country,
            $prefix,
            $number
        );
    }
}