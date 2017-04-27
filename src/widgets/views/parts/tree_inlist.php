<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row" data-key="<?=$category[$widget->idField]?>">
    <div class="col-lg-6 col-xs-6">
        ∟ <input type="hidden" name="ids[]" value="<?=$category[$widget->idField];?>" />
            <?=$category[$widget->idField];?>.
        <?php if($category['childs']) { ?>
            <?=Html::a($category['name'], '#', ['title' => 'Показать\скрыть подкатегории', 'class' => 'dvizh-tree-toggle']);?>
        <?php } else { ?>
            <strong><?=$category['name']?></strong>
        <?php } ?>
    </div>
    <div class="col-lg-6 col-xs-6 dvizh-tree-right-col">
        <div class="buttons">
            <?php if($widget->viewUrl) { ?>
            <?php if($widget->viewUrlToSearch) { ?> 
                <?=Html::a('<span class="glyphicon glyphicon-eye-open">', [$widget->viewUrl, $widget->viewUrlModelName => [$widget->viewUrlModelField => $category[$widget->idField]]], ['class' => 'btn btn-default', 'title' => 'Смотреть']);?>
            <?php } else { ?>
                <?=Html::a('<span class="glyphicon glyphicon-eye-open">', [$widget->viewUrl, 'id' => $category[$widget->idField]], ['class' => 'btn btn-default', 'title' => 'Смотреть']);?>
            <?php } ?>
            <?php } ?>
            <?php if($widget->updateUrl) { ?>
            <?=Html::a('<span class="glyphicon glyphicon-pencil">', [$widget->updateUrl, 'id' => $category[$widget->idField]], ['class' => 'btn btn-default', 'title' => 'Редактировать']);?>
            <?php } ?>
            <form class="btn" action="<?=Url::toRoute([$widget->deleteUrl, 'id' => $category[$widget->idField]]);?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <?=Html::submitButton('<span class="glyphicon glyphicon-trash">', ['class' => 'btn btn-default', 'data-confirm' => 'Вы уверены, что хотите удалить данную категорию?']); ?>        
            </form>
            </div>
    </div>
</div>
