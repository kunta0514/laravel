<title>工作流-FAQ</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{asset('vendor/css/marxico.css')}}" rel="stylesheet">
<style>
.note-content  {font-family: 'Helvetica Neue', Arial, 'Hiragino Sans GB', STHeiti, 'Microsoft YaHei', 'WenQuanYi Micro Hei', SimSun, Song, sans-serif;}
</style>
<div class="container">
    <div class="row">
        <h1 style="text-align: center">工作流 FAQ</h1>
    </div>
  <div class="col-xs-6 col-md-4">
  <blockquote>
    <p>1、标准ERP-工作流对照表</p>
  </blockquote>
      <table>
      <thead>
      <tr>
        <th>ERP版本号</th>
        <th>工作流-版本号</th>
        <th>备注</th>
      </tr>
      </thead>
      <tbody>
    @foreach($pageData['version_contrast'] as $k=>$item)
        <tr>
        <td>{{$k}}</td>
        <td>{{$item}}</td>
        <td>-</td>
      </tr>
    @endforeach
      </tbody>
    </table>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-8">
        <div id="wmd-preview-section-8" class="wmd-preview-section preview-content">

            <h3 id="常见的错误及对应的解决方案集锦">常见的错误及对应的解决方案集锦</h3>

            <hr>

            <p><strong>Q：临时，待补充</strong></p>

            <p>A：</p>

            <hr>

            <p><strong>Q：狗驱动</strong></p>

            <ul><li>驱动分32和64位的两种，检查版本是否正确。</li>
                <li>web.config中可配置狗驱动的类型，包括Rainbow(彩虹，开发使用)和Aladdin(阿拉丁，产品使用)。</li>
            </ul>

            <hr>

            <p><strong>Q：定义了重复的“system.web.extensions/scripting/scriptResourceHandler”节</strong></p>

            <p>A：.NET CLR的版本选择2.0，管道模式选择经典。</p>

            <hr>

            <p><strong>Q:SqlDependency</strong></p>

            <ul><li><p>将web.config中的UseSqlDependency 的值为false。</p></li>
                <li><p>当前数据库执行 exec usp_p_ERPDbConfig ‘数据库名’。</p></li>
            </ul>

            <hr>

            <p><strong>Q：事件订阅入口函数调用失败</strong></p>

            <ul><li>方案一：刷新页面。</li>
                <li>方案二：方案一无效的话，可以去数据库更改。方式如下：</li>
            </ul>

        </div><div id="wmd-preview-section-9" class="wmd-preview-section preview-content">

            <pre class="prettyprint hljs-dark"><code class="hljs sql"><span class="hljs-operator"><span class="hljs-keyword">truncate</span> <span class="hljs-keyword">table</span> myEventSubscribeEntry<br></span><br></code></pre>

            <hr>

            <p><strong>Q：详细错误信息查看</strong></p>

            <p>A：web.config</p>

        </div><div id="wmd-preview-section-10" class="wmd-preview-section preview-content">

            <pre class="prettyprint hljs-dark"><code class="hljs elm">&lt;--!设置 customErrors mode=<span class="hljs-string">"On"</span> 或 <span class="hljs-string">"RemoteOnly"</span> 以启用自定义错误信息<span class="hljs-comment">--&gt;</span><br>&lt;customErrors defaultRedirect=<span class="hljs-string">"/ErrPage.aspx"</span> mode=<span class="hljs-string">"RemoteOnly"</span> /&gt;<br><br></code></pre>

            <hr>

            <p><strong>Q：日志文件地址</strong></p>

            <p>A：工作流站点/Map/Tracelogs/workflow</p>

            <hr>

            <p><strong>Q：<a href="http://localhost:10306" target="_blank">http://localhost:10306</a></strong></p>

            <ul><li>现象：打开部分项目代码的时候显示未能链接到<a href="http://localhost:10306" target="_blank">http://localhost:10306</a>，Map项目显示不可用。</li>
                <li>解决方案：找到Map.vbproj.user文件，搜索”10306”，找到该行，直接删除，重启刷新即可。</li>
            </ul>

        </div>
    </div>
</div>
