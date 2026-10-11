<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

    <h1>Edit User</h1>

    <?php if (isset($validation)): ?>
        <div style="color: red;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="/users/update/<?= $user['id'] ?>" method="post" enctype="multipart/form-data">

        <?= csrf_field() ?>

        <label>Current Avatar:</label><br>

        <?php if (!empty($user['avatar'])): ?>
            <img
                src="/uploads/<?= esc($user['avatar']) ?>"
                width="120"
                height="120"
                alt="Current avatar"
            >
        <?php else: ?>
            <img
                src="/avatar-placeholder.svg"
                width="120"
                height="120"
                alt="Placeholder avatar"
            >
        <?php endif; ?>

        <br><br>

        <label for="username">Username:</label><br>
        <input
            type="text"
            id="username"
            name="username"
            value="<?= esc(old('username', $user['username'])) ?>"
        >
        <br><br>

        <label for="full_name">Full Name:</label><br>
        <input
            type="text"
            id="full_name"
            name="full_name"
            value="<?= esc(old('full_name', $user['full_name'])) ?>"
        >
        <br><br>

        <label for="avatar">New Avatar JPG or PNG, maximum 2 MB:</label><br>
        <input
            type="file"
            id="avatar"
            name="avatar"
            accept=".jpg,.jpeg,.png"
        >
        <br><br>

        <button type="submit">Update User</button>
    </form>

    <br>

    <a href="/users">Back to Users</a>

</body>
</html>