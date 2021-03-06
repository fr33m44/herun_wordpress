<?php
/**
 * 检测留言中是否带有中文字，如果没有，则返回出错信息，并不保存该条留言。
 * 登录用户，留言可以不带有中文字。
 * @param mixed $comment
 * @return mixed
 */
function scp_check_comment($comment) {
    $options = scp_get_options();
    if ('unrequired' == $options['login_user'] && is_user_logged_in()) return $comment;
    $commentStr = $comment['comment_content'];
    $pattern = '/[一-龥]/u';

    if(!preg_match_all($pattern, $commentStr, $match)){
        $options['message'] = apply_filters('scp_message', $options['message']);
        $options['message'] = apply_filters('display_smilies', $options['message']);
        header("Content-type: text/html; charset=utf-8");
        exit($options['message'] . '<br /><a href="' . $_SERVER['HTTP_REFERER'] .'#respond">返回留言</a>');
    }else{
        return $comment;
    }
}

/**
 * 在留言框的下面增加一个英文提示。
 */
function scp_js() {
    $options = scp_get_options();
    if ($options['show_message'] == 'show'){
        $options['message'] = apply_filters('scp_message', $options['message']);
        $options['message'] = apply_filters('display_smilies', $options['message']);
        echo <<<JS
<script type="text/javascript"><!--//--><![CDATA[//><!--
    var cf = document.getElementById("commentform");
    cf.innerHTML += "<p class='scp_message' style='color:#EB5050;clear:both;'>{$options['message']}</p>";
//--><!]]></script>
JS;
    }
}

/* EOF scp-front.php */
/* ./wp-content/plugins/some-chinese-please/scp-front.php */