<?php
require './config.php';

if (isset($_GET['code'])) {
  $code = htmlspecialchars($_GET['code']);
  try {
    $c = function($s){return $s;};
    $dbh = new PDO("mysql:host={$c(DATABASE_HOST)};dbname={$c(DATABASE_NAME)};charset=utf8", DATABASE_USER, DATABASE_PASSWD);

    $sql = "SELECT * FROM `sciors` WHERE `short_code` = :short_code";
    $statement = $dbh->prepare($sql);
    $statement->execute( array(':short_code' => $code));
    $result = $statement->fetchAll();

    $url = $result[0][url];
    $statement = null;
    $dbh = null;

    header( "Location: ${url}" );
    exit;
  } catch(PDOException $e) {
    http_response_code( 500 );
    echo $e->getMessage();
	  die();
  }
} else {
  http_response_code( 404 );
  echo "404 Not Found";
}
