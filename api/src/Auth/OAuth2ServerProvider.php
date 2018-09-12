<?php
namespace Auth;

use OAuth2;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OAuth2ServerProvider implements ServiceProviderInterface{
    /**
     * Register all the services required by the OAuth2 server
     *
     * @param  Container $c
     */
    public function register(Container $container){
        $container[OAuth2\OAuth2Sever::class] = function ($c) {
            $pdo = $c->get('dbOauth');
            $storage = new PdoStorage($pdo);

            $server = new OAuth2\Server($storage, [
                'enforce_redirect' => false
            ]);

            $server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
            $server->addGrantType(new OAuth2\GrantType\RefreshToken($storage));

            return $server;
        };

        $container[Action\TokenAction::class] = function ($c) {
            $server = $c->get(OAuth2\OAuth2Sever::class);

            return new Action\TokenAction($server);
        };

        $container[Action\AuthoriseAction::class] = function ($c) {
            $server = $c->get(OAuth2\OAuth2Sever::class);

            return new Action\AuthoriseAction($server);
        };

        $container[GuardMiddleware::class] = function ($c) {
            $server = $c->get(OAuth2\OAuth2Sever::class);

            return new GuardMiddleware($server);
        };
    }
}