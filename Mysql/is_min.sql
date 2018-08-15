-- 比较两个数并返回最小值
CREATE FUNCTION is_min(a INT,b INT) RETURNS INT
BEGIN 
  declare s int default 0;
  if a>=b then 
    set s = b;
  else 
    set s = a;
  end if;
  return s;
END
