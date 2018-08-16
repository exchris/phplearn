<?php
    /**
	 * zip_open()函数打开ZIP文件以供读取
	 * 如果成功,则返回zip文件档案资源。如果失败,则返回false。
	 */
	$zip = zip_open("D:/test.zip");
	if ($zip) {

		/**
		 * zip_read()函数读取打开的zip档案中的下一个文件。
		 * 如果成功,则返回包含zip档案中一个文件的资源。如果没有更多的项目可供读取,则返回false。
		 */
		while ($zip_entry = zip_read($zip))
		{
			/**
			 * zip_entry_name()函数返回zip档案项目的名称。
			 * 返回压缩文件中的所有文件名称
			 */
			echo "Name:".zip_entry_name($zip_entry)."<br/>";

			/**
			 * zip_entry_compressedsize(zip_entry):返回zip档案项目的压缩文件尺寸
			 */
			echo "Compressed Size:".zip_entry_compressedsize($zip_entry)."<br/>";

			/**
			 * zip_entry_compressionmethod(zip_entry):返回zip档案项目的压缩方法
			 */
			echo "Compression Method:".zip_entry_compressionmethod($zip_entry)."<br/>";

			/*
			 * zip_entry_filesize()函数返回zip档案项目的原始大小(在压缩之前)
			 */	
			echo "Original size:".zip_entry_filesize($zip_entry)."<br/>";
			
			/**
			 * zip_entry_open()函数打开一个ZIP档案项目以供读取
			 * zip_entry_open(zip,zip_entry,mode)
			 * zip:必须。规定要读取的zip资源(由zip_open()打开的zip文件)
			 * zip_entry:必需。规定要打开的zip项目资源(由zip_read()打开的zip项目)
			 * mode: 在php5中,mode会被忽略,且总为"rb",因为php中zip支持是只读的
			 */
			if (zip_entry_open($zip, $zip_entry)) 
			{
				echo "File Contents:<br/>";

				/**
				 * zip_entry_read()函数从打开的zip档案项目中获取内容
				 * 如果成功,则返回项目的内容。如果失败,则返回false。
				 */		
				$contents = zip_entry_read($zip_entry);
				echo "$contents<br/>";

				/**
				 * zip_entry_close()函数关闭由zip_entry_close()函数打开的zip档案文件
				 */
				zip_entry_close($zip_entry);
			}
		}
	}
	// 关闭压缩文件
	zip_close($zip);
?>
