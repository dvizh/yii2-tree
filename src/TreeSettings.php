<?php
namespace dvizh\tree;

use yii\helpers\Url;
use yii\base\Component;

class TreeSettings extends Component
{


    public $updateUrl = 'category/update';
    public $viewUrl = '/shop/product/index';
    public $deleteUrl = '/tree/tree/delete';
    public $expandUrl = '/tree/tree/expand';
    public $viewUrlToSearch = true;
    public $viewUrlModelName = 'ProductSearch';
    public $viewUrlModelField = 'category_id';
    public $orderField = false;
    public $parentField = 'parent_id';
    public $idField = 'id';
    public $nameField = 'name';
    public $view = 'index';
    public $showId = false;
    public $model = null;

    /**
     * @param $id
     * @return mixed
     */
    public function getItems($id)
    {
        $items = $this->findModel($id);
        foreach ($items as $number => $item)
            $items[$number]['childs'] =  $item['childs'] = $this->isChildren($item[$this->idField]);

        return $items;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function findModel($id)
    {
        $model = $this->model;
        if($this->orderField) {
            $list = $model::find()->where([$this->parentField => $id])->orderBy($this->orderField)->asArray()->all();
        } else {
            $list = $model::find()->where([$this->parentField => $id])->asArray()->all();
        }

        return $list;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function isChildren($id)
    {
        $model = $this->model;

        return $model::find()->where([$this->parentField => $id])->exists();
    }
}
