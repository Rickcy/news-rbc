<?php


namespace app\controllers;


use app\src\repository\IRepository;
use app\src\repository\NewsActiveRecordRepository;
use Throwable;

class NewsController extends RestController
{

    /** @var NewsActiveRecordRepository */
    private $repository;


    /**
     * NewsController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @param IRepository|null $repository
     */
    public function __construct($id, $module, $config = [], IRepository $repository = null)
    {
        $this->repository = $repository ?? new NewsActiveRecordRepository();
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws Throwable
     */
    public function actionList()
    {
        $news = $this->repository->all();
        return ['list' => $news];

    }


    /**
     * @param int $id
     * @return array
     * @throws Throwable
     */
    public function actionItem(int $id)
    {
        $news = $this->repository->get($id);
        return ['item' => $news];

    }
}