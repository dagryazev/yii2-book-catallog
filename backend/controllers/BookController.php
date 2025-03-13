<?php

namespace backend\controllers;

use common\dto\BookDto;
use common\repositories\interfaces\BookRepositoryInterface;
use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class BookController extends ActiveController
{
    public $modelClass = BookDto::class;

    public function __construct(
        $id,
        $module,
        private readonly BookRepositoryInterface $bookRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $bookDto = new BookDto();
        $bookDto->load(Yii::$app->request->post());

        $this->bookRepository->save($bookDto);
        return $bookDto;
    }

    public function actionUpdate($id)
    {
        $bookDto = $this->bookRepository->findOne($id);
        if (!$bookDto) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        $bookDto->load(Yii::$app->request->post());
        $this->bookRepository->save($bookDto);

        return $bookDto;
    }

    public function actionDelete($id)
    {
        if ($this->bookRepository->delete($id)) {
            return ['message' => 'Книга удалена'];
        }

        return ['error' => 'Не удалось удалить книгу'];
    }
}
