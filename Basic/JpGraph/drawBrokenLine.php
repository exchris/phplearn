<?php

// 配置北京时间
date_default_timezone_set('PRC');

// 引入类库
require_once __DIR__.'./src/jpgraph.php';
require_once __DIR__.'./src/jpgraph_line.php';

// 第一条折线数据
$brokenDataFirst = [-21,-3,12,19,23,29,30,22,26,18,5,10];

// 第二条折线数据
$brokenDataSecond = [3,12,18,30,28,33,43,39,36,29,15,10];

// 实例化Graph类,得到Graph对象
$graph = new Graph(1200, 400);

// 设置X轴和Y轴样式及Y轴的最大值和最小值
$graph->SetScale("textint",-30,50);
// 设置右侧Y轴样式及其最大值最小值
$graph->SetY2Scale("int",-30,50);
// 设置图像样式,加入阴影
$graph->SetShadow();
// 设置图像边界范围
$graph->img->SetMargin(60,60,50,70);
// 设置标题
$graph->title->SetFont(FF_CHINESE);
$graph->title->Set("X-Y-Y示例");
// 得到曲线示例
$linePlot = new LinePlot($brokenDataFirst);
// 得到第二条曲线示例
$linePlot2y = new LinePlot($brokenDataSecond);

// 将曲线加入到图像中
$graph->Add($linePlot);
$graph->Add($linePlot2y);

// 设置三个坐标轴名称
$graph->xaxis->title->Set("月");
$graph->yaxis->title->Set("北京");
$graph->y2axis->title->Set("上海");

// 设置两条曲线的颜色
$linePlot->SetColor("red");
$linePlot2y->SetColor("black");

// 设置两条曲线的图例
$linePlot->SetLegend("北京");
$linePlot2y->SetLegend("上海");

// 设置图例样式
$graph->legend->SetLayout(LEGEND_HOR);
$graph->legend->Pos(0.5,0.9,"center","bottom");

//将图像输出到浏览器
$graph->Stroke();