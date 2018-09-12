<?php
namespace Auth\Action;

use OAuth2;

class AuthoriseAction
{
    protected $server;
    
    public function __construct($server)
    {
        $this->server = $server;
    }

    public function __invoke($request, $response)
    {
        $server = $this->server;
        $serverRequest = OAuth2\Request::createFromGlobals();
        $serverResponse = new OAuth2\Response();

        if (!$server->validateAuthorizeRequest($serverRequest, $serverResponse)) {
            $serverResponse->send();
            die;
        }

        $username = $request->getAttribute('username');
        $server->handleAuthorizeRequest($serverRequest, $serverResponse, true, $username);
        
        $serverResponse->send();
        exit;
    }
}