<?php

/**
 * Description of User
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package etki-tools
 * @subpackage <subpackage>
 */
class User extends ActiveRecordLayer
{
    public $id;
    public $username;
    public $password;
    public $newPassword;
    public $newPasswordRepeat;
    
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function tableName() {
        return 'users';
    }
    public function passwordUpdateValidator($attribute, $params)
    {
        if (!isset($params['compareAttribute'])) {
            $message = 'Password verification requires `compareAttribute` parameter';
            throw new CException($message);
        }
        if (sha1($this->$attribute) !== $this->$params['compareAttribute']) {
            $error = Yii::t('user.messages', 'incorrect-password');
            $this->addError($attribute, $error);
        }
    }
    public function attributeLabels() {
        if (!isset($this->_cachedAttributeLabels)) {
            $this->_cachedAttributeLabels = array(
                'id' => 'ID',
                'username' => Yii::t('forms.labels', 'user.username'),
                'password' => Yii::t('forms.labels', 'user.password'),
                'newPassword' => Yii::t('forms.labels', 'user.newPassword'),
                'newPasswordRepeat' => Yii::t('forms.labels', 'user.newPasswordRepeat'),
            );
        }
        return $this->_cachedAttributeLabels;
    }
    public function rules()
    {
        return array(
            // create
            array(
                array('username'),
                'length',
                'allowEmpty' => false,
                'min' => 3,
                'max' => 255,
                'on' => array('create'),
            ),
            array(
                array('newPassword', 'newPasswordRepeat'),
                'length',
                'allowEmpty' => false,
                'min' => 6,
                'max' => 255,
                'on' => array('create', 'update'),
            ),
            array(
                array('newPasswordRepeat'),
                'compare',
                'compareAttribute' => 'newPassword',
                'on' => array('create', 'update'),
            ),
            array(
                array('newPassword'),
                'compare',
                'compareAttribute' => 'password',
                'on' => array('update'),
            )
        );
    }
}
