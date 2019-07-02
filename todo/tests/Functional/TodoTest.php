<?php

namespace Tests\Functional;

class TodoTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetOneTodoNotAuthenticated()
    {
        $response = $this->runApp('GET', '/api/v1/todo/1');
        $obj = (array) json_decode($response->getBody());
        $this->assertArrayHasKey("message", $obj);        
    }

    public function testGetTodoNotAuthenticated()
    {
        $response = $this->runApp('GET', '/api/v1/todo');
        $obj = (array) json_decode($response->getBody());
        $this->assertArrayHasKey("message", $obj);        
    }

    public function testPutTodoNotAuthenticated()
    {
        $response = $this->runApp('PUT', '/api/v1/todo/1');
        $obj = (array) json_decode($response->getBody());
        $this->assertArrayHasKey("message", $obj);        
    }

    public function testPostTodoNotAuthenticated()
    {
        $todo['title'] = "tes";
        $todo['description'] = "tes123";

        $response = $this->runApp('POST', '/api/v1/todo/', $todo);
        $obj = (array) json_decode($response->getBody());
        $this->assertArrayHasKey("message", $obj);        
    }

    public function testDeleteTodoNotAuthenticated()
    {
        $response = $this->runApp('DELETE', '/api/v1/todo/1');
        $obj = (array) json_decode($response->getBody());
        $this->assertArrayHasKey("message", $obj);        
    }

    public function testGetTodoAuthenticated()
    {
        // $user = new \stdClass();
        $user['username'] = "iksan";
        $user['password'] = "tes123";
        $responseLogin = $this->runApp('POST', '/api/v1/login', $user);
        $response = $this->runApp('GET', '/api/v1/todo');
        $obj = (array) json_decode($response->getBody());
        $this->assertNotContains('message', $obj);        
    }

    public function testGetOneTodoAuthenticated()
    {
        // $user = new \stdClass();
        $user['username'] = "iksan";
        $user['password'] = "tes123";
        $responseLogin = $this->runApp('POST', '/api/v1/login', $user);
        $response = $this->runApp('GET', '/api/v1/todo/1');
        $obj = (array) json_decode($response->getBody());
        $this->assertNotContains('message', $obj);        
    }

    public function testPostTodoAuthenticated()
    {
        // $user = new \stdClass();
        $user['username'] = "iksan";
        $user['password'] = "tes123";
        $responseLogin = $this->runApp('POST', '/api/v1/login', $user);

        $todo['title'] = "tes";
        $todo['description'] = "tes123";

        $response = $this->runApp('POST', '/api/v1/todo/', $todo);
        $obj = (array) json_decode($response->getBody());
        $this->assertNotContains('message', $obj);        
    }

    public function testPutTodoAuthenticated()
    {
        // $user = new \stdClass();
        $user['username'] = "iksan";
        $user['password'] = "tes123";
        $responseLogin = $this->runApp('POST', '/api/v1/login', $user);

        $todo['title'] = "tes";
        $todo['description'] = "tes123";
        $response = $this->runApp('PUT', '/api/v1/todo/'.$this->lastId, $todo);
        $obj = (array) json_decode($response->getBody());
        $this->assertNotContains('message', $obj);        
    }

    public function testDeleteTodoAuthenticated()
    {
        // $user = new \stdClass();
        $user['username'] = "iksan";
        $user['password'] = "tes123";
        $responseLogin = $this->runApp('POST', '/api/v1/login', $user);

        $response = $this->runApp('DELETE', '/api/v1/todo/'.$this->lastId);
        $obj = (array) json_decode($response->getBody());
        $this->assertNotContains('message', $obj);        
    }
}
