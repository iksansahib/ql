<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use App\Service\TodoService;
use Slim\Http\Environment;
use Slim\Http\Request;

class TodoTest extends TestCase
{
    public function request($method, $path, $options = array())
    {
        // Capture STDOUT
        ob_start();
        // Prepare a mock environment
        $env = Environment::mock(array_merge(array(
            'REQUEST_METHOD' => $method,
            'PATH_INFO' => $path
        )));
        $settings = require __DIR__ . '/../src/settings.php';
        $app = new \Slim\App($settings);
        $app->getContainer()['request'] = Request::createFromEnvironment($env);
        $this->response = $app->run(true);
        // Return STDOUT
        return ob_get_clean();
    }
    public function get($path, $options = array())
    {
        $this->request('GET', $path, $options);
    }
    public function testIndex()
    {
        $this->get('/todo');
        $this->assertEquals('200', $this->response->getStatusCode());
    }
}