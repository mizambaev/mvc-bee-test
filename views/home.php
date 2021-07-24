
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Задачник</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbar-static/">
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Задачник</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Главная</a>
                </li>

            </ul>
            <?php if (!$user) :?>
                <a class="btn btn-primary" href="/login" role="button">Авторизация</a>
            <?php endif;?>
            <?php if ($user) :?>
                <a class="btn btn-primary" href="/logout" role="button">Выйти</a>
            <?php endif;?>
        </div>
    </div>
</nav>

<main class="container">
    <div class="bg-light p-5 rounded">
        <h1>Задачи</h1>
        <div class="d-md-flex justify-content-md-end">
            <a class="btn btn-primary" href="/create" role="button">Добавить задачу</a>
        </div>
        <br>
        <select onchange="location = this.value;">
            <option value="/">По умолчанию</option>
            <option <?php echo (strpos($url, '/?sort=username') === false) ? '' : 'selected'?> value="/?sort=username">Имя пользователя по убыванию</option>
            <option <?php echo (strpos($url, '/?sort=username&order=ASC') === false) ? '' : 'selected'?> value="/?sort=username&order=ASC">Имя пользователя по возрастанию</option>
            <option <?php echo (strpos($url, '/?sort=email') === false) ? '' : 'selected'?> value="/?sort=email">Email по убыванию</option>
            <option <?php echo (strpos($url, '/?sort=email&order=ASC') === false) ? '' : 'selected'?> value="/?sort=email&order=ASC">Email по возрастанию</option>
            <option <?php echo (strpos($url, '/?sort=solved') === false) ? '' : 'selected'?> value="/?sort=solved">Сначала решенные задачи</option>
            <option <?php echo (strpos($url, '/?sort=solved&order=ASC') === false) ? '' : 'selected'?> value="/?sort=solved&order=ASC">Сначала не решенные задачи</option>
        </select>
        <br>

        <br>
        <?php if (isset($msg['success'])):?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo $msg['success']['value']?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif;?>
        <?php if (isset($msg['auth_msg'])):?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $msg['auth_msg']['value']?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif;?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Имя пользователя</th>
                <th scope="col">Email</th>
                <th scope="col">Текст задачи</th>
                <th scope="col">Статус</th>

            </tr>
            </thead>
            <tbody>
            <?php if($tasks['items']):?>
                <?php foreach ($tasks['items'] as $task):?>
                    <tr>
                        <td><?php echo $task['username'];?></td>
                        <td><?php echo $task['email'];?></td>
                        <td><?php echo $task['text'];?></td>
                        <td>
                            <?php if ($task['solved'] == 1) echo "Выполнено";?><br>
                            <?php if ($task['created_at'] !== $task['updated_at']) echo 'Отредактировано администратором';?>
                            <?php if ($user) :?>
                                <br>
                                <a class="btn btn-success" href="/edit?id=<?php echo $task['id'];?>" role="button">Редактировать</a>
                            <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>
        <?php if(isset($tasks['pagination'])) :?>
        <nav aria-label="...">
            <ul class="pagination justify-content-center">
                <?php
                    for ($i = 1; $i <= $tasks['pagination']['pages']; $i++) {
                        if ($i == $tasks['pagination']['current_page']) {
                            echo "<li class='page-item active' aria-current='page'><span class='page-link'>" . $i . "</span></li>";
                        } else {
                            echo "<li class='page-item' aria-current='page'><a class='page-link' href='" . $tasks['pagination']['link'].$i . "'>" . $i . "</a></li>";
                        }
                    }
                ?>
            </ul>
        </nav>
        <?php endif;?>
    </div>
</main>

<script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
