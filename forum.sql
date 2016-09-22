CREATE TABLE users (
userId     INT(8) NOT NULL AUTO_INCREMENT,
userName   VARCHAR(30) NOT NULL,
userPass   VARCHAR(255) NOT NULL,
userEmail  VARCHAR(255) NOT NULL,
userDate   DATETIME NOT NULL,
userLevel  INT(8) NOT NULL,
UNIQUE INDEX userName_unique (userName),
PRIMARY KEY (userId)
)engine=innodb default charset = utf8;

CREATE TABLE categories (
catId          INT(8) NOT NULL AUTO_INCREMENT,
catName        VARCHAR(255) NOT NULL,
catDescription     VARCHAR(255) NOT NULL,
UNIQUE INDEX catName_unique (catName),
PRIMARY KEY (catId)
)engine=innodb default charset = utf8;

CREATE TABLE topics (
topicId        INT(8) NOT NULL AUTO_INCREMENT,
topicSubject       VARCHAR(255) NOT NULL,
topicDate      DATETIME NOT NULL,
topicCat       INT(8) NOT NULL,
topicBy        INT(8) NOT NULL,
PRIMARY KEY (topicId)
)engine=innodb default charset = utf8;

CREATE TABLE posts (
postId         INT(8) NOT NULL AUTO_INCREMENT,
postContent        TEXT NOT NULL,
postDate       DATETIME NOT NULL,
postTopic      INT(8) NOT NULL,
postBy     INT(8) NOT NULL,
PRIMARY KEY (postId)
)engine=innodb default charset = utf8;