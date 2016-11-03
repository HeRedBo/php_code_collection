<?php include_once("function.php");?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title>演示：收集整理的非常有用的PHP函数</title>
<meta name="keywords" content="php函数">
<link rel="stylesheet" type="text/css" href="../css/main.css" />
<style type="text/css">
.demo{width:700px; margin:40px auto 0 auto;}
@media screen and (max-width: 360px) {.demo {width:320px}}
pre{background:#f0f0f0; padding:10px;white-space:pre-wrap;word-wrap:break-word;}
.demo h4{padding:10px 0;font-size:16px}
.demo p{padding:8px 2px}
</style>

</head>

<body>
<div id="header">
   <div id="logo"><h1><a href="http://www.helloweba.com" title="返回helloweba首页">helloweba</a></h1></div>
   <div class="demo_topad"><script src="/js/ad_js/demo_topad.js" type="text/javascript"></script></div>
</div>

<div id="main">
   <h2 class="top_title"><a href="http://www.helloweba.com/view-blog-281.html">收集整理的非常有用的PHP函数</a></h2>
   <div class="demo">
   		<h4 id="encrypt">PHP搜索和高亮显示字符串中的关键字</h4>

		<pre>
function highlighter($text, $words) { 
  $split_words = explode(" " , $words ); 
  foreach($split_words as $word) { 
    $color = "#4285F4"; 
    $text = preg_replace("/($word)/i" , "&lt;span style=\"color:".$color.";\"&gt;&lt;b&gt;$1&lt;/b&gt;&lt;/span&gt;", $text ); 
  } 
  return $text; 
}

$string = "基于Zepto的内容滑动插件：zepto.hwSlider.js"; 
$words = "zepto"; 
echo highlighter($string ,$words);
</pre>
<p>运行结果：</p>
	<?php 
$string = "基于Zepto的内容滑动插件：zepto.hwSlider.js"; 
$words = "zepto"; 
echo highlighter($string ,$words);
   ?>
	</div>
  <div class="ad_76090"><script src="/js/ad_js/bd_76090.js" type="text/javascript"></script></div><br/>
  
  <br/>
</div>


<div id="footer">
    <p>Powered by helloweba.com  允许转载、修改和使用本站的DEMO，但请注明出处：<a href="http://www.helloweba.com">www.helloweba.com</a></p>
</div>
<p id="stat"><script type="text/javascript" src="/js/tongji.js"></script></p>
</body>
</html>