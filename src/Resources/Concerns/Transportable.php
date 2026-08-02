<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources\Concerns;

use EFinancialsClient\Contracts\TransporterContract;

trait Transportable
{
    public function __construct(private readonly TransporterContract $transporter)
    {
        // ..
    }
}
