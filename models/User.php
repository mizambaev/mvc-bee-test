<?php


namespace app\models;


use app\core\db\DbModel;


class User extends DbModel
{
    public int $id = 0;
    public string $login = '';
    public string $password= '';

    public static function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return [
            'login' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Это поле обязательно к заполнению'
        ];
    }

    public function login($login, $password)
    {
        $user = User::findOne(['login' => $login]);
        if (!$user) {
            $this->addError('login', 'Пользователь не существует');
            return false;
        }
        if (!password_verify($password, $user['password'])) {
            $this->addError('password', 'Неверный пароль');
            return false;
        }
        return true;
    }
}