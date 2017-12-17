<?php
namespace dvizh\tree\widgets;

use yii;

class Tree extends \yii\base\Widget
{
    public $model = null;

    public function init()
    {
        if (!$this->model) {
            throw new \Exception('You need to transfer the model!');
        }
        parent::init();
        \dvizh\tree\assets\WidgetAsset::register($this->getView());
    }

    /**
     * @return string
     */
    public function run()
    {
        $treeSettings = Yii::$app->treeSettings;
        $modelSetting = $treeSettings->getSettingsModel($this->model);
        $tree = $this->branchBuild($treeSettings->getItems(null), $modelSetting);

        return $this->render($modelSetting['view'], [
            'tree' => $tree,
            'model' => $this->model,
            'expandUrl' => $modelSetting['expandUrl'],
            'deleteUrl' => $modelSetting['deleteUrl'],
        ]);
    }

    /**
     * @param $items
     * @param $settings
     * @return null|string
     */
    private function branchBuild($items, $settings)
    {
        $branch = null;
        foreach ($items as $item) {
            $branch .= $this->render('parts/tree-inlist', ['category' => $item, 'settings' => $settings]);
        }

        return $branch;
    }
}
