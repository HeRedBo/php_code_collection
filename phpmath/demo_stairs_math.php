<?php
    /**
     *  PHP上台阶问题（斐波纳契数列应用）
     *  2016年8月31日面试遇到的一道算法题目
     *  面试的时候没有没做到 现在做个笔记
     */

    /**
     * 题目：
     *有个人想上一个50层的台阶，但他一次只能迈一层或两层台阶，问：这个人有多少种方法可以把台阶走完？
     */
    /**
     *
     *  分析：先列举几个实例：1代表迈一层，2代表迈2层
     *  一层：1
     *  二层：11  2
     *  三层：111 12 21
     *  四层：1111 121 211 112 22
     *  五层：11111 2111 1211 1121 1112 221 212 122
     * 我们可以看到从第三层开始的走法等于上两层的走法之和，这个符合斐波纳契数列（斐波纳契数列指数列的第一项和第二项已知，那么后面的项等于前面两项的和，比如，第四
     */

     /**
      * 楼梯的个数 (递归方法实现) 有多少种走法的实现
      *
      * @author Red-Bo
      * @date   2016-08-31
      * @param  int  $stepnum 楼梯的阶梯数
      * @return int 返回请求的结果
      */
     function countNumber($stepnum)
     {
        $sum = 0;
        if($stepnum == 0)
            return 0;
        else if($stepnum == 1)
            return 1;
        else if($stepnum == 2)
            return 2;
        else if($stepnum == 3)
            return 4;
        else if($stepnum > 3)
        {
            return countNumber($stepnum -3) + countNumber($stepnum - 2) + countNumber($stepnum -1);
        }
        return $num;
     }

     // 测试
     $step = 20;
     for ($i=1; $i <= $step; $i++)
     {
        echo '楼梯台阶上有'.$i.'个 一共有'.countNumber($i)."法<br/>";
     }



     /**
      * 计算走法的个数 采用递归方法实现
      *
      */

     function up_out($n)
     {
         if($n == 1)
             return ['1'];
        else if($n == 2)
            return ['1 1 ','2 '];
        else if($n == 3)
            return ['1 1 1 ','1 2 ','2 1'];
        else if($n > 3)
        {
            return ArrayMerge();
        }
     }

     function ArrayMerge()
     {
         
     }
