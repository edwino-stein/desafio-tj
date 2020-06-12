<?php
    use yii\helpers\Html;
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <link rel="stylesheet" href="/css/bootstrap.min.css" >
        <link rel="stylesheet" href="/css/font-awesome.all.min.css" >

        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>

        <?php $this->head() ?>
    </head>
    <body>
        <?= $content ?>
    </body>
</html>
