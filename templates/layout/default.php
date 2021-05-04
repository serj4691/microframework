<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css"/>
    <title><?= $this->renderBlock('title') ?> - App</title>
    <?= $this->renderBlock('meta') ?>
    <style>
        body {
            padding-top: 70px;
        }

        .app {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .app-content {
            flex: 1;
        }

        .app-footer {
            padding-bottom: 1em;
        }
    </style>
</head>
<body class="app">
<header class="app-header">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">App</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= $this->encode($this->path('about')) ?>"><i class="glyphicon glyphicon-book"></i>About</a></li>
                    <li><a href="<?= $this->encode($this->path('cabinet')) ?>"><i class="glyphicon glyphicon-user"></i>Cabinet</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="app-content">
    <main class="container">
        <?= $this->renderBlock('breadcrumbs') ?>
        <?= $this->renderBlock('content') ?>
    </main>

</div>
<footer class="app-footer">
    <div class="container">
        <hr/>
        <p>&copy; 2021 - My App</p>
    </div>
</footer>
</body>
<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
</html>
