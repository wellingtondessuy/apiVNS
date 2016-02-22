DROP TABLE IF EXISTS `transactions`;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` BIGINT(12) NOT NULL ,
  `status` ENUM('PAGO','A PAGAR') NOT NULL DEFAULT 'A PAGAR' ,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `paid_off_at` DATETIME NULL DEFAULT NULL,
  `expiration_date` DATE NULL DEFAULT NULL,
  `inserted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
CHECKSUM = 1;