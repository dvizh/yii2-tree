<?php
namespace dvizh\tree;

use yii\helpers\Url;
use yii\base\Component;

class TreeSettings extends Component
{
    public $models = [];
    public $currentModelName = null;
    public $currentModelSettings = null;
    private $defaultSettings = [
        'updateUrl' => '/shop/category/update',
        'viewUrl' => '/shop/product/index',
        'deleteUrl' => '/tree/tree/delete',
        'expandUrl' => '/tree/tree/expand',
        'viewUrlToSearch' => true,
        'viewUrlModelName' => 'ProductSearch',
        'viewUrlModelField' => 'category_id',
        'orderField' => false,
        'parentField' => 'parent_id',
        'idField' => 'id',
        'nameField' => 'name',
        'view' => 'index',
        'showId' => false,
    ];

    public function getSettingProperty($property, $model)
    {
        $settings = $this->getSettingsModel($model);

        if(isset($settings[$property])) {
            return $settings[$property];
        }

        return null;
    }

    public function getSettingsModel($model)
    {

        $this->setModel($model);
        $settingsModel = null;
        $model = $this->getModel($model);
        foreach ($this->defaultSettings as $property => $value) {
            if(isset($model[$property])) {
                $settingsModel[$property] = $model[$property];
            } else {
                $settingsModel[$property] = $value;
            }
        }
        $this->setModelSettings($settingsModel);

        return $settingsModel;
    }
    private function setModel($modelName)
    {
        $this->currentModelName = $modelName;
    }

    private function setModelSettings($settingsModel)
    {
        $this->currentModelSettings = $settingsModel;
    }

    private function getModel()
    {
        return $this->models[$this->currentModelName];
    }
    /**
     * @param $id
     * @return mixed
     */
    public function getItems($id)
    {

        $items = $this->findModels($id);
        foreach ($items as $number => $item) {
            $items[$number]['childs'] = $this->isChildren($item[$this->currentModelSettings['idField']]);
        }

        return $items;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function findModels($id)
    {
        $query = $this->findModel($id);

        if($this->currentModelSettings['orderField']) {
            return $query->orderBy($this->currentModelSettings['orderField'])->asArray()->all();
        }

        return $query->asArray()->all();
    }

    protected function findModel($id)
    {
        $model = $this->currentModelName;

        return $model::find()->where([$this->currentModelSettings['parentField']=> $id]);
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function isChildren($id)
    {
        return $this->findModel($id)->exists();
    }
}
