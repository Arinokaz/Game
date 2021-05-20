<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Prize;
use app\services\convert_service\ConvertService;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;

class Convert
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
            ->load('user')
            ->fetchOne();

        if (empty($prize) && $prize->getType() != Prize::TYPE_MONEY) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'Wrong params']));
            return $this->response;
        }

        $points = new ConvertService((int) $prize->getValue());

        $last_points = $prize->getUser()->getPoints();
        $prize->getUser()->setPoints($last_points + $points->getPoints());

        $prize->setStatus(Prize::STATUS_TAKE);
        $prize->setProcessed(Prize::PROCESSED_SUCCESS);

        $t = new Transaction($this->db);
        $t->persist($prize);
        $t->run();

        $this->response->getBody()->write(json_encode(['type' => 'success', 'message' => 'Success!!!']));

        return $this->response;
    }
}
