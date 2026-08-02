<?php

test('api resources')->expect('EFinancialsClient\API')->toOnlyUse([
    'EFinancialsClient\Client',
    'DateTime',
    'InvalidArgumentException',
]);

test('client')->expect('EFinancialsClient\Client')->toOnlyUse([
    'EFinancialsClient\API',
    'GuzzleHttp\Client',
    'GuzzleHttp\Exception\RequestException',
    'Psr\Http\Message\ResponseInterface',
    'JsonException',
    'ValueError',
]);

test('api resources extend abstract api')
    ->expect('EFinancialsClient\API')
    ->classes()
    ->toExtend('EFinancialsClient\API\AbstractAPI')
    ->ignoring('EFinancialsClient\API\AbstractAPI');
