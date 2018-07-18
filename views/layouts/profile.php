<?php
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;

?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php
echo Nav::widget([
    'items' => [
        [
            'label' => 'Profile',
            'url' => ['/runner/user/profile-view'],
        ],
        [
            'label' => 'Update Profile',
            'url' => ['/runner/user/profile-update'],
        ]
    ],
    'options' => ['class' =>'nav nav-tabs'], // set this to nav-tab to get tab-styled navigation
]);
?>
    <div style="padding:20px;">

        <?php echo $content; ?>
    </div>

<?php $this->endContent(); ?>