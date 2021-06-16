<?php

namespace Backend\Forms;

use Backend\Models\AuthItemChild;
use Backend\Models\AuthPermission;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class AuthPermissionForm extends Model {

  public $id;

  public $pid;

  public $name;

  public $ruleId;

  public function rules() {

    return [
        [
            [
                'id',
                'name'
            ],
            'required'
        ],
        [
            [
                'id',
                'pid',
                'ruleId',
                'name'
            ],
            'string'
        ]
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'app_auth_item', 'ID' ),
        'name' => Yii::t( 'app_auth_item', 'Name' ),
        'ruleId' => Yii::t( 'app_auth_item', 'Rule ID' ),
        'pid' => Yii::t( 'app_auth_item', 'Pid' )
    ];

  }

  /**
   * 保存权限
   *
   * @param boolean $validation
   * @return boolean
   */
  public function save( $validation = true ) {

    if ( $validation && ! $this->validate() ) {
      return false;
    }
    return \Yii::$app->db->transaction( function ( $db ) {
      $perm = AuthPermission::findOne( [
          'id' => $this->id
      ] );
      // 更新
      if ( ! $perm ) {
        $perm = new AuthPermission( [
            'id' => $this->id
        ] );
      }
      $perm->name = $this->name;
      $perm->ruleId = $this->ruleId;
      if ( $perm->save( false ) ) {
        $relation = AuthItemChild::findOne( [
            'child' => $this->id,
            'parent' => AuthPermission::find()->select( 'id' )
        ] );
        if ( $relation ) {
          if ( $this->parent ) {
            $relation->parent = $this->parent;
            $relation->save( false );
          } else {
            $relation->delete();
          }
        } else {
          if ( $this->parent ) {
            $relation = new AuthItemChild( [
                'parent' => $this->parent,
                'child' => $this->id
            ] );
            $relation->save( false );
          }
        }
        return true;
      }
      return false;
    } );

  }

  public static function findModel( $id ) {

    $model = AuthPermission::findOne( $id );
    if ( null != $model ) {
      $form = new AuthPermissionForm( [
          'id' => $id,
          'name' => $model->name,
          'ruleId' => $model->ruleId
      ] );
      $relation = AuthItemChild::findOne( [
          'child' => $id,
          'parent' => AuthPermission::find()->select( 'id' )
      ] );
      if ( $relation ) {
        $form->pid = $relation->parent;
      }
      return $form;
    }
    throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );

  }
}

