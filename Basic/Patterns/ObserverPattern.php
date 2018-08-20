<?php
interface IObserver {
	function onChanged($sender, $args);
}
interface IObservable {
	#增加观察者对象
	function addObserver($observer);
}
class UserList implements IObservable {
	private $_observers = array();
	public function addCustomer($name) {
		foreach ($this->_observers as $obs) {
			$obs->onChanged($this, $name);
		}
	}
	public function addObserver($observer) {
		$this->_observers[] = $observer;
	}
}

class UserListLogger implements IObserver {
	public function onChanged($sender, $args) {
		echo "'$args'被添加到用户列表中\n";
	}
}
$ul = new UserList();
$ul->addObserver(new UserListLogger());
$ul->addCustomer("运动秀");