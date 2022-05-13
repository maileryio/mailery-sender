<?php declare(strict_types=1);

use Yiisoft\Form\Widget\Form;
use Mailery\Widget\Select\Select;

/** @var Mailery\Sender\Form\SenderForm $form */
/** @var Yiisoft\Form\Widget\Field $field */
/** @var Yiisoft\Yii\WebView $this */
/** @var Yiisoft\Yii\View\Csrf $csrf */

?>
<?= Form::widget()
        ->csrf($csrf)
        ->id('sender-form')
        ->begin(); ?>

<?= $field->select(
        $form,
        'channel',
        [
            'class' => Select::class,
            'items()' => [$form->getChannelListOptions()],
            'searchable()' => [false],
            'clearable()' => [false],
        ]
    ); ?>

<?= $field->submitButton()
        ->class('btn btn-primary float-right mt-2')
        ->value('Next'); ?>

<?= Form::end(); ?>
