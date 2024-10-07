<?php
try {
    $db=new PDO("mysql:host=localhost;dbname=back_cards","root","");
} catch ( PDOException $ex) {
    $ex->getMessage();
}



?>