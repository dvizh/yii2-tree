<?php
use yii\helpers\Url;
?>
<div class="tree-index">
    <div class="categories-tree"
         data-role="tree"
         data-action-expand="<?= Url::to([$expandUrl]) ?>"
         data-model="<?= $model ?>"
         data-action-delete="<?= Url::to([$deleteUrl]) ?>">
        <ul>
            <?= $tree ?>
        </ul>
    </div>
</div>
