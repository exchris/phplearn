-- 创建阶乘函数
CREATE FUNCTION Factorial(n INT) RETURNS INT 
BEGIN
  DECLARE i int DEFAULT 1;
  DECLARE result int DEFAULT 1;
  WHILE i<=n DO
    SET result = result*i;
    SET i=i+1;
  END WHILE;
  RETURN result;
END
