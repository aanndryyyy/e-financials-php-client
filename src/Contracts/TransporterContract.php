<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts;

use EFinancialsClient\Exceptions\ErrorException;
use EFinancialsClient\Exceptions\TransporterException;
use EFinancialsClient\Exceptions\UnserializableResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;

/**
 * @internal
 */
interface TransporterContract
{
    /**
     * Sends a request expecting a decoded JSON array/object back.
     *
     * @return Response<array<array-key, mixed>>
     *
     * @throws ErrorException|UnserializableResponse|TransporterException
     */
    public function request(Payload $payload): Response;

    /**
     * Sends a request expecting raw response body content.
     *
     * @throws ErrorException|TransporterException
     */
    public function requestContent(Payload $payload): string;
}
