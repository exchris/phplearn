DROP PROCEDURE IF EXISTS sum2n;
CREATE PROCEDURE sum2n(n INT(11)) RETURNS INT(11) COMMENT '循环1-n的和'
BEGIN 
DECLARE i INT DEFAULT 1;
DECLARE s INT DEFAULT 0;
REPEAT 
SET s = s + i;
SET i = i + 1;
UNTIL i > n 
END REPEAT;
SELECT s;
END