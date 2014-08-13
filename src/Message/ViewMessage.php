<?php
namespace Wuai\Utils\Message;
/**
 * 带视图的消息跳转页面
 * @author 吾爱 <carlton.cheng@foxmail.com>
 * @license http://opensource.org/licenses/mit-license.php
 */
class ViewMessage {
    /**
     * 成功提示
     * @param type $msg 提示信息
     * @param type $jumpurl 跳转url
     * @param type $wait 等待时间
     */
    public function success($msg = "", $jumpurl = "", $wait = 3)
    {
        return $this->_jump($msg, $jumpurl, $wait, 1);
    }

    /**
     * 错误提示
     * @param type $msg 提示信息
     * @param type $jumpurl 跳转url
     * @param type $wait 等待时间
     */
    public function error($msg = "", $jumpurl = "", $wait = 3)
    {
        return $this->_jump($msg, $jumpurl, $wait, 0);
    }

    /**
     * 最终跳转处理
     * @param type $msg 提示信息
     * @param type $jumpurl 跳转url
     * @param type $wait 等待时间
     * @param int $type 消息类型 0或1
     */
    private function _jump($msg = "", $jumpurl = "", $wait = 3, $type = 0)
    {
        $data = array(
            'msg' => $msg,
            'jumpurl' => $jumpurl,
            'wait' => $wait,
            'type' => $type
        );
        $data['title'] = ($type == 1) ? "提示信息" : "错误提示";
        if (empty($jumpurl))
        {
            if ($type == 1)
            {
                $data['jumpurl'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "javascript:window.close();";
            }
            else
            {
                $data['jumpurl'] = "javascript:history.back(-1);";
            }
        }
        
        return $this->render($data);
    }
    
    //渲染模板
    protected function render($data=array()){
        extract($data);
        ob_start();
        include __DIR__."/jumpTpl.phtml";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}