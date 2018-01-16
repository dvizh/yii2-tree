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
        $data = Yii::$app->request->post();
        $treeSettings = Yii::$app->treeSettings;
        $model = $data['model'];
        $field = $treeSettings->getSettingProperty('idField', $model);
        $id = $data['id'];

        if ($id && $field && $model) {
            $this->deleteCategory($id, $model, $field);

            return 'delete';
        }

        return false;
    }

    /**
     * @return bool|string
     */
    public function actionExpand()
    {
        $data = Yii::$app->request->post();

        $branch = null;
        $treeSettings = Yii::$app->treeSettings;
        $modelSetting = $treeSettings->getSettingsModel($data['model']);
        $fieldId = $modelSetting['idField'];
        if (!isset($data[$fieldId]))
            return false;

        $tree = $this->branchBuild($treeSettings->getItems($data[$fieldId]), $modelSetting);

        return Html::tag('ul', $tree, ['class' => 'child', 'data-role' => 'child', 'data-id' => $data[$fieldId]]);

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