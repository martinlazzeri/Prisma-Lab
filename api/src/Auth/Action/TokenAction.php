<?php
namespace Auth\Action;

use OAuth2;

class TokenAction
{
    protected $server;
    
    public function __construct($server)
    {
        $this->server = $server;
    }

    public function __invoke($request, $response)
    {
        $serverRequest = OAuth2\Request::createFromGlobals();
        $serverResponse = $this->server->handleTokenRequest($serverRequest);

        $serverResponse->send();
        exit;
    }
}