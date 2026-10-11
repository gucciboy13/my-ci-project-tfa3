<!DOCTYPE html>
<html>
<head>
    <title>Add New Customer</title>
</head>
<body>

    <h1>Add New Customer</h1>

    <?php if (isset($validation)): ?>
        <div style="color: red;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="/customers/create" method="post">

        <?= csrf_field() ?>

        <label for="full_name">Full Name:</label><br>
        <input
            type="text"
            id="full_name"
            name="full_name"
            value="<?= esc(old('full_name')) ?>"
        >
        <br><br>

        <label for="email">Email:</label><br>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= esc(old('email')) ?>"
        >
        <br><br>

        <label for="phone">Phone:</label><br>
        <input
            type="text"
            id="phone"
            name="phone"
            value="<?= esc(old('phone')) ?>"
        >
        <br><br>

        <button type="submit">Save Customer</button>
    </form>

    <br>

    <a href="<?= base_url('customers') ?>">Back to Customers</a>

</body>
</html>