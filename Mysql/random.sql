-- 随机15位数字
DROP FUNCTION IF EXISTS randomNumber(counts INT(11)) RETURNS INT(11)
COMMENT '随机n位数字'
BEGIN
	DECLARE stemp VARCHAR(20);
	DECLARE stempcounts INTEGER;
	SET stemp = ROUND(ROUND(RAND(), counts) * POW(10, counts));
	IF CHAR_LENGTH(stemp) < counts THEN 
	SET stemp = CONCAT(stemp, RIGHT(CONCAT(POW(10, stempcounts),''),stempcounts));
	END IF;
	IF CHAR_LENGTH(stemp) > counts THEN 
	SET stemp = RIGHT(stemp, counts);
	END IF;
	RETURN stemp;
END

-- 随机6位字母
SELECT CONCAT(
CHAR(ROUND((RAND())*25)+97),
CHAR(ROUND((RAND())*25)+65),
CHAR(ROUND((RAND())*25)+65),
CHAR(ROUND((RAND())*25)+65),
CHAR(ROUND((RAND())*25)+65),
CHAR(ROUND((RAND())*25)+97)
)


-- 随机32位字符
SELECT REPLACE(UUID(),'-','');