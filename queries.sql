CREATE TABLE `t_priority` (
  `pri_id` int(11) NOT NULL,
  `pri_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `t_priority`(`pri_id`, `pri_name`) VALUES (1,'Urgent');
INSERT INTO `t_priority`(`pri_id`, `pri_name`) VALUES (2,'Nice to have');

ALTER TABLE t_idea
ADD ide_priority_fk INTEGER;
