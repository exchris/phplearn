-- 阶乘函数
DROP FUNCTION IF EXISTS Factorial;
-- 创建阶乘函数
CREATE FUNCTION Factorial(n INT(11)) RETURNS INT(11) COMMENT '阶乘函数'
BEGIN
  DECLARE i INT DEFAULT 1;
  DECLARE result INT DEFAULT 1;
  WHILE i <= n DO 
    SET result = result * i;
    set i = i + 1;
  END WHILE;
  RETURN result;
END
