<?php declare(strict_types=1);

use Yiisoft\Html\Tag\Form;
use Mailery\Widget\Select\Select;
use Yiisoft\Form\Field;

/** @var Mailery\Sender\Form\SenderForm $form */
/** @var Yiisoft\Yii\WebView $this */
/** @var Yiisoft\Yii\View\Csrf $csrf */

?>
<?= Form::tag()
        ->csrf($csrf)
        ->id('sender-form')
        ->post()
        ->open(); ?>

<?= Field::input(
        Select::class,
        $form,
        'channel',
        [
            'optionsData()' => [$form->getChannelListOptions()],
            'searchable()' => [false],
            'clearable()' => [false],
        ]
    ); ?>

<?= Field::submitButton()
        ->content('Next'); ?>

<?= Form::tag()->close(); ?>
