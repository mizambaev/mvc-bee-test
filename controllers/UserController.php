<?php

namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\models\User;
use app\core\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Application::$app->session->get('user')) {
            Application::$app->session->setFlash('auth_msg', 'Вы уже авторизованы!');
            Application::$app->response->redirect('/');
        }
        $user = new User();
        $data = $request->getBody();
        if ($request->getMethod() === 'post') {
            $user->loadData($data);
            if ($user->validate() && $user->login($data['login'], $data['password'])) {
                Application::$app->session->set('user', $user);
                Application::$app->response->redirect('/');
            } else {
                return $this->view('user\login', ['errors' => $user->errors]);
            }
        }
        return $this->view('user\login');
    }

    public function logout()
    {
        if (Application::$app->session->get('user')) {
            Application::$app->session->remove('user');
        }
        Application::$app->response->redirect('/');
    }
}