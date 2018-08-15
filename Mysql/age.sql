# 计算年龄的方法
DROP FUNCTION IF EXISTS `age`;

CREATE DEFINER = `root`@`localhost` FUNCTION age(birthday VARCHAR(15)) RETURNS INT(11) COMMENT '计算年龄的方法'
BEGIN
  DECLARE age INT(10); # 年龄初始化
  IF birthday IS NULL THEN 
  RETURN '';
  END IF;
  SET age = YEAR(CURDATE()) - YEAR(birthday) - 1;
  IF MONTH(CURDATE()) >= MONTH(birthday) THEN
  IF DAY(CURDATE()) > DAY(birthday) THEN
  	SET age = age + 1;
  END IF;
  ELSEIF MONTH(CURDATE()) > MONTH(birthday) THEN
  	SET age = age + 1;
  END IF;
  RETURN age;
END
