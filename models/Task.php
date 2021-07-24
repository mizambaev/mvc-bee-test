<?php

namespace app\models;


use app\core\Application;
use app\core\db\DbModel;


class Task extends DbModel
{

    public int $id = 0;
    public string $email = '';
    public string $username = '';
    public string $text = '';
    public int $solved = 0;
    public string $created_at = '';
    public string $updated_at = '';

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function attributes(): array
    {
        return ['username', 'email', 'text'];
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'text' => [self::RULE_REQUIRED],
        ];
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Это поле обязательно к заполнению',
            self::RULE_EMAIL => 'В этом поле должен быть адрес электронной почты',
        ];
    }

    public function save(): bool
    {
        return parent::save();
    }

    public function updateTask($attr, $data, $id)
    {
        return parent::update($attr, $data, ['id' => $id]);
    }

    public function getTaskById($id)
    {
        $select = ['id', 'text', 'solved'];
        $where = ['id' => $id];
        return parent::findOne($where, $select);
    }

    public function getWithPaginate($page, $sort, $orderBy, $limit = 3): array
    {
        $total = parent::numRows();

        if ($total > $limit) {
            $pages = ceil($total / $limit);
            $offset = ($page - 1) * $limit;
            $link = Application::$app->request->getFullUrl();

            if (strpos($link, '?page=')) {
                $url_data = explode('?page', $link);
                $link = $url_data[0];
            } elseif (strpos($link, '&page=')) {
                $url_data = explode('&page', $link);
                $link = $url_data[0];
            }

            $result['pagination'] = [
                'pages' => $pages,
                'link' => (strpos($link, '?')) ? $link . '&page=' : $link . '?page=',
                'current_page' => $page,
                'total' => $total
            ];
        }
        $param = [
            'limit' => $limit,
            'offset' => $offset ?? 0,
            'sort' => $sort,
            'orderBy' => $orderBy
        ];

        $select = ['id', 'username', 'email', 'text', 'solved', 'created_at', 'updated_at'];
        $result['items'] = parent::findAll($param, $select);

        return $result;
    }


}