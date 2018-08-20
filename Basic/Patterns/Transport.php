<?php
  # 工厂模式
  # 以交通工具为例子:要求请既可以定制交通工具,又可以定制交通工具生产的过程
  # 1. 定制交通工具
  #  1. 定义一个接口,里面包含交通工具的方法(启动 运行 停止)
  #  2. 让飞机,汽车等类去实现它们
  # 2. 定制工厂
  #  1. 定义一个接口,里面包含交通工具的制造方法
  #  2. 分半写制造飞机,汽车的工厂类去继承实现这个接口
  # 定义交通功能的公共功能:启动,运行,停止
  interface TransportFactory {
	public function start(); # 启动
	public function run(); # 运行
	public function stop(); # 停止
  }
  
  # 飞机类
  class Aircraft implements TransportFactory {
  	public function start() {
  		return 'Aircraft start';
  	}
  	public function run() {
  		return 'Aircraft run';
  	}
  	public function stop() {
  		return 'Aircraft stop';
  	}
  }
  
  # 汽车类
  class Car implements TransportFactory {
  	public function start() {
  		return 'Car start';
  	}
  	public function run() {
  		return 'Car run';
  	}
  	public function stop() {
  		return 'Car stop';
  	}
  }
  
  // 根据传入的交通工具来获取对象功能
  class Transport {
  public static function createObj($type) {
  		switch ($type) {
  			case 'aircraft' :
  				return new Aircraft(); break;
  			case 'car' :
  				return new Car(); break;
  		}
  	}
  }
  
  $transport = new Transport();
  $info = $transport->createObj('car');
  var_dump($info);