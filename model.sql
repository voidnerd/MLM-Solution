
CREATE TABLE `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) not null,
    `email` varchar (255) not null UNIQUE,
	`username` varchar(255),
    `phone` varchar(255),
	`referrer` varchar(255) default null,
	`parent_id` INT(10),
    `sponsor_id` varchar(255),
	`direct_downlines` int(10) DEFAULT 0,
    `level` int(10) DEFAULT 0,
    `two` int(10) default 0,
     `three` int(10) default 0,
      `four` int(10) default 0,
       `five` int(10) default 0,
        `six` int(10) default 0,
    `password` varchar (255) not null,
    `avartar` varchar(250),
    `role` varchar(150) default 'user',
    `activated` varchar(150) default 'no',
    `activated_at` datetime,
    `activated_by` int(11),
	`email_verified_at` datetime DEFAULT NULL,
    `remember_token` VARCHAR(150),
    `address` text,
    `country` varchar(255),
    `state` varchar (255),
    `code` varchar(1255),
    `deleted` datetime DEFAULT NULL,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users_tree` (
    `ancestor` int(10) unsigned NOT NULL,
    `descendant` int(10) unsigned NOT NULL,
    `depth` int(11) NOT NULL,
    PRIMARY KEY (`ancestor`,`descendant`),
    KEY `descendant` (`descendant`),
    CONSTRAINT `tree_hierarchy_ibfk_1` FOREIGN KEY (`ancestor`) REFERENCES `users` (`id`),
    CONSTRAINT `tree_hierarchy_ibfk_2` FOREIGN KEY (`descendant`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `password_resets` (
  `email` varchar(255)  NOT NULL,
  `token` varchar(255)  NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_accounts` (
	 `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `bank_name` VARCHAR(150),
     `account_name` VARCHAR(150),
     `account_no` VARCHAR(80),
     `user_id` int(10),
     `default`  tinyint,
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `app_accounts` (
	 `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `bank_name` VARCHAR(150),
     `account_name` VARCHAR(150),
     `account_no` VARCHAR(80),
	`user_id` int(10),
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wallets` (
	 `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	 `user_id` int(1) not null,
	 `amount` int(11) not null,
	 `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transactions` (
	 `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	 `user_id` int(1) not null,
	 `amount` int(11) not null,
     `type` varchar(250),
	 `status` varchar(150),
     `paid_by` int(11),
	 `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
