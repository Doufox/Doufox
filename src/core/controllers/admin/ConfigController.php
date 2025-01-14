<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * 网站配置
 */
class ConfigController extends Admin
{
    private $msg_result;

    public function __construct()
    {
        parent::__construct();
        $this->configTips = array(
            'SITE_THEME'             => '桌面端主题样式, 默认default',
            'SITE_MOBILE'            => '移动端主题样式, 默认mobile',
            'SITE_NAME'              => '网站名称',
            'SITE_SLOGAN'            => '网站宣传标语',
            'SITE_TITLE'             => '网站首页SEO标题',
            'SITE_KEYWORDS'          => '网站SEO关键字',
            'SITE_DESCRIPTION'       => '网站SEO描述信息',
            'SITE_WATERMARK'         => '水印功能',
            'SITE_WATERMARK_ALPHA'   => '图片水印透明度',
            'SITE_WATERMARK_TEXT'    => '文字水印',
            'SITE_WATERMARK_SIZE'    => '文字大小',
            'SITE_WATERMARK_POS'     => '水印位置',
            'SITE_THUMB_WIDTH'       => '内容缩略图默认宽度',
            'SITE_THUMB_HEIGHT'      => '内容缩略图默认高度',
            'MEMBER_MODELID'         => '默认会员模型',
            'MEMBER_REGISTER'        => '新会员注册',
            'MEMBER_STATUS'          => '新会员审核',
            'MEMBER_REGCODE'         => '注册验证码',
            'MEMBER_LOGINCODE'       => '登录验证码',
            'DIY_URL'                => '开启伪静态',
            'INDEX_URL'              => '首页url',
            'LIST_URL'               => '栏目url',
            'LIST_PAGE_URL'          => '栏目带分页url',
            'SHOW_URL'               => '内容页url',
            'SHOW_PAGE_URL'          => '内容分页url',
            'HIDE_ENTRY_FILE'        => '隐藏入口文件需要服务器配置默认文件，如index.php。当服务器配置的默认文件与程序入口文件一致时，设置才生效',
            'URL_LIST_TYPE'          => '栏目参数形式，ID形式：catid=123，目录形式：catpath=catpath',
            'RAND_CODE'              => '随机代码',
            'WEIXIN_MP_OPENED'       => '微信公众号开关',
            'WEIXIN_MP_URL'          => '接收来自微信服务器的请求,必须以http://或https://开头',
            'WEIXIN_MP_TOKEN'        => '微信服务器的验证token,必须为英文或数字，长度为3-32字符',
            'WEIXIN_MP_AESKEY'       => 'EncodingAESKey,消息加密密钥由43位字符组成',
            'ADMIN_LOGINCODE'        => '后台登录需要输入验证码',
            'ADMIN_LOGINPATH'        => '后台登录路径默认admin',
            'SITE_ICP_FILING_NUMBER' => '网站ICP备案号',
            'STORAGE_TYPE'           => '附件存储形式'
        );
    }

    /**
     * 系统基本配置
     */
    public function indexAction()
    {
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }

