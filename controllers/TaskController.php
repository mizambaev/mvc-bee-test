<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $sort_fields = ['username', 'email', 'solved'];
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        if (isset($_GET['sort']) && array_search($_GET['sort'], $sort_fields) !== false) {
            $sort = $_GET['sort'];
        } else {
            $sort = 'created_at';
        }
        $orderBy = (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'ASC' : 'DESC';

        $tasks = new Task();
        $data['tasks'] = $tasks->getWithPaginate($page, $sort, $orderBy);
        $data['msg'] = Application::$app->session->get('flash_messages');
        $data['url'] = Application::$app->request->getFullUrl();
        $data['user'] = Application::$app->session->get('user');
        return $this->view('home', $data);
    }

    public function create()
    {
        $msg = Application::$app->session->get('flash_messages');
        $data = [];
        $data['user'] = Application::$app->session->get('user');
        if ($msg) {
            $data['msg'] = $msg;
        }

        return $this->view('task/create', $data);
    }

    public function store()
    {
        $task = new Task();
        if (!empty($_POST)) {
            $new_task = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'text' => htmlspecialchars($_POST['text'] ?? ''),
            ];
            $task->loadData($new_task);
            if (!$task->validate()) {
                return $this->view('task\create', ['errors' => $task->errors]);
            } else {
                $task->save();
                Application::$app->session->setFlash('success', 'Задача добавлена!');
                Application::$app->response->redirect('/');
            }
        }
    }

    public function edit()
    {
        if (!Application::$app->session->get('user') || !isset($_GET['id'])) {
            Application::$app->session->setFlash('auth_msg', 'Пожалуйста авторизуйтесь!');
            Application::$app->response->redirect('/');
        }
        $tasks = new Task();
        $task = $tasks->getTaskById($_GET['id']);
        if (!$task) {
            Application::$app->response->redirect('/');
        }
        Application::$app->session->set('old_text', $task['text']);
        return $this->view('task/edit', ['task' => $task]);
    }

    public function update()
    {
        if (!Application::$app->session->get('user') || empty($_POST)) {
            Application::$app->session->setFlash('auth_msg', 'Пожалуйста авторизуйтесь!');
            Application::$app->response->redirect('/');
        } else {
            $task = new Task();
            $old_text = Application::$app->session->get('old_text');
            $update_task = [
                'text' => htmlspecialchars(
                    (isset($_POST['text']) && $_POST['text'] !== '') ? $_POST['text'] : $old_text
                ),
                'solved' => (isset($_POST['solved']) && $_POST['solved'] == 0) ? 0 : 1,
            ];
            if ($update_task['text'] !== $old_text) {
                $update_task['updateds_at'] = date("Y-m-d H:i:s");
            }
            $task->updateTask(array_keys($update_task), $update_task, $_POST['id']);
            Application::$app->response->redirect('/edit?id=' . $_POST['id']);
        }
    }
}