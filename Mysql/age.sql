-- 已知生日求年龄
create function age(birthday date) returns int 
begin 
  declare age int(10);
  if birthday IS NULL THEN
    return '';
  end if;
  set age = year(curdate())-year(birthday)-1;
  if month(curdate())==month(birthday) then
    if day(curdate())>day(birthday) then
	set age = age+1;
    end if;
  elseif month(curdate())>month(birthday) then
	set age=age+1;
   end if;
   return age;
end
