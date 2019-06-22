=== Traum Captcha ===
Contributors: jysafe 
Donate link: http://www.jysafe.cn/
Tags: sign up,Captcha
Requires at least: 5.0
Tested up to: 5.0
Stable tag: 4.3
Requires PHP: 5.5 
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

CN: 最基本的形式：
    输入上图物质分子式，看着复杂，其实挺简单的，数数各个原子个数，按照顺序堆起来就行了。
    此外还有计算矩阵、说出事件发生日期的验证码，三者随机出现。
    
EN: This is a special captcha plugin. 
    It is not verified by math but by chemical formula and Calculation matrix and date of some event.

== Installation ==
CN:
1.启用插件
2.进入插件设置页面，安装数据库
3.尽情享用

EN:
1.Enable plugin
2.Go to plugin setting page and install database
3.Enjoy yourself

== Frequently Asked Questions == 
CN:
1.是否涉及敏感数据操作？
A：没有，最敏感权限是向数据库写入验证码数据。

2.为什么使用 "https://www.chemicalbook.com/CAS/GIF/"?
A:我使用它去获得化学方程式的图片，而图片是本插件所必需的。

3.为什么使用 "https://api.jysafe.cn/traum_captcha_update/update.json"?
A:我使用它去获得最新版本信息，包括测试版本。

EN:
1.Is it involves sensitive data operations？
A：No，it just write some captcha questions into the database.

2.Why I use "https://www.chemicalbook.com/CAS/GIF/"?
A:I use it to get the chemical equation images.
About chemicalbook:https://www.chemicalbook.com/AboutUs_EN.aspx

3.Why I use "https://api.jysafe.cn/traum_captcha_update/update.json"?
A:I use it to get the latest version including the test version.

== Upgrade Notice == 
CN:
1.0.3   修复数据库特定情况下写入失败的问题，优化部分处理逻辑，更新翻译。
EN:
1.0.3   Fix a problem that sometimes writing database may fail，Optimize partial processing logic，update translate。

== Screenshots == 
1.none

== Changelog ==
CN:
1.0.3   修复数据库特定情况下写入失败的问题，优化部分处理逻辑，更新翻译。
1.0.2   使用Wordpress自带设置API,使用专有名称使本插件与其它插件产生冲突的可能性减小。
1.0.1   增加设置功能
1.0     测试版本

EN:
1.0.3   Fix a problem that sometimes writing database may fail，Optimize partial processing logic，update translate。
1.0.2   use setting api,use unique name.
1.0.1   add settings.
1.0     test version.

## 捐赠支持
### 如果你觉得不错，可以请作者喝杯奶茶，谢谢大家支持！
![webconfig](preview/donate.jpg)