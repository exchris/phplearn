--------------------------------
-- Procedure structure for `addShare`
--
--------------------------------
DROP PROCEDURE IF EXISTS `addShare`
DELIMITER ;;
CREATE DEFINTER=`root`@`localhost` PROCEDURE `addShare`()
    COMMENT '将未确认收款的金额存入到投资表中'
BEGIN
   DECLARE red float;
   DECLARE id int ;
   DECLARE dont int;
   -- 创建游标
   DECLARE addShare CURSOR FOR
      SELECT mid,money FROM `share` WHERE type=0;
   DECLARE CONTINUE handler for not found set done = 1;
   -- 打开游标
   OPEN addShare;
   aa:LOOP
      fetch addShare into id, red;
   if done then
      leave aa;
   end if;
      update `investment` set money=money+red where mid=id limit 1;
    end loop aa;
    close addShare; -- 关闭游标
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `Bonus`
-- ----------------------------
DROP PROCEDURE IF EXISTS `Bonus`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Bonus`()
    COMMENT '将投资的金额*0.3存入提额表'
BEGIN
declare m float(10,2); -- 金额
declare ids int;  -- 自身ID
declare done int;
-- 创建游标
declare addQuota cursor for
  select if(getAssembly(mid)=0,money,getAssembly(mid)) as money,mid
from (select money,m.id as mid,rid from member m inner join investment i on i.mid=m.id)b;
declare continue handler for not found set done=1;
-- 打开游标
open addQuota;
 aa:loop
fetch addQuota into m,ids;
if done then
  leave aa;
end if;
if m >= 3000 then
	insert into withdrawal(mid,type,time,money)values(ids,0,now(),0.3*m);
end if;
end loop aa;
close addQuota;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `quota`
-- ----------------------------
DROP PROCEDURE IF EXISTS `quota`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `quota`()
    COMMENT '将分红信息插入到分红表'
begin
	declare invest int; -- 投资金额
	declare t int;
	declare s int;
	declare id int;
	declare stime datetime;
	declare done int;
	-- 创建游标
	declare shareQuota CURSOR for
		select mid,type,time,state,money
	from investment;
	declare continue handler for not found set done=1;
	-- 打开游标
	open shareQuota;
	aa:loop
		fetch shareQuota into id,t,stime,s,invest;
	if done then
		leave aa;
	end if;
		set @last = DATEDIFF(now(),stime);
    -- 未得到运行
		if t = 0 then
			-- 未动
			if s = 0 then
					set @fenhong = format(getShare(invest,@last,0.0026),2);
				  insert into `share`(mid,money,stime,type) values(id,@fenhong,now(),0);
			else
					set @fenhong = format(0.0026*invest*@last,2);
				  insert into `share`(mid,money,stime,type) values(id,@fenhong,now(),0);
			end if;
		ELSE
			if s=0 THEN
					set @fenhong = format(getShare(invest,@last,0.0093),2);
				  insert into `share`(mid,money,stime,type) values(id,@fenhong,now(),0);
			ELSE
					set @fenhong = format(0.0093*invest*@last,2);
					insert into `share`(mid,money,stime,type) values(id,@fenhong,now(),0);
			end if;
		end if;
end loop aa;
  CLOSE shareQuota;
end
;;
DELIMITER ;

-- ----------------------------
-- Function structure for `getAssembly`
-- ----------------------------
DROP FUNCTION IF EXISTS `getAssembly`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `getAssembly`(id INT) RETURNS int(11)
    COMMENT '获取用户下线金额数'
BEGIN
	DECLARE
		sum INT;

SELECT
	sum(money) INTO sum
FROM
	investment i
INNER JOIN member m ON m.id = i.mid
WHERE
	rid = id
LIMIT 1;
if  sum>0 then
return sum;
else return 0;
end if;
END
;;
DELIMITER ;

-- ----------------------------
-- Function structure for `getShare`
-- ----------------------------
DROP FUNCTION IF EXISTS `getShare`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `getShare`(money float, m int,rate float) RETURNS float(10,2)
    COMMENT '根据投资表获取利息和'
begin
  declare i int default 1;
  declare profit float default 0.0;
  declare s float default 0.0;
  while i<=m do
    set profit = rate*money;
    set s = s+profit;
    set money = money+profit;
    set i = i+1;
	end while;
  return s;
end
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `bonus`
-- ----------------------------
DROP EVENT IF EXISTS `bonus`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `bonus` ON SCHEDULE EVERY 1 DAY STARTS '2017-05-26 15:00:00' ON COMPLETION PRESERVE ENABLE DO CALL Bonus ()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `quota`
-- ----------------------------
DROP EVENT IF EXISTS `quota`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `quota` ON SCHEDULE EVERY 1 DAY STARTS '2017-05-26 10:30:00' ON COMPLETION NOT PRESERVE ENABLE DO call quota()
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `shareToInvest`
-- ----------------------------
DROP EVENT IF EXISTS `shareToInvest`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `shareToInvest` ON SCHEDULE EVERY 1 DAY STARTS '2017-05-27 02:00:00' ON COMPLETION PRESERVE ENABLE DO call addShare()
;;
DELIMITER ;
