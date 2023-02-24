<h1>tasks</h1>
<?php
    $session = \App\helper\Session::getFlash('errors') ?? "";
    unset($_SESSION['flash_messages']['errors']);
?>
<form method="post" >
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" placeholder="Title">
        <p class="text-danger"><?= $session['description'][0] ?? '' ?></p>
    </div>
    <div class="form-group">
        <label>Description</label>
        <input name="description" type="text" class="form-control" placeholder="Description">
        <p class="text-danger"><?= $session['description'][0] ?? '' ?></p>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>

<br>

<table class="table .table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    foreach ($tasks as $task){
    ?>
    <tr>
        <form method="post" action="/tasks/update">
            <td><?= $i; ?></td>
            <td><input value="<?= $task->title ?>" name="title"></input></td>
            <td><input value="<?= $task->description ?>" name="description"></input></td>
            <td><input class="btn btn-primary" type="submit" value="Update"></input></td>
        </form>
        <td><input class="btn btn-danger" type="submit" value="Delete"></input></td>
    </tr>
    <?php
        $i++;
    }
    ?>
    </tbody>
</table>