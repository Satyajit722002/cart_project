<?php
include "db.php";

$conn->query("CREATE TABLE IF NOT EXISTS cart(id INT AUTO_INCREMENT PRIMARY KEY,
                                             user_id INT NOT NULL,
                                             product_id INT NOT NULL,
                                             product_name VARCHAR(50),
                                             product_price INT NOT NULL,
                                             quantity INT NOT NULL)");


$conn->query("ALTER TABLE cart ADD session_id varchar(225) NULL AFTER USER_ID");
?>