-- 循环 1-n的和
create procedure sum(n int) returns int
begin 
  declare i int default 1;
  declare s int default 0;
  while i<=n do
    set s=s+i;
    set i=i+1；
  end while;
  select s;
end

create procedure sum(n int)returns int
begin 
  declare i int default 1;
  declare s int default 0;
  repeat
    set s=s+i;
    set i=i+1;
  until i>n
  end repeat;
  select s;
end

create procedure sum(n int)returns int 
begin
  declare i int default 1;
  declare s int default 0;
  aa:loop
  if i>n then 
    leave aa;
  end if;
    set s=s+i;
    set i=i+1;
  end loop;
  select s;
end
