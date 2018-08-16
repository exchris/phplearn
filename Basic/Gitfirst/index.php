<?php
function listDir($dir)
{
	if (is_dir($dir))
	{
		if ($dh = opendir($dir))
		{
			while (($file = readdir($dh)) !== false)
			{
				if ((is_dir($dir."/".$file)) && $file!="." && $file !="..")
				{
					echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
                    listDir($dir."/".$file."/");
				}
				else 
				{
					if ($file != "." && $file!="..")
					{
						echo $file."<br>";
					}
				}
			}
		}
	}
}
// 开始运行
listDir("http://www.ifitshow.com/Public/uploads/article/image/");
?>