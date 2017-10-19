<?php
namespace dvizh\tree\controllers;

use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;

class TreeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'expand' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionDelete()
    {
        $data = \Yii::$app->request->post();
        $treeSettings = Yii::$app->treeSettings;
        if (isset($data[$treeSettings->idField]))
            $this->deleteCategory($data['id'], $treeSettings->model);

        return 'delete';
    }

    /**
     * @return bool|string
     */
    public function actionExpand()
    {
        $branch = null;
        $treeSettings = Yii::$app->treeSettings;
        $data = \Yii::$app->request->post();
        if (!isset($data[$treeSettings->idField]))
            return false;

        $items = $treeSettings->getItems($data[$treeSettings->idField]);

        return Html::tag('ul', $this->branchBuild($items, $treeSettings), ['class' => 'child', 'data-role' => 'child', 'data-id' => $data[$treeSettings->idField]]);

    }

    /**
     * @param $items
     * @param $treeSettings
     * @return null|string
     */
    private function branchBuild($items, $treeSettings)
    {
        $branch = null;
        foreach ($items as $item) {
            $branch .= $this->renderPartial('expand', ['settings' => $treeSettings, 'category' => $item]);
        }

        return $branch;
    }

    /**
     * @param $id
     * @param $model
     */
    protected function deleteCategory($id, $model)
    {
        $model = $model::findOne($id);

        if (!empty($model))
            $model->delete();
    }

}