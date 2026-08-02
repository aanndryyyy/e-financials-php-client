<?php

test('resources')->expect('EFinancialsClient\Resources')->toOnlyUse([
    'EFinancialsClient\Contracts\TransporterContract',
    'EFinancialsClient\Resources\Concerns\Transportable',
    'EFinancialsClient\Responses',
    'EFinancialsClient\ValueObjects\Transporter\Payload',
    'EFinancialsClient\ValueObjects\Transporter\Response',
    'DateTime',
    'DateTimeInterface',
    'InvalidArgumentException',
])->ignoring('EFinancialsClient\Resources\Concerns\Transportable');

test('client')->expect('EFinancialsClient\Client')->toOnlyUse([
    'EFinancialsClient\Contracts\ClientContract',
    'EFinancialsClient\Contracts\TransporterContract',
    'EFinancialsClient\Resources',
]);

test('transporter')->expect('EFinancialsClient\Transporters')->toOnlyUse([
    'EFinancialsClient\Contracts\TransporterContract',
    'EFinancialsClient\Exceptions',
    'EFinancialsClient\ValueObjects',
    'Closure',
    'JsonException',
    'Psr\Http\Client',
    'Psr\Http\Message',
]);

test('resources are final')
    ->expect('EFinancialsClient\Resources')
    ->classes()
    ->toBeFinal()
    ->ignoring('EFinancialsClient\Resources\Concerns\Transportable');
