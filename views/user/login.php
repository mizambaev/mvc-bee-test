
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Авторизация</title>
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
        </div>
    </div>
</nav>

<main class="container">
    <div class="bg-light p-5 rounded">
        <h1>Авторизация</h1>
        <form method="POST" action="/login">
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Логин</label>
                <input name="login" type="text" class="form-control" id="usernameInput" aria-describedby="usernameHelp">
                <?php if (isset($errors['login'])):?>
                    <?php foreach ($errors['login'] as $item) :?>
                        <div id="usernameHelp" class="form-text"><?php echo $item?></div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control" id="emailInput" aria-describedby="emailHelp">
                <?php if (isset($errors['password'])):?>
                    <?php foreach ($errors['password'] as $item) :?>
                        <div id="usernameHelp" class="form-text"><?php echo $item?></div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
