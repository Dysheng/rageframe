<?php
namespace api\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\TooManyRequestsHttpException;
use api\models\LoginForm;
use common\models\base\AccessToken;

/**
 * 默认登录控制器
 * Class SiteController
 * @package api\controllers
 */
class SiteController extends AController
{
    public $modelClass = '';

    /**
     * 登录根据用户信息返回access_token
     * @param $group
     * @return bool|mixed|string
     * @throws NotFoundHttpException
     * @throws TooManyRequestsHttpException
     */
    public function actionLogin($group = 1)
    {
        if(Yii::$app->request->isPost)
        {
            $model = new LoginForm();
            $model->attributes = Yii::$app->request->post();
            if($model->validate())
            {
                $user = $model->getUser();
                return [
                    'accessToken' => AccessToken::setMemberInfo($group, $user['id'])
                ];
            }
            else
            {
                //返回数据验证失败
                return $this->setResponse($this->analysisError($model->getFirstErrors()));
            }
        }
        else
        {
            throw new NotFoundHttpException('请求出错!');
        }
    }
}
