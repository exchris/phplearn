-- 判断年份是否为闰年
DROP PROCEDURE IF EXISTS learYear;
CREATE PROCEDURE learYear(n int) COMMENT '判断年份是否为闰年'
BEGIN
	IF n <= 0 -- 参数不合法
		THEN SELECT '该年份不合法' AS s;
	ELSE -- 参数合法
	IF (n%4=0 && n%100<>0 || n%400=0) -- 闰年
		THEN SELECT '该年份为闰年' AS s;
	ELSE -- 不是闰年
		SELECT '该年份为平年' AS s;
	END IF;
	END IF;
END