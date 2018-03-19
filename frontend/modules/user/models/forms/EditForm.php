<?php

namespace frontend\modules\user\models\forms;
use yii\base\Model;
use frontend\models\User;
use Yii;
/**
 * Description of EditForm
 *
 * @author dboro
 */
class EditForm extends Model{
    
    public $username;
    public $email;
    public $about;
    public $nickname;
    
    private $_user;
    
    public function __construct(User $user){
        $this->_user = $user;

        $this->username = $user->username;
        $this->email = $user->email;
        $this->about = $user->about;
        $this->nickname = $user->nickname;
        
    }


    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 20],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\frontend\models\User', 'message' => 'This email address has already been taken.'],
            
            [['about', 'nickname'], 'safe']
        ];
    }
    
    public function save(){
        if($this->username !== $this->_user->username){
            $this->validate(['username']);
        }
        
        if($this->email !== $this->_user->username){
            $this->validate(['email']);
        }
        
        if($this->getErrors()){
            return null;
        }
            
        
        $this->_user->username = $this->username;
        
        $this->_user->email = $this->email;
        $this->_user->about = $this->about;
        $this->_user->nickname = $this->nickname;
        return $this->_user->save();
    }

}
