-- 求表中身份证号最后一位是偶数的成员
DROP PROCEDURE IF EXISTS idCardEven() COMMENT '表中身份证号最后一位是偶数的成员'
BEGIN
	SELECT * FROM `student` WHERE 
	right(cardid, 1)%2= 0 AND lcase(right(cardid, 1)) <> 'X';
END