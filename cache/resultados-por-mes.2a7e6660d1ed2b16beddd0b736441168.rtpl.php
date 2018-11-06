<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../views/assets/css/style.css">
    <title>Resultados</title>
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
                    <li class="nav-item ">
                        <a class="nav-link" href="/clientes">Clientes</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="/avaliacoes">Avaliações</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/avaliacoes">Resultados</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
        <h3>Resultados</h3>
        <div id="tabela-resultados" class="table-responsive">
            <table class="table table-hover ">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Detratores</th>
                        <th scope="col">Neutros</th>
                        <th scope="col">Promotores</th>
                        <th scope="col">NPS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="<?php echo htmlspecialchars( $data["marcador"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                        <td id="data" class="classificar"><?php echo htmlspecialchars( $data["data"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td id="detratores" class="classificar"><?php echo htmlspecialchars( $data["detratores"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td id="neutros" class="classificar"><?php echo htmlspecialchars( $data["neutros"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td id="promotores" class="classificar"><?php echo htmlspecialchars( $data["promotores"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td id="nps" class="classificar"><?php echo format($data["nps"]); ?>%</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h3>Avaliações</h3>
            <div id="tabela-resultados" class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Cliente</th>
                            <th scope="col">Nota</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter1=-1;  if( isset($value) && ( is_array($value) || $value instanceof Traversable ) && sizeof($value) ) foreach( $value as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td><?php echo htmlspecialchars( $value1["cliente"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["nota"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["motivo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                            <td><?php echo htmlspecialchars( $value1["data"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer>
        <div class="row justify-content-center">
            <p>© Todos os direitos reservados.</p>
        </div>
    </footer> 
     <!--Script Google Charts-->
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

         <!-- Optional JavaScript -->
     <script type="text/javascript" src="../views/js/myLib.js"></script>
</body>

</html>