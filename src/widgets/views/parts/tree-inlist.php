<?php
use yii\helpers\Html;

$idField = $settings['idField'];
?>
<li class="main">
    <div class="row">
        <div class="col-lg-6 col-xs-6" <?= $category['childs'] ? 'data-role="expand-tree"' : null ?>
             data-id="<?= $category[$idField] ?>">
            <?= $settings['showId'] ? $category[$idField] . '.' : null ?>
            <strong>
                <?= $category[$settings['nameField']] ?>
                <span class="glyphicon <?= $category['childs'] ? 'glyphicon-chevron-down' : null ?>"></span>
            </strong>
        </div>
        <div class="col-lg-6 col-xs-6 dvizh-tree-right-col">
            <div class="buttons">
                <?php if ($settings['viewUrl']) { ?>
                    <?php if ($settings['viewUrlToSearch']) { ?>
                        <?= Html::a('<span class="glyphicon glyphicon-eye-open">', [
                                $settings['viewUrl'],
                                $settings['viewUrlModelName'] => [
                                    $settings['viewUrlModelField'] => $category[$idField]
                                ]
                        ],
                            ['class' => 'btn btn-default', 'title' => 'Смотреть']); ?>
                    <?php } else { ?>
                        <?= Html::a('<span class="glyphicon glyphicon-eye-open">', [$settings['viewUrl'], 'id' => $category[$idField]], ['class' => 'btn btn-default', 'title' => 'Смотреть']); ?>
                    <?php } ?>
                <?php } ?>
                <?php if ($settings['updateUrl']) { ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil">', [$settings['updateUrl'], 'id' => $category[$idField]], ['class' => 'btn btn-default', 'title' => 'Редактировать']); ?>
                <?php } ?>
                <?= Html::tag('button', Html::tag('span', null, [
                    'class' => 'glyphicon glyphicon-trash',
                    'data-role' => 'delete-tree',
                    'data-id' => $category[$idField]
                ]), ['class' => 'btn btn-default']); ?>
            </div>
        </div>
    </div>
</li>