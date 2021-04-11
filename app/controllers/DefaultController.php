<?php
namespace App\Controllers;

use App\Core\Controllers\Base\BaseController;

class DefaultController extends BaseController
{
    public function actionShow($request)
    {

        return $this->view('index');
    }

}