CREATE DATABASE onlibar CHARSET=utf8 COLLATE utf8_general_ci;

-- Criação dos Logins

CREATE TABLE `onlibarc_onlibar`.`logins` (
  `userId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(150) NOT NULL , 
  `senha` VARCHAR(32) NOT NULL ,
  `userName` VARCHAR(200) NOT NULL ,
  `userPicture` VARCHAR(100) NOT NULL , 
  `userBio` VARCHAR(500) NULL , 
  `userAccess` ENUM('usuario','verified','del', 'banido') NOT NULL DEFAULT 'usuario' ,
  `caddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `altdate` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`userId`) , 
  UNIQUE (`email`), 
  INDEX (`senha`) ) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- Criação dos Seguidores

CREATE TABLE `onlibar`.`follows` ( 
  `followId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `followedId` BIGINT UNSIGNED NOT NULL , 
  `followerId` BIGINT UNSIGNED NOT NULL , 
  `followDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`followId`), 
  INDEX (`followerId`)) 
ENGINE = InnoDB;

-- --------------------------------------------------------

-- Criação das Notificações

CREATE TABLE `onlibarc_onlibar`.`notifications` ( 
  `notificationId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `notificationUserId` BIGINT UNSIGNED NOT NULL , 
  `notificationLink` VARCHAR(500) NOT NULL , 
  `notificationTxt` VARCHAR(500) NOT NULL , 
  `notificationDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`notificationId`), 
  INDEX (`notificationUserId`)) 
ENGINE = InnoDB;

-- --------------------------------------------------------

-- Criação dos Stories

CREATE TABLE `onlibarc_onlibar`.`stories` ( 
  `storyId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `storyUserId` BIGINT UNSIGNED NOT NULL , 
  `storyImg` VARCHAR(100) NULL , 
  `storyVideo` VARCHAR(100) NULL , 
  `storyStatus` ENUM('on','del') NOT NULL DEFAULT 'on' , 
  `storyDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`storyId`), 
  INDEX (`storyUserId`), 
  INDEX (`storyStatus`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- Criação dos Comentários de Stories

CREATE TABLE `onlibarc_onlibar`.`storyComments` ( 
  `commentId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `commentStoryId` BIGINT UNSIGNED NOT NULL , 
  `commentUserId` BIGINT UNSIGNED NOT NULL , 
  `commentTxt` VARCHAR(500) NULL , 
  `commentStatus` ENUM('on','del') NOT NULL DEFAULT 'on' , 
  `commentDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`commentId`), 
  INDEX (`commentStoryId`), 
  INDEX (`commentStatus`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- Criação dos Likes de Stories

CREATE TABLE `onlibarc_onlibar`.`storyLikes` ( 
  `likeId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `likeStoryId` BIGINT UNSIGNED NOT NULL , 
  `likeUserId` BIGINT UNSIGNED NOT NULL , 
  `likeDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`likeId`), 
  INDEX (`likeStoryId`)) 
ENGINE = InnoDB;

-- --------------------------------------------------------

-- Criação dos Reports de Stories

CREATE TABLE `onlibarc_onlibar`.`storyReports` ( 
  `reportId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `reportStoryId` BIGINT UNSIGNED NOT NULL , 
  `reportUserId` BIGINT UNSIGNED NOT NULL , 
  `reportStatus` ENUM('pending','del','ok') NOT NULL DEFAULT 'pending' , 
  `reportDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`reportId`)) 
ENGINE = InnoDB;

-- --------------------------------------------------------

-- Criação dos Posts

