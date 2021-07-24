
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
                    <a class="nav-link active" aria-current="page" href="/">Главная</a>
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
        <h1>Редактировать задачу</h1>
        <?php if (isset($msg['success'])):?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo $msg['success']['value']?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif;?>
        <form method="POST" action="/update">
            <input type="hidden" name="id" value="<?php echo $task['id']?>">
            <div class="mb-3">
                <label for="textInput" class="form-label">Текст задачи</label>
                <textarea name="text" class="form-control" id="textInput"  aria-describedby="textHelp"><?php echo $task['text']?></textarea>
                <?php if (isset($msg['error']['value']['text'])):?>
                    <?php foreach ($msg['error']['value']['text'] as $item) :?>
                        <div id="usernameHelp" class="form-text"><?php echo $item?></div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
            <div class="mb-3">
                <label for="textInput" class="form-label">Статус задачи</label>
                <br>
                <input type="radio" name="solved" value="0" <?php echo ($task['solved'] == 0) ? 'checked' : '' ?>> - Не выполнено
                <br>
                <input type="radio" name="solved" value="1" <?php echo ($task['solved'] == 1) ? 'checked' : '' ?>> - Выполнено
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
