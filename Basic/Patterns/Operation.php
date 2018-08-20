<?php
  header("content-type:text/html;charset=utf-8");
  # 简单工厂模式
  #  1. 抽象基类:类中定义抽象一些方法,用以在子类中实现
  #  2. 继承自抽象基类的子类:实现基类中的抽象方法
  #  3. 工厂类:用以实例化所有相对于的子类
  
  /**
   * 
   * 定义个抽象的类,让子类去继承实现它
   * 
   */
  abstract class Operation {
	// 抽象方法不能包含函数体
	// 强烈要求子类必须实现该功能函数
	abstract public function getValue($num1, $num2); 
  }
  
  /**
   * 加法类
   */
  class OperationAdd extends Operation {
  	public function getValue($num1, $num2) {
  		return $num1 + $num2;
  	}
  }
  
  /**
   * 减法类
   */
  class OperationSub extends Operation {
  	public function getValue($num1, $num2) {
  		return $num1 - $num2;
  	}
  }
  
  /**
   * 乘法类
   */
  class OperationMul extends Operation {
  	public function getValue($num1, $num2) {
  		return $num1 * $num2;
  	}
  }
  
  /**
   * 除法类
   */
  class OperationDiv extends Operation {
  	public function getValue($num1, $num2) {
  		try {
  			if ($num2 == 0) {
  				throw new Exception("除数不能为0");
  			}
  		} catch (Exception $e) {
  			echo "错误信息:". $e->getMessage();
  		}
  	}
  }
  
  class OperationRem extends Operation {
  	public function getValue($num1, $num2) {			
  		return $num1 % $num2;
  	}
  }

  /**
   * 工厂类:主要用来创建对象
   * 功能:根据输入的运算符号,工厂就能实例化合适的对象
   */
  class Factory {
  	public static function createObj($operate) {
  		switch ($operate) {
  			case '+' :
  				return new OperationAdd(); break;
  			case '-' :
  				return new OperationSub(); break;
  			case '*' :
  				return new OperationMul(); break;
  			case '/' :
  				return new OperationDiv(); break;
  			default :
  				return new OperationRem(); break;
  		}
  	}
  }
  
  $test = Factory::createObj('/');
  $result = $test->getValue(23, 0);
  echo $result;
  