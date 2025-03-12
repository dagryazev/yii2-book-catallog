<?php

namespace backend\controllers;

use common\dto\BookDto;
use common\repositories\interfaces\AuthorRepositoryInterface;
use common\repositories\interfaces\BookRepositoryInterface;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly BookRepositoryInterface $bookRepository,
        private readonly AuthorRepositoryInterface $authorRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $bookDto = new BookDto();

        if (Yii::$app->request->isPost) {
            $bookDto->title = Yii::$app->request->post('title');
            $bookDto->description = Yii::$app->request->post('description');
            $bookDto->publishYear = Yii::$app->request->post('publishYear');
            $bookDto->isbn = Yii::$app->request->post('isbn');
            $bookDto->authorIds = Yii::$app->request->post('authorIds', []);

            $this->bookRepository->save($bookDto);
            return $this->redirect(['index']);
        }

        $authors = $this->authorRepository->findAll();

        return $this->render('create', ['bookDto' => $bookDto, 'authors' => $authors]);
    }

    public function actionUpdate(int $id)
    {
        $bookDto = $this->bookRepository->findOne($id);
        if (!$bookDto) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        if (Yii::$app->request->isPost) {
            $bookDto->title = Yii::$app->request->post('title');
            $bookDto->description = Yii::$app->request->post('description');
            $bookDto->publishYear = Yii::$app->request->post('publishYear');
            $bookDto->isbn = Yii::$app->request->post('isbn');
            $bookDto->authorIds = Yii::$app->request->post('authorIds', []);

            $this->bookRepository->save($bookDto);
            return $this->redirect(['index']);
        }

        $authors = $this->authorRepository->findAll();

        return $this->render('update', ['bookDto' => $bookDto, 'authors' => $authors]);
    }

    public function actionDelete(int $id)
    {
        if ($this->bookRepository->delete($id)) {
            Yii::$app->session->setFlash('success', 'Книга удалена.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось удалить книгу.');
        }

        return $this->redirect(['index']);
    }
}
