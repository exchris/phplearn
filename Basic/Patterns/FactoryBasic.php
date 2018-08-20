<?php
  // 定义形状的公共功能:获取周长和面积
  interface IShape {
    public function getCircum();
    public function getArea();
  }

  # 定义矩形类
  class Rectangle implements IShape {
    private $width, $height;

    public function __construct($width, $height) {
      $this->width = $width;
      $this->height = $height;
    }

    public function getCircum() {
      return 2 * ($this->width + $this->height);
    }

    public function getArea() {
      return $this->width * $this->height;
    }
  }

  # 定义圆类
  class Circle implements IShape {
    private $radius;

    public function __construct($radius) {
      $this->radius = $radius;
    }

    public function getCircum() {
      return 2 * M_PI * $this->radius;
    }

    public function getArea() {
      return M_PI * pow($this->radius, 2);
    }
  }

  # 根据传入的参数个数不同来创建不同的形状
  class FactoryShape {
    public static function create() {
      switch (func_num_args()) {
        case 1:
           return new Circle(func_get_arg(0)); break;
        case 2:
           return new Rectangle(func_get_arg(0), func_get_arg(1)); break;
      }
    }
  }

  // 矩形对象
  $rectangle = FactoryShape::create(4, 2);
  var_dump($rectangle->getArea());

  # 圆对象
  $circle = FactoryShape::create(2);
  var_dump($circle->getArea());

?>
