--docker run -it --link docker420px_db_1:mysql --rm mysql sh -c 'exec mysql -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_POR
--T_3306_TCP_PORT" -uroot -p"$MYSQL_ENV_MYSQL_ROOT_PASSWORD"'

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

USE myapp;

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image` varchar(512) NOT NULL,
  `user_id` int(11) NOT NULL,
  `main_color` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(16, 'thib', 'thib'),
(15, 'plop', 'plop'),
(14, 'yo', 'yo'),
(17, 'rss', 'rss'),
(18, 'lea', 'lea'),
(19, 'wida', 'wida');

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;