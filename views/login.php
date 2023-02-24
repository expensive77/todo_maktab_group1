<h1 class="text-center">Login Page</h1>
<?php
    $session = \App\helper\Session::getFlash('errors') ?? "";
    unset($_SESSION['flash_messages']['errors']);
?>
<div class="container">
    <form method="post" >
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="text" name="email" class="form-control" placeholder="Enter email">
            <p class="text-danger"><?= $session['email'][0] ?? '' ?></p>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" placeholder="Password">
            <p class="text-danger"><?= $session['password'][0] ?? '' ?></p>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>