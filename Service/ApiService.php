<?php
namespace App\Services;

class ApiService 
{
    /**
     * 返回码固定code
     */
    const SUCCESS_CODE           = 10200; //数据处理成功
    const SUCCESS_NO_DATA_CODE   = 10205; //数据处理成功无结果
    const SUCCESS_FORBIDDEN_CODE = 10403; //无权限
    const SUCCESS_SYSTEM_CODE    = 10500; //服务器错误
    const ERROE_CODE             = 10900; //错误，一般做为接口请求终止
    const NOLOGIN_CODE           = 20001; //未登陆

    protected $http_code  = 10200;
    protected $http_msg   = 'ok';
    protected $http_event = 'none';
    protected $return_data= [];
    protected $return_msg = [];

    const EVENT_ALERT   = 'alert';              //弹出确定框
    const EVENT_CONFIRM = 'confirm';            //弹出选择框
    const EVENT_OUTPUT  = 'output';             //输出到页面上
    const EVENT_NONE    = 'none';               //无操作

    /**
     * 获取数据处理结果
     * @return 
     */
    public function getResult()
    {
        if(empty($this->return_msg)) 
        {
            $this->return_msg = [
                'state' => [
                    'code'  => $this->http_code,
                    'event' => $this->http_event,
                    'msg'   => $this->http_msg
                ],
            ];
        }

        if($return_data !== '')
        {
            $this->return_msg['data'] = $return_data;
        }
        return $this->response($this->return_msg);
    }

    /**
     * 返回成功消息
     * @param string $msg 成功消息
     * @return mixed
     */
    protected function success($msg)
    {
        $this->return_msg = [
            'state' => [
                'code' => self::SUCCESS_CODE,
                'msg'  => $msg,
            ]
        ];
    }

    /**
     * 设置错误消息
     * @param  string $msg 错误信息
     * @return mixed 
     */
    protected function error($msg)
    {
         $this->return_msg = [
            'state' => [
                'code' => self::ERROE_CODE,
                'msg'  => $msg
            ],
        ];
    }

    protected function response(array $result)
    {
        return \Response::json($return_msg);
    }
}
