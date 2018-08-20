<?php
  #　观察者皆可
  interface IObserver {
    function onListen($sender, $args);
    function getName();
  }

  # 可被观察接口
  interface IObservable {
    function addObserver($observer);
    function removeObserver($observer_name);
  }

  # 观察者类
  abstract class Observer implements IObserver {
    protected $name;

    public function getName() {
      return $this->name;
    }
  }

  # 可被观察类
  class Observable implements IObservable {
    protected $observers = array();

    public function addObserver($observer) {
      if (!($observer instanceof IObserver)) {
        return;
      }
      $this->observers[] = $observer;
    }

    public function removeObserver($observer_name) {
      foreach ($this->observers as $index => $observer) {
        if ($observer->getName() === $observer_name) {
          array_splice($this->observers, $index, 1);
          return;
        }
      }
    }
  }

  # 模拟一个可以被观察的类:RadioStation
  class RadioStation extends Observable {
    public function addListener($listener) {
      foreach ($this->observers as $observer) {
        $observer->onListen($this, $listener);
      }
    }
  }

  # 模拟一个观察者类
  class RadioStationLogger extends Observer {
    protected $name = 'logger';

    public function onListen($sender, $args) {
      echo $args.' join the radiostation.<br/>';
    }
  }

  # 模拟另外一个观察者类
  class OtherObserver extends Observer {
    protected $name = 'other';
    public function onListen($sender, $args) {
      echo 'other observer...<br/>';
    }
  }

  $rs = new RadioStation();

  # 注入观察者
  $rs->addObserver(new RadioStationLogger());
  $rs->addObserver(new OtherObserver());

  # 移除观察者
  $rs->removeObserver('other');

  # 可以看到观察到的信息
  $rs->addListener('cctv');
?>
