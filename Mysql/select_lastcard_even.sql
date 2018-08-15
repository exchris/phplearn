-- 求表中身份证号最后一位是偶数的成员
create procedure select_lastcard_even()
begin
  select * from students where right(cardid,1)%2=0 and lcase(right(cardid,1))<>'x';
end
