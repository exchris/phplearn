-- 求1!+2!+3!+...+n!
CREATE PROCEDURE sum_factorial(n int)
BEGIN 
  declare i int default 1;
  declare s int default 0;
  while i<=n do
    set s=s+Factorial(i);
    set i=i+1;
  end while;
select s;
END
