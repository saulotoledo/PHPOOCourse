<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $viewVars->strings->pageTitle; ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .container {
            max-width: 730px;
        }

        .panel {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php
            if ($viewVars->selected != null):
            ?>
            <div class="panel panel-success">
                <div class="panel-body">
                    <?php

                    foreach ($viewVars->strings->fieldLabels as $field => $label) {
                        echo sprintf('<label>%s:</label> %s<br />', $label, $viewVars->selected->$field);
                    }

                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <a href="?order=desc" class="btn btn-"><i class="glyphicon glyphicon-circle-arrow-up"></i></a>
            <a href="?order=asc" class="btn btn-"><i class="glyphicon glyphicon-circle-arrow-down"></i></a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <h2><?php echo $viewVars->strings->pageTitle; ?></h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th><label><?php echo $viewVars->strings->fieldLabels->nome; ?></label></th>
                        <th><label><?php echo $viewVars->strings->fieldLabels->email; ?></label></th>
                        <th><label><?php echo $viewVars->strings->fieldLabels->telefone; ?></label></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($viewVars->clientes as $key => $cliente):
                    ?>

                    <tr>
                        <td><?php echo $cliente->id; ?></td>
                        <td><a href="?id=<?php echo $key; ?>&order=<?php echo $viewVars->order; ?>"><?php echo $cliente->nome; ?></a></td>
                        <td><?php echo $cliente->email; ?></td>
                        <td><?php echo $cliente->telefone; ?></td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>