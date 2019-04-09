1、什么是SQL注入？

**如何理解SQL注入**
- SQL注入是一种将SQL代码添加到输入参数中
```
learn.me/sql/article.php?id=1
SELECT * FROM article WHERE id = 1

learn.me/sql/article.php?id=-1 OR 1=1
SELECT * FROM article WHERE id = -1 OR 1=1
```

**SQL注入是怎么产生的?**
- WEB开发人员无法保证所有的输入都已经过滤;
- 攻击者利用发送给SQL服务器的输入数据构造可执行的SQL代码
- 数据库未做相应的安全配置

3、如何寻找SQL注入漏洞？

**如何寻找SQL注入漏洞**
- 识别web应用中所有输入点
```
learn.me/sql/article.php?id=1
SELECT * FROM article WHERE id = 1
Array
(
    [id] => 1,
    [title] => 测试数字注入标题
    [content] => 测试数字注入内容
    [type] => 1
    [ctime] => 2017-05-05 23:25:19
    [mtime] => 2017-05-05 23:26:13
)
learn.me/sql/article.php?id=1'
query failed:You have an error in your SQL syntax:check the manual that corresponds to you MySQL
syntax to user near ' at line 1
```

4、如何进行SQL注入攻击？
- 数字注入
```
learn.me/sql/article.php?id=1
```
- 字符串注入
```
// $sql = "SELECT * FROM user WHERE user_name = 'james'#' AND password='697d51a19d8a121ce81499d7b701668'"
// $sql = "SELECT * FROM user WHERE user_name = 'james '-- ' AND password='698d51a19d8a121ce81499d7b701668'"
```
5、如何预防SQL注入
- 严格检查输入变量的类型和格式
- 过滤和转义特殊字符
- 利用mysql的预编译机制
