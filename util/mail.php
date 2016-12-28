<?php
/*MailDAO
* @author Junxiao Yi
* @Created on Mar 11 2014
*/
class MailDAO
{
/*+++++++++++++++for get mail list+++++++++++++++*/
    public static function get_mail_list_eid($eid)
    {
        //#0 default value
        $member_id_list = array();
        $mail_list = array();

        $member_id_list = PeopleDAO::get_pid_list_event_nogender($eid);

        //get mail_list
        foreach ($member_id_list as $ids)
        {
            $url = self::get_mail_url_pid($ids);
            array_push($mail_list, $url);
        }

        return $mail_list;
    }

    public static function get_mail_list()
    {
         //#0 default value
        $mail_list = array();

        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT uid, email, user FROM login LIMIT 2000;');
        // $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $mail['id'] = '0';
        $mail['email'] = 'Email';
        $mail['user'] = 'Name';
        array_push($mail_list, $mail);
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
        {
            if ($row['uid'] >= 400)
            {
                if ( Authority::isEmail($row['email']) )
                {
                    $mail['id'] = $row['uid'];
                    $mail['email'] = $row['email'];
                    $mail['user'] = $row['user'];
                    array_push($mail_list, $mail);
                } 
            }          
        }

        $stmt->close();

        return $mail_list;
    }

    public static function get_mail_list_all()
    {
         //#0 default value
        $mail_list = array();

        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT uid, email, user FROM login LIMIT 3000;');
        // $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
        {
            if ( Authority::isEmail($row['email']) )
            {
                $mail['id'] = $row['uid'];
                $mail['email'] = $row['email'];
                $mail['user'] = $row['user'];
                array_push($mail_list, $mail);
            }         
        }

        $stmt->close();

        return $mail_list;
    }

    public static function get_mail_list_string_eid($eid)
    {
        //#0 default value
        $mail_list_string = '';
        $mail_list_array = array();

        $mail_list_array = self::get_mail_list_eid($eid);

        $mail_list_string = implode('yiuniim', $mail_list_array);

        return $mail_list_string;
    }

    public static function get_eventbrite_attendee_mail_list()
    {
        //#0 default value
        $param = '&only_display=order_id,email,first_name,last_name';
        $count = 0;
        $mail_list = array();

        //#1 access eventbrite attendees information
        $attendee_array = EventDAO::pub_acc_Eb($param);

        //#2 get mail_list information
        foreach ($attendee_array as $key => $attendee_list)
        {
            foreach ($attendee_list as $key_value => $attendee)
            {
                if ( $attendee['email'] != '' )
                {
                    $mail['id'] = $count+1;
                    $mail['email'] = $attendee['email'];
                    $mail['name'] = $attendee['first_name']."_".$attendee['last_name'];

                    array_push($mail_list, $mail);

                    ++$count;
                }
            }
        }

        return $mail_list;
    }

    public static function get_paypalsale_mail_list_eid($eid)
    {
        $mail_list = array();

        //get email address
        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT DISTINCT payer_email, buyer_info FROM paypal WHERE eid=? LIMIT 3000;');
        $stmt->bind_param('i', $eid);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
        {
            $email['email'] = $row['payer_email'];
            
            $buyer_info = $row['buyer_info'];
            $buyer_arr = explode("|", $buyer_info);
            $buyer_name = $buyer_arr[0];
            $buyer_name_arr = explode(",", $buyer_name);
            $buyer_name_use = $buyer_name_arr[0]." ".$buyer_name_arr[1];
            $email['name'] = $buyer_name_use;

            array_push($mail_list, $email);
        }
        $stmt->close();
        return $mail_list;
    }
/*===============for get mail list===============*/

/*+++++++++++++++for mail url use+++++++++++++++*/
    public static function get_mail_url_pid($pid)
    {
        //#0 default value
        $url = '';

        //get email address
        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT uid, email FROM login WHERE uid=? LIMIT 1;');
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
        {
            $uid = $row['uid'];
            $url = $row['email'];
            $stmt->close();
            return $url;
        }
        $stmt->close();
        return $url;
    }

