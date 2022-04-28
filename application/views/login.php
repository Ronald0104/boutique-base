<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>..:: <?php echo $empresa[0]->nombreComercial ?> ::..</title>    
    <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/css/login.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            /* background: rgba(109,0,25,1); */
            background: rgb(225 203 208);
            /* background: -moz-linear-gradient(top, rgba(109,0,25,1) 0%, rgba(143,2,34,0.76) 56%, rgba(169,3,41,0.57) 100%);
            background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(109,0,25,1)), color-stop(56%, rgba(143,2,34,0.76)), color-stop(100%, rgba(169,3,41,0.57)));
            background: -webkit-linear-gradient(top, rgba(109,0,25,1) 0%, rgba(143,2,34,0.76) 56%, rgba(169,3,41,0.57) 100%);
            background: -o-linear-gradient(top, rgba(109,0,25,1) 0%, rgba(143,2,34,0.76) 56%, rgba(169,3,41,0.57) 100%);
            background: -ms-linear-gradient(top, rgba(109,0,25,1) 0%, rgba(143,2,34,0.76) 56%, rgba(169,3,41,0.57) 100%);
            background: linear-gradient(to bottom, rgba(109,0,25,1) 0%, rgba(143,2,34,0.76) 56%, rgba(169,3,41,0.57) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6d0019', endColorstr='#a90329', GradientType=0 ); */
        }
        .container-login {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .col-login {
            margin-top: 50px;
            min-width: 320px;
        }
        .card {
            background-color: #0c0c0c;
        }
        .card-header {
            border-bottom: 1px solid #8a5e5e;
        }
        .card-footer {
            border-top: 1px solid #8a5e5e;
        }
        h5 {
            color: #fff;
            font-size: 1.4rem;
            /* font-family: cursive; */
        }
        h4.text-login {
            color: #6c76c1;
        }
        .profile-img {
            width: 140px;
            height: 140px;
        }
        label {
            color: #fff;
        }
        input[type="submit"] {
            font-weight: bold;
            font-size: 1.1rem;
            line-height: 24px;
            background-color: #b30c13;
        }
        #btnLogin {
            height: 44px; 
            text-transform: uppercase;
        }

        @media screen and (min-width: 768px) {
            .col-login {
                margin-top: 50px;                
                min-width: 380px;
            }
        }
    </style>
</head>

<body>
                            
    <!-- <pre><?php echo var_dump($empresa[0])?></pre>
    <pre><?php echo print_r($empresa[0])?></pre>
    <?php echo base_url()."/assets/img/".$empresa[0]->logoLogin?> -->

    <!------ Include the above in your HEAD tag ---------->
    <div class="container container-login" id="container-login">
        <div class="row">
            <!-- <div class="col-xs-12 col-sm-8 col-md-6 col-md-offset-4 col-login"> -->
            <div class="col-login">
                <div class="card">
                    <div class="card-header">                 
                        <h5 class="d-block text-center font-weight-bold mb-0"><?php echo $empresa[0]->tituloLogin ?></h5>
                    </div>

                    <div class="card-body pb-1">                        
                        <img class="profile-img card-img-top" src="<?php echo base_url()."/assets/img/company/".$empresa[0]->logoLogin;?>" alt="LOGO">
                    </div>
                    <div class="card-body pt-2">
                        <!-- <h4 class="text-login text-center">Ingreso al <span>Sistema</span></h4> -->
                        <form role="form" action="/login/login" method="POST" id="frmLogin">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-user"></i>
                                            </span>
                                            <input class="form-control" placeholder="Usuario" name="username" id="username" type="text" autofocus>
                                        </div>
                                        <!-- <span class="text-danger"><?php echo form_error('username')?></span> -->
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-lock"></i>
                                            </span>
                                            <input class="form-control" placeholder="password" name="password" id="password" type="password" value="" autocomplete="nope">
                                        </div>
                                        <!-- <span class="text-danger"><?php echo form_error('password')?></span> -->
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="recordar" id="recordar">
                                        <label class="form-check-label font-weight-bold" for="recordar">Recordar Contraseña</label>
                                    </div>
                                    <div class="text text-danger" id="error" style="margin-top: -5px; margin-bottom: 5px;">
                                        <!-- <b><?php if(isset($error)) { echo $error; };?></b> -->
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="submit" class="btn btn-lg btn-primary btn-block" id="btnLogin" value="Ingresar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="card-footer">

                    </div> -->
                </div>
                <!-- <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong> Acceso usuarios</strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="/admin/login" method="POST" id="frmLogin">
                            <fieldset>
                                <div class="row">
                                    <div class="center-block">
                                        <img class="profile-img" src="<?php echo base_url();?>/assets/img/security-128.png" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <h3 class="text-center text-login">Ingresar al <span>Sistema</span></h3>
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </span>
                                                <input class="form-control" placeholder="Usuario" name="username" id="username" type="text" autofocus>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('username')?></span>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-lock"></i>
                                                </span>
                                                <input class="form-control" placeholder="password" name="password" id="password" type="password" value="">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('password')?></span>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="text text-danger" id="error" style="margin-top: -5px; margin-bottom: 5px;">
                                            <b><?php if(isset($error)) { echo $error; };?></b>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Ingresar">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="panel-footer">
                        Don't have an account! <a href="#" onClick=""> Sign Up Here </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
    <!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->

    <script src="<?php echo base_url();?>assets/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/login.js?v=1.2.1"></script>
</body>

</html>