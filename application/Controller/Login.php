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
        $clientIp = get_client_ip();

        if (Cache::get("login_lock.{$clientIp}")) {
            $lockLockCount = Cache::get("login_lock_count.{$clientIp}");
            $this->responseFail("登录失败次数过多，请 {$lockLockCount} 分钟后再操作");
        }

        $userModel = new UserModel();
        $userInfo = $userModel->where('username', $username)->find();
        if (empty($userInfo)) {
            $this->loginLock($clientIp);
            $this->responseFail('用户名或密码错误');
        }
        if (! $this->checkPassword($password, $userInfo['password'])) {
            $this->loginLock($clientIp);
            $this->responseFail('用户名或密码错误');
        }
        $this->unLoginLock($clientIp);

        $token = get_guid();

        $response = [
            'id' => $userInfo['id'],
            'username' => $userInfo['username']
        ];
        Cache::set($token, $response);

        Cache::set('auth.'.$userInfo['id'], $userInfo['auth']);

        $this->responseSuccess('登录成功', $response);
    }

    protected function loginLock($ip)
    {
        Cache::inc("login_count.{$ip}");

        // 加锁数量
        $addLockCount = 3;
        if ($addLockCount < Cache::get("login_count.{$ip}")) {
            // 锁定次数
            Cache::inc("login_lock_count.{$ip}");

            // 锁定次数越多，锁定时间越长
            $lockLockCount = Cache::get("login_lock_count.{$ip}");
            $lockTime = 60 * $lockLockCount;
            Cache::set("login_lock.{$ip}", $ip, $lockTime);

            $this->responseFail("登录失败次数过多，请 {$lockLockCount} 分钟后再操作");
        }
    }

    // 登录成功要记得去除关联的缓存
    protected function unLoginLock($ip)
    {
        Cache::rm("login_count.{$ip}");
        Cache::rm("login_lock.{$ip}");
        Cache::rm("login_lock_count.{$ip}");
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