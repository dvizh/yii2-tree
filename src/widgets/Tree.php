<?php
namespace dvizh\tree\widgets;

use yii;

class Tree extends \yii\base\Widget
{
    public function init()
    {
        parent::init();
        \dvizh\tree\assets\WidgetAsset::register($this->getView());
    }

    /**
     * @return string
     */
    public function run()
    {
        $treeSettings = Yii::$app->treeSettings;
        $items = $treeSettings->getItems(null);
        $tree = $this->branchBuild($items, $treeSettings);

        return $this->render($treeSettings->view, [
            'categoriesTree' => $tree,
            'expandUrl' => $treeSettings->expandUrl,
            'deleteUrl' => $treeSettings->deleteUrl,
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
            $branch .= $this->render('parts/tree_inlist.php', ['category' => $item, 'settings' => $settings]);
        }

        return $branch;
    }
}
