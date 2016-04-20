<title>工作流-FAQ</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{asset('vendor/css/marxico.css')}}" rel="stylesheet">
<style>
.note-content  {font-family: 'Helvetica Neue', Arial, 'Hiragino Sans GB', STHeiti, 'Microsoft YaHei', 'WenQuanYi Micro Hei', SimSun, Song, sans-serif;}
</style>
<div class="container">
  <blockquote>
    <p>标准ERP-工作流对照表</p>
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
    <td>{{$item['erp_version']}}</td>
    <td>{{$item['workflow_version']}}</td>
    <td>-</td>
  </tr>
@endforeach
  </tbody>
</table>
</div>
