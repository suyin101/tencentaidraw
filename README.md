# 腾讯云AI绘画

对接腾讯云官方接口AI绘画做的一个页面，可以实现文生图的功能

演示地址：https://www.suyin66.com/suyinai

![image-20230825223549837](https://picosssuyin.oss-cn-beijing.aliyuncs.com/img-typora/image-20230825223549837.png)

有限制每天使用20次，可以自己修改次数，但是这个功能还不够完善，大佬们可以看看。

### 代码目录

index.php  首页文件

draw.php   接口代码

proxy.php 代理接口文件  



### 部署教程

把以上三个文件都放到网站中，并修改相应内容

![image-20230825224141296](https://picosssuyin.oss-cn-beijing.aliyuncs.com/img-typora/image-20230825224141296.png)

![image-20230825224344528](https://picosssuyin.oss-cn-beijing.aliyuncs.com/img-typora/image-20230825224344528.png)

![image-20230825224444507](https://picosssuyin.oss-cn-beijing.aliyuncs.com/img-typora/image-20230825224444507.png)

且需要安装Composer依赖

具体可以参考腾讯云的文档和这个

[API Explorer - 云 API - 控制台 (tencent.com)](https://console.cloud.tencent.com/api/explorer?Product=aiart&Version=2022-12-29&Action=TextToImage)

[PHP-SDK 中心-腾讯云 (tencent.com)](https://cloud.tencent.com/document/sdk/PHP)

[宝塔Linux面板安装Composer依赖管理工具与PHP依赖包的方法_宝塔面板安装composer_苏音资源的博客-CSDN博客](https://blog.csdn.net/qq_43079386/article/details/131714001?spm=1001.2014.3001.5501)