        $file_list = core::load_class('file_list');
        $arr = $file_list->get_file_list(PATH_TEMPLATE);
        // 主题文件夹列表
        $template = array_diff($arr, array('index.html'));
        unset($arr, $file_list);
        $msg = $this->msg_result;
        include $this->views('admin/config/index');
    }

    /**
     * 用户设置
     */
    public function memberAction()
    {
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }
        // 用户模型列表
        $membermodel = $this->membermodel;
        $msg = $this->msg_result;
        include $this->views('admin/config/member');
    }

    /**
     * Robots 爬虫规则设置
     */
    public function robotsAction()
    {
        // 文件路径
        $file = PATH_ROOT . DS .'robots.txt';
        // 提交的数据
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            file_put_contents($file, $post_data);
            $this->show_message('修改成功', 1, url('admin/config/robots'));
        }
        $data = array(
            'robots' => ''
        );
        // 获取当前配置信息
        if (is_file($file)) {
            $data['robots'] = file_get_contents($file);
        }

        // 加载视图
        include $this->views('admin/config/robots');
    }

    /**
     * URL设置
     */
    public function urlAction()
    {
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        // 获取当前配置信息
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }
        $msg = $this->msg_result;
        include $this->views('admin/config/url');
    }

    /**
     * 图片水印
     */
    public function watermarkAction()
    {
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        // 获取当前配置信息
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }
        $msg = $this->msg_result;
        include $this->views('admin/config/watermark');
    }

    /**
     * 微信设置
     */
    public function weixinAction()
    {
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $post_data['WEIXIN_MP_URL'] = HTTP_PRE . HTTP_HOST . url('api/weixin/index');
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        // 获取当前配置信息
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }
        $msg = $this->msg_result;
        include $this->views('admin/config/weixin');
    }

    /**
     * 安全设置
     */
    public function securityAction()
    {

        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $post_data['ADMIN_LOGINPATH'] = $post_data['ADMIN_LOGINPATH'] ? $post_data['ADMIN_LOGINPATH'] : 'admin';
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        // 获取当前配置信息
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }
        $msg = $this->msg_result;
        include $this->views('admin/config/security');
    }

    /**
     * 附件设置
     */
    public function attachmentAction()
    {
        if ($this->isPostForm()) {
            $post_data = $this->post('data');
            $this->save_config($post_data);
            $this->msg_result = '修改成功';
        }
        // 获取当前配置信息
        $data = $this->site_config;
        if (isset($post_data)) {
            $data = array_merge($data, $post_data);
            unset($post_data);
        }
        $msg = $this->msg_result;
        include $this->views('admin/config/attachment');
    }

    /**
     * 数据库设置
     */
    public function databaseAction()
    {
        if ($this->isPostForm()) {
            $postdata = $this->post('data');
            // 拼接文件内容
            $content = "<?php" . PHP_EOL . "if (!defined('IN_CRONLITE')) exit();" . PHP_EOL . PHP_EOL . "return array(" . PHP_EOL;
            $content .= "    'db_host'     => '" . $postdata['db_host']     . "'," . PHP_EOL;
            $content .= "    'db_username' => '" . $postdata['db_username'] . "'," . PHP_EOL;
            $content .= "    'db_password' => '" . $postdata['db_password'] . "'," . PHP_EOL;
            $content .= "    'db_name'     => '" . $postdata['db_name']     . "'," . PHP_EOL;
            $content .= "    'db_prefix'   => '" . $postdata['db_prefix']   . "'," . PHP_EOL;
            $content .= "    'db_charset'  => '" . $postdata['db_charset']  . "'";
            $content .= PHP_EOL . ");";
            // 保存数据库配置文件
            if (!file_put_contents(PATH_DATA . DS . 'config' . DS . 'database.ini.php', $content)) {
                dexit('数据库配置文件保存失败, 请检查文件权限！');
            }
            $this->msg_result = '修改成功';
            unset($content);
            unset($postdata);
        }
        // 获取当前配置信息
        // 加载数据库配置文件
        $data = core::load_config('database');
        if (!is_array($data)) {
            exit('数据库配置文件不存在');
        }
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
        }

        $data['db_host'] = trim($data['db_host']);
        $data['db_username'] = trim($data['db_username']);
        $data['db_password'] = trim($data['db_password']);
        $data['db_name'] = trim($data['db_name']);
        $data['db_charset'] = ($data['db_charset']) ? trim($data['db_charset']) : '';
        $data['db_prefix'] = ($data['db_prefix']) ? trim($data['db_prefix']) : '';
        $msg = $this->msg_result;
        include $this->views('admin/config/database');
    }

    /**
     * 保存配置
     */
    private function save_config($postdata)
    {
        $postdata['RAND_CODE'] = md5(microtime());
        $postdata = array_merge($this->site_config, $postdata);
        $content = "<?php" . PHP_EOL . "if (!defined('IN_CRONLITE')) {" . PHP_EOL . "    exit();" . PHP_EOL . "}" . PHP_EOL . PHP_EOL . "return array(" . PHP_EOL;
        foreach ($postdata as $k => $v) {
            $value = $v == 'false' || $v == 'true' ? $v : "'" . $v . "'";
            $content .= "    '" . strtoupper($k) . "'" . $this->setspace($k) . " => " . $value . ", // " . $this->configTips[$k] . PHP_EOL;
        }
        $content .= PHP_EOL . ");";
        file_put_contents(PATH_DATA . DS .'config' . DS . 'config.ini.php', $content);
        return true;
    }

    /**
     * 空格填补
     */
    private function setspace($var)
    {
        $len = strlen($var) + 2;
        $cha = 25 - $len;
        $str = '';
        for ($i = 0; $i < $cha; $i++) {
            $str .= ' ';
        }

        return $str;
    }
}
