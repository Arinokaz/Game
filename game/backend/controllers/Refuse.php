<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Prize;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;

class Refuse
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
     * @param ORM $db
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

        if (empty($ajaxData['id'])) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'Wrong attribute']));
            return $this->response;
        }

        $prize = $this->db->getRepository(Prize::class)
            ->select()
            ->wherePK($ajaxData['id'])
            ->fetchOne();

        if (empty($prize)) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'Wrong params']));
            return $this->response;
        }

        $t = new Transaction($this->db);
        $t->delete($prize);
        $t->run();

        $this->response->getBody()->write(json_encode(['type' => 'success', 'message' => 'Success!!!']));

        return $this->response;
    }
}
