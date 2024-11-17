<?php

namespace app\router;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Container\Container;

class Router
{
    private RouteCollection $routes;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routes = new RouteCollection();


        $this->routes->add('userProfileIndex', new Route('/', [
            '_controller' => [\app\controller\UserProfileController::class, 'index']
        ], [], [], '', [], ['GET']));

        $this->routes->add('userProfileCreate', new Route('/user-profile', [
            '_controller' => [\app\controller\UserProfileController::class, 'createUserProfile']
        ], [], [], '', [], ['POST']));

        $this->routes->add('usersProfile', new Route('/users-profile', [
            '_controller' => [\app\controller\UserProfileController::class, 'getUsersProfile']
        ], [], [], '', [], ['GET']));
    }

    public function handle(Request $request): Response
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $parameters = $matcher->match($request->getPathInfo());
            [$controllerClass, $method] = $parameters['_controller'];
            unset($parameters['_controller']);

            $controller = $this->container->get($controllerClass);

            return call_user_func_array([$controller, $method], [$request]);
        } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (\Exception $e) {
            return new Response('An error occurred ', 500);
        }
    }
}
