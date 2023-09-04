<!DOCTYPE html>
<html>
<head>
    <title>mission5-1</title>
</head>
<body>
    <h2>投稿フォーム</h2>
    <form method="post" action="">
        <input type="text" name="new_post" placeholder="新しい投稿を入力">
        <input type="password" name="password_post_id" placeholder="パスワードを入力">
        <input type="submit" value="投稿">
    </form>

    <h2>削除ホーム</h2>
    <form method="post" action="">
        <input type="number" name="delete_post_id" placeholder="削除対象の投稿番号">
        <input type="password" name="delete_password_post_id" placeholder="パスワードを入力">
        <input type="submit" value="削除">
    </form>

    <h2>編集フォーム</h2>
    <form method="post" action="">
        <input type="number" name="edit_post_id" placeholder="編集対象の投稿番号">
        <input type="password" name="edit_password_post_id" placeholder="パスワードを入力">
        <input type="submit" value="編集">
    </form>

    <?php
    $dsn = 'mysql:dbname=tb250212db;host=localhost';
    $user = 'tb-250212';
    $password = 'KYV2bca3Mg';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    if (isset($_POST['password_post_id']) && isset($_POST['new_post'])) {
        $new_post = $_POST['new_post'];
        $password_post_id = $_POST['password_post_id'];
    
        $sql = "INSERT INTO tbtest (name, comment) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$password_post_id, $new_post]);
    }

    if (isset($_POST['delete_post_id']) && isset($_POST['delete_password_post_id'])) {
        $delete_post_id = intval($_POST['delete_post_id']);
        $delete_password_post_id = $_POST['delete_password_post_id'];
    
        $sql = "DELETE FROM tbtest WHERE id = ? AND name = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$delete_post_id, $delete_password_post_id]);
    }

    if (isset($_POST['edit_post_id']) && isset($_POST['edit_password_post_id'])) {
        $edit_post_id = intval($_POST['edit_post_id']);
        $edit_password_post_id = $_POST['edit_password_post_id'];
        $sql = "SELECT * FROM tbtest WHERE id = ? AND name = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$edit_post_id, $edit_password_post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($post) {
            echo "<h2>投稿編集</h2>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='edited_post_id' value='{$post['id']}'>";
            echo "名前: <input type='text' name='edited_name' value='{$post['name']}'><br>";
            echo "コメント: <input type='text' name='edited_comment' value='{$post['comment']}'><br>";
            echo "<input type='submit' value='更新'>";
            echo "</form>";       
           }
        }
        
        
       
    
        echo "<h2>投稿一覧</h2>";
    echo "<ul>";
    
    $sql = "SELECT * FROM tbtest";
    $stmt = $pdo->query($sql);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>{$row['id']}: {$row['comment']}</li>";
    }
    
    echo "</ul>";
    ?>
</body>
</html>