CREATE TABLE `onlibarc_onlibar`.`posts` (
  `postId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `postUserId` BIGINT UNSIGNED NOT NULL , 
  `postTxt` VARCHAR(500) NULL ,
  `postImg` VARCHAR(100) NULL ,
  `postVideo` VARCHAR(100) NULL ,
  `postStatus` ENUM('on','del') NOT NULL DEFAULT 'on' ,
  `postDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`postId`),  
  INDEX (`postStatus`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------


-- Criação das Tags

CREATE TABLE `onlibarc_onlibar`.`postTags` ( 
  `tagId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT , 
  `tagPostId` BIGINT UNSIGNED NOT NULL ,
  `tagTxt` VARCHAR(500) NOT NULL ,
  `tagDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`tagId`), 
  INDEX (`tagPostId`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- Criação dos Likes

CREATE TABLE `onlibarc_onlibar`.`postLikes` ( 
  `likeId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `likePostId` BIGINT UNSIGNED NOT NULL ,
  `likeUserId` BIGINT UNSIGNED NOT NULL ,
  `likeDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
   PRIMARY KEY (`likeId`)) 
ENGINE = InnoDB;

-- --------------------------------------------------------

-- Criação dos Comentários

CREATE TABLE `onlibarc_onlibar`.`postComments` ( 
  `commentId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `commentPostId` BIGINT UNSIGNED NOT NULL ,
  `commentUserId` BIGINT UNSIGNED NOT NULL ,
  `commentTxt` VARCHAR(500) NOT NULL ,
  `commentStatus` ENUM('on','del') NOT NULL DEFAULT 'on' ,
  `commentDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`commentId`), 
  INDEX (`commentPostId`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- Criação das Denúncias de Posts

CREATE TABLE `onlibarc_onlibar`.`postReports` (
  `reportId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `reportPostId` BIGINT UNSIGNED NOT NULL ,
  `reportUserId` BIGINT UNSIGNED NOT NULL ,
  `reportStatus` ENUM('pending','del','ok') NOT NULL DEFAULT 'pending' ,
  `reportDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`reportId`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- Criação das Denúncias de Usuários

CREATE TABLE `onlibarc_onlibar`.`userReports` ( 
  `reportId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `reportedUserId` BIGINT UNSIGNED NOT NULL ,
  `reportingUserId` BIGINT UNSIGNED NOT NULL ,
  `reportStatus` ENUM('pending','ban','ok') NOT NULL DEFAULT 'pending' ,
  `reportDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
  PRIMARY KEY (`reportId`)) 
ENGINE = InnoDB 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

-- View Denúncias de Usuários

CREATE VIEW `onlibarc_onlibar`.`pendingUserReports` 
AS
SELECT 
COUNT(reportId) AS totReports, reportedUserId 
FROM `onlibar`.`userReports` 
WHERE reportStatus='pending' 
GROUP BY reportedUserId;

-- --------------------------------------------------------

-- View Post Pronto

CREATE VIEW `onlibarc_onlibar`.`donePost`
AS 
SELECT 
u.userName AS postUserName, u.userPicture AS postUserPicture, u.userId AS postUserId, u.userAccess AS postUserAccess, 
p.postId, p.postTxt, p.postImg, p.postVideo, DATE_FORMAT(p.postDate, '%H:%i <br> %d/%m/%Y') AS postDate 
FROM `onlibar`.`posts` AS p 
INNER JOIN `onlibar`.`logins` AS u
ON 
p.postUserId = u.userId
WHERE p.postStatus='on' 
ORDER BY p.postId DESC;

-- --------------------------------------------------------

-- View tags mais usadas no momento

CREATE VIEW `onlibarc_onlibar`.`rankRecTags`
AS
SELECT 
COUNT(tagId) AS Total, tagTxt 
FROM `onlibar`.`postTags`
WHERE (tagTxt IS NOT NULL) 
AND (tagTxt != '')
AND (tagTxt != ' ')
AND (tagTxt != '
') AND 
`tagDate` >= (DATE(NOW()) - INTERVAL 6 WEEK)
GROUP BY tagTxt
ORDER BY Total DESC;

-- --------------------------------------------------------

-- Usuário não encontrado

INSERT INTO logins 
(userId, email, senha, userName, userPicture, userBio, 
userAccess, caddate, altdate) 
VALUES (0, 'Não Encontrado', '76d8ce8247ed0b1755b7ed1fc416f11f',
'Usuário Não Encontrado', '../media/usersPictures/defaultIcon.png', 
NULL, 'usuario', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- --------------------------------------------------------

-- Evitar Erro Nas Tags

INSERT INTO postTags 
(tagId, tagPostId, tagTxt, tagDate) 
VALUES 
(1, 0, '.', CURRENT_TIMESTAMP),
(2, 0, '..', CURRENT_TIMESTAMP),
(3, 0, '...', CURRENT_TIMESTAMP);