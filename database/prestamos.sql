/*
Navicat MySQL Data Transfer

Source Server         : Localhost Laragon
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : prestamos

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-10-09 17:33:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dispositivos
-- ----------------------------
DROP TABLE IF EXISTS `dispositivos`;
CREATE TABLE `dispositivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo_dispositivo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dispositivos_tipo_dispositivo1_idx` (`tipo_dispositivo_id`),
  CONSTRAINT `fk_dispositivos_tipo_dispositivo1` FOREIGN KEY (`tipo_dispositivo_id`) REFERENCES `tipo_dispositivo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dispositivos
-- ----------------------------
INSERT INTO `dispositivos` VALUES ('2', '3', 'Protoboard', '1', '2017-10-08 18:24:39', '2017-10-08 18:24:39', null);
INSERT INTO `dispositivos` VALUES ('3', '20', 'Resistencia 330', '4', '2017-10-08 18:24:39', '2017-10-08 18:24:39', null);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2016_09_04_000000_create_roles_table', '1');
INSERT INTO `migrations` VALUES ('4', '2016_09_04_100000_create_role_user_table', '1');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for prestamos
-- ----------------------------
DROP TABLE IF EXISTS `prestamos`;
CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  `dispositivos_id` int(11) NOT NULL,
  `tipo_prestamo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prestamos_users1_idx` (`users_id`),
  KEY `fk_prestamos_dispositivos1_idx` (`dispositivos_id`),
  KEY `fk_prestamos_tipo_prestamo1_idx` (`tipo_prestamo_id`),
  CONSTRAINT `fk_prestamos_dispositivos1` FOREIGN KEY (`dispositivos_id`) REFERENCES `dispositivos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_prestamos_tipo_prestamo1` FOREIGN KEY (`tipo_prestamo_id`) REFERENCES `tipo_prestamo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_prestamos_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prestamos
-- ----------------------------
INSERT INTO `prestamos` VALUES ('1', '2', '2', '3', '2', '2017-10-08 18:41:32', '2017-10-08 18:41:32', null);
INSERT INTO `prestamos` VALUES ('2', '1', '2', '2', '4', '2017-10-08 18:45:32', '2017-10-08 18:45:32', null);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Admin', 'admin', 'Custodians of the system.', 'default', '2017-10-08 23:38:55', '2017-10-08 23:38:55', null);
INSERT INTO `roles` VALUES ('2', 'Estudiante', 'estudiante', 'Quienes pueden hacer los prestamos.', 'default', '2017-10-08 23:38:55', '2017-10-08 23:38:55', null);
INSERT INTO `roles` VALUES ('3', 'Super Admin', 'super-admin', 'Root', 'default', '2017-10-08 23:38:55', '2017-10-08 23:38:55', null);

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('4', '3', '1', '2017-10-09 21:01:16', '2017-10-09 21:01:16', null);
INSERT INTO `role_user` VALUES ('14', '2', '2', '2017-10-09 21:51:55', '2017-10-09 21:51:55', null);
INSERT INTO `role_user` VALUES ('15', '1', '3', '2017-10-09 22:15:25', '2017-10-09 22:15:25', null);

-- ----------------------------
-- Table structure for tipo_dispositivo
-- ----------------------------
DROP TABLE IF EXISTS `tipo_dispositivo`;
CREATE TABLE `tipo_dispositivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipo_dispositivo
-- ----------------------------
INSERT INTO `tipo_dispositivo` VALUES ('1', 'Placa', null, '2017-10-08 18:08:01', '2017-10-08 18:08:04', null);
INSERT INTO `tipo_dispositivo` VALUES ('2', 'Chip', null, '2017-10-08 18:08:01', '2017-10-08 18:08:01', null);
INSERT INTO `tipo_dispositivo` VALUES ('3', 'Sensor', null, '2017-10-08 18:08:01', '2017-10-08 18:08:01', null);
INSERT INTO `tipo_dispositivo` VALUES ('4', 'Resistencia', null, '2017-10-08 18:08:01', '2017-10-08 18:08:01', null);
INSERT INTO `tipo_dispositivo` VALUES ('5', 'Cables', null, '2017-10-08 18:08:01', '2017-10-08 18:08:01', null);
INSERT INTO `tipo_dispositivo` VALUES ('6', 'Shield', null, '2017-10-08 18:08:01', '2017-10-08 18:08:01', null);
INSERT INTO `tipo_dispositivo` VALUES ('7', 'Protoboard', null, '2017-10-08 18:08:01', '2017-10-08 18:08:01', null);

-- ----------------------------
-- Table structure for tipo_prestamo
-- ----------------------------
DROP TABLE IF EXISTS `tipo_prestamo`;
CREATE TABLE `tipo_prestamo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipo_prestamo
-- ----------------------------
INSERT INTO `tipo_prestamo` VALUES ('1', 'Tesis', null, '2017-10-08 18:24:39', '2017-10-08 18:24:39', null);
INSERT INTO `tipo_prestamo` VALUES ('2', 'Practica', null, '2017-10-08 18:24:39', '2017-10-08 18:24:39', null);
INSERT INTO `tipo_prestamo` VALUES ('3', 'Proyecto Investigacion', null, '2017-10-08 18:24:39', '2017-10-08 18:24:39', null);
INSERT INTO `tipo_prestamo` VALUES ('4', 'ABP', null, '2017-10-08 18:24:39', '2017-10-08 18:24:39', null);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Usuario Admin', 'admin@admin.com', 'a03ab19b866fc585b5cb1812a2f63ca861e7e7643ee5d43fd7106b623725fd67', '6YdKUPKl5M3BZMsqCBbcTqA3qMPCunHzrlVPuw33uScoNzAVKVdVUbrBvARh', '2017-10-08 23:38:55', '2017-10-09 17:17:51', null);
INSERT INTO `users` VALUES ('2', 'Usuario Estudiante', 'est@est.com', 'a03ab19b866fc585b5cb1812a2f63ca861e7e7643ee5d43fd7106b623725fd67', null, '2017-10-08 23:38:55', '2017-10-09 21:08:57', null);
INSERT INTO `users` VALUES ('3', 'Alejandro Martinez', 'ing.amartinez94@gmail.com', '602bdc204140db016bee5374895e5568ce422fabe17e064061d80097', null, '2017-10-09 22:15:25', '2017-10-09 22:15:25', null);
SET FOREIGN_KEY_CHECKS=1;
