<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
</head>
<body>

    <h1>Add New User</h1>

    <?php if (isset($validation)): ?>
        <div style="color: red;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="/users/create" method="post">

        <?= csrf_field() ?>

        <label for="username">Username:</label><br>
        <input
            type="text"
            id="username"
            name="username"
            value="<?= esc(old('username')) ?>"
        >
        <br><br>

        <label for="full_name">Full Name:</label><br>
        <input
            type="text"
            id="full_name"
            name="full_name"
            value="<?= esc(old('full_name')) ?>"
        >
        <br><br>

        <button type="submit">Save User</button>
    </form>

    <br>

    <a href="/users">Back to Users</a>

</body>
</html>