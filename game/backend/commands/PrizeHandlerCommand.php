<?php

namespace app\commands;

use app\models\Prize;
use app\services\prize_handler_service\PrizeHandlerService;
use Cycle\ORM\ORM;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PrizeHandlerCommand extends Command
{

    public function __construct(ORM $orm)
    {
        $this->orm = $orm;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('money:to-pay')->setDescription('Pay unpaid prizes')->addArgument('limit', null, '', 5);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = $input->getArgument('limit');

        $prizes = $this->orm->getRepository(Prize::class)
            ->findMoneyNotProcessed($limit)
            ->fetchAll();

        
        foreach ($prizes as $prize) {
            (new PrizeHandlerService($prize, $this->orm))->handler();
        }

        return 1;
    }
}
