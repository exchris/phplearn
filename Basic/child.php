<?php

//子空间使用
namespace beijing\haidian;
function getName() {
	return "haidian"; 
}

namespace hebei\handan;
function getName() {
	return "handan";
}

namespace beijing\chaoyang;
function getName() {
	return "chaoyang";
}

namespace beijing\changping;
function getName() {
	return "changping";
}

//获得最下边的getName()使用非限定名称,使用上边的getName()需要使用完全限定名称
// echo getName(); //changping
// echo \beijing\chaoyang\getName(); //chaoyang
// echo \hebei\handan\getName(); //handan
