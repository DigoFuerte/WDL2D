--  TODO             ... 
--  todo             ... 

--
--?             Database:  Ptolemy Exchange ... PEX
--
CREATE DATABASE IF NOT EXISTS pex_db;
USE pex_db;
-- --------------------------------------------------------

--?             REQUIRED TABLES:
--* web api
--* users            ... personal details for all website users
--* user_permissions ... user access permissions for website ... use bit masking
--* access_control   ... website facility access control - based on user permissions
--* contact          ... for messages submitted via the Contact webpage
--* blog             ... blog for posts submitted by users with [Member]-permission
-- 
-- 
-- 

--
--?             Table: users 
--
USE pex_db;
-- DROP TABLE IF EXISTS users;
-- ALTER TABLE users DROP PRIMARY KEY, ADD PRIMARY KEY(user_id, firstname, lastname);
-- ALTER TABLE users CHANGE COLUMN user_permission user_permissions INT(16) NOT NULL DEFAULT 0x1
-- UPDATE users SET password = '40bd001563085fc35165329ea1ff5c5ecbdbbeef' WHERE user_id = 1;
-- user with two permissions, Guest, Admin
-- UPDATE users SET user_permissions = 9 WHERE user_id = 1;
-- user with three permissions, Guest, Member, Admin
-- UPDATE users SET user_permissions = 11 WHERE user_id = 1;
-- user with two permissions, Guest, Member
-- UPDATE users SET user_permissions = 3 WHERE user_id = 2;
CREATE TABLE IF NOT EXISTS users (
-- MANDATORY ... DB ENFORCED
user_id          INT(10)         NOT NULL AUTO_INCREMENT,
-- DEFAULT PERMISSION IS Guest
user_permissions INT(16)         NOT NULL DEFAULT 0x1,
firstname        VARCHAR(50)     NOT NULL,
lastname         VARCHAR(50)     NOT NULL,
email            VARCHAR(100)    NOT NULL,
password         VARCHAR(200)    NOT NULL,
-- REQUIRED DATA FOR MEMBER PERMISSION
-- OPTIONAL DATA
street           VARCHAR(50)     NULL,
-- MANDATORY DATA ... UI ENFORCED
profile_done    BOOLEAN         DEFAULT FALSE,
city             VARCHAR(50)     NULL,
country          VARCHAR(50)     NULL,
-- OPTIONAL DATA
post_code        VARCHAR(50)     NULL,
phone            VARCHAR(20)     NULL,
profile_picture  VARCHAR(50)     DEFAULT 'default_profile_image.png',
interests        VARCHAR(1024)   DEFAULT 'Not Available', 
PRIMARY KEY (user_id, firstname, lastname)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
--?             Table: users_permissions 
--
USE pex_db;
-- DROP TABLE IF EXISTS user_permissions;
-- ALTER TABLE user_permissions ADD COLUMN perm_name VARCHAR(15) AFTER perm_id;
-- ALTER TABLE user_permissions CHANGE COLUMN perm_key perm_name VARCHAR(50) NOT NULL AFTER perm_id;
-- ALTER table user_permissions DROP PRIMARY KEY, ADD PRIMARY KEY(perm_id, perm_name);
DROP TABLE IF EXISTS user_permissions;
CREATE TABLE IF NOT EXISTS user_permissions (
perm_id         INT(10)         NOT NULL AUTO_INCREMENT,
perm_name       VARCHAR(50)     NOT NULL,
perm_bit_mask   INT(16)         NOT NULL,
PRIMARY KEY (perm_id, perm_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--? USER PERMISSIONS DATA
--* "Guest"   => 0x1, 
--* "Member" => 0x2,
--* "Blog"   => 0x4,
--* "Admin"  => 0x8
--* U_PERM_GUEST   = 0x1; // 1
--* U_PERM_MEMBER = 0x2; // 2
--* U_PERM_BLOG   = 0x4; // 4
--* U_PERM_ADMIN  = 0x8; // 8

--* INSERT INTO user_permissions (perm_key, perm_bit_mask)
--* VALUES 
--* ('User', 0x1),
--* ('Member', 0x2),
--* ('Blog', 0x4),
--* ('Admin', 0x8)
--* ;

--
--?             Table: contact 
--
USE pex_db;
DROP TABLE IF EXISTS contacts;
CREATE TABLE IF NOT EXISTS contacts (
contact_id      INT(10)         NOT NULL AUTO_INCREMENT,
name            VARCHAR(250)    NOT NULL,
email           VARCHAR(250)    NOT NULL,
reason          VARCHAR(250)    NOT NULL,
message         TEXT            NOT NULL,
date_posted     TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (contact_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--? User selected media
--
--?             Table: user_media
--
USE pex_db;
--DROP TABLE IF EXISTS user_media;
-- ALTER TABLE user_media ADD COLUMN thumb_url VARCHAR(128) NULL AFTER url;
CREATE TABLE IF NOT EXISTS user_media (
media_id        INT(10)      NOT NULL AUTO_INCREMENT,
copyright       VARCHAR(50)  NULL,
apod_date       VARCHAR(20)  NULL,
explanation     VARCHAR(512) NULL,
hdurl           VARCHaR(128) NULL,
media_type      VARCHAR(10)  NULL,
service_version VARCHAR(10)  NULL,
title           VARCHAR(50)  NULL,
url             VARCHAR(128) NOT NULL,
thumb_url       VARCHAR(128) NULL,
PRIMARY KEY (media_id),
UNIQUE KEY idx_url (url), 
KEY idx_title (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--? Link table for users and user_media tables
--
--?             Table: user_media_link
--?                    only accessed via stored procedure
--
USE pex_db;
DROP TABLE IF EXISTS user_media_link;
CREATE TABLE IF NOT EXISTS user_media_link (
link_id         INT(10) NOT  NULL AUTO_INCREMENT,
user_id         INT(10) NOT  NULL,
media_id        INT(10) NOT  NULL,
PRIMARY KEY (link_id),
UNIQUE KEY idx_user_id (user_id, media_id), 
-- foreign keys ensure the referential integrity of the link table
-- if a record in a parent table (i.e users, user_media) is removed, 
--  remove all associated records in the child table (i.e user_media_link)
FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE, 
FOREIGN KEY (media_id) REFERENCES user_media (media_id) ON DELETE CASCADE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--? Stored procedure to add user media to the database
--
--?             Procedure: sp_add_user_media
--
USE pex_db;
DELIMITER $$
CREATE OR REPLACE PROCEDURE sp_save_user_media (
  IN p_user_id         INT(10),      
  IN p_copyright       VARCHAR(50),  
  IN p_apod_date       VARCHAR(20),  
  IN p_explanation     VARCHAR(512), 
  IN p_hdurl           VARCHAR(128), 
  IN p_media_type      VARCHAR(10),  
  IN p_service_version VARCHAR(10),  
  IN p_title           VARCHAR(50),  
  IN p_url             VARCHAR(128) 
  -- IN p_flag            BOOLEAN,      
  -- OUT p_result         BOOLEAN       
)
BEGIN
  DECLARE p_media_id           INT(10) DEFAULT -88;
  DECLARE p_user_media_link_id INT(10) DEFAULT -88;

  START TRANSACTION;

    IF ( NOT EXISTS (SELECT * FROM user_media WHERE url = p_url) ) THEN      
      INSERT INTO user_media (copyright, apod_date, explanation, hdurl, media_type, service_version, title, url)
        VALUES (p_copyright, p_apod_date, p_explanation, p_hdurl, p_media_type, p_service_version, p_title, p_url);
    END IF;

    SET p_media_id = ( SELECT media_id FROM user_media WHERE url = p_url );

    INSERT INTO user_media_link (user_id, media_id)
      VALUES (p_user_id, p_media_id);
    
    -- SET p_user_media_link_id = ( SELECT LAST_INSERT_ID() );

  COMMIT;
  
  -- SET p_result = (p_user_media_link_id != -88);

END$$

DELIMITER ;

--? Stored procedure to get media saved by a user in the database
--
--?             Procedure: sp_get_user_media
--
USE pex_db;
DELIMITER $$

CREATE OR REPLACE PROCEDURE sp_get_user_media (
  IN p_user_id         INT(10)
)
BEGIN

  SELECT M.media_id,
         M.copyright,
         M.apod_date,
         M.explanation,
         M.hdurl,
         M.media_type,
         M.service_version,
         M.title,
         M.url

  FROM user_media M
    INNER JOIN user_media_link L ON M.media_id = L.media_id
    INNER JOIN users U           ON U.user_id  = L.user_id
  WHERE U.user_id = p_user_id 
  ORDER BY M.media_id ; 

END$$

DELIMITER ;
