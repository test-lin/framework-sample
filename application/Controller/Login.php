<?php

namespace App\Controller;

use think\Cache;
use App\Model\UserModel;

class Login extends Base
{
    public function index()
    {
        $username = $this->getPost('username');
        $password = $this->getPost('password');

        if (empty($username) || empty($password)) {
            $this->responseFail('请填写用户名以及密码');
        }

        $userModel = new UserModel();
        $userInfo = $userModel->where('username', $username)->find();
        if (empty($userInfo)) {
            $this->responseFail('用户名或密码错误');
        }
        if (! $this->checkPassword($password, $userInfo['password'])) {
            $this->responseFail('用户名或密码错误');
        }

        $token = get_guid();

        $response = [
            'id' => $userInfo['id'],
            'username' => $userInfo['username']
        ];
        Cache::set($token, $response);

        Cache::set('auth.'.$userInfo['id'], $userInfo['auth']);

        $this->responseSuccess('登录成功', $response);
    }

    protected function getPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    protected function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}