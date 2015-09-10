=== 洋葱授权 ===
Contributors: support
Donate link: https://www.yangcong.com
Tags: secken, yangcong
Requires at least: 2.7.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

原DNSPod创始人吴洪声，第二次创业起航，倾情打造划时代产品，带领豪华技术团队，为用户提供移动互联网时代的全新账号安全体系

详细介绍：
英文版: https://www.secken.com
中文版: https://www.yangcong.com

== Installation ==

1. 上传 `yangcong目录` 到项目根目录下的`/plugins/` 目录
2. 将plugin.php文件放到您的ecshop项目根目录
3. 打开themes/default/library/member_info.lbi
将
{$lang.welcome}&nbsp;&nbsp;&nbsp;&nbsp;

改为
{$lang.welcome}&nbsp;&nbsp;&nbsp;&nbsp;
<a href="plugin.php?act=yangcong_login">
<img src="./plugins/yangcong/template/image/login.jpg" class="xi2" rel="nofollow" alt="洋葱扫一扫登录" />
</a>

4. 打开themes/default/library/user_menu.lbi文件

将下方代码
<a href="user.php?act=account_log"{if $action eq 'account_log'}class="curs"{/if}><img src="../images/u13.gif"> {$lang.label_user_surplus}</a>

更改为
<a href="user.php?act=account_log"{if $action eq 'account_log'}class="curs"{/if}><img src="../images/u13.gif"> {$lang.label_user_surplus}</a>
<a href="plugin.php?act=yangcong_bind"{if $action eq 'yangcong_bind'}class="curs"{/if}><img src="../images/u13.gif">洋葱授权</a>

5. 打开languages/zh-cn/admin/common.php文件

在文件最下方加入一下代码
//洋葱授权
$_LANG['17_yangcong_manage'] = '洋葱授权';
$_LANG['settings'] = '设置';

6. 打开admin/includes/inc_menu.php文件
在文件最下方添加一下代码
//添加我的洋葱
$modules['17_yangcong_manage']['settings']  = 'yangcong.php?act=settings';

7. 安装必要的数据表

访问 http://xxx.com/plugin.php?act=yangcong_install

8. 去管理后台配置您的洋葱，位置：菜单》洋葱授权》设置

== Screenshots ==


== Changelog ==

2015.09.10
= 1.0 =
* 添加后台管理菜单
* 登录表单中嵌入洋葱登录
