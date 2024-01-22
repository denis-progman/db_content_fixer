<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DB content fixer</title>
</head>
<body>
    <h1>DB content fixer</h1>
    <form action="fixer.php" method="post">
        <label for="db_host">DB host</label>
        <input type="text" name="db_host" id="db_host" value="<?= $_POST["target_content"] ?? "localhost" ?>">
        <br>
        <label for="db_name">DB name</label>
        <input type="text" name="db_name" id="db_name" value="test">
        <br>
        <label for="db_user">DB user</label>
        <input type="text" name="db_user" id="db_user" value="root">
        <br>
        <label for="db_pass">DB password</label>
        <input type="password" name="db_pass" id="db_pass" value="">
        <hr>
        <label for="target_content">Target content</label>
        <textarea name="target_content" id="target_content" cols="30" rows="10"><?= $_POST["target_content"] ?></textarea>
        <br>
        <label for="replace_content">Replace content</label>
        <textarea name="replace_content" id="replace_content" cols="30" rows="10"><?= $_POST["replace_content"] ?></textarea>
        <br>
        <input type="submit" value="fined">
        <?php if (isset($found) && !empty($found)): ?>
            <hr>
            <h2>Found content</h2>
            <table>
                <thead>
                    <tr>
                        <th>Table</th>
                        <th>Column</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($found as $table => $data): ?>
                        <tr>
                            <td><?= $table ?></td>
                            <td><?= $data['column'] ?></td>
                            <td><?= $data['value'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>
        <strong><?= count($found)?> items have been found. Fix it? </strong>
            <input type="submit" value="fix">
        <?php endif; ?>
    </form>
</body>
</html>
