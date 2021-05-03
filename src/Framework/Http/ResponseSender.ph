<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;

class ResponseSender
{
    public function send(ResponseInterface $response): void
    {
        header(sprintf(
            'HTTP/%s %d %s'
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ));
        foreach ($response->getHeaders() as $name => $value) {
            header(sprntf('$s: %s', $name, $value),false);
        }
        echo $response->getBody()->getContents();
    }
}