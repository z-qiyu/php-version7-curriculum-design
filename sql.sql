BEGIN;
--
-- Create model File
--
CREATE TABLE `file` (`id` bigint AUTO_INCREMENT NOT NULL PRIMARY KEY, `name` varchar(128) NOT NULL, `create_time` datetime(6) NOT NULL, `urlpath` varchar(256) NOT NULL);
--
-- Create model FileTable
--
CREATE TABLE `file_table` (`id` bigint AUTO_INCREMENT NOT NULL PRIMARY KEY, `name` varchar(32) NOT NULL, `create_time` datetime(6) NOT NULL, `max_length` smallint NOT NULL);
--
-- Create model Friend
--
CREATE TABLE `friend` (`id` bigint AUTO_INCREMENT NOT NULL PRIMARY KEY, `user1_is_ok` bool NOT NULL, `user2_is_ok` bool NOT NULL, `is_friend` bool NOT NULL);
--
-- Create model Share
--
CREATE TABLE `share` (`id` bigint AUTO_INCREMENT NOT NULL PRIMARY KEY, `filetable_id` bigint NOT NULL);
--
-- Create model User
--
CREATE TABLE `user` (`id` bigint AUTO_INCREMENT NOT NULL PRIMARY KEY, `name` varchar(32) NOT NULL, `password` varchar(128) NOT NULL, `create_time` datetime(6) NOT NULL, `is_superuser` bool NOT NULL);
--
-- Add field to_user to share
--
ALTER TABLE `share` ADD COLUMN `to_user_id` bigint NOT NULL;
--
-- Add field user1 to friend
--
ALTER TABLE `friend` ADD COLUMN `user1_id` bigint NOT NULL;
--
-- Add field user2 to friend
--
ALTER TABLE `friend` ADD COLUMN `user2_id` bigint NOT NULL;
--
-- Add field user to filetable
--
ALTER TABLE `file_table` ADD COLUMN `user_id` bigint NOT NULL;
--
-- Add field filetable to file
--
ALTER TABLE `file` ADD COLUMN `filetable_id` bigint NOT NULL;
ALTER TABLE `share` ADD CONSTRAINT `share_filetable_id_58a688ab_fk_file_table_id` FOREIGN KEY (`filetable_id`) REFERENCES `file_table` (`id`);
CREATE INDEX `share_filetable_id_58a688ab` ON `share` (`filetable_id`);
CREATE INDEX `share_to_user_id_a3238ad6` ON `share` (`to_user_id`);
ALTER TABLE `share` ADD CONSTRAINT `share_to_user_id_a3238ad6_fk_user_id` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`);
CREATE INDEX `friend_user1_id_02a36fa8` ON `friend` (`user1_id`);
ALTER TABLE `friend` ADD CONSTRAINT `friend_user1_id_02a36fa8_fk_user_id` FOREIGN KEY (`user1_id`) REFERENCES `user` (`id`);
CREATE INDEX `friend_user2_id_76dcff2d` ON `friend` (`user2_id`);
ALTER TABLE `friend` ADD CONSTRAINT `friend_user2_id_76dcff2d_fk_user_id` FOREIGN KEY (`user2_id`) REFERENCES `user` (`id`);
CREATE INDEX `file_table_user_id_65dcbcd7` ON `file_table` (`user_id`);
ALTER TABLE `file_table` ADD CONSTRAINT `file_table_user_id_65dcbcd7_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
CREATE INDEX `file_filetable_id_70b44df2` ON `file` (`filetable_id`);
ALTER TABLE `file` ADD CONSTRAINT `file_filetable_id_70b44df2_fk_file_table_id` FOREIGN KEY (`filetable_id`) REFERENCES `file_table` (`id`);
COMMIT;
