CREATE TABLE `lesson` (
  `lessonid` int(11) NOT NULL DEFAULT '0',
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `conceptid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contentHTML` longtext COLLATE utf8mb4_unicode_ci,
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateUpdated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lessonid`,`moduleid`,`conceptid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

