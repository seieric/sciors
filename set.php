<?php
if(file_exists('./config.php')) {
  require_once './config.php';
} else {
  header( 'Location: /install.php' );
  exit;
}

if(isset($_POST['url'])) {
  $url = $_POST['url'];
  if(!filter_var($url, FILTER_VALIDATE_URL)){
    $error_message = "Invalid URL.";
  } else {
    $short_code = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);

    try {
      $c = function($s){return $s;};
      $dbh = new PDO("mysql:host={$c(DATABASE_HOST)};dbname={$c(DATABASE_NAME)};charset=utf8", DATABASE_USER, DATABASE_PASSWD);
      $sql = "INSERT INTO `sciors` (short_code, url) VALUES (:short_code, :url);";
      $statement = $dbh->prepare($sql);
      $statement->execute( array(
        ':short_code' => $short_code,
        ':url' => $url
      ));

      $statement = null;
      $dbh = null;

      $current = $_SERVER['PHP_SELF'];
      $path = rtrim($current, 'set.php');
      $short_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER['SERVER_NAME'] . $path . $short_code;
    } catch(PDOException $e) {
      $error_message = $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>URL Shortener Sciors</title>
  </head>
  <body>
    <h1>Create new short url</h1>
    <hr>
    <a href="list.php">See generated URLs</a>
    <?php if(isset($short_url)) : ?>
      <p>This is your short url for "<?php echo $url; ?>".</p>
      <a href="<?php echo $short_url; ?>"style="color: green;"><?php echo $short_url ?></a>
    <?php endif; ?>
    <p>Please fill the blank below.</p>
    <?php if (isset($error_message)) : ?>
      <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="set.php" method="post">
      <label for="url">URL</label>
      <input type="text" name="url">
      <br>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
