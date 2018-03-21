<?php

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\User;

/**
 * Description of PasswrodChangeForm
 *
 * @author dboro
 */
class PasswordChangeForm extends Model{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;
    
    /* @var $_user User */
    private $_user;
    
    public function __construct(User $user, $config = []) {
        $this->_user = $user;
        parent::__construct($config);
    }
    
    public function rules(){
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'currentPassword'],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'newPassword' => Yii::t('user/update', 'New password'),
            'newPasswordRepeat' => Yii::t('user/update', 'New password repeat'),
            'currentPassword' => Yii::t('user/update', 'Current password'),
        ];
    }
    
    public function currentPassword($attribute, $params){
        if(!$this->hasErrors()){
            if(!$this->_user->validatePassword($this->$attribute)){
                $this->addError($attribute, Yii::t('user/view', 'Error wrong current password'));
            }
        }
    }
    
    public function changePassword(){
        if($this->validate()){
            $user = $this->_user;
            $user->setPassword($this->newPassword);
            return $user->save();
        }else{
            return false;
        }
    }
}
