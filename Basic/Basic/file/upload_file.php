<?php
  header("content-type:text/html;charset=utf-8");
  print "<pre>";
  # 文件上传后存储路径
  $store_dir = 'd:\\www\leetcode\php\basic\upload\\';
  # 上传文件的原始名字
  $uploadfile = "$store_dir".basename($_FILES['sendfile']['name']);
  # 上传文件的临时名字
  $uploadfile_temp = $_FILES['sendfile']['tmp_name'];
  # 上传文件时产生的错误信息
  $err_msg = $_FILES['sendfile']['error'];

  # 如果存在错误代码则打印出来
  if ($err_msg) {
    print "错误代码: $err_msg <br/>";
  }

  # 检测上传文件是否可写,不可写则打印错误信息并退出
  if (!is_writable($store_dir)) {
    print "$store_dir 目录不可写<br/>";
    exit;
  } else {
    print "$store_dir 目录可写<br/>";
  }

  if (isset($_FILES['sendfile'])) {
    if (is_uploaded_file($uploadfile_temp)) {
      print "文件检验成功\n";
    } else {
      print "文件检验失败,可能遭受文件上传攻击!";
      exit;
    }
    if (move_uploaded_file($uploadfile_temp, $uploadfile)) {
      print "文件移动成功\n";
    } else {
      print "移动文件失败,可能遭受文件上传攻击!";
    }
    print "文件上传成功!<br>";
  } else {
    print "文件上传失败!<br/>";
  }
  print '$_FILES=';
  print_r($_FILES);
  print "</pre>";
?>
