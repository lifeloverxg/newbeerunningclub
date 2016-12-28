<?php
function request_by_fsockopen($url,$post_data=array()){
    $url_array = parse_url($url);
    $hostname = $url_array['host'];
    $port = isset($url_array['port'])? $url_array['port'] : 80; 
    $requestPath = $url_array['path'] ."?". $url_array['query'];
    $fp = fsockopen($hostname, $port, $errno, $errstr, 10);
    if (!$fp) {
        echo "$errstr ($errno)";
        return false;
    }
    $method = "GET";
    if(!empty($post_data)){
        $method = "POST";
    }
    $header = "$method $requestPath HTTP/1.1\r\n";
    $header.="Host: $hostname\r\n";
    if(!empty($post_data)){
        $_post = strval(NULL);
        foreach($post_data as $k => $v){
                $_post[]= $k."=".urlencode($v);//必须做url转码以防模拟post提交的数据中有&符而导致post参数键值对紊乱
        }
        $_post = implode('&', $_post);
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";//POST数据
        $header .= "Content-Length: ". strlen($_post) ."\r\n";//POST数据的长度
        $header.="Connection: Close\r\n\r\n";//长连接关闭
        $header .= $_post; //传递POST数据
    }else{
        $header.="Connection: Close\r\n\r\n";//长连接关闭
    }
    fwrite($fp, $header);
    //-----------------调试代码区间-----------------
    /*$html = '';
    while (!feof($fp)) {
        $html.=fgets($fp);
    }
    echo $html;*/
    //-----------------调试代码区间-----------------
    fclose($fp);
 }
 
$data = array(
    'authId'=>'authcode',
    'email'=>'mengkang@php.net',
    'nickname'=>'周梦康',
    'mailBody'=>'<h3>康哥 <span style="padding:15px">某某文章</span> 有新的留言</span></h3><p>周某人 < mengkang@php.net >在评论中说：</p><div style="border-radius: 4px;margin: 10px 0 10px;border: 1px dashed #BEB0B0;padding: 8px;background: #F0F0F0;">测试回复的内容</div><p><a href="http://m.cn/github/zhoumengkang/index.php?m=Blog&a=blog&id=21#floor26">点击链接查看</a></p>'
    );
echo microtime(),"\r\n";
request_by_fsockopen('http://m.cn/github/zhoumengkang/index.php?m=Comment&a=sendEmail',$data);
echo microtime();
?>