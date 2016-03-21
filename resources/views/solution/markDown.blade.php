<style type="text/css">
    .myfloat{
        float: left;
        position: absolute;
        width: 120px;
        border: 1px solid #ddd;
        z-index: 9999;
        padding: 5px 8px;
        top:180px;
        left: 20px;
        min-height: 180px;
        font-family: Microsoft YaHei;
    }
</style>
{{--// 引入编辑器代码--}}
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
@include('editor::head')
<div class="myfloat">
    Tips:<br><p>需要输入标题、主体，主题部分必须超过50字....</p>
</div>
<div class="container">
    <form action="{{ URL('solution/markdown_save') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="id" value="{{($solution==NULL)?'':$solution->id}}" />
    <div style="text-align: right;margin: 5px 0;">
        <input id="btn_save" class="btn btn-success" type="submit" value="保 存">
    </div>
    <div class="input-group" style="margin-bottom: 5px;">
        <span class="input-group-addon" id="sizing-addon2">标题：</span>
        <input name="title" type="text" class="form-control" placeholder="标题" aria-describedby="sizing-addon2" value="{{($solution==NULL)?'':$solution->solution_name}}">
    </div>
    <div class="input-group" style="margin-bottom: 5px;">
         <span class="input-group-addon" id="sizing-addon2">分类：</span>
        <select name="solution_classify" id="solution_classify" style="height: 28px;max-width: 40%;border: 1px solid #ddd;padding: 0 5px;">
            <option value="mobile">移动问题集</option>
            <option value="1">PC审批</option>
        </select>
    </div>
    <div class="editor" style="margin: 2px auto;">
        <textarea name="content" id='myEditor'>{{($solution==NULL)? '':$solution->solution_content}}</textarea>
    </div>
    </form>
</div>

<script type="text/javascript">
    $(function(){
        $("#btn_save").unbind("click").bind("click", function () {
            if($.trim($("input[name='title']").val()).length==0 || $.trim($("textarea[name='content']").val()).length<50)
            {
                alert("提交数据不完整哦...");
                return false;
            }
        });
    });
</script>

