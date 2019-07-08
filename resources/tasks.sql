CREATE TABLE `tasks` (
                       `id` int(11) NOT NULL AUTO_INCREMENT,
                       `task` varchar(300) NOT NULL,
                       `createdAt` int(10) NOT NULL,
                       `isCompleted` tinyint(4) NOT NULL,
                       PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
