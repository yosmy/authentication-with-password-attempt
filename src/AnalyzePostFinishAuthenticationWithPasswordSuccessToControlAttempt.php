<?php

namespace Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.post_finish_authentication_with_password_success',
 *     ]
 * })
 */
class AnalyzePostFinishAuthenticationWithPasswordSuccessToControlAttempt implements AnalyzePostFinishAuthenticationWithPasswordSuccess
{
    /**
     * @var DeleteAttempt
     */
    private $deleteAttempt;

    /**
     * @param DeleteAttempt $deleteAttempt
     */
    public function __construct(
        DeleteAttempt $deleteAttempt
    ) {
        $this->deleteAttempt = $deleteAttempt;
    }

    /**
     * {@inheritDoc}
     */
    public function analyze(
        string $device,
        string $country,
        string $prefix,
        string $number
    ) {
        unset($device);

        $this->deleteAttempt->delete(
            'yosmy.finish_authentication_with_password',
            sprintf('phone-%s-%s-%s', $country, $prefix, $number)
        );
    }
}
