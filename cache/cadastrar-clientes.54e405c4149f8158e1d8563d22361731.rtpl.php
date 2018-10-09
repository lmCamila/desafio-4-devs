<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="./views/assets/css/style.css">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">ForLogic</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/clientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/avaliacoes">Avaliações</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container" id="register-customer">
        <div id="forms-customer" class="col-9 align-self-center">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="cliente">Empresa:</label>
                    <div >
                        <input class="form-control" type="text" id="cliente" name="cliente" required>
                        <span class" msg-erro msg-cliente"></span>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="nome_contato">Nome do contato:</label>
                    <input class="form-control" type="text" id="nome_contato" name="nome_contato" required>
                    <span class" msg-erro msg-contato"></span>
                </div>
                <div class="form-group">
                    <label for="data" class="col-form-label">Data em que se tornou cliente:</label>
                    <div>
                        <input class="form-control" type="month"  id="data" name="data" required>
                        <span class" msg-erro msg-contato"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for = "status">Status</label>
                    <select id="status" class="form-control" name= "status">
                        <option>Ativo</option>
                        <option>Inativo</option>
                    </select>
                    <span class" msg-erro msg-status"></span>
                </div>
                <div class="row justify-content-center">
                    <input type="submit" class="btn btn-primary" value="ENVIAR">
                </div>
            </form>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <script type="text/javascript" src="../views/js/cliente.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>