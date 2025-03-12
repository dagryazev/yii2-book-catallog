<?php

namespace frontend\controllers;

use common\repositories\interfaces\BookRepositoryInterface;
use common\repositories\interfaces\SubscriptionRepositoryInterface;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{

    public function __construct(
        $id,
        $module,
        private readonly BookRepositoryInterface $bookRepository,
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'], // Только для авторизованных пользователей
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'subscribe'],
                        'roles' => ['?','@'], // Для гостей и авторизованных пользователей
                    ],
                ],
            ],
        ];
    }

    // Просмотр всех книг
    public function actionIndex()
    {
        $books = $this->bookRepository->findAll();
        return $this->render('index', ['books' => $books]);
    }

    public function actionView($id)
    {
        $book = $this->bookRepository->findOne($id);
        return $this->render('view', ['book' => $book]);
    }

    public function actionSubscribe($authorId)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Только зарегистрированные пользователи могут подписаться на новые книги.');
            return $this->redirect(['book/index']);
        }

        // Проверяем, не подписан ли уже пользователь на книги этого автора
        $existingSubscription = $this->subscriptionRepository->findByUserAndAuthor(Yii::$app->user->id, $authorId);

        if (!$existingSubscription) {
            $this->subscriptionRepository->create(Yii::$app->user->id, $authorId);
            Yii::$app->session->setFlash('success', 'Вы успешно подписались на новые книги этого автора.');
        } else {
            Yii::$app->session->setFlash('info', 'Вы уже подписаны на новые книги этого автора.');
        }

        return $this->redirect(['book/index']);
    }

    protected function findModel($id)
    {
        if (($model = $this->bookRepository->findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
