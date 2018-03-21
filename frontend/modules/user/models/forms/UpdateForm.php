<?php

namespace frontend\modules\user\models\forms;
use yii\base\Model;
use frontend\models\User;
/**
 * Description of EditForm
 *
 * @author dboro
 */
class UpdateForm extends Model{
    
    public $username;
    public $about;
    public $nickname;
    
    private $_user;
    
    public function __construct(User $user){
        $this->_user = $user;

        $this->username = $user->username;
        $this->about = $user->about;
        $this->nickname = $user->nickname;
        
    }


    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 20],

            [['about', 'nickname'], 'safe']
        ];
    }
    
    public function update(){
        if($this->username !== $this->_user->username){
            $this->validate(['username']);
        }
        
        if($this->getErrors()){
            return false;
        }

        $this->_user->username = $this->username;
        $this->_user->about = $this->about;
        $this->_user->nickname = $this->nickname;
        return $this->_user->save();
    }

}
