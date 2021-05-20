<?php

namespace app\controllers;

use app\models\User;
use Cycle\ORM\ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Login
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ORM
     */
    private $db;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, ORM $db)
    {
        $this->request = $request;

        $response = $response->withHeader('Content-Type', 'application/json');
        $this->response = $response;

        $this->db = $db;
    }

    /**
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(): ResponseInterface
    {

        $ajaxData = json_decode(file_get_contents('php://input'), true);

        if (empty($ajaxData['login']) || empty($ajaxData['password'])) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'Login and Password required.']));
            return $this->response;
        }

        $user = $this->db->getRepository(User::class)->findOne(['login' => $ajaxData['login']]);

        if (empty($user)) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'User not found.']));
            return $this->response;
        }

        //Тут должна быть нормальная проверка, т.к. пароль не должен хранится в оригинальном виде.
        if ($ajaxData['password'] !== $user->getPassword()) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'Login/Password invalid.']));
            return $this->response;
        }

        $this->response->getBody()->write(json_encode(['type' => 'success', 'user' => ['id' => $user->getId()]]));

        return $this->response;
    }
}
