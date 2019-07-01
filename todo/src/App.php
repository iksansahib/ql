<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Service\TodoService;
use App\Service\UserService;

return function (App $app) {
    $container = $app->getContainer();
    session_start();
    $container['todo'] = function($c){
        return new TodoService();
    };
    $container['user'] = function($c){
        return new UserService();
    };
    $app->group('/todo', function(App $app){
        
        $app->map(['GET'], '', function(Request $request, Response $response){
            $todo_list = $this->todo->getTodo();
            return $response->withJson($todo_list);
        });

        $app->get('/{id}', function (Request $request, Response $response, array $args) use ($container) {
            $todo_list = $this->todo->getTodo($args['id']);
            return $response->withJson($todo_list);
        });

        $app->delete('/{id}', function (Request $request, Response $response, array $args) use ($container) {
            $todo_list = $this->todo->deleteTodo($args['id']);
            return $response->withJson($todo_list);
        });

        $app->put('/{id}', function (Request $request, Response $response, array $args) use ($container) {
            $todo_list = $this->todo->updateTodo($args['id'], $request->getParsedBody());
            return $response->withJson($todo_list);
        });

        $app->post('/', function (Request $request, Response $response, array $args) use ($container) {
            $todo_list = $this->todo->addTodo($request->getParsedBody());
            return $response->withJson($todo_list);
        });
    })->add(function ($request, $response, $next) {
        if($_SESSION['username'])
            $response = $next($request, $response);
        else 
            $response = $response->withJson(['message'=>'Not authenticated']);
        return $response;
    });;

    $app->post('/register', function (Request $request, Response $response, array $args) use ($container) {
        $user_status = $this->user->register($request->getParsedBody());
        return $response->withJson($user_status);
    });

    $app->post('/login', function (Request $request, Response $response, array $args) use ($container) {
        $user_status = $this->user->login($request->getParsedBody());
        return $response->withJson($user_status);
    });

    $app->post('/logout', function (Request $request, Response $response, array $args) use ($container) {
        $user_status = $this->user->logout($request->getParsedBody());
        return $response->withJson($user_status);
    });
};
