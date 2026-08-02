<?php

namespace EFinancialsClient\API;

use EFinancialsClient\Client;

abstract class AbstractAPI
{
    /**
     * Create a new API instance.
     *
     *
     * @return void
     */
    public function __construct(
        public Client $client
    ) {}
}
