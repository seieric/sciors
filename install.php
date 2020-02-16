<?php
if(file_exists('./config.php')) {
  require_once './config.php';
  #If alereay installed, return HTTP 404.
  if (INSTALL_STATUS) {
    http_response_code( 404 );
    echo "404 Not Found";
    exit;
  }
}

if (htmlspecialchars($_POST['action']) == "create") {
  if(isset($_POST['dbname']) && isset($_POST['dbhost']) && isset($_POST['dbuser']) && isset($_POST['dbpasswd'])){
    $db_name = htmlspecialchars($_POST['dbname']);
    $db_host = htmlspecialchars($_POST['dbhost']);
    $db_user = htmlspecialchars($_POST['dbuser']);
    $db_passwd = htmlspecialchars($_POST['dbpasswd']);

    try {
      $dbh = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_passwd);
      $sql = "CREATE TABLE IF NOT EXISTS `sciors` (
      	`id` INT(11) AUTO_INCREMENT PRIMARY KEY,
      	`short_code` VARCHAR(6),
      	`url` VARCHAR(2048)
      );";

      $statement = $dbh->prepare($sql);
      $statement->execute();

$config = <<< EOF
<?php
# Here is your database configuration
define( 'DATABASE_NAME' , '{$db_name}' );
define( 'DATABASE_PASSWD' , '{$db_passwd}' );
define( 'DATABASE_HOST' , '{$db_host}' );
define( 'DATABASE_USER' , '{$db_user}' );
define( 'INSTALL_STATUS' , true );
EOF;
      $file = fopen("config.php", "w");
      fwrite($file, $config);
      fclose($file);
      echo "Successfully installed Sciors!";
      exit;
    } catch (PDOException $e) {
      $error_message = $e->getMessage();
    }
  } else {
    $error_message = "Something went wrong. Please try again.";
  }
}?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Installation</title>
  </head>
  <body>
    <h1>Sciors Installation</h1>
    <hr>
    <h2>Requirements</h2>
    <ul>
      <li>MySQL ~= 5.7</li>
      <li>PHP ~= 7.1</li>
      <li>Apache ~= 2.2</li>
    </ul>
    <p>If your server does't meet them, you cannot make sure that this program works.</p>
    <p>Your configuration will save in config.php. See config.php.</p>
    <?php if (isset($error_message)) : ?>
      <p style="color: red;"><?php echo $error_message;?></p>
    <?php endif;?>
    <form action="install.php" method="post">
      <label for="dbname">Databse Name:</label>
      <input type="text" name="dbname">
      <br>
      <label for="dbhost">Databse Server Host:</label>
      <input type="text" name="dbhost" value="localhost">
      <br>
      <label for="dbuser">Databse User:</label>
      <input type="text" name="dbuser">
      <br>
      <label for="dbpasswd">Databse Password:</label>
      <input type="password" name="dbpasswd">
      <br>
      <input type="hidden" name="action" value="create">
      <input type="submit" value="Install">
    </form>
  </body>
</html>
