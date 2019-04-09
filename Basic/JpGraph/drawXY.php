<?php

date_default_timezone_set('PRC');

// XY坐标图
require_once __DIR__.'./src/jpgraph.php';
require_once __DIR__.'./src/jpgraph_line.php';

// 1.创建画布
$graph = new Graph(600, 400);
// 2.设置横纵坐标刻度样式

/**
 * lin 直线
 * text 文本
 * int 整数
 * log 对数
 * textint
 */

$aAxisType = 'textint';
$graph->SetScale($aAxisType);

// 3. 设置统计图的标题
// $graph->title->Set('This is a X/Y test');
// 设置中文标题
$graph->title->SetFont(FF_CHINESE);
$graph->title->Set('XY示例');

$data = array(
	0 => 20 , 1 => 30  , 2 => 40  , 3 => 50,
	4 => 12 , 5 => 38  , 6 => 55  , 7 => 30,
	8 => 110, 9 => 40, 10 => 54, 11 => 80
);

// 4. 得到LinePlot对象
$linePlot = new LinePlot($data);

// 5. 设置图例
$linePlot->SetLegend('图例');

// 6. 将统计图添加到画布上
$graph->Add($linePlot);

// 设置统计图的颜色,一定要在添加到画布之后在设置
$linePlot->SetColor('#F00');

// 输出画布
$graph->Stroke();
// $graph->Stroke('./test.png');

/**
 * 1.支持中文配置
 * 修改jpgraph_ttf.inc.php
 * 搜索CHINESE_TTF_FONT选项，修改常量的值是支持中文的字体
 * define('CHINESE_TTF_FONT','SIMYOU.TTF');
 * $graph->title->SetFont(FF_CHINESE);
 *
 * 2. 支持图例中文
 * 修改jpgraph_legend.inc.php,将$font_family修改成FF_CHINESE
 * public $font_family = FF_CHINESE,
 * $font_style = FS_NORMAL,$font_size = 8;
 */

