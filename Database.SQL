SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- Create tables 

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `qtyLeft` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `personal_code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`)
  
  ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;

INSERT INTO `users` (`id`, `name`, `surname`, `personal_code`, `email`, `role`, `password`, `created_at`) VALUES
(24, 'Janis', 'Berzins', '080187-12345', 'admin@b.lv', 'admin', '$2y$10$UiKGf8ofeQnVij6qq.hYouyg4do5Y0emsdlSSUS/g99OT6LwZ7r96', '2019-03-24 19:23:34')


ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`)



--Insert values

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`) VALUES
(1, 'door capitals', 'door capitals to be installed with doors', 35.00, 8),
(2, 'window capitals', 'window capitals to be installed with windows', 15.00, 7),
(3, 'handrails', 'handrails for home or office', 100.00, 3),
(4, 'door handles', 'door handles to be installed with doors', 60.00, 0),
(5, 'window handles', 'window handles to be installed with windows', 30.00, 5),
(6, 'chandeliers', 'different size chandeliers', 350.00, 0),
(7, 'medals', 'medium size medals', 12.00, 0);


INSERT INTO `items` (`id`, `name`, `description`, `price`, `qtyLeft`) VALUES
(1, 'door capitals', 'door capitals to be installed with doors', 35.00, 8),
(2, 'window capitals', 'window capitals to be installed with windows', 15.00, 7),
(3, 'handrails', 'handrails for home or office', 100.00, 3),
(4, 'door handles', 'door handles to be installed with doors', 60.00, 0),
(5, 'window handles', 'window handles to be installed with windows', 30.00, 5),
(6, 'chandeliers', 'different size chandeliers', 350.00, 0),
(7, 'medals', 'medium size medals', 12.00, 0);






