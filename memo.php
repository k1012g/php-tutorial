<!DOCTYPE html>
<?php
  $dsn = "mysql:dbname=php_tools;host=localhost;charset=utf8";
  $user = "root";
  $password = "";
  $pdo = new PDO($dsn, $user, $password);

  if (null !== @$_POST["create"]) {
    if (@$_POST["title"] != "" OR @$_POST["contents"] != "") {
      $stmt = $pdo->prepare("INSERT INTO memo(title, contents) VALUES (:title, :contents)");
      $stmt->bindvalue(":title", @$_POST["title"]);
      $stmt->bindvalue(":contents", @$_POST["contents"]);
      $stmt->execute();
    }
  }

  if (null !== @$_POST["update"]) {
    $stmt = $pdo->prepare("UPDATE memo SET title = :title, contents = :contents WHERE id = :id");
    $stmt->bindvalue(":title", @$_POST["title"]);
    $stmt->bindvalue(":contents", @$_POST["contents"]);
    $stmt->bindvalue(":id", @$_POST["id"]);
    $stmt->execute();
  }

  if (null !== @$_POST["delete"]) {
    $stmt = $pdo->prepare("DELETE FROM memo WHERE id = :id");
    $stmt->bindvalue(":id", @$_POST["id"]);
    $stmt->execute();
  }
?>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h2>新規作成</h2>
    <form action="memo.php" method="post">
      Title<br>
      <input type="text" name="title" size="20">
      <br>
      Contents<br>
      <textarea name="contents" style="width: 300px; height: 100px;"></textarea>
      <br>
      <input type="submit" name="create" value="追加">
    </form>
    <h2>メモ一覧</h2>
    <?php
      $stmt = $pdo->query("SELECT * FROM memo");
      foreach ($stmt as $row):
    ?>
      <form action="memo.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row[0] ?>">
        Title<br>
        <input type="text" name="title" size="20" value="<?php echo $row[1] ?>">
        <br>
        Contents<br>
        <textarea name="contents" style="width:300px; height:100px;">
          <?php echo $row[2] ?>
        </textarea>
        <br>
        <input type="submit" name="update" value="変更">
        <input type="submit" name="delete" value="削除">
      </form>
    <?php endforeach; ?>
  </body>
</html>