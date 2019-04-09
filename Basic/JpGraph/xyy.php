<?php

date_default_timezone_set('PRC');
//引入类库
require_once "./src/jpgraph.php";
require_once "./src/jpgraph_line.php";
$data=array(0=>-21,1=>-3,2=>12,3=>19,4=>23,5=>29,6=>30,7=>22,8=>26,9=>18,10=>5,11=>-10);//第一条数据
$data2y=array(0=>3,1=>12,2=>18,3=>30,4=>28,5=>33,6=>43,7=>39,8=>36,9=>29,10=>15,11=>10);//第二条数据
//得到Graph对象
$graph=new Graph(1200,800);
//设置X和Y轴样式及Y轴的最大值最小值
$graph->SetScale("textint",-30,50);
//设置右侧Y轴样式及其最大值最小值
$graph->SetY2Scale("int",-30,50);
//设置图像样式，加入阴影
$graph->SetShadow();
//设置图像边界范围
$graph->img->setMargin(40,60,50,70);
//设置标题
$graph->title->Set("this is a test X-Y-Y");
//得到曲线实例
$linePlot=new LinePlot($data);
//得到第二条曲线
$linePlot2y=new LinePlot($data2y);
//将曲线加入到图像中
$graph->Add($linePlot);
$graph->Add($linePlot2y);

//设置三个坐标轴名称
$graph->xaxis->title->Set("Month");
$graph->yaxis->title->Set("beijing");
$graph->y2axis->title->Set("ShangHai");

//设置两条曲线的颜色
$linePlot->SetColor("red");
$linePlot2y->SetColor("black");

//设置两条曲线的图例
$linePlot->SetLegend("Beijing");
$linePlot2y->SetLegend("Shanghai");

//设置图例样式
$graph->legend->setlayout(LEGEND_HOR);
$graph->legend->Pos(0.45,0.9,"center","bottom");
//将图像输出到浏览器
$graph->Stroke();