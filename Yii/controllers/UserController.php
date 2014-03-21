<?php

/**
 * Description of UserController
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package etki-tools
 * @subpackage <subpackage>
 */
class UserController
{
    public function actionAddUser()
    {
        if ($data = Yii::app()->request->getPost('User')) {
            Yii::app()->redirect(array('user/edit'), $user->id);
        }
    }
    public function actionEditUser()
    {
        
    }
    public function actionDeleteUser()
    {
        
    }
    public function actionIndex()
    {
        
    }
}
