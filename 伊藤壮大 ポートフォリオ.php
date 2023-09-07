<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>伊藤壮大　製作物</title>
    <style type="text/css">
        div#main {
            padding: 30px;
            background-image: url('デスク周り.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        div#main {
            padding: 30px;
            background-color: #efefef;
        }
    </style>
</head>
<body>
<div class="container">
    <div id="main">
        <h2>投稿フォーム</h2>
        <form class="form" method="post" action="">
            <div class="form-group">
                <input class="form-control" type="text" name="new_post" placeholder="新しい投稿を入力">
                <input class="form-control" type="password" name="password_post_id" placeholder="パスワードを入力">
                <button class="btn btn-primary" type="submit" name="submit_new_post">投稿</button>
            </div>
        </form>
    
        <h2>削除ホーム</h2>
        <form class="form" method="post" action="">
            <div class="form-group">
                <input class="form-control" type="number" name="delete_post_id" placeholder="削除対象の投稿番号">
                <input class="form-control" type="password" name="delete_password_post_id" placeholder="パスワードを入力">
                <button class="btn btn-danger" type="submit" name="submit_delete_post">削除</button>
            </div>
        </form>

        <h2>編集フォーム</h2>
        <form class="form" method="post" action="">
            <div class="form-group">
                <input class="form-control" type="number" name="edit_post_id" placeholder="編集対象の投稿番号">
                <input class="form-control" type="password" name="edit_password_post_id" placeholder="パスワードを入力">
                <button class="btn btn-warning" type="submit" name="submit_edit_post">編集</button>
            </div>
        </form>

        <?php
        $dsn = 'mysql:dbname=tb250212db;host=localhost';
        $user = 'tb-250212';
        $password = 'KYV2bca3Mg';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        if (isset($_POST['submit_new_post'])) {
            $new_post = $_POST['new_post'];
            $password_post_id = $_POST['password_post_id'];

            $sql = "INSERT INTO tbtest (name, comment) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$password_post_id, $new_post]);
        }

        if (isset($_POST['submit_delete_post'])) {
            $delete_post_id = intval($_POST['delete_post_id']);
            $delete_password_post_id = $_POST['delete_password_post_id'];

            $sql = "DELETE FROM tbtest WHERE id = ? AND name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$delete_post_id, $delete_password_post_id]);
        }

        echo "<h2>投稿一覧</h2>";
        echo "<ul>";

        $sql = "SELECT * FROM tbtest";
        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>{$row['id']}: {$row['comment']} <a href='?edit_post_id={$row['id']}'>編集</a></li>";
        }

        echo "</ul>";

        if (isset($_POST['submit_edit_post'])) {
            $edit_post_id = intval($_POST['edit_post_id']);
            $sql = "SELECT * FROM tbtest WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$edit_post_id]);
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                echo "<h2>投稿編集</h2>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='edited_post_id' value='{$post['id']}'>";
                echo "名前: <input type='text' name='edited_name' value='{$post['name']}'><br>";
                echo "コメント: <input type='text' name='edited_comment' value='{$post['comment']}'><br>";
                echo "<button class='btn btn-warning' type='submit' name='submit_update_post'>更新</button>";
                echo "</form>";
            }
        }

        if (isset($_POST['submit_update_post'])) {
            $edited_post_id = intval($_POST['edited_post_id']);
            $edited_name = $_POST['edited_name'];
            $edited_comment = $_POST['edited_comment'];

            $sql = "UPDATE tbtest SET name = ?, comment = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$edited_name, $edited_comment, $edited_post_id]);
        }
        ?>
        </div>
    </div>
</body>
</html>



