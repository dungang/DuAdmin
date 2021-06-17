<?php

namespace app\generators\language;

use app\generators\CodeFile;
use app\generators\Generator as BaseGenerator;
use yii\db\Connection;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;

class Generator extends BaseGenerator {

  public $db = 'db';

  /**
   * 消息存储路径
   *
   * @var string
   */
  public $messagesPath = "";

  /**
   * 生成的语言
   *
   * @var string
   */
  public $language = "zh-CN";

  /**
   * 选择表
   *
   * @var array
   */
  public $tables;

  /**
   * 翻译消息前缀
   *
   * @var string
   */
  public $messageCategoryPrefix = 'da';

  public function init() {

    parent::init();
    $this->on( self::AFTER_SAVE_SUCCESS, [
        $this,
        'updateAddonI18N'
    ] );

  }

  public function getName() {

    return '翻译';

  }

  public function rules() {

    return [
        [
            [
                'messagesPath',
                'language',
                'messageCategoryPrefix'
            ],
            'filter',
            'filter' => 'trim'
        ],
        [
            [
                'messagesPath',
                'language',
                'tables'
            ],
            'required'
        ],
        [
            [
                'messagesPath',
                'language',
                'messageCategoryPrefix'
            ],
            'string'
        ]
    ];

  }

  public function attributeLabels() {

    return [
        'language' => '语言',
        'tables' => '翻译的表',
        'messagesPath' => '翻译存储文件目录',
        'messageCategoryPrefix' => '翻译消息类前缀'
    ];

  }

  public function attributeHints() {

    return [
        'language' => '根据表的注释语言选择，默认选择的是中文:zh-CN',
        'messagesPath' => '翻译存储文件目录',
        'tables' => '根据业务选择翻译的表，最后把多个表的翻译合并去重在保存'
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function getDescription() {

    return '该生成器根据数据库中指定的表来生成对应的中文本地语言。';

  }

  /**
   *
   * @return Connection the DB connection as specified by [[db]].
   */
  protected function getDbConnection() {

    return \Yii::$app->get( $this->db, false );

  }

  public function getTableNames() {

    return $this->getDbConnection()->getSchema()->getTableNames();

  }

  public function getMessagesPaths() {

    $messagesPaths = [
        '@app/Messages'
      // '@Backend/Messages',
      // '@Frontend/Messages'
    ];
    $dirs = FileHelper::findDirectories( \Yii::$app->basePath . '/Addons', [
        'recursive' => false
    ] );
    foreach ( $dirs as $dir ) {
      $path = '@Addons/' . basename( $dir ) . '/Messages';
      $messagesPaths [] = $path;
    }
    return $messagesPaths;

  }

  public function getAddonNameFromMessagePath( $messagePath ) {

    $match = [ ];
    if ( preg_match( '/\@Addons\/(.*?)\//', $messagePath, $match ) ) {
      return $match [1];
    }
    return null;

  }

  public function generate() {

    $this->updateAddonI18N();
    $db = $this->getDbConnection();
    $tableNamesIn = implode( ',', array_map( function ( $table ) {
      return "'" . $table . "'";
    }, $this->tables ) );
    $tableInfos = $db->createCommand( "SELECT TABLE_NAME tableName,TABLE_COMMENT tableComment
FROM INFORMATION_SCHEMA.TABLES
WHERE table_schema='" . getenv( 'DB_DATABASE' ) . "' AND TABLE_NAME IN (" . $tableNamesIn . ")" )->queryAll();
    $tablePrefixLen = strlen( $db->tablePrefix );
    $codeFiles = [ ];
    if ( $this->messagesPath == '@app/messages' ) {
      $this->messageCategoryPrefix = 'app';
    }
    foreach ( $tableInfos as $tableInfo ) {
      $trans = [ ];
      $tableName = $tableInfo ['tableName'];
      $tableComment = $tableInfo ['tableComment'];
      $noPrefixTableName = $tableName;
      if ( substr( $tableName, 0, $tablePrefixLen ) == $db->tablePrefix ) {
        $noPrefixTableName = substr( $tableName, $tablePrefixLen );
        $words = Inflector::camel2words( $noPrefixTableName );
        $trans [$words] = $tableComment;
      } else {
        $words = Inflector::id2camel( $tableName );
        $trans [$words] = $tableComment;
      }
      $words = Inflector::pluralize( $words );
      $trans [$words] = $tableComment;
      $tableSchema = $db->getTableSchema( $tableName );
      $columns = $tableSchema->columns;
      foreach ( $columns as $column ) {
        if ( $column->name == 'id' ) {
          continue;
        }
        $pieces = explode( "::", $column->comment );
        $columnComment = array_shift( $pieces );
        $columnWords = Inflector::camel2words( $column->name );
        if ( ! empty( $columnWords ) && substr_compare( $columnWords, ' id', - 3, 3, true ) === 0 ) {
          $columnWords = substr( $columnWords, 0, - 3 ) . ' ID';
        }
        $trans [$columnWords] = $columnComment;
      }
      $codeFiles [] = new CodeFile( \Yii::getAlias( $this->messagesPath ) . '/' . $this->language . '/' . $this->messageCategoryPrefix . '_' . $noPrefixTableName . '.php', $this->render( 'message.php', [
          'trans' => $trans
      ] ) );
    }
    return $codeFiles;

  }

  public function updateAddonI18N() {

    if ( $addonName = $this->getAddonNameFromMessagePath( $this->messagesPath ) ) {
      $dir = \Yii::getAlias( $this->messagesPath . '/' . $this->language );
      if ( ! is_dir( $dir ) ) {
        FileHelper::createDirectory( $dir );
      }
      ;
      $files = FileHelper::findFiles( $dir, [
          'recursive' => false
      ] );
      $fileNames = array_map( function ( $file ) {
        return substr( basename( $file ), 0, - 4 );
      }, $files );
      if ( count( $files ) > 0 ) {
        $addonJsonFile = \Yii::getAlias( '@Addons/' . $addonName . '/addon.json' );
        if ( file_exists( $addonJsonFile ) ) {
          $json = Json::decode( file_get_contents( $addonJsonFile ) );
          $json ['i18n'] = $fileNames;
          file_put_contents( $addonJsonFile, json_encode( $json, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) );
        }
      }
    }

  }
}

