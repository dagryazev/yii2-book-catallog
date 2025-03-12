<?php

namespace frontend\controllers;

use common\services\BookReportService;
use yii\web\Controller;

class ReportController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly BookReportService $bookReportService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function actionTopAuthors($year)
    {
        return $this->bookReportService->getTopAuthorsByBooksInYear($year);
    }
}
