<?php
/* @var $this \yii\web\View */
/* @var $content string */
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\Navigation;
use DuAdmin\Widgets\AutoFixBootstrapColumn;
use DuAdmin\Widgets\DefaultPageFooter;
use DuAdmin\Widgets\LazyLoad;
use DuAdmin\Widgets\Nav;
use DuAdmin\Widgets\Notify;
use Frontend\Assets\AppAsset;
use app\Themes\Basic\widgets\ThemeAsset;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
AppAsset::register( $this );
ThemeAsset::register( $this );
Notify::widget();
LazyLoad::widget();
$this->params ['logo'] = AppHelper::getSetting( 'site.logo' );
$siteName = Yii::t( 'app', AppHelper::getSetting( 'site.name', Yii::$app->name ) );
?>
<?php
$this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">

<head>
    <base href="<?=Yii::$app->request->baseUrl?>/">
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode( $this->title . '-' . $siteName )?></title>
    <?php
    $this->head()?>
</head>

<body>
    <?php
    $this->beginBody()?>

    <div class="wrap">
        <?php
        NavBar::begin( [
            'brandLabel' => Yii::t( 'app', '<i class="fa fa-rocket"></i> ' . $siteName ) . ' <small>' . Yii::$app->version . '</small>',
            // 'brandImage' => $this->params['logo'],
            'brandUrl' => [
                '/site/index'
            ],
            'options' => [
                'class' => 'navbar-inverse nav-affix'
            ]
        ] );
        $menus = [
            [
                'label' => Yii::t( 'yii', 'Home' ),
                'url' => [
                    '/site/index'
                ]
            ]
        ];
        if ( ($navigations = Navigation::getNavigation()) ) {
          foreach ( $navigations as $navigation ) {
            if ( $navigation ['requireLogin'] && Yii::$app->user->isGuest ) {
              continue;
            }
            if ( empty( $navigation ['isOuter'] ) ) {
              $navigation ['url'] = AppHelper::parseDuAdminMenuUrl( $navigation ['url'], '/' );
            } else {
              $navigation ['linkOptions'] = [
                  'target' => '_blank'
              ];
            }
            $menus [] = $navigation;
          }
        }
        if ( Yii::$app->user->isGuest ) {
          $menus [] = [
              'label' => Yii::t( 'app', 'Login' ),
              'url' => [
                  '/login'
              ]
          ];
        } else {
          $menus [] = '<li>' . Html::beginForm( [
              '/site/logout'
          ], 'post' ) . Html::submitButton( Yii::t( 'app', 'Logout' ) . ' ( ' . Yii::$app->user->identity->username . ' ) ', [
              'class' => 'btn btn-link logout'
          ] ) . Html::endForm() . '</li>';
        }
        echo Nav::widget( [
            'options' => [
                'class' => 'navbar-nav navbar-right text-uppercase'
            ],
            'activateParents' => true,
            'items' => $menus
        ] );
        NavBar::end();
        AutoFixBootstrapColumn::widget();
        ?>
        <?php
        if ( isset( $this->params ['breadcrumbs'] ) ) :
          ?>
        <div class="container">
            <?=Breadcrumbs::widget( [ 'links' => isset( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ]] )?>
        </div>
        <?php endif;

        ?>
        <?=$content?>
    </div>

    <?=DefaultPageFooter::renderPageFooter()?>
    <?php
    $this->endBody()?>
</body>

</html>
<?php
$this->endPage()?>