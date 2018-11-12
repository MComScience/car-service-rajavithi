/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100129
 Source Host           : localhost:3306
 Source Schema         : car-service-rajavithi

 Target Server Type    : MariaDB
 Target Server Version : 100129
 File Encoding         : 65001

 Date: 12/11/2018 15:05:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `auth_assignment_user_id_idx`(`user_id`) USING BTREE,
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('Admin', '1', 1537449830);

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/*', 2, NULL, NULL, NULL, 1537449817, 1537449817);
INSERT INTO `auth_item` VALUES ('/app/administrative/*', 2, NULL, NULL, NULL, 1537703848, 1537703848);
INSERT INTO `auth_item` VALUES ('/app/car/*', 2, NULL, NULL, NULL, 1537703851, 1537703851);
INSERT INTO `auth_item` VALUES ('/user/settings/*', 2, NULL, NULL, NULL, 1537449864, 1537449864);
INSERT INTO `auth_item` VALUES ('Admin', 1, 'ผู้ดูแลระบบสูงสุด', NULL, NULL, 1537449806, 1537449806);
INSERT INTO `auth_item` VALUES ('App', 2, NULL, NULL, NULL, 1537501456, 1537501456);
INSERT INTO `auth_item` VALUES ('Profile', 2, 'จัดการข้อมูลส่วนตัว', NULL, NULL, 1537449857, 1537449857);
INSERT INTO `auth_item` VALUES ('User', 1, 'ผู้ใช้งานทั่วไป', NULL, NULL, 1537703773, 1537703773);
INSERT INTO `auth_item` VALUES ('ฝ่ายบริหาร', 2, NULL, NULL, NULL, 1537703837, 1537703837);
INSERT INTO `auth_item` VALUES ('แผนกรถยนต์', 2, NULL, NULL, NULL, 1537703879, 1537703879);

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('Admin', '/*');
INSERT INTO `auth_item_child` VALUES ('Admin', 'App');
INSERT INTO `auth_item_child` VALUES ('Admin', 'Profile');
INSERT INTO `auth_item_child` VALUES ('Admin', 'ฝ่ายบริหาร');
INSERT INTO `auth_item_child` VALUES ('Admin', 'แผนกรถยนต์');
INSERT INTO `auth_item_child` VALUES ('User', 'App');
INSERT INTO `auth_item_child` VALUES ('User', 'Profile');
INSERT INTO `auth_item_child` VALUES ('ฝ่ายบริหาร', '/app/administrative/*');
INSERT INTO `auth_item_child` VALUES ('แผนกรถยนต์', '/app/car/*');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for file_storage_item
-- ----------------------------
DROP TABLE IF EXISTS `file_storage_item`;
CREATE TABLE `file_storage_item`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `base_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `path` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `size` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `upload_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of file_storage_item
-- ----------------------------
INSERT INTO `file_storage_item` VALUES (1, 'fileStorage', '/uploads', '1/_sNoCbHa4UWyoO8-SNU4O-cWjuPHXrv_.jpg', 'image/jpeg', 135820, '_sNoCbHa4UWyoO8-SNU4O-cWjuPHXrv_', '127.0.0.1', 1533309163);
INSERT INTO `file_storage_item` VALUES (2, 'fileStorage', '/uploads', '1/cEKpvlVn2FZt4pU5vcvblsDy3NmTglGr.jpg', 'image/jpeg', 135820, 'cEKpvlVn2FZt4pU5vcvblsDy3NmTglGr', '127.0.0.1', 1533309282);
INSERT INTO `file_storage_item` VALUES (3, 'fileStorage', '/uploads', '1/4tO0GKNDnATccbJZXuv-mEVwFcBJm28F.jpg', 'image/jpeg', 135820, '4tO0GKNDnATccbJZXuv-mEVwFcBJm28F', '127.0.0.1', 1533309293);
INSERT INTO `file_storage_item` VALUES (4, 'fileStorage', '/uploads', '1/kbvSEXTPxEpGYXSwOdxzbW9LP0VOidb_.png', 'image/png', 64092, 'kbvSEXTPxEpGYXSwOdxzbW9LP0VOidb_', '127.0.0.1', 1534913374);
INSERT INTO `file_storage_item` VALUES (5, 'fileStorage', '/uploads', '1/XhTxgx7eMKQpIKpqvbA9h7XD9WTt8IbO.png', 'image/png', 64092, 'XhTxgx7eMKQpIKpqvbA9h7XD9WTt8IbO', '127.0.0.1', 1534913678);
INSERT INTO `file_storage_item` VALUES (6, 'fileStorage', '/uploads', '1/JFvKwmC0PqFEmwB1MGHgI4yEOkZxgvJ3.png', 'image/png', 64092, 'JFvKwmC0PqFEmwB1MGHgI4yEOkZxgvJ3', '127.0.0.1', 1534913877);
INSERT INTO `file_storage_item` VALUES (7, 'fileStorage', '/uploads', '1/fcfSM-Cscw2wblEJwrxD25cqpYR8XbNr.png', 'image/png', 64092, 'fcfSM-Cscw2wblEJwrxD25cqpYR8XbNr', '127.0.0.1', 1534914027);

-- ----------------------------
-- Table structure for icons
-- ----------------------------
DROP TABLE IF EXISTS `icons`;
CREATE TABLE `icons`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 676 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of icons
-- ----------------------------
INSERT INTO `icons` VALUES (1, 'glass', 'fa');
INSERT INTO `icons` VALUES (2, 'music', 'fa');
INSERT INTO `icons` VALUES (3, 'search', 'fa');
INSERT INTO `icons` VALUES (4, 'envelope-o', 'fa');
INSERT INTO `icons` VALUES (5, 'heart', 'fa');
INSERT INTO `icons` VALUES (6, 'star', 'fa');
INSERT INTO `icons` VALUES (7, 'star-o', 'fa');
INSERT INTO `icons` VALUES (8, 'user', 'fa');
INSERT INTO `icons` VALUES (9, 'film', 'fa');
INSERT INTO `icons` VALUES (10, 'th-large', 'fa');
INSERT INTO `icons` VALUES (11, 'th', 'fa');
INSERT INTO `icons` VALUES (12, 'th-list', 'fa');
INSERT INTO `icons` VALUES (13, 'check', 'fa');
INSERT INTO `icons` VALUES (14, 'times', 'fa');
INSERT INTO `icons` VALUES (15, 'search-plus', 'fa');
INSERT INTO `icons` VALUES (16, 'search-minus', 'fa');
INSERT INTO `icons` VALUES (17, 'power-off', 'fa');
INSERT INTO `icons` VALUES (18, 'signal', 'fa');
INSERT INTO `icons` VALUES (19, 'cog', 'fa');
INSERT INTO `icons` VALUES (20, 'trash-o', 'fa');
INSERT INTO `icons` VALUES (21, 'home', 'fa');
INSERT INTO `icons` VALUES (22, 'file-o', 'fa');
INSERT INTO `icons` VALUES (23, 'clock-o', 'fa');
INSERT INTO `icons` VALUES (24, 'road', 'fa');
INSERT INTO `icons` VALUES (25, 'download', 'fa');
INSERT INTO `icons` VALUES (26, 'arrow-circle-o-down', 'fa');
INSERT INTO `icons` VALUES (27, 'arrow-circle-o-up', 'fa');
INSERT INTO `icons` VALUES (28, 'inbox', 'fa');
INSERT INTO `icons` VALUES (29, 'play-circle-o', 'fa');
INSERT INTO `icons` VALUES (30, 'repeat', 'fa');
INSERT INTO `icons` VALUES (31, 'refresh', 'fa');
INSERT INTO `icons` VALUES (32, 'list-alt', 'fa');
INSERT INTO `icons` VALUES (33, 'lock', 'fa');
INSERT INTO `icons` VALUES (34, 'flag', 'fa');
INSERT INTO `icons` VALUES (35, 'headphones', 'fa');
INSERT INTO `icons` VALUES (36, 'volume-off', 'fa');
INSERT INTO `icons` VALUES (37, 'volume-down', 'fa');
INSERT INTO `icons` VALUES (38, 'volume-up', 'fa');
INSERT INTO `icons` VALUES (39, 'qrcode', 'fa');
INSERT INTO `icons` VALUES (40, 'barcode', 'fa');
INSERT INTO `icons` VALUES (41, 'tag', 'fa');
INSERT INTO `icons` VALUES (42, 'tags', 'fa');
INSERT INTO `icons` VALUES (43, 'book', 'fa');
INSERT INTO `icons` VALUES (44, 'bookmark', 'fa');
INSERT INTO `icons` VALUES (45, 'print', 'fa');
INSERT INTO `icons` VALUES (46, 'camera', 'fa');
INSERT INTO `icons` VALUES (47, 'font', 'fa');
INSERT INTO `icons` VALUES (48, 'bold', 'fa');
INSERT INTO `icons` VALUES (49, 'italic', 'fa');
INSERT INTO `icons` VALUES (50, 'text-height', 'fa');
INSERT INTO `icons` VALUES (51, 'text-width', 'fa');
INSERT INTO `icons` VALUES (52, 'align-left', 'fa');
INSERT INTO `icons` VALUES (53, 'align-center', 'fa');
INSERT INTO `icons` VALUES (54, 'align-right', 'fa');
INSERT INTO `icons` VALUES (55, 'align-justify', 'fa');
INSERT INTO `icons` VALUES (56, 'list', 'fa');
INSERT INTO `icons` VALUES (57, 'outdent', 'fa');
INSERT INTO `icons` VALUES (58, 'indent', 'fa');
INSERT INTO `icons` VALUES (59, 'video-camera', 'fa');
INSERT INTO `icons` VALUES (60, 'picture-o', 'fa');
INSERT INTO `icons` VALUES (61, 'pencil', 'fa');
INSERT INTO `icons` VALUES (62, 'map-marker', 'fa');
INSERT INTO `icons` VALUES (63, 'adjust', 'fa');
INSERT INTO `icons` VALUES (64, 'tint', 'fa');
INSERT INTO `icons` VALUES (65, 'pencil-square-o', 'fa');
INSERT INTO `icons` VALUES (66, 'share-square-o', 'fa');
INSERT INTO `icons` VALUES (67, 'check-square-o', 'fa');
INSERT INTO `icons` VALUES (68, 'arrows', 'fa');
INSERT INTO `icons` VALUES (69, 'step-backward', 'fa');
INSERT INTO `icons` VALUES (70, 'fast-backward', 'fa');
INSERT INTO `icons` VALUES (71, 'backward', 'fa');
INSERT INTO `icons` VALUES (72, 'play', 'fa');
INSERT INTO `icons` VALUES (73, 'pause', 'fa');
INSERT INTO `icons` VALUES (74, 'stop', 'fa');
INSERT INTO `icons` VALUES (75, 'forward', 'fa');
INSERT INTO `icons` VALUES (76, 'fast-forward', 'fa');
INSERT INTO `icons` VALUES (77, 'step-forward', 'fa');
INSERT INTO `icons` VALUES (78, 'eject', 'fa');
INSERT INTO `icons` VALUES (79, 'chevron-left', 'fa');
INSERT INTO `icons` VALUES (80, 'chevron-right', 'fa');
INSERT INTO `icons` VALUES (81, 'plus-circle', 'fa');
INSERT INTO `icons` VALUES (82, 'minus-circle', 'fa');
INSERT INTO `icons` VALUES (83, 'times-circle', 'fa');
INSERT INTO `icons` VALUES (84, 'check-circle', 'fa');
INSERT INTO `icons` VALUES (85, 'question-circle', 'fa');
INSERT INTO `icons` VALUES (86, 'info-circle', 'fa');
INSERT INTO `icons` VALUES (87, 'crosshairs', 'fa');
INSERT INTO `icons` VALUES (88, 'times-circle-o', 'fa');
INSERT INTO `icons` VALUES (89, 'check-circle-o', 'fa');
INSERT INTO `icons` VALUES (90, 'ban', 'fa');
INSERT INTO `icons` VALUES (91, 'arrow-left', 'fa');
INSERT INTO `icons` VALUES (92, 'arrow-right', 'fa');
INSERT INTO `icons` VALUES (93, 'arrow-up', 'fa');
INSERT INTO `icons` VALUES (94, 'arrow-down', 'fa');
INSERT INTO `icons` VALUES (95, 'share', 'fa');
INSERT INTO `icons` VALUES (96, 'expand', 'fa');
INSERT INTO `icons` VALUES (97, 'compress', 'fa');
INSERT INTO `icons` VALUES (98, 'plus', 'fa');
INSERT INTO `icons` VALUES (99, 'minus', 'fa');
INSERT INTO `icons` VALUES (100, 'asterisk', 'fa');
INSERT INTO `icons` VALUES (101, 'exclamation-circle', 'fa');
INSERT INTO `icons` VALUES (102, 'gift', 'fa');
INSERT INTO `icons` VALUES (103, 'leaf', 'fa');
INSERT INTO `icons` VALUES (104, 'fire', 'fa');
INSERT INTO `icons` VALUES (105, 'eye', 'fa');
INSERT INTO `icons` VALUES (106, 'eye-slash', 'fa');
INSERT INTO `icons` VALUES (107, 'exclamation-triangle', 'fa');
INSERT INTO `icons` VALUES (108, 'plane', 'fa');
INSERT INTO `icons` VALUES (109, 'calendar', 'fa');
INSERT INTO `icons` VALUES (110, 'random', 'fa');
INSERT INTO `icons` VALUES (111, 'comment', 'fa');
INSERT INTO `icons` VALUES (112, 'magnet', 'fa');
INSERT INTO `icons` VALUES (113, 'chevron-up', 'fa');
INSERT INTO `icons` VALUES (114, 'chevron-down', 'fa');
INSERT INTO `icons` VALUES (115, 'retweet', 'fa');
INSERT INTO `icons` VALUES (116, 'shopping-cart', 'fa');
INSERT INTO `icons` VALUES (117, 'folder', 'fa');
INSERT INTO `icons` VALUES (118, 'folder-open', 'fa');
INSERT INTO `icons` VALUES (119, 'arrows-v', 'fa');
INSERT INTO `icons` VALUES (120, 'arrows-h', 'fa');
INSERT INTO `icons` VALUES (121, 'bar-chart', 'fa');
INSERT INTO `icons` VALUES (122, 'twitter-square', 'fa');
INSERT INTO `icons` VALUES (123, 'facebook-square', 'fa');
INSERT INTO `icons` VALUES (124, 'camera-retro', 'fa');
INSERT INTO `icons` VALUES (125, 'key', 'fa');
INSERT INTO `icons` VALUES (126, 'cogs', 'fa');
INSERT INTO `icons` VALUES (127, 'comments', 'fa');
INSERT INTO `icons` VALUES (128, 'thumbs-o-up', 'fa');
INSERT INTO `icons` VALUES (129, 'thumbs-o-down', 'fa');
INSERT INTO `icons` VALUES (130, 'star-half', 'fa');
INSERT INTO `icons` VALUES (131, 'heart-o', 'fa');
INSERT INTO `icons` VALUES (132, 'sign-out', 'fa');
INSERT INTO `icons` VALUES (133, 'linkedin-square', 'fa');
INSERT INTO `icons` VALUES (134, 'thumb-tack', 'fa');
INSERT INTO `icons` VALUES (135, 'external-link', 'fa');
INSERT INTO `icons` VALUES (136, 'sign-in', 'fa');
INSERT INTO `icons` VALUES (137, 'trophy', 'fa');
INSERT INTO `icons` VALUES (138, 'github-square', 'fa');
INSERT INTO `icons` VALUES (139, 'upload', 'fa');
INSERT INTO `icons` VALUES (140, 'lemon-o', 'fa');
INSERT INTO `icons` VALUES (141, 'phone', 'fa');
INSERT INTO `icons` VALUES (142, 'square-o', 'fa');
INSERT INTO `icons` VALUES (143, 'bookmark-o', 'fa');
INSERT INTO `icons` VALUES (144, 'phone-square', 'fa');
INSERT INTO `icons` VALUES (145, 'twitter', 'fa');
INSERT INTO `icons` VALUES (146, 'facebook', 'fa');
INSERT INTO `icons` VALUES (147, 'github', 'fa');
INSERT INTO `icons` VALUES (148, 'unlock', 'fa');
INSERT INTO `icons` VALUES (149, 'credit-card', 'fa');
INSERT INTO `icons` VALUES (150, 'rss', 'fa');
INSERT INTO `icons` VALUES (151, 'hdd-o', 'fa');
INSERT INTO `icons` VALUES (152, 'bullhorn', 'fa');
INSERT INTO `icons` VALUES (153, 'bell', 'fa');
INSERT INTO `icons` VALUES (154, 'certificate', 'fa');
INSERT INTO `icons` VALUES (155, 'hand-o-right', 'fa');
INSERT INTO `icons` VALUES (156, 'hand-o-left', 'fa');
INSERT INTO `icons` VALUES (157, 'hand-o-up', 'fa');
INSERT INTO `icons` VALUES (158, 'hand-o-down', 'fa');
INSERT INTO `icons` VALUES (159, 'arrow-circle-left', 'fa');
INSERT INTO `icons` VALUES (160, 'arrow-circle-right', 'fa');
INSERT INTO `icons` VALUES (161, 'arrow-circle-up', 'fa');
INSERT INTO `icons` VALUES (162, 'arrow-circle-down', 'fa');
INSERT INTO `icons` VALUES (163, 'globe', 'fa');
INSERT INTO `icons` VALUES (164, 'wrench', 'fa');
INSERT INTO `icons` VALUES (165, 'tasks', 'fa');
INSERT INTO `icons` VALUES (166, 'filter', 'fa');
INSERT INTO `icons` VALUES (167, 'briefcase', 'fa');
INSERT INTO `icons` VALUES (168, 'arrows-alt', 'fa');
INSERT INTO `icons` VALUES (169, 'users', 'fa');
INSERT INTO `icons` VALUES (170, 'link', 'fa');
INSERT INTO `icons` VALUES (171, 'cloud', 'fa');
INSERT INTO `icons` VALUES (172, 'flask', 'fa');
INSERT INTO `icons` VALUES (173, 'scissors', 'fa');
INSERT INTO `icons` VALUES (174, 'files-o', 'fa');
INSERT INTO `icons` VALUES (175, 'paperclip', 'fa');
INSERT INTO `icons` VALUES (176, 'floppy-o', 'fa');
INSERT INTO `icons` VALUES (177, 'square', 'fa');
INSERT INTO `icons` VALUES (178, 'bars', 'fa');
INSERT INTO `icons` VALUES (179, 'list-ul', 'fa');
INSERT INTO `icons` VALUES (180, 'list-ol', 'fa');
INSERT INTO `icons` VALUES (181, 'strikethrough', 'fa');
INSERT INTO `icons` VALUES (182, 'underline', 'fa');
INSERT INTO `icons` VALUES (183, 'table', 'fa');
INSERT INTO `icons` VALUES (184, 'magic', 'fa');
INSERT INTO `icons` VALUES (185, 'truck', 'fa');
INSERT INTO `icons` VALUES (186, 'pinterest', 'fa');
INSERT INTO `icons` VALUES (187, 'pinterest-square', 'fa');
INSERT INTO `icons` VALUES (188, 'google-plus-square', 'fa');
INSERT INTO `icons` VALUES (189, 'google-plus', 'fa');
INSERT INTO `icons` VALUES (190, 'money', 'fa');
INSERT INTO `icons` VALUES (191, 'caret-down', 'fa');
INSERT INTO `icons` VALUES (192, 'caret-up', 'fa');
INSERT INTO `icons` VALUES (193, 'caret-left', 'fa');
INSERT INTO `icons` VALUES (194, 'caret-right', 'fa');
INSERT INTO `icons` VALUES (195, 'columns', 'fa');
INSERT INTO `icons` VALUES (196, 'sort', 'fa');
INSERT INTO `icons` VALUES (197, 'sort-desc', 'fa');
INSERT INTO `icons` VALUES (198, 'sort-asc', 'fa');
INSERT INTO `icons` VALUES (199, 'envelope', 'fa');
INSERT INTO `icons` VALUES (200, 'linkedin', 'fa');
INSERT INTO `icons` VALUES (201, 'undo', 'fa');
INSERT INTO `icons` VALUES (202, 'gavel', 'fa');
INSERT INTO `icons` VALUES (203, 'tachometer', 'fa');
INSERT INTO `icons` VALUES (204, 'comment-o', 'fa');
INSERT INTO `icons` VALUES (205, 'comments-o', 'fa');
INSERT INTO `icons` VALUES (206, 'bolt', 'fa');
INSERT INTO `icons` VALUES (207, 'sitemap', 'fa');
INSERT INTO `icons` VALUES (208, 'umbrella', 'fa');
INSERT INTO `icons` VALUES (209, 'clipboard', 'fa');
INSERT INTO `icons` VALUES (210, 'lightbulb-o', 'fa');
INSERT INTO `icons` VALUES (211, 'exchange', 'fa');
INSERT INTO `icons` VALUES (212, 'cloud-download', 'fa');
INSERT INTO `icons` VALUES (213, 'cloud-upload', 'fa');
INSERT INTO `icons` VALUES (214, 'user-md', 'fa');
INSERT INTO `icons` VALUES (215, 'stethoscope', 'fa');
INSERT INTO `icons` VALUES (216, 'suitcase', 'fa');
INSERT INTO `icons` VALUES (217, 'bell-o', 'fa');
INSERT INTO `icons` VALUES (218, 'coffee', 'fa');
INSERT INTO `icons` VALUES (219, 'cutlery', 'fa');
INSERT INTO `icons` VALUES (220, 'file-text-o', 'fa');
INSERT INTO `icons` VALUES (221, 'building-o', 'fa');
INSERT INTO `icons` VALUES (222, 'hospital-o', 'fa');
INSERT INTO `icons` VALUES (223, 'ambulance', 'fa');
INSERT INTO `icons` VALUES (224, 'medkit', 'fa');
INSERT INTO `icons` VALUES (225, 'fighter-jet', 'fa');
INSERT INTO `icons` VALUES (226, 'beer', 'fa');
INSERT INTO `icons` VALUES (227, 'h-square', 'fa');
INSERT INTO `icons` VALUES (228, 'plus-square', 'fa');
INSERT INTO `icons` VALUES (229, 'angle-double-left', 'fa');
INSERT INTO `icons` VALUES (230, 'angle-double-right', 'fa');
INSERT INTO `icons` VALUES (231, 'angle-double-up', 'fa');
INSERT INTO `icons` VALUES (232, 'angle-double-down', 'fa');
INSERT INTO `icons` VALUES (233, 'angle-left', 'fa');
INSERT INTO `icons` VALUES (234, 'angle-right', 'fa');
INSERT INTO `icons` VALUES (235, 'angle-up', 'fa');
INSERT INTO `icons` VALUES (236, 'angle-down', 'fa');
INSERT INTO `icons` VALUES (237, 'desktop', 'fa');
INSERT INTO `icons` VALUES (238, 'laptop', 'fa');
INSERT INTO `icons` VALUES (239, 'tablet', 'fa');
INSERT INTO `icons` VALUES (240, 'mobile', 'fa');
INSERT INTO `icons` VALUES (241, 'circle-o', 'fa');
INSERT INTO `icons` VALUES (242, 'quote-left', 'fa');
INSERT INTO `icons` VALUES (243, 'quote-right', 'fa');
INSERT INTO `icons` VALUES (244, 'spinner', 'fa');
INSERT INTO `icons` VALUES (245, 'circle', 'fa');
INSERT INTO `icons` VALUES (246, 'reply', 'fa');
INSERT INTO `icons` VALUES (247, 'github-alt', 'fa');
INSERT INTO `icons` VALUES (248, 'folder-o', 'fa');
INSERT INTO `icons` VALUES (249, 'folder-open-o', 'fa');
INSERT INTO `icons` VALUES (250, 'smile-o', 'fa');
INSERT INTO `icons` VALUES (251, 'frown-o', 'fa');
INSERT INTO `icons` VALUES (252, 'meh-o', 'fa');
INSERT INTO `icons` VALUES (253, 'gamepad', 'fa');
INSERT INTO `icons` VALUES (254, 'keyboard-o', 'fa');
INSERT INTO `icons` VALUES (255, 'flag-o', 'fa');
INSERT INTO `icons` VALUES (256, 'flag-checkered', 'fa');
INSERT INTO `icons` VALUES (257, 'terminal', 'fa');
INSERT INTO `icons` VALUES (258, 'code', 'fa');
INSERT INTO `icons` VALUES (259, 'reply-all', 'fa');
INSERT INTO `icons` VALUES (260, 'star-half-o', 'fa');
INSERT INTO `icons` VALUES (261, 'location-arrow', 'fa');
INSERT INTO `icons` VALUES (262, 'crop', 'fa');
INSERT INTO `icons` VALUES (263, 'code-fork', 'fa');
INSERT INTO `icons` VALUES (264, 'chain-broken', 'fa');
INSERT INTO `icons` VALUES (265, 'question', 'fa');
INSERT INTO `icons` VALUES (266, 'info', 'fa');
INSERT INTO `icons` VALUES (267, 'exclamation', 'fa');
INSERT INTO `icons` VALUES (268, 'superscript', 'fa');
INSERT INTO `icons` VALUES (269, 'subscript', 'fa');
INSERT INTO `icons` VALUES (270, 'eraser', 'fa');
INSERT INTO `icons` VALUES (271, 'puzzle-piece', 'fa');
INSERT INTO `icons` VALUES (272, 'microphone', 'fa');
INSERT INTO `icons` VALUES (273, 'microphone-slash', 'fa');
INSERT INTO `icons` VALUES (274, 'shield', 'fa');
INSERT INTO `icons` VALUES (275, 'calendar-o', 'fa');
INSERT INTO `icons` VALUES (276, 'fire-extinguisher', 'fa');
INSERT INTO `icons` VALUES (277, 'rocket', 'fa');
INSERT INTO `icons` VALUES (278, 'maxcdn', 'fa');
INSERT INTO `icons` VALUES (279, 'chevron-circle-left', 'fa');
INSERT INTO `icons` VALUES (280, 'chevron-circle-right', 'fa');
INSERT INTO `icons` VALUES (281, 'chevron-circle-up', 'fa');
INSERT INTO `icons` VALUES (282, 'chevron-circle-down', 'fa');
INSERT INTO `icons` VALUES (283, 'html5', 'fa');
INSERT INTO `icons` VALUES (284, 'css3', 'fa');
INSERT INTO `icons` VALUES (285, 'anchor', 'fa');
INSERT INTO `icons` VALUES (286, 'unlock-alt', 'fa');
INSERT INTO `icons` VALUES (287, 'bullseye', 'fa');
INSERT INTO `icons` VALUES (288, 'ellipsis-h', 'fa');
INSERT INTO `icons` VALUES (289, 'ellipsis-v', 'fa');
INSERT INTO `icons` VALUES (290, 'rss-square', 'fa');
INSERT INTO `icons` VALUES (291, 'play-circle', 'fa');
INSERT INTO `icons` VALUES (292, 'ticket', 'fa');
INSERT INTO `icons` VALUES (293, 'minus-square', 'fa');
INSERT INTO `icons` VALUES (294, 'minus-square-o', 'fa');
INSERT INTO `icons` VALUES (295, 'level-up', 'fa');
INSERT INTO `icons` VALUES (296, 'level-down', 'fa');
INSERT INTO `icons` VALUES (297, 'check-square', 'fa');
INSERT INTO `icons` VALUES (298, 'pencil-square', 'fa');
INSERT INTO `icons` VALUES (299, 'external-link-square', 'fa');
INSERT INTO `icons` VALUES (300, 'share-square', 'fa');
INSERT INTO `icons` VALUES (301, 'compass', 'fa');
INSERT INTO `icons` VALUES (302, 'caret-square-o-down', 'fa');
INSERT INTO `icons` VALUES (303, 'caret-square-o-up', 'fa');
INSERT INTO `icons` VALUES (304, 'caret-square-o-right', 'fa');
INSERT INTO `icons` VALUES (305, 'eur', 'fa');
INSERT INTO `icons` VALUES (306, 'gbp', 'fa');
INSERT INTO `icons` VALUES (307, 'usd', 'fa');
INSERT INTO `icons` VALUES (308, 'inr', 'fa');
INSERT INTO `icons` VALUES (309, 'jpy', 'fa');
INSERT INTO `icons` VALUES (310, 'rub', 'fa');
INSERT INTO `icons` VALUES (311, 'krw', 'fa');
INSERT INTO `icons` VALUES (312, 'btc', 'fa');
INSERT INTO `icons` VALUES (313, 'file', 'fa');
INSERT INTO `icons` VALUES (314, 'file-text', 'fa');
INSERT INTO `icons` VALUES (315, 'sort-alpha-asc', 'fa');
INSERT INTO `icons` VALUES (316, 'sort-alpha-desc', 'fa');
INSERT INTO `icons` VALUES (317, 'sort-amount-asc', 'fa');
INSERT INTO `icons` VALUES (318, 'sort-amount-desc', 'fa');
INSERT INTO `icons` VALUES (319, 'sort-numeric-asc', 'fa');
INSERT INTO `icons` VALUES (320, 'sort-numeric-desc', 'fa');
INSERT INTO `icons` VALUES (321, 'thumbs-up', 'fa');
INSERT INTO `icons` VALUES (322, 'thumbs-down', 'fa');
INSERT INTO `icons` VALUES (323, 'youtube-square', 'fa');
INSERT INTO `icons` VALUES (324, 'youtube', 'fa');
INSERT INTO `icons` VALUES (325, 'xing', 'fa');
INSERT INTO `icons` VALUES (326, 'xing-square', 'fa');
INSERT INTO `icons` VALUES (327, 'youtube-play', 'fa');
INSERT INTO `icons` VALUES (328, 'dropbox', 'fa');
INSERT INTO `icons` VALUES (329, 'stack-overflow', 'fa');
INSERT INTO `icons` VALUES (330, 'instagram', 'fa');
INSERT INTO `icons` VALUES (331, 'flickr', 'fa');
INSERT INTO `icons` VALUES (332, 'adn', 'fa');
INSERT INTO `icons` VALUES (333, 'bitbucket', 'fa');
INSERT INTO `icons` VALUES (334, 'bitbucket-square', 'fa');
INSERT INTO `icons` VALUES (335, 'tumblr', 'fa');
INSERT INTO `icons` VALUES (336, 'tumblr-square', 'fa');
INSERT INTO `icons` VALUES (337, 'long-arrow-down', 'fa');
INSERT INTO `icons` VALUES (338, 'long-arrow-up', 'fa');
INSERT INTO `icons` VALUES (339, 'long-arrow-left', 'fa');
INSERT INTO `icons` VALUES (340, 'long-arrow-right', 'fa');
INSERT INTO `icons` VALUES (341, 'apple', 'fa');
INSERT INTO `icons` VALUES (342, 'windows', 'fa');
INSERT INTO `icons` VALUES (343, 'android', 'fa');
INSERT INTO `icons` VALUES (344, 'linux', 'fa');
INSERT INTO `icons` VALUES (345, 'dribbble', 'fa');
INSERT INTO `icons` VALUES (346, 'skype', 'fa');
INSERT INTO `icons` VALUES (347, 'foursquare', 'fa');
INSERT INTO `icons` VALUES (348, 'trello', 'fa');
INSERT INTO `icons` VALUES (349, 'female', 'fa');
INSERT INTO `icons` VALUES (350, 'male', 'fa');
INSERT INTO `icons` VALUES (351, 'gratipay', 'fa');
INSERT INTO `icons` VALUES (352, 'sun-o', 'fa');
INSERT INTO `icons` VALUES (353, 'moon-o', 'fa');
INSERT INTO `icons` VALUES (354, 'archive', 'fa');
INSERT INTO `icons` VALUES (355, 'bug', 'fa');
INSERT INTO `icons` VALUES (356, 'vk', 'fa');
INSERT INTO `icons` VALUES (357, 'weibo', 'fa');
INSERT INTO `icons` VALUES (358, 'renren', 'fa');
INSERT INTO `icons` VALUES (359, 'pagelines', 'fa');
INSERT INTO `icons` VALUES (360, 'stack-exchange', 'fa');
INSERT INTO `icons` VALUES (361, 'arrow-circle-o-right', 'fa');
INSERT INTO `icons` VALUES (362, 'arrow-circle-o-left', 'fa');
INSERT INTO `icons` VALUES (363, 'caret-square-o-left', 'fa');
INSERT INTO `icons` VALUES (364, 'dot-circle-o', 'fa');
INSERT INTO `icons` VALUES (365, 'wheelchair', 'fa');
INSERT INTO `icons` VALUES (366, 'vimeo-square', 'fa');
INSERT INTO `icons` VALUES (367, 'try', 'fa');
INSERT INTO `icons` VALUES (368, 'plus-square-o', 'fa');
INSERT INTO `icons` VALUES (369, 'space-shuttle', 'fa');
INSERT INTO `icons` VALUES (370, 'slack', 'fa');
INSERT INTO `icons` VALUES (371, 'envelope-square', 'fa');
INSERT INTO `icons` VALUES (372, 'wordpress', 'fa');
INSERT INTO `icons` VALUES (373, 'openid', 'fa');
INSERT INTO `icons` VALUES (374, 'university', 'fa');
INSERT INTO `icons` VALUES (375, 'graduation-cap', 'fa');
INSERT INTO `icons` VALUES (376, 'yahoo', 'fa');
INSERT INTO `icons` VALUES (377, 'google', 'fa');
INSERT INTO `icons` VALUES (378, 'reddit', 'fa');
INSERT INTO `icons` VALUES (379, 'reddit-square', 'fa');
INSERT INTO `icons` VALUES (380, 'stumbleupon-circle', 'fa');
INSERT INTO `icons` VALUES (381, 'stumbleupon', 'fa');
INSERT INTO `icons` VALUES (382, 'delicious', 'fa');
INSERT INTO `icons` VALUES (383, 'digg', 'fa');
INSERT INTO `icons` VALUES (384, 'pied-piper-pp', 'fa');
INSERT INTO `icons` VALUES (385, 'pied-piper-alt', 'fa');
INSERT INTO `icons` VALUES (386, 'drupal', 'fa');
INSERT INTO `icons` VALUES (387, 'joomla', 'fa');
INSERT INTO `icons` VALUES (388, 'language', 'fa');
INSERT INTO `icons` VALUES (389, 'fax', 'fa');
INSERT INTO `icons` VALUES (390, 'building', 'fa');
INSERT INTO `icons` VALUES (391, 'child', 'fa');
INSERT INTO `icons` VALUES (392, 'paw', 'fa');
INSERT INTO `icons` VALUES (393, 'spoon', 'fa');
INSERT INTO `icons` VALUES (394, 'cube', 'fa');
INSERT INTO `icons` VALUES (395, 'cubes', 'fa');
INSERT INTO `icons` VALUES (396, 'behance', 'fa');
INSERT INTO `icons` VALUES (397, 'behance-square', 'fa');
INSERT INTO `icons` VALUES (398, 'steam', 'fa');
INSERT INTO `icons` VALUES (399, 'steam-square', 'fa');
INSERT INTO `icons` VALUES (400, 'recycle', 'fa');
INSERT INTO `icons` VALUES (401, 'car', 'fa');
INSERT INTO `icons` VALUES (402, 'taxi', 'fa');
INSERT INTO `icons` VALUES (403, 'tree', 'fa');
INSERT INTO `icons` VALUES (404, 'spotify', 'fa');
INSERT INTO `icons` VALUES (405, 'deviantart', 'fa');
INSERT INTO `icons` VALUES (406, 'soundcloud', 'fa');
INSERT INTO `icons` VALUES (407, 'database', 'fa');
INSERT INTO `icons` VALUES (408, 'file-pdf-o', 'fa');
INSERT INTO `icons` VALUES (409, 'file-word-o', 'fa');
INSERT INTO `icons` VALUES (410, 'file-excel-o', 'fa');
INSERT INTO `icons` VALUES (411, 'file-powerpoint-o', 'fa');
INSERT INTO `icons` VALUES (412, 'file-image-o', 'fa');
INSERT INTO `icons` VALUES (413, 'file-archive-o', 'fa');
INSERT INTO `icons` VALUES (414, 'file-audio-o', 'fa');
INSERT INTO `icons` VALUES (415, 'file-video-o', 'fa');
INSERT INTO `icons` VALUES (416, 'file-code-o', 'fa');
INSERT INTO `icons` VALUES (417, 'vine', 'fa');
INSERT INTO `icons` VALUES (418, 'codepen', 'fa');
INSERT INTO `icons` VALUES (419, 'jsfiddle', 'fa');
INSERT INTO `icons` VALUES (420, 'life-ring', 'fa');
INSERT INTO `icons` VALUES (421, 'circle-o-notch', 'fa');
INSERT INTO `icons` VALUES (422, 'rebel', 'fa');
INSERT INTO `icons` VALUES (423, 'empire', 'fa');
INSERT INTO `icons` VALUES (424, 'git-square', 'fa');
INSERT INTO `icons` VALUES (425, 'git', 'fa');
INSERT INTO `icons` VALUES (426, 'hacker-news', 'fa');
INSERT INTO `icons` VALUES (427, 'tencent-weibo', 'fa');
INSERT INTO `icons` VALUES (428, 'qq', 'fa');
INSERT INTO `icons` VALUES (429, 'weixin', 'fa');
INSERT INTO `icons` VALUES (430, 'paper-plane', 'fa');
INSERT INTO `icons` VALUES (431, 'paper-plane-o', 'fa');
INSERT INTO `icons` VALUES (432, 'history', 'fa');
INSERT INTO `icons` VALUES (433, 'circle-thin', 'fa');
INSERT INTO `icons` VALUES (434, 'header', 'fa');
INSERT INTO `icons` VALUES (435, 'paragraph', 'fa');
INSERT INTO `icons` VALUES (436, 'sliders', 'fa');
INSERT INTO `icons` VALUES (437, 'share-alt', 'fa');
INSERT INTO `icons` VALUES (438, 'share-alt-square', 'fa');
INSERT INTO `icons` VALUES (439, 'bomb', 'fa');
INSERT INTO `icons` VALUES (440, 'futbol-o', 'fa');
INSERT INTO `icons` VALUES (441, 'tty', 'fa');
INSERT INTO `icons` VALUES (442, 'binoculars', 'fa');
INSERT INTO `icons` VALUES (443, 'plug', 'fa');
INSERT INTO `icons` VALUES (444, 'slideshare', 'fa');
INSERT INTO `icons` VALUES (445, 'twitch', 'fa');
INSERT INTO `icons` VALUES (446, 'yelp', 'fa');
INSERT INTO `icons` VALUES (447, 'newspaper-o', 'fa');
INSERT INTO `icons` VALUES (448, 'wifi', 'fa');
INSERT INTO `icons` VALUES (449, 'calculator', 'fa');
INSERT INTO `icons` VALUES (450, 'paypal', 'fa');
INSERT INTO `icons` VALUES (451, 'google-wallet', 'fa');
INSERT INTO `icons` VALUES (452, 'cc-visa', 'fa');
INSERT INTO `icons` VALUES (453, 'cc-mastercard', 'fa');
INSERT INTO `icons` VALUES (454, 'cc-discover', 'fa');
INSERT INTO `icons` VALUES (455, 'cc-amex', 'fa');
INSERT INTO `icons` VALUES (456, 'cc-paypal', 'fa');
INSERT INTO `icons` VALUES (457, 'cc-stripe', 'fa');
INSERT INTO `icons` VALUES (458, 'bell-slash', 'fa');
INSERT INTO `icons` VALUES (459, 'bell-slash-o', 'fa');
INSERT INTO `icons` VALUES (460, 'trash', 'fa');
INSERT INTO `icons` VALUES (461, 'copyright', 'fa');
INSERT INTO `icons` VALUES (462, 'at', 'fa');
INSERT INTO `icons` VALUES (463, 'eyedropper', 'fa');
INSERT INTO `icons` VALUES (464, 'paint-brush', 'fa');
INSERT INTO `icons` VALUES (465, 'birthday-cake', 'fa');
INSERT INTO `icons` VALUES (466, 'area-chart', 'fa');
INSERT INTO `icons` VALUES (467, 'pie-chart', 'fa');
INSERT INTO `icons` VALUES (468, 'line-chart', 'fa');
INSERT INTO `icons` VALUES (469, 'lastfm', 'fa');
INSERT INTO `icons` VALUES (470, 'lastfm-square', 'fa');
INSERT INTO `icons` VALUES (471, 'toggle-off', 'fa');
INSERT INTO `icons` VALUES (472, 'toggle-on', 'fa');
INSERT INTO `icons` VALUES (473, 'bicycle', 'fa');
INSERT INTO `icons` VALUES (474, 'bus', 'fa');
INSERT INTO `icons` VALUES (475, 'ioxhost', 'fa');
INSERT INTO `icons` VALUES (476, 'angellist', 'fa');
INSERT INTO `icons` VALUES (477, 'cc', 'fa');
INSERT INTO `icons` VALUES (478, 'ils', 'fa');
INSERT INTO `icons` VALUES (479, 'meanpath', 'fa');
INSERT INTO `icons` VALUES (480, 'buysellads', 'fa');
INSERT INTO `icons` VALUES (481, 'connectdevelop', 'fa');
INSERT INTO `icons` VALUES (482, 'dashcube', 'fa');
INSERT INTO `icons` VALUES (483, 'forumbee', 'fa');
INSERT INTO `icons` VALUES (484, 'leanpub', 'fa');
INSERT INTO `icons` VALUES (485, 'sellsy', 'fa');
INSERT INTO `icons` VALUES (486, 'shirtsinbulk', 'fa');
INSERT INTO `icons` VALUES (487, 'simplybuilt', 'fa');
INSERT INTO `icons` VALUES (488, 'skyatlas', 'fa');
INSERT INTO `icons` VALUES (489, 'cart-plus', 'fa');
INSERT INTO `icons` VALUES (490, 'cart-arrow-down', 'fa');
INSERT INTO `icons` VALUES (491, 'diamond', 'fa');
INSERT INTO `icons` VALUES (492, 'ship', 'fa');
INSERT INTO `icons` VALUES (493, 'user-secret', 'fa');
INSERT INTO `icons` VALUES (494, 'motorcycle', 'fa');
INSERT INTO `icons` VALUES (495, 'street-view', 'fa');
INSERT INTO `icons` VALUES (496, 'heartbeat', 'fa');
INSERT INTO `icons` VALUES (497, 'venus', 'fa');
INSERT INTO `icons` VALUES (498, 'mars', 'fa');
INSERT INTO `icons` VALUES (499, 'mercury', 'fa');
INSERT INTO `icons` VALUES (500, 'transgender', 'fa');
INSERT INTO `icons` VALUES (501, 'transgender-alt', 'fa');
INSERT INTO `icons` VALUES (502, 'venus-double', 'fa');
INSERT INTO `icons` VALUES (503, 'mars-double', 'fa');
INSERT INTO `icons` VALUES (504, 'venus-mars', 'fa');
INSERT INTO `icons` VALUES (505, 'mars-stroke', 'fa');
INSERT INTO `icons` VALUES (506, 'mars-stroke-v', 'fa');
INSERT INTO `icons` VALUES (507, 'mars-stroke-h', 'fa');
INSERT INTO `icons` VALUES (508, 'neuter', 'fa');
INSERT INTO `icons` VALUES (509, 'genderless', 'fa');
INSERT INTO `icons` VALUES (510, 'facebook-official', 'fa');
INSERT INTO `icons` VALUES (511, 'pinterest-p', 'fa');
INSERT INTO `icons` VALUES (512, 'whatsapp', 'fa');
INSERT INTO `icons` VALUES (513, 'server', 'fa');
INSERT INTO `icons` VALUES (514, 'user-plus', 'fa');
INSERT INTO `icons` VALUES (515, 'user-times', 'fa');
INSERT INTO `icons` VALUES (516, 'bed', 'fa');
INSERT INTO `icons` VALUES (517, 'viacoin', 'fa');
INSERT INTO `icons` VALUES (518, 'train', 'fa');
INSERT INTO `icons` VALUES (519, 'subway', 'fa');
INSERT INTO `icons` VALUES (520, 'medium', 'fa');
INSERT INTO `icons` VALUES (521, 'y-combinator', 'fa');
INSERT INTO `icons` VALUES (522, 'optin-monster', 'fa');
INSERT INTO `icons` VALUES (523, 'opencart', 'fa');
INSERT INTO `icons` VALUES (524, 'expeditedssl', 'fa');
INSERT INTO `icons` VALUES (525, 'battery-full', 'fa');
INSERT INTO `icons` VALUES (526, 'battery-three-quarters', 'fa');
INSERT INTO `icons` VALUES (527, 'battery-half', 'fa');
INSERT INTO `icons` VALUES (528, 'battery-quarter', 'fa');
INSERT INTO `icons` VALUES (529, 'battery-empty', 'fa');
INSERT INTO `icons` VALUES (530, 'mouse-pointer', 'fa');
INSERT INTO `icons` VALUES (531, 'i-cursor', 'fa');
INSERT INTO `icons` VALUES (532, 'object-group', 'fa');
INSERT INTO `icons` VALUES (533, 'object-ungroup', 'fa');
INSERT INTO `icons` VALUES (534, 'sticky-note', 'fa');
INSERT INTO `icons` VALUES (535, 'sticky-note-o', 'fa');
INSERT INTO `icons` VALUES (536, 'cc-jcb', 'fa');
INSERT INTO `icons` VALUES (537, 'cc-diners-club', 'fa');
INSERT INTO `icons` VALUES (538, 'clone', 'fa');
INSERT INTO `icons` VALUES (539, 'balance-scale', 'fa');
INSERT INTO `icons` VALUES (540, 'hourglass-o', 'fa');
INSERT INTO `icons` VALUES (541, 'hourglass-start', 'fa');
INSERT INTO `icons` VALUES (542, 'hourglass-half', 'fa');
INSERT INTO `icons` VALUES (543, 'hourglass-end', 'fa');
INSERT INTO `icons` VALUES (544, 'hourglass', 'fa');
INSERT INTO `icons` VALUES (545, 'hand-rock-o', 'fa');
INSERT INTO `icons` VALUES (546, 'hand-paper-o', 'fa');
INSERT INTO `icons` VALUES (547, 'hand-scissors-o', 'fa');
INSERT INTO `icons` VALUES (548, 'hand-lizard-o', 'fa');
INSERT INTO `icons` VALUES (549, 'hand-spock-o', 'fa');
INSERT INTO `icons` VALUES (550, 'hand-pointer-o', 'fa');
INSERT INTO `icons` VALUES (551, 'hand-peace-o', 'fa');
INSERT INTO `icons` VALUES (552, 'trademark', 'fa');
INSERT INTO `icons` VALUES (553, 'registered', 'fa');
INSERT INTO `icons` VALUES (554, 'creative-commons', 'fa');
INSERT INTO `icons` VALUES (555, 'gg', 'fa');
INSERT INTO `icons` VALUES (556, 'gg-circle', 'fa');
INSERT INTO `icons` VALUES (557, 'tripadvisor', 'fa');
INSERT INTO `icons` VALUES (558, 'odnoklassniki', 'fa');
INSERT INTO `icons` VALUES (559, 'odnoklassniki-square', 'fa');
INSERT INTO `icons` VALUES (560, 'get-pocket', 'fa');
INSERT INTO `icons` VALUES (561, 'wikipedia-w', 'fa');
INSERT INTO `icons` VALUES (562, 'safari', 'fa');
INSERT INTO `icons` VALUES (563, 'chrome', 'fa');
INSERT INTO `icons` VALUES (564, 'firefox', 'fa');
INSERT INTO `icons` VALUES (565, 'opera', 'fa');
INSERT INTO `icons` VALUES (566, 'internet-explorer', 'fa');
INSERT INTO `icons` VALUES (567, 'television', 'fa');
INSERT INTO `icons` VALUES (568, 'contao', 'fa');
INSERT INTO `icons` VALUES (569, '500px', 'fa');
INSERT INTO `icons` VALUES (570, 'amazon', 'fa');
INSERT INTO `icons` VALUES (571, 'calendar-plus-o', 'fa');
INSERT INTO `icons` VALUES (572, 'calendar-minus-o', 'fa');
INSERT INTO `icons` VALUES (573, 'calendar-times-o', 'fa');
INSERT INTO `icons` VALUES (574, 'calendar-check-o', 'fa');
INSERT INTO `icons` VALUES (575, 'industry', 'fa');
INSERT INTO `icons` VALUES (576, 'map-pin', 'fa');
INSERT INTO `icons` VALUES (577, 'map-signs', 'fa');
INSERT INTO `icons` VALUES (578, 'map-o', 'fa');
INSERT INTO `icons` VALUES (579, 'map', 'fa');
INSERT INTO `icons` VALUES (580, 'commenting', 'fa');
INSERT INTO `icons` VALUES (581, 'commenting-o', 'fa');
INSERT INTO `icons` VALUES (582, 'houzz', 'fa');
INSERT INTO `icons` VALUES (583, 'vimeo', 'fa');
INSERT INTO `icons` VALUES (584, 'black-tie', 'fa');
INSERT INTO `icons` VALUES (585, 'fonticons', 'fa');
INSERT INTO `icons` VALUES (586, 'reddit-alien', 'fa');
INSERT INTO `icons` VALUES (587, 'edge', 'fa');
INSERT INTO `icons` VALUES (588, 'credit-card-alt', 'fa');
INSERT INTO `icons` VALUES (589, 'codiepie', 'fa');
INSERT INTO `icons` VALUES (590, 'modx', 'fa');
INSERT INTO `icons` VALUES (591, 'fort-awesome', 'fa');
INSERT INTO `icons` VALUES (592, 'usb', 'fa');
INSERT INTO `icons` VALUES (593, 'product-hunt', 'fa');
INSERT INTO `icons` VALUES (594, 'mixcloud', 'fa');
INSERT INTO `icons` VALUES (595, 'scribd', 'fa');
INSERT INTO `icons` VALUES (596, 'pause-circle', 'fa');
INSERT INTO `icons` VALUES (597, 'pause-circle-o', 'fa');
INSERT INTO `icons` VALUES (598, 'stop-circle', 'fa');
INSERT INTO `icons` VALUES (599, 'stop-circle-o', 'fa');
INSERT INTO `icons` VALUES (600, 'shopping-bag', 'fa');
INSERT INTO `icons` VALUES (601, 'shopping-basket', 'fa');
INSERT INTO `icons` VALUES (602, 'hashtag', 'fa');
INSERT INTO `icons` VALUES (603, 'bluetooth', 'fa');
INSERT INTO `icons` VALUES (604, 'bluetooth-b', 'fa');
INSERT INTO `icons` VALUES (605, 'percent', 'fa');
INSERT INTO `icons` VALUES (606, 'gitlab', 'fa');
INSERT INTO `icons` VALUES (607, 'wpbeginner', 'fa');
INSERT INTO `icons` VALUES (608, 'wpforms', 'fa');
INSERT INTO `icons` VALUES (609, 'envira', 'fa');
INSERT INTO `icons` VALUES (610, 'universal-access', 'fa');
INSERT INTO `icons` VALUES (611, 'wheelchair-alt', 'fa');
INSERT INTO `icons` VALUES (612, 'question-circle-o', 'fa');
INSERT INTO `icons` VALUES (613, 'blind', 'fa');
INSERT INTO `icons` VALUES (614, 'audio-description', 'fa');
INSERT INTO `icons` VALUES (615, 'volume-control-phone', 'fa');
INSERT INTO `icons` VALUES (616, 'braille', 'fa');
INSERT INTO `icons` VALUES (617, 'assistive-listening-systems', 'fa');
INSERT INTO `icons` VALUES (618, 'american-sign-language-interpreting', 'fa');
INSERT INTO `icons` VALUES (619, 'deaf', 'fa');
INSERT INTO `icons` VALUES (620, 'glide', 'fa');
INSERT INTO `icons` VALUES (621, 'glide-g', 'fa');
INSERT INTO `icons` VALUES (622, 'sign-language', 'fa');
INSERT INTO `icons` VALUES (623, 'low-vision', 'fa');
INSERT INTO `icons` VALUES (624, 'viadeo', 'fa');
INSERT INTO `icons` VALUES (625, 'viadeo-square', 'fa');
INSERT INTO `icons` VALUES (626, 'snapchat', 'fa');
INSERT INTO `icons` VALUES (627, 'snapchat-ghost', 'fa');
INSERT INTO `icons` VALUES (628, 'snapchat-square', 'fa');
INSERT INTO `icons` VALUES (629, 'pied-piper', 'fa');
INSERT INTO `icons` VALUES (630, 'first-order', 'fa');
INSERT INTO `icons` VALUES (631, 'yoast', 'fa');
INSERT INTO `icons` VALUES (632, 'themeisle', 'fa');
INSERT INTO `icons` VALUES (633, 'google-plus-official', 'fa');
INSERT INTO `icons` VALUES (634, 'font-awesome', 'fa');
INSERT INTO `icons` VALUES (635, 'handshake-o', 'fa');
INSERT INTO `icons` VALUES (636, 'envelope-open', 'fa');
INSERT INTO `icons` VALUES (637, 'envelope-open-o', 'fa');
INSERT INTO `icons` VALUES (638, 'linode', 'fa');
INSERT INTO `icons` VALUES (639, 'address-book', 'fa');
INSERT INTO `icons` VALUES (640, 'address-book-o', 'fa');
INSERT INTO `icons` VALUES (641, 'address-card', 'fa');
INSERT INTO `icons` VALUES (642, 'address-card-o', 'fa');
INSERT INTO `icons` VALUES (643, 'user-circle', 'fa');
INSERT INTO `icons` VALUES (644, 'user-circle-o', 'fa');
INSERT INTO `icons` VALUES (645, 'user-o', 'fa');
INSERT INTO `icons` VALUES (646, 'id-badge', 'fa');
INSERT INTO `icons` VALUES (647, 'id-card', 'fa');
INSERT INTO `icons` VALUES (648, 'id-card-o', 'fa');
INSERT INTO `icons` VALUES (649, 'quora', 'fa');
INSERT INTO `icons` VALUES (650, 'free-code-camp', 'fa');
INSERT INTO `icons` VALUES (651, 'telegram', 'fa');
INSERT INTO `icons` VALUES (652, 'thermometer-full', 'fa');
INSERT INTO `icons` VALUES (653, 'thermometer-three-quarters', 'fa');
INSERT INTO `icons` VALUES (654, 'thermometer-half', 'fa');
INSERT INTO `icons` VALUES (655, 'thermometer-quarter', 'fa');
INSERT INTO `icons` VALUES (656, 'thermometer-empty', 'fa');
INSERT INTO `icons` VALUES (657, 'shower', 'fa');
INSERT INTO `icons` VALUES (658, 'bath', 'fa');
INSERT INTO `icons` VALUES (659, 'podcast', 'fa');
INSERT INTO `icons` VALUES (660, 'window-maximize', 'fa');
INSERT INTO `icons` VALUES (661, 'window-minimize', 'fa');
INSERT INTO `icons` VALUES (662, 'window-restore', 'fa');
INSERT INTO `icons` VALUES (663, 'window-close', 'fa');
INSERT INTO `icons` VALUES (664, 'window-close-o', 'fa');
INSERT INTO `icons` VALUES (665, 'bandcamp', 'fa');
INSERT INTO `icons` VALUES (666, 'grav', 'fa');
INSERT INTO `icons` VALUES (667, 'etsy', 'fa');
INSERT INTO `icons` VALUES (668, 'imdb', 'fa');
INSERT INTO `icons` VALUES (669, 'ravelry', 'fa');
INSERT INTO `icons` VALUES (670, 'eercast', 'fa');
INSERT INTO `icons` VALUES (671, 'microchip', 'fa');
INSERT INTO `icons` VALUES (672, 'snowflake-o', 'fa');
INSERT INTO `icons` VALUES (673, 'superpowers', 'fa');
INSERT INTO `icons` VALUES (674, 'wpexplorer', 'fa');
INSERT INTO `icons` VALUES (675, 'meetup', 'fa');

-- ----------------------------
-- Table structure for key_storage_item
-- ----------------------------
DROP TABLE IF EXISTS `key_storage_item`;
CREATE TABLE `key_storage_item`  (
  `key` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  UNIQUE INDEX `idx_key_storage_item_key`(`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of key_storage_item
-- ----------------------------
INSERT INTO `key_storage_item` VALUES ('app-name', 'ระบบคิวโรงพยาบาลอุดรธานี', '', 1533350945, 1518009214);
INSERT INTO `key_storage_item` VALUES ('copy-right', 'โรงพยาบาลอุดรธานี', '', 1533350952, 1527783992);
INSERT INTO `key_storage_item` VALUES ('dynamic-limit', '20', '', 1519362612, 1519362612);
INSERT INTO `key_storage_item` VALUES ('frontend.body.class', 'fixed-sidebar fixed-navbar', '', 1518010225, NULL);
INSERT INTO `key_storage_item` VALUES ('frontend.navbar', 'navbar-fixed-top', 'fix navbar header', 1515767197, NULL);
INSERT INTO `key_storage_item` VALUES ('frontend.page-breadcrumbs', '0', 'breadcrumbs-fixed', 1515767838, NULL);
INSERT INTO `key_storage_item` VALUES ('frontend.page-header', '0', 'page-header-fixed', 1515767908, NULL);
INSERT INTO `key_storage_item` VALUES ('frontend.page-sidebar', 'sidebar-fixed menu-compact', 'sidebar-fixed , menu-compact', 1516690802, NULL);
INSERT INTO `key_storage_item` VALUES ('hospital-email', 'app@banbunghospital.com', '', 1527784016, 1527784016);
INSERT INTO `key_storage_item` VALUES ('hospital-name', 'โรงพยาบาลอุดรธานี', '', 1533351896, 1533351896);
INSERT INTO `key_storage_item` VALUES ('line-notify', 'false', 'แจ้งเตือนไลน์ (true,false)', 1542009228, 1542009051);
INSERT INTO `key_storage_item` VALUES ('line-token', 'BhmpnpvMGWReH8nmyFnHtubB0CpjmFLwPeszBfs8TQe', '', 1542009077, 1542009077);
INSERT INTO `key_storage_item` VALUES ('logo-url', '/imgs/udh-logo.png', '', 1533350304, 1533350304);
INSERT INTO `key_storage_item` VALUES ('text-marquee-kiosk', '<i class=\"fa fa-hospital-o\"></i> โรงพยาบาลบ้านบึงยินดีให้บริการ', 'ข้อความวิ่งหน้าจอ Kiosk', 1531472785, 1531471602);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_category_id` int(11) NOT NULL,
  `parent_id` int(11) NULL DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `router` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `icon` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` enum('2','1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '0',
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `target` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `protocol` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `home` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '0',
  `sort` int(3) NULL DEFAULT NULL,
  `language` varchar(7) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '*',
  `params` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `assoc` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `parent` int(11) NULL DEFAULT NULL,
  `route` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `order` int(11) NULL DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `auth_items` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_menu_category_id_5207_00`(`menu_category_id`) USING BTREE,
  INDEX `idx_parent_id_5207_01`(`parent_id`) USING BTREE,
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`menu_category_id`) REFERENCES `menu_category` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 1, NULL, 'หน้าหลัก', '/site/index', '', 'home', '1', NULL, '', '', '1', 1, '*', NULL, NULL, 1537703988, 1, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (2, 1, NULL, 'Gii', '/gii', '', 'newspaper-o', '1', NULL, '', '', '1', 4, '*', NULL, NULL, 1534903801, 1, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (3, 1, NULL, 'ข้อมูลส่วนตัว', '/user/settings/profile', '', 'user', '1', NULL, '', '', '1', 6, '*', NULL, NULL, 1534944136, 1, NULL, NULL, '', NULL, NULL, '[\"แก้ไขข้อมูลส่วนตัว\"]');
INSERT INTO `menu` VALUES (4, 1, NULL, 'ตั้งค่า', '#', '', 'cogs', '1', NULL, '', '', '1', 7, '*', NULL, NULL, 1524041211, 2, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (5, 1, 4, 'ผู้ใช้งาน', '/user/admin/index', '', 'users', '1', NULL, '', '', '1', 9, '*', '', NULL, 1523348294, 2, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (6, 1, 4, 'สิทธิ์การใช้งาน', '/rbac/assignment', '', 'unlock-alt', '1', NULL, '', '', '1', 10, '*', NULL, NULL, 1533348930, 1, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (7, 1, 4, 'AppConfig', '/key-storage/index', '', 'circle-thin', '1', NULL, '', '', '1', 11, '*', NULL, NULL, 1537504594, 1, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (10, 1, 4, 'เมนู', '/menu/default/menu-order', '', 'list', '1', NULL, '', '', '1', 12, '*', '', NULL, 1523349768, 2, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (17, 1, NULL, 'รายงาน', '/app/report/index', '', 'file-text-o', '1', NULL, '', '', '1', 5, '*', NULL, NULL, 1537672904, 1, NULL, NULL, '', NULL, NULL, '[\"App\"]');
INSERT INTO `menu` VALUES (20, 1, NULL, 'ฝ่ายบริหาร', '/app/administrative/index', '', 'user-o', '1', NULL, '', '', '1', 2, '*', NULL, NULL, 1537703935, 1, NULL, NULL, '', NULL, NULL, '[\"ฝ่ายบริหาร\"]');
INSERT INTO `menu` VALUES (21, 1, NULL, 'แผนกรถยนต์', '/app/car/index', '', 'car', '1', NULL, '', '', '1', 3, '*', NULL, NULL, 1537703940, 1, NULL, NULL, '', NULL, NULL, '[\"แผนกรถยนต์\"]');
INSERT INTO `menu` VALUES (22, 1, 4, 'ช่องจอด', '/app/settings/slot', '', 'circle-thin', '1', NULL, '', '', '1', 8, '*', '', NULL, 1537666367, 1, NULL, NULL, '', NULL, NULL, '[\"App\"]');

-- ----------------------------
-- Table structure for menu_auth
-- ----------------------------
DROP TABLE IF EXISTS `menu_auth`;
CREATE TABLE `menu_auth`  (
  `menu_id` int(11) NOT NULL,
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`menu_id`) USING BTREE,
  INDEX `item_name`(`item_name`) USING BTREE,
  CONSTRAINT `menu_auth_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for menu_category
-- ----------------------------
DROP TABLE IF EXISTS `menu_category`;
CREATE TABLE `menu_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `discription` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_id_5487_02`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of menu_category
-- ----------------------------
INSERT INTO `menu_category` VALUES (1, 'app-frontend', 'เมนู frontend', '1');
INSERT INTO `menu_category` VALUES (2, 'app-backend', 'backend', '1');

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1537448574);
INSERT INTO `migration` VALUES ('m140209_132017_init', 1537448581);
INSERT INTO `migration` VALUES ('m140403_174025_create_account_table', 1537448582);
INSERT INTO `migration` VALUES ('m140504_113157_update_tables', 1537448587);
INSERT INTO `migration` VALUES ('m140504_130429_create_token_table', 1537448588);
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', 1537449296);
INSERT INTO `migration` VALUES ('m140830_171933_fix_ip_field', 1537448589);
INSERT INTO `migration` VALUES ('m140830_172703_change_account_table_name', 1537448589);
INSERT INTO `migration` VALUES ('m141222_110026_update_ip_field', 1537448591);
INSERT INTO `migration` VALUES ('m141222_135246_alter_username_length', 1537448592);
INSERT INTO `migration` VALUES ('m150614_103145_update_social_account_table', 1537448598);
INSERT INTO `migration` VALUES ('m150623_212711_fix_username_notnull', 1537448598);
INSERT INTO `migration` VALUES ('m151218_234654_add_timezone_to_profile', 1537448598);
INSERT INTO `migration` VALUES ('m160929_103127_add_last_login_at_to_user_table', 1537448599);
INSERT INTO `migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1537449297);

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile`  (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `public_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gravatar_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gravatar_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `bio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `timezone` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `avatar_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `avatar_base_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `profile_type_id` int(11) NULL DEFAULT NULL COMMENT 'ประเภทผู้ใช้งาน',
  PRIMARY KEY (`user_id`) USING BTREE,
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES (1, 'Admin', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Asia/Bangkok', NULL, NULL, 1);
INSERT INTO `profile` VALUES (2, 'นายอรุณ นามเมือง', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', NULL, NULL, NULL, 3);
INSERT INTO `profile` VALUES (3, 'นายพิชิต สมบูรณ์ทรัพย์', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', NULL, NULL, NULL, 3);
INSERT INTO `profile` VALUES (4, 'นายวิโรจน์ เฟื่องฟู', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', NULL, NULL, NULL, 3);
INSERT INTO `profile` VALUES (5, 'นายจรูญศักดิ์ ประภาศรี', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', NULL, NULL, NULL, 3);
INSERT INTO `profile` VALUES (6, '', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', NULL, NULL, NULL, 2);

-- ----------------------------
-- Table structure for social_account
-- ----------------------------
DROP TABLE IF EXISTS `social_account`;
CREATE TABLE `social_account`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account_unique`(`provider`, `client_id`) USING BTREE,
  UNIQUE INDEX `account_unique_code`(`code`) USING BTREE,
  INDEX `fk_user_account`(`user_id`) USING BTREE,
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tb_autocomplete
-- ----------------------------
DROP TABLE IF EXISTS `tb_autocomplete`;
CREATE TABLE `tb_autocomplete`  (
  `autocomplete_id` int(11) NOT NULL AUTO_INCREMENT,
  `destination_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ปลายทาง',
  PRIMARY KEY (`autocomplete_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_autocomplete
-- ----------------------------
INSERT INTO `tb_autocomplete` VALUES (1, 'สวนดุสิต');
INSERT INTO `tb_autocomplete` VALUES (2, 'มหาวิทยาลัยจุฬาลงกรณ์');
INSERT INTO `tb_autocomplete` VALUES (3, 'มหาวิทยาลัยจุฬาลงกรณ์ test');
INSERT INTO `tb_autocomplete` VALUES (4, 'ฟิวเจอร์รังสิต');
INSERT INTO `tb_autocomplete` VALUES (5, 'โรงพยาบาลทหาร');
INSERT INTO `tb_autocomplete` VALUES (6, 'ฟิวเจอร์รังสิต ถนนวิภาวดี');
INSERT INTO `tb_autocomplete` VALUES (7, 'โรงพยาบาลธรรมศาสตร์');
INSERT INTO `tb_autocomplete` VALUES (8, 'มหาวิทยาลัยสวนดุสิต');
INSERT INTO `tb_autocomplete` VALUES (9, 'โรงพยาบาลธรรมศาสตร์ ศูนย์รังสิต');

-- ----------------------------
-- Table structure for tb_destination
-- ----------------------------
DROP TABLE IF EXISTS `tb_destination`;
CREATE TABLE `tb_destination`  (
  `destination_id` int(11) NOT NULL AUTO_INCREMENT,
  `destination` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ปลายทาง',
  `user_id` int(11) NOT NULL COMMENT 'พนักงานขับรถ',
  `destination_date` date NOT NULL COMMENT 'วันที่เดินทาง',
  `destination_time` time(0) NOT NULL COMMENT 'เวลารถออก',
  `parking_slot_id` int(11) NOT NULL COMMENT 'ช่องจอดรถ',
  `status_id` int(11) NULL DEFAULT NULL COMMENT 'สถานะ',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  `confirm_at` datetime(0) NULL DEFAULT NULL COMMENT 'เวลายืนยัน',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'หมายเหตุ',
  PRIMARY KEY (`destination_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_destination
-- ----------------------------
INSERT INTO `tb_destination` VALUES (1, 'สวนดุสิต', 2, '2018-09-24', '11:20:00', 1, 4, 1, '2018-09-24 11:16:43', NULL, '2018-09-24 11:18:27', '2018-09-24 00:00:00', '');
INSERT INTO `tb_destination` VALUES (2, 'มหาวิทยาลัยจุฬาลงกรณ์', 4, '2018-09-24', '11:40:00', 1, 4, 1, '2018-09-24 11:22:42', NULL, '2018-09-24 12:06:46', '2018-09-24 00:00:00', '');
INSERT INTO `tb_destination` VALUES (3, 'มหาวิทยาลัยจุฬาลงกรณ์ test', 3, '2018-09-24', '11:40:00', 3, 4, 1, '2018-09-24 11:34:48', NULL, '2018-09-24 11:36:15', '2018-09-24 00:00:00', '');
INSERT INTO `tb_destination` VALUES (5, 'โรงพยาบาลทหาร', 4, '2018-09-24', '12:30:00', 1, 4, 1, '2018-09-24 12:10:52', NULL, '2018-09-24 12:11:24', '2018-09-24 00:00:00', '');
INSERT INTO `tb_destination` VALUES (6, 'โรงพยาบาลธรรมศาสตร์', 3, '2018-09-24', '15:00:00', 2, 2, 1, '2018-09-24 14:54:02', 1, '2018-09-24 14:54:02', NULL, '');
INSERT INTO `tb_destination` VALUES (7, 'โรงพยาบาลธรรมศาสตร์', 2, '2018-09-24', '15:40:00', 3, 2, 1, '2018-09-24 15:25:51', NULL, '2018-09-24 15:26:25', '2018-09-24 00:00:00', '');
INSERT INTO `tb_destination` VALUES (8, 'มหาวิทยาลัยสวนดุสิต', 4, '2018-09-25', '13:20:00', 2, 2, 1, '2018-09-25 12:17:25', 1, '2018-09-25 14:17:10', '2018-09-25 00:00:00', 'หมายเหตุ 123');
INSERT INTO `tb_destination` VALUES (9, 'โรงพยาบาลทหาร', 4, '2018-09-26', '12:40:00', 1, 2, 1, '2018-09-26 12:24:26', 1, '2018-09-26 12:24:26', NULL, '');
INSERT INTO `tb_destination` VALUES (10, 'โรงพยาบาลธรรมศาสตร์', 3, '2018-09-26', '12:50:00', 2, 2, 1, '2018-09-26 12:24:47', 1, '2018-09-26 12:24:47', NULL, '');
INSERT INTO `tb_destination` VALUES (11, 'มหาวิทยาลัยจุฬาลงกรณ์ test', 2, '2018-10-03', '10:10:00', 1, 2, 1, '2018-10-03 10:06:56', 1, '2018-10-03 10:06:56', NULL, 'ทดสอบ');
INSERT INTO `tb_destination` VALUES (12, 'โรงพยาบาลธรรมศาสตร์ ศูนย์รังสิต', 4, '2018-10-03', '10:30:00', 2, 3, 1, '2018-10-03 10:06:56', 1, '2018-10-03 11:49:55', '2018-10-03 00:00:00', 'ทดสอบ');
INSERT INTO `tb_destination` VALUES (13, 'โรงพยาบาลทหาร', 2, '2018-11-12', '11:10:00', 1, 3, 1, '2018-11-12 11:00:28', 1, '2018-11-12 14:36:18', '2018-11-12 00:00:00', '');
INSERT INTO `tb_destination` VALUES (14, 'โรงพยาบาลทหาร', 4, '2018-11-12', '14:50:00', 3, 2, 1, '2018-11-12 14:42:57', 1, '2018-11-12 14:46:47', NULL, '');
INSERT INTO `tb_destination` VALUES (15, 'มหาวิทยาลัยจุฬาลงกรณ์', 3, '2018-11-12', '15:00:00', 2, 3, 1, '2018-11-12 14:46:22', 1, '2018-11-12 14:47:17', '2018-11-12 00:00:00', '');
INSERT INTO `tb_destination` VALUES (16, 'โรงพยาบาลธรรมศาสตร์', 5, '2018-11-12', '15:40:00', 1, 2, 1, '2018-11-12 14:53:35', 1, '2018-11-12 14:53:35', NULL, '');
INSERT INTO `tb_destination` VALUES (17, 'มหาวิทยาลัยจุฬาลงกรณ์ test', 4, '2018-11-12', '16:50:00', 3, 2, 1, '2018-11-12 14:54:03', 1, '2018-11-12 14:54:03', NULL, '');

-- ----------------------------
-- Table structure for tb_parking_slot
-- ----------------------------
DROP TABLE IF EXISTS `tb_parking_slot`;
CREATE TABLE `tb_parking_slot`  (
  `parking_slot_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสช่องจอด',
  `parking_slot_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ช่องจอด',
  PRIMARY KEY (`parking_slot_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_parking_slot
-- ----------------------------
INSERT INTO `tb_parking_slot` VALUES (1, '1');
INSERT INTO `tb_parking_slot` VALUES (2, '2');
INSERT INTO `tb_parking_slot` VALUES (3, '3');
INSERT INTO `tb_parking_slot` VALUES (4, 'สำรอง');

-- ----------------------------
-- Table structure for tb_profile_type
-- ----------------------------
DROP TABLE IF EXISTS `tb_profile_type`;
CREATE TABLE `tb_profile_type`  (
  `profile_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทผู้ใช้งาน',
  `profile_type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อประเภทผู้ใช้งาน',
  PRIMARY KEY (`profile_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_profile_type
-- ----------------------------
INSERT INTO `tb_profile_type` VALUES (1, 'เจ้าหน้าที่ดูแลระบบ');
INSERT INTO `tb_profile_type` VALUES (2, 'เจ้าหน้าที่ฝ่ายบริหาร');
INSERT INTO `tb_profile_type` VALUES (3, 'พนักงานขับรถ');

-- ----------------------------
-- Table structure for tb_status
-- ----------------------------
DROP TABLE IF EXISTS `tb_status`;
CREATE TABLE `tb_status`  (
  `status_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสถานะ',
  `status_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อสถานะ',
  PRIMARY KEY (`status_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_status
-- ----------------------------
INSERT INTO `tb_status` VALUES (1, 'ร่าง');
INSERT INTO `tb_status` VALUES (2, 'รอยืนยัน');
INSERT INTO `tb_status` VALUES (3, 'ยืนยันแล้ว');
INSERT INTO `tb_status` VALUES (4, 'ออกแล้ว');
INSERT INTO `tb_status` VALUES (5, 'ยกเลิก');

-- ----------------------------
-- Table structure for token
-- ----------------------------
DROP TABLE IF EXISTS `token`;
CREATE TABLE `token`  (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE INDEX `token_unique`(`user_id`, `code`, `type`) USING BTREE,
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) NULL DEFAULT NULL,
  `unconfirmed_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `blocked_at` int(11) NULL DEFAULT NULL,
  `registration_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `last_login_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_unique_username`(`username`) USING BTREE,
  UNIQUE INDEX `user_unique_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'q-car@gmail.com', '$2y$10$XAZvjriPCeMqBF9ywmoSZ.Wts8x9Q8ank41nogJ3naKVskEosIUPO', 'xMOl5Zkmri6IYRmiDS1tzEnR0HiLYlog', 1537448761, NULL, NULL, NULL, 1537448761, 1537448761, 0, 1541994934);
INSERT INTO `user` VALUES (2, 'user1', 'user1@gmail.com', '$2y$10$VXLEF1GES6kDULqDuGCkVuV9a1ePDtPLArwVXmEYVTNAonkvj/wPS', 'pN1ciKauwIiDxKg3whwMdXk-Dw1XK5Ru', 1537542139, NULL, NULL, '127.0.0.1', 1537542139, 1537542139, 0, NULL);
INSERT INTO `user` VALUES (3, 'user2', 'user2@gmail.com', '$2y$10$CfyknuDNeqADtn2T0cErYO9c7FUVtyJN2rK/XXF8YE/LIzeoYhnxO', 'vLzoA2oQXq1dliunw7SuQ7QU7TneZSwp', 1537542182, NULL, NULL, '127.0.0.1', 1537542182, 1537542182, 0, NULL);
INSERT INTO `user` VALUES (4, 'user3', 'user3@gmail.com', '$2y$10$Dj4D1HqQ1MLSadvJhQ3/9u.BS9fxTzMDMyUoc7odXxEJ1MTOZbFV6', 'v4nTwqbLYb3YdooyWf0mHKiM51R322et', 1537542227, NULL, NULL, '127.0.0.1', 1537542227, 1537542227, 0, NULL);
INSERT INTO `user` VALUES (5, 'user4', 'user4@gmail.com', '$2y$10$FRFwYtefHL.m9aMz3W8mRuO4hRD2Qm.M8EYrgFu1Sud2f5nDz86zC', 'OFWM9QMbMJrCToD0D0YOSsguaLLDnUpF', 1537542265, NULL, NULL, '127.0.0.1', 1537542265, 1537542265, 0, NULL);
INSERT INTO `user` VALUES (6, 'u123', '123@gmail.com', '$2y$10$.49BLTyx0ZkYHW1XDtbtD.ZIFJ0CrwtzZ4hXVdhMUYWGdmFJxb9Ti', 'LR7askGsrUXxhBTsscKdf47s1Z_WSrsP', 1542006003, NULL, NULL, '127.0.0.1', 1542006003, 1542006003, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
