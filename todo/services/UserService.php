<?php

namespace App\Service;

class UserService {
    private $user_json = __DIR__ . "/../user.json";
    public function register($user){
        $json = json_decode(file_get_contents($this->user_json), true);
        if(empty($user['username']) || empty($user['password'])){
            return array('message'=>"Gagal register");
        }
        foreach($json as $k=>$v){
            if($v['username']==$user['username']){
                return array('message'=>"User eksis");
            }
        }
        $new_user = new \stdClass();
        $new_user->username = $user['username'];
        $new_user->password = $user['password'];
        $json[] = $new_user;
        file_put_contents($this->user_json, json_encode($json));
        $new_json = json_decode(file_get_contents($this->user_json), true);
        return array('message'=>"Berhasil register");
    }

    public function login($user){
        $json = json_decode(file_get_contents($this->user_json), true);
        if(empty($user['username']) || empty($user['password'])){
            return array('message'=>"Login gagal");
        }

        foreach($json as $k=>$v){
            if($v['username']==$user['username'] && $v['password']==$user['password']){
                $_SESSION['username'] = $user['username'];
                return array('message'=>"Login sukses");
            }
        }
        return array('message'=>"Login gagal");
    }

    public function logout(){
        @\session_destroy();
        return array('message'=>"Logout Sukses");
    }
}