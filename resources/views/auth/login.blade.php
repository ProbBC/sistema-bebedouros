<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <!--Font Awesome-->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
       <link rel="stylesheet" href="/boostrap/style.css">

       <!-- Bootstrap CSS -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Login</title>
</head>
<body >

    <div class="container">
        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-center p-5 mt-5">
                <div class="row shadow">
                    <div class="col-12 d-flex justify-content-center p-5">
                          @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <!--<x-auth-validation-errors class="mb-4" :errors="$errors" />-->
                                <strong>Algo deu errado!</strong> {{ implode('', $errors->all(':message')) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                          @endif
                          <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" :value="old('email')" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">Nunca compartilharemos seu e-mail com mais ninguém.</div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Senha</label>
                                <input type="password" class="form-control" name="password" id="password">
                                <div class="form-text">
                                <!--<span>Esqueceu a senha? </span>
                                <a href="#">clique aqui</a>-->
                            </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                <label class="form-check-label" for="exampleCheck1">Lembrar senha</label>
                            </div>
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-danger">Fazer login</button>
                            </div>
                            <div class="d-grid gap-2 mb-3">
                                <input type="button" onclick="location.href='{{ route('register') }}';" class="btn btn-danger" value="Registrar"/>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--scripts bootstrap-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>
