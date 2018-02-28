<?php
// http://www.neatstudio.com/show-2310-1.shtml
/** 
 * 创建子进程入口 
 * @author selfimpr 
 * @blog http://blog.csdn.net/lgg201 
 * @mail lgg860911@yahoo.com.cn 
 * @param $func_name 代表子进程处理过程的函数名 
 * @param other 接受不定参数, 提供给子进程的过程函数. 
 */  
function new_child($func_name)  
{  
    $args = func_get_args();  
    unset($args[0]);  
    $pid = pcntl_fork();  
    if ($pid == 0) {  
        function_exists($func_name) and exit(call_user_func_array($func_name, $args)) or exit(-1);  
    }  
    else if ($pid == -1) {  
        echo "Couldn’t create child process .";  
    }  
}  

//测试处理函数, 输出$prefix连接的数组    
function test($prefix, $num)  
{  
    while ($i++ < $num) {  
        echo $prefix . $i ."\n";  
    }  
}  
//创建一个子进程    
new_child("test", "child process ", 100);  
//父进程也开启一个与子进程同样多的循环.    
test("parent process", 100);  
//运行结果, 我这里运行父进程输出50个左右, 子进程开始运行.    