    public static function get_mail_url($email) 
    {
        $token = '';
        $url = '';

        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT uid, user FROM login WHERE email=? LIMIT 1;');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
        {
            $uid = $row['uid'];
            $token = base64_encode($uid."|".$user."|".$email);
            $url = "http://nycuni.com/account?code=".$token;
            $stmt->close();
            return $url;
        }
        $stmt->close();
        return $url;
    }
/*===============for mail url use===============*/

/*++++++++++++++++++++++++++++++sendmail functions++++++++++++++++++++++++++++++*/
    public static function sendmail($to, $subject = "", $body = "")
    {
        //返回值
        $result = '';
        
        //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
        // date_default_timezone_set("Asia/Shanghai");//设定时区东八区
        date_default_timezone_set("America/New_York");//设定时区EST
    //    include('class.phpmailer.php');
    //    include("class.smtp.php"); 
        $mail             = new PHPMailer(); 
        $body             = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
        $mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP(); // 设定使用SMTP服务
        $mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
                                               // 1 = errors and messages
                                               // 2 = messages only
        $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
        $mail->SMTPSecure = "ssl";                 // 安全协议
        $mail->Host       = "hwsmtp.exmail.qq.com";      // SMTP 服务器
        $mail->Port       = 465;                   // SMTP服务器的端口号
        $mail->Username   = "yijunxiao@nycuni.com";  // SMTP服务器用户名
        $mail->Password   = "yinycunicom1990";            // SMTP服务器密码
        $mail->SetFrom('yijunxiao@nycuni.com', 'nycuni.com');
        $mail->AddReplyTo("yijunxiao@nycuni.com","nycuni.com");
        $mail->Subject    = $subject;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer! - From www.jiucool.com"; // optional, comment out and test
        $mail->MsgHTML("亲爱的".$to."：<br/>您在我们NYCUNI.com提交了找回密码请求。请点击下面的链接重置密码 
（链接24小时内有效）。<br/><a href='".$body."'target='_blank'>".$body."</a>");
        $address = $to;
        $mail->AddAddress($address, "nycuni.com");
        
        //yi:请不要删我的注释！！！ 
    //   $mail->AddAttachment("../../theme/images/faq.png", "faq.png");      // attachment 
    //    $mail->AddAttachment("../images/phpmailer_mini.gif"); // attachment
        // if(!$mail->Send())
        // {
        //     echo "Mailer Error: " . $mail->ErrorInfo;
        // } 
        // else 
        // {
        //     echo "Message sent!恭喜！";
        // }
        //yi:请不要删我的注释！！！

        if (!$mail->Send())
        {
            $result = "Mailer Error: " . $mail->ErrorInfo;
        }
        else
        {
            $result = "yi";
            return $result;
        }

        return $result;
    }

    //sendmail_event_paypalsale test版本
    public static function sendmail_event_paypalsale($to, $subject = "", $body = "", $ticket_url = "")
    {
        //返回值
        $result = '';
        
        //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
        // date_default_timezone_set("Asia/Shanghai");//设定时区东八区
        date_default_timezone_set("America/New_York");//设定时区EST

        $mail             = new PHPMailer(); 
        $body             = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
        $mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP(); // 设定使用SMTP服务
        $mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
                                               // 1 = errors and messages
                                               // 2 = messages only
        $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
        $mail->SMTPSecure = "ssl";                 // 安全协议
        $mail->Host       = "hwsmtp.exmail.qq.com";      // SMTP 服务器
        $mail->Port       = 465;                   // SMTP服务器的端口号
        $mail->Username   = "order@nycuni.com";  // SMTP服务器用户名
        $mail->Password   = "niuyueyouni2014";            // SMTP服务器密码
        $mail->SetFrom('order@nycuni.com', 'nycuni.com');
        $mail->AddReplyTo("order@nycuni.com","nycuni.com");
        $mail->Subject    = $subject;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer! - From www.jiucool.com"; // optional, comment out and test
        $mail->MsgHTML($body);
        $mail->AddAddress($to, "nycuni.com");
        // $address = "lifeloverxg@gmail.com";
        // $mail->AddBCC($address, "nycuni.com");
        
        //yi:请不要删我的注释！！！ 
        if ( $ticket_url != '' )
        {
            $mail->AddAttachment($ticket_url, "nycuni_ticket.pdf");      // attachment 
        }
        // $mail->AddAttachment("../images/phpmailer_mini.gif"); // attachment
        // if(!$mail->Send())
        // {
        //     echo "Mailer Error: " . $mail->ErrorInfo;
        // } 
        // else 
        // {
        //     echo "Message sent!恭喜！";
        // }
        //yi:请不要删我的注释！！！

        if (!$mail->Send())
        {
            $result = "Mailer Error: " . $mail->ErrorInfo;
        }
        else
        {
            $result = "yi";
            return $result;
        }

        return $result;
    }

    //sendmail_event_groupmail_version1 test版本
    public static function sendmail_event_groupmail_version1($to, $subject = "", $body = "")
    {
        //返回值
        $result = '';
        
        //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
        // date_default_timezone_set("Asia/Shanghai");//设定时区东八区
        date_default_timezone_set("America/New_York");//设定时区EST

        $mail             = new PHPMailer(); 
        $body             = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
        $mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP(); // 设定使用SMTP服务
        $mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
                                               // 1 = errors and messages
                                               // 2 = messages only
        $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
        $mail->SMTPSecure = "ssl";                 // 安全协议
        $mail->Host       = "hwsmtp.exmail.qq.com";      // SMTP 服务器
        $mail->Port       = 465;                   // SMTP服务器的端口号
        $mail->Username   = "yijunxiao@nycuni.com";  // SMTP服务器用户名
        $mail->Password   = "yinycunicom1990";            // SMTP服务器密码
        $mail->SetFrom('yijunxiao@nycuni.com', 'nycuni.com');
        $mail->AddReplyTo("yijunxiao@nycuni.com","nycuni.com");
        $mail->Subject    = $subject;
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer! - From www.jiucool.com"; // optional, comment out and test
        $mail->MsgHTML("亲爱的".$to."：<br/>".$body);
        $address = "lifeloverxg@gmail.com";
        $mail->AddAddress($address, "nycuni.com");
        
        //yi:请不要删我的注释！！！ 
    //   $mail->AddAttachment("../../theme/images/faq.png", "faq.png");      // attachment 
    //    $mail->AddAttachment("../images/phpmailer_mini.gif"); // attachment
        // if(!$mail->Send())
        // {
        //     echo "Mailer Error: " . $mail->ErrorInfo;
        // } 
        // else 
        // {
        //     echo "Message sent!恭喜！";
        // }
        //yi:请不要删我的注释！！！

        if (!$mail->Send())
        {
            $result = "Mailer Error: " . $mail->ErrorInfo;
        }
        else
        {
            $result = "yi";
            return $result;
        }

        return $result;
    }
/*==============================sendmail functions==============================*/

/*++++++++++for update mail list username with email++++++++++*/
    protected static function get_mail_list_for_login()
    {
        $mail_list = array();
        $mail_list_temp = array();
        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT email, uid FROM login WHERE user LIKE "%无名英雄%" LIMIT 1000;');
        //$stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
        {
            $mail_list_temp['uid'] = $row['uid'];
            $mail_list_temp['email'] = $row['email'];
            
            array_push($mail_list, $mail_list_temp);   
        }
        $stmt->close();

        return $mail_list;
    }

    protected static function get_mail_list_pre_for_login()
    {
        $mail_list = self::get_mail_list_for_login();
        $mail_pre_array = array();
        $mail_pre = '';
        $mail_list_new = array();
        $mail_list_new_temp = array();

        foreach ( $mail_list as $mail_list_value )
        {
            $mail_pre_array = explode('@', $mail_list_value['email']);
            $mail_pre = $mail_pre_array[0];
            $mail_list_new_temp['uid'] = $mail_list_value['uid'];
            $mail_list_new_temp['mail_pre'] = $mail_pre;

            array_push($mail_list_new, $mail_list_new_temp);
        }

        return $mail_list_new;       
    }

    public static function update_mail_list_for_login()
    {
        $mail_list_with_pre = self::get_mail_list_pre_for_login();

        $mysqli = MysqlInterface::get_connection();
        $stmt = $mysqli->stmt_init();
        foreach ( $mail_list_with_pre as $mail_list )
        {
            $stmt->prepare('UPDATE login SET user = ? where uid = ?;');
            $stmt->bind_param('ss', $mail_list['mail_pre'], $mail_list['uid']);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        
        $stmt->close();
        return $true;
    }
/*==========for update mail list username with email==========*/

/*++++++++++for authenticate email address along with the username++++++++++*/
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600) 
    {
            /**
             * @param string $string 原文或者密文
             * @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
             * @param string $key 密钥
             * @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
             * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
             *
             * @example
             *
             * $a = authcode('abc', 'ENCODE', 'key');
             * $b = authcode($a, 'DECODE', 'key');  // $b(abc)
             *
             * $a = authcode('abc', 'ENCODE', 'key', 3600);
             * $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
             */
        $ckey_length = 4;
        // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥
        

        $key = md5 ( $key ? $key : 'key' ); //这里可以填写默认key值
        $keya = md5 ( substr ( $key, 0, 16 ) );
        $keyb = md5 ( substr ( $key, 16, 16 ) );
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';
        
        $cryptkey = $keya . md5 ( $keya . $keyc );
        $key_length = strlen ( $cryptkey );
        
        $string = $operation == 'DECODE' ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
        $string_length = strlen ( $string );
        
        $result = '';
        $box = range ( 0, 255 );
        
        $rndkey = array ();
        for($i = 0; $i <= 255; $i ++) 
        {
            $rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
        }
        
        for($j = $i = 0; $i < 256; $i ++) 
        {
            $j = ($j + $box [$i] + $rndkey [$i]) % 256;
            $tmp = $box [$i];
            $box [$i] = $box [$j];
            $box [$j] = $tmp;
        }
        
        for($a = $j = $i = 0; $i < $string_length; $i ++) 
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box [$a]) % 256;
            $tmp = $box [$a];
            $box [$a] = $box [$j];
            $box [$j] = $tmp;
            $result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
        }
        
        if ($operation == 'DECODE') 
        {
            if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) 
            {
                return substr ( $result, 26 );
            } 
            else 
            {
                return '';
            }
        } 
        else 
        {
            return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
        }
    }
    /*==========for authenticate email address along with the username==========*/
}

?>