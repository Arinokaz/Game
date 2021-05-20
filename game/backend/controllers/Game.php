<?php

namespace app\controllers;

use app\services\prizes_service\PrizesServiceInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Cycle\ORM\ORM;
use app\models\User;
use app\models\Prize;
use Cycle\ORM\Transaction;

class Game
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
     * @var PrizesServiceInterface
     */
    private $prizesService;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param ORM $db
     * @param PrizesServiceInterface $prizesService
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, ORM $db, PrizesServiceInterface $prizesService)
    {
        $this->request = $request;

        $response = $response->withHeader('Content-Type', 'application/json');
        $this->response = $response;

        $this->db = $db;

        $this->prizesService = $prizesService;
    }

    /**
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(): ResponseInterface
    {

        $ajaxData = json_decode(file_get_contents('php://input'), true);

        if (empty($ajaxData['id'])) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'Wrong request']));
            return $this->response;
        }

        $type = $this->prizesService->getRandomPrizeType();
        $vaule = $this->prizesService->getPrize($type);

        $user = $this->db->getRepository(User::class)->findOne(['id' => $ajaxData['id']]);

        if (empty($user)) {
            $this->response->getBody()->write(json_encode(['type' => 'error', 'message' => 'User not found.']));
            return $this->response;
        }

        $prize = new Prize();
        $prize->setType($type);
        $prize->setStatus(Prize::STATUS_GET);
        $prize->setProcessed(Prize::PROCESSED_WAIT);
        $prize->setValue($vaule);

        $user->getPrizes()->add($prize);

        $t = new Transaction($this->db);
        $t->persist($user);
        $t->run();

        $this->response->getBody()->write(json_encode(['type' => 'success', 'prize' => ['id' => $prize->getId(), 'value' => $prize->getValue(), 'type' => $prize->getType()]]));

        return $this->response;
    }
}
