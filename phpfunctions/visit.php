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
   		<h4 id="encrypt">PHP检查是否宕机</h4>

		<pre>
function visit($url){ 
  $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
  $ch=curl_init(); 
  curl_setopt ($ch, CURLOPT_URL,$url ); 
  curl_setopt($ch, CURLOPT_USERAGENT, $agent); 
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt ($ch,CURLOPT_VERBOSE,false); 
  curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE); 
  curl_setopt($ch,CURLOPT_SSLVERSION,3); 
  curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE); 
  $page=curl_exec($ch); //echo curl_error($ch); 
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
  curl_close($ch); 
  if($httpcode>=200 && $httpcode<300) return true; 
  else return false; 
} 
</pre>
	<?php 
  if (visit("http://www.qq.com")) 
    echo "www.qq.com is OK"."\n"; 
  else 
    echo "Website DOWN";
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