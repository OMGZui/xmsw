<?php
/**
 * Created by PhpStorm.
 * User: 小粽子
 * Date: 2019/4/12
 * Time: 14:59
 */
namespace App\HttpController;

class Index extends Base
{
    public function index()
    {
        return $this->response()->write('1122111');
    }
}