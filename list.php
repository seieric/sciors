<?php
if(file_exists('./config.php')) {
  require_once './config.php';
} else {
  header( 'Location: /install.php' );
  exit;
}

try {
  $c = function($s){return $s;};
  $dbh = new PDO("mysql:host={$c(DATABASE_HOST)};dbname={$c(DATABASE_NAME)};charset=utf8", DATABASE_USER, DATABASE_PASSWD);

  $sql = "SELECT * FROM `sciors`";
  $statement = $dbh->query($sql);
  $dbh = null;

  $current = $_SERVER['PHP_SELF'];
  $current_path = rtrim($current, 'list.php');
  $base_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['SERVER_NAME'] . $current_path;
} catch(PDOException $e) {
  http_response_code( 500 );
  echo $e->getMessage();
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>URL List</title>
  </head>
  <body>
    <h1>Generated URLs</h1>
    <hr>
    <div>
      <a href="set.php">Create new shoten URL</a>
      <table>
        <thead>
          <th>ID</th>
          <th>URL</th>
          <th>Short URL</th>
        </thead>
        <tbody>
          <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
              <td><?= $row['id']?></td>
              <td><a href="<?= $row['url']?>"><?= $row['url']?></a></td>
              <td><?= $base_url . $row['short_code']?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
