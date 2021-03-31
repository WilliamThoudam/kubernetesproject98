CREATE TABLE `wp_bulk_invite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_user_id` int NOT NULL,
  `recipient_email_id` varchar(100) NOT NULL,
  `group_id` int NOT NULL,
  `invite_link` varchar(1000) NOT NULL,
  `account_verify_link` varchar(1000) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_sign_up` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `wp_open_ssl_key` (
  `id` int NOT NULL AUTO_INCREMENT,
  `options` int DEFAULT NULL,
  `ciphermethod` varchar(100) DEFAULT NULL,
  `enc_iv` varchar(100) DEFAULT NULL,
  `enc_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;