-- 判断年份是否为闰年
CREATE PROCEDURE is_leap_year(n int)
BEGIN
  IF n<=0 -- 参数不合法
    THEN SELECT '该年份不合法' AS s;
  ELSE --参数合法
    IF (n%4=0&&n%100<>0||n%400=0) -- 判断闰年
      THEN SELECT '该年份为闰年' AS s;
    ELSE -- 不是闰年
      SELECT '该年份为平年' AS s;
    END IF;
  END IF;
END
