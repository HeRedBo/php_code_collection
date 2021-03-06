<?php

/**
 * 加密解密
 * @author Red-Bo
 */
function encryptDecrypt($key, $string, $decrypt)
{
    if($decrypt){
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "12");
        return $decrypted;
    }else{
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $encrypted;
    }
}

//生成随机字符串
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

//获取文件扩展名
function getExtension($filename)
{
  $myext = substr($filename, strrpos($filename, '.'));
  return str_replace('.','',$myext);
}

//获取文件大小并格式化
function formatSize($size)
{
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) {
		return('n/a');
	} else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
	}
}

//PHP替换标签字符
function stringParser($string,$replacer)
{
    $result = str_replace(array_keys($replacer), array_values($replacer),$string);
    return $result;
}

//列出目录下的文件
function listDirFiles($DirPath)
{
    if($dir = opendir($DirPath)){
         while(($file = readdir($dir))!== false){
                if(!is_dir($DirPath.$file))
                {
                    echo "filename: $file<br />";
                }
         }
    }
}

//获取当前页面的url
function curPageURL()
{
	$pageURL = 'http';
	if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

//强制下载
function download($filename){
    if ((isset($filename))&&(file_exists($filename))){
       header("Content-length: ".filesize($filename));
       header('Content-Type: application/octet-stream');
       header('Content-Disposition: attachment; filename="' . $filename . '"');
       readfile("$filename");
    } else {
       echo "Looks like file does not exist!";
    }
}

/*
 Utf-8、gb2312都支持的汉字截取函数
 cut_str(字符串, 截取长度, 开始长度, 编码);
 编码默认为 utf-8
 开始长度默认为 0
*/
function cutStr($string, $sublen, $start = 0, $code = 'UTF-8'){
    if($code == 'UTF-8'){
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);

        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }else{
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i<$strlen; $i++){
            if($i>=$start && $i<($start+$sublen)){
                if(ord(substr($string, $i, 1))>129){
                    $tmpstr.= substr($string, $i, 2);
                }else{
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}


//获取用户真实IP
function getIp() {
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		$ip = getenv("HTTP_CLIENT_IP");
	else
		if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else
			if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
				$ip = getenv("REMOTE_ADDR");
			else
				if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
					$ip = $_SERVER['REMOTE_ADDR'];
				else
					$ip = "unknown";
	return ($ip);
}

//防止注入
function injCheck($sql_str) {
	$check = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/', $sql_str);
	if ($check) {
		echo '非法字符！！'.$sql_str;
		exit;
	} else {
		return $sql_str;
	}
}

//页面提示跳转
function message($msgTitle,$message,$jumpUrl){
	$str = '<!DOCTYPE HTML>';
	$str .= '<html>';
	$str .= '<head>';
	$str .= '<meta charset="utf-8">';
	$str .= '<title>页面提示</title>';
	$str .= '<style type="text/css">';
	$str .= '*{margin:0; padding:0}a{color:#369; text-decoration:none;}a:hover{text-decoration:underline}body{height:100%; font:12px/18px Tahoma, Arial,  sans-serif; color:#424242; background:#fff}.message{width:450px; height:120px; margin:16% auto; border:1px solid #99b1c4; background:#ecf7fb}.message h3{height:28px; line-height:28px; background:#2c91c6; text-align:center; color:#fff; font-size:14px}.msg_txt{padding:10px; margin-top:8px}.msg_txt h4{line-height:26px; font-size:14px}.msg_txt h4.red{color:#f30}.msg_txt p{line-height:22px}';
	$str .= '</style>';
	$str .= '</head>';
	$str .= '<body>';
	$str .= '<div class="message">';
	$str .= '<h3>'.$msgTitle.'</h3>';
	$str .= '<div class="msg_txt">';
	$str .= '<h4 class="red">'.$message.'</h4>';
	$str .= '<p>系统将在 <span style="color:blue;font-weight:bold">3</span> 秒后自动跳转,如果不想等待,直接点击 <a href="{$jumpUrl}">这里</a> 跳转</p>';
	$str .= "<script>setTimeout('location.replace(\'".$jumpUrl."\')',2000)</script>";
	$str .= '</div>';
	$str .= '</div>';
	$str .= '</body>';
	$str .= '</html>';
	echo $str;
}


//时间长度转换
function changeTimeType($seconds) {
	if ($seconds > 3600) {
		$hours = intval($seconds / 3600);
		$minutes = $seconds % 3600;
		$time = $hours . ":" . gmstrftime('%M:%S', $minutes);
	} else {
		$time = gmstrftime('%H:%M:%S', $seconds);
	}
	return $time;
}

//检查是否宕机
function visit($url)
{
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
	if($httpcode>=200 && $httpcode<300)
        return true;
	else
        return false;
}

function highlighter($text, $words)
{
	$split_words = explode(" " , $words );
	foreach($split_words as $word)
    {
		$color = "#4285F4";
		$text = preg_replace("/($word)/i" , "<span style=\"color:".$color.";\"><b>$1</b></span>", $text );
	}
	return $text;
}

function generateRandomStr($length = 8)
{
    $str = '1234567890qwertyuiopasdfghjklzxcvbnm';
    $strlen = strlen($str);
    while($length > $strlen)
    {
        $str .= $str;
        $strlen += strlen($str);
    }
    $str = str_shuffle($str);
    return  substr($str, 0, $length);
}

/**
 * 校验银行卡号是否输入有误 使用了Luhn算法校验
 * @param  int $no 银行卡号
 * @return bool 返回数据校验结果
 */
function luhm($no)
{
	if(empty($no) || !is_numeric($no) || strlen($no) < 16)
	{
		return false;
	}
	$arr_no = str_split($no);
	$last_n = end($arr_no);
	krsort($arr_no);
	$i = 1;
	$total = 0;
	foreach ($arr_no as $n)
	{
	    if($i%2==0) {
	        $ix = $n*2;
	        if($ix >= 10) {
	            $nx = 1 + ($ix % 10);
	            $total += $nx;
	        } else {
	            $total += $ix;
	        }
	    } else {
	        $total += $n;
	    }
	    $i++;
	}
	$total -= $last_n;
	$total *= 9;
	if($last_n == ($total%10)){
    	return true;
	} 
	return false;
}


/**
 * 身份证校验函数 start
 */

function validation_filter_id_card($id_card)
{
    if(strlen($id_card)==18)
    {
        return idcard_checksum18($id_card);
    }
    elseif((strlen($id_card)==15))
    {
        $id_card=idcard_15to18($id_card);
        return idcard_checksum18($id_card);
    }
    else
    {
        return false;
    }
}

// 计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base)
{
    if(strlen($idcard_base)!=17){
        return false;
    }
    //加权因子
    $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
    //校验码对应值
    $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
    $checksum=0;
    for($i=0;$i<strlen($idcard_base);$i++) {
        $checksum += substr($idcard_base,$i,1) * $factor[$i];
    }
    $mod=$checksum % 11;
    $verify_number=$verify_number_list[$mod];
    return $verify_number;
}
// 将15位身份证升级到18位
function idcard_15to18($idcard)
{
    if(strlen($idcard)!=15){
        return false;
    }else{
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){
            $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
        }else{
            $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
        }
    }
    $idcard=$idcard.idcard_verify_number($idcard);
    return $idcard;
}
// 18位身份证校验码有效性检查
function idcard_checksum18($idcard)
{
    if(strlen($idcard)!=18) {
        return false;
    }
    $idcard_base=substr($idcard,0,17);
    if(idcard_verify_number($idcard_base)!= strtoupper(substr($idcard,17,1))) {
        return false;
    } else {
        return true;
    }
}

//调用方法如：
$res = validation_filter_id_card('44142319940113561X');
/**
 * 身份证校验函数 end 
 */