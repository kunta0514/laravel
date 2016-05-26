<title>Tools-移动审批</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
    .panle4Check
    {
        width: 100%;
    }
    .border_r_1
    {
        border-right: 1px solid #ddd;
        width: 100px;
    }
    .panle4Check h4
    {
        margin: 0;
    }
    .version,.remark,.result
    {
        font-size: 14px;;
    }
    .my_alert
    {
        padding: 10px;
        font-size: 14px;;
        margin-bottom: 0;
        text-align: left;
    }
    div[name=history_tasks] li,div[name=history_tasks] li:hover,div[name=history_tasks] li:focus,div[name=version] li,div[name=code_lib] li
    {
        font-size: 13px;
        width: 100%;
        border-bottom: 1px solid #ddd;
        padding: 3px 0;
    }

    .solution_list
    {
        width: 100%;
        margin-top: 10px;
    }

    .my_image
    {
        overflow-x: hidden;
    }
    .my_image img
    {
        width: 99%;
        max-width: 99%;

    }
</style>
<script type="text/javascript">
    $(function(){
        //检测按钮 事件绑定
        $("#btnCheck").unbind("click").bind("click",function(){
            var customer_name= $.trim($("#customer_name").val());
            if(customer_name.length==0)
            {
                $("div[name='divalert']").show();
                return;
            }
            $("div[name='divalert']").hide();
            $("div[name='check_process_bar']").show();
            //异步请求
            $.get("/solution/mobile/check", { customer_name: customer_name },function(data){
                var Json_data=eval("("+data+")");
                $("#current_id").val(Json_data.id);
//                console.info(Json_data);
                $("div.panle4Check h4").html(Json_data.customer_name+" <small>"+Json_data.alias+"</small>");

                if(Json_data.result==1)
                {
                    $("div[name='result']").attr("class","").attr("class","alert alert-success my_alert");
                    $("div[name='result']").html("可以直接使用更新标准包...")
                }else if(Json_data.result==0)
                {
                    $("div[name='result']").attr("class","").attr("class","alert alert-danger my_alert");
                    $("div[name='result']").html("需要升级任务给工作流团队...")
                }else{
                    $("div[name='result']").attr("class","").attr("class","alert alert-warning my_alert");
                    $("div[name='result']").html("臣妾判断不出来...")
                }
                var version=$("div.version");
                version.html("");
                $.each(Json_data.version_list,function(n,value){
                    version.append($("<li></li>").html( value));
                });
                var code_lib=$("div.code_lib");
                code_lib.html("");
                $.each(Json_data.code_lib,function(n,value){
                    code_lib.append($("<li></li>").html(value.project_name+"("+value.workflow_version+")"));
                });
                var history_tasks=$("div[name='history_tasks']");
                history_tasks.html("");
                $.each(Json_data.task_list,function(n,value){
                    history_tasks.append($("<li></li>").html("<a target='_blank' href='"+value.url+"'>"+value.name+"</a>"));
                });
                $("span.remark").html(Json_data.message);
                $("div[name='check_process_bar']").hide();
            } );
        });

        $(document).on("keypress", '#customer_name', function (e) {
            if (e.keyCode == "13") {
                $("#btnCheck").click();
            }
        });
        //
        $("input[name='is_valid']").on('click',function(){
            $(this).attr("is_check")=="true"?$(this).attr("is_check","false"):$(this).attr("is_check","true")
        });

        //搜索按钮 事件绑定
        $("#btnSearch").unbind("click").bind("click",function(){
            var txtSearch= $.trim($("#txtSearch").val());
            $.get("/solution/mobile/search", { KeyValue: txtSearch },function(data){
                console.info(data);
            } );
        });

        //反馈按钮点击事件
        $("button[name='btn_feedback']").on("click",function(){
            var data=new Object();
            data.id=$("#current_id").val()==""?0:$("#current_id").val();
            data.result=$("input[name='is_valid']").attr("is_check");
            console.info(data);
//            alert("4323");
        });
    });
    function oprClick_title(obj)
    {
        $("#myModalLabel").html($(obj).attr("s_title"));
        $("div.modal-body").html($(obj).attr("rel"));
    }
</script>

<div class="container">
    <div class="page-header">
        <h1><span class="glyphicon glyphicon-queen"></span>小工具<small> By Wonder4</small></h1>
    </div>
    <div class="row">
        <input type="hidden" name="current_id" id="current_id">
        <div class="col-lg-5" style="border-right: 1px dotted #ddd">
            <div class="input-group">
                <input id="customer_name" type="text" class="form-control" placeholder="客户名称...">
          <span class="input-group-btn">
            <button id="btnCheck" class="btn btn-default" type="button">个性化检测</button>
          </span>
            </div><!-- /input-group -->
            <div name="divalert" class="alert alert-danger" role="alert" style="margin-bottom: 0;margin-top: 5px;padding: 5px 15px;display: none">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                请输入客户名称！
            </div>
            <div name="check_process_bar" class="progress" style="margin: 5px 0;display: none">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
            <div class="panel panel-default" style="margin-top: 8px;">
                <div class="panel-body panle4Check">
                    <h4>客户名称 <small>客户名称</small></h4>
                </div>
                <!-- Table -->
                <table class="table">
                    <tr class="hidden1">
                        <td class="border_r_1"><h5>结果：</h5></td>
                        <td><div name="result" class="alert alert-success my_alert hidden" role="alert"></div></td>
                    </tr>
                    <tr>
                        <td class="border_r_1"><h5>ERP信息：</h5></td>
                        <td><div name="version" class="version"></div></td>
                    </tr>
                    <tr>
                        <td class="border_r_1"><h5>WF代码库：</h5></td>
                        <td><div name="code_lib" class="code_lib"></div></td>
                    </tr>
                    <tr>
                        <td class="border_r_1"><h5>历史任务：</h5></td>
                        <td><div name="history_tasks" ></div></td>
                    </tr>

                    <tr>
                        <td class="border_r_1"><h5>备注：</h5></td>
                        <td><span class="remark"></span></td>
                    </tr>
                    <tr class="hidden">
                        <td class="border_r_1"><h5>反馈：</h5></td>
                        <td class="checkbox">
                            <label>
                                <input type="checkbox" name="is_valid" is_check="false">是否有效
                            </label>
                            <button name="btn_feedback" type="button" class="btn btn-default" style="float: right;">提交</button>
                        </td>
                    </tr>
                </table>
                <!-- Table -->
            </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-7 hidden">
            <div class="input-group">
                <input id="txtSearch" type="text" class="form-control" placeholder="输入问题关键字,逗号分隔...">
          <span class="input-group-btn">
            <button id="btnSearch" class="btn btn-default" type="button">Go!</button>
          </span>
            </div><!-- /input-group -->
            <div class="solution_list">
                <ul class="list-group">
                    @foreach($solution_list as $key=>$value)
                        <li class="list-group-item">
                            <span class="badge">x</span>
                            <span class="label label-success">{{$value->solution_label}}</span>
                            <a href="#" rel="{{$value->Html}}" data-toggle="modal" data-target="#myModal" onclick="oprClick_title(this)" s_title="{{$value->solution_title}}">{{$value->solution_title}}</a>
                        </li>
                    @endforeach
                    <?php //var_dump($solution_list) ?>
                </ul>
                <?php echo '共有: '.$solution_list->total().' 条记录,当前页显示: '.$solution_list->count().' 条';?>
            </div>
            <?php echo $solution_list->render(); ?>
        </div><!-- /.col-lg-8 -->
        <div class="col-lg-7">
                <fieldset>
                    <legend>Tips:</legend>
                    <div class="jumbotron">
                        <p style="font-size: 16px;line-height: 28px;">
                            ①从<font color="red">历史任务</font>和<font color="red">工作流代码库</font>两个维度来分析该客户是否有个性化。<br>
                            ②输入客户名称关键字可以提高准确度，比如：重庆东原，输入"东原"...</p>
                    </div>
                </fieldset>
            <div class="">
                <fieldset>
                    <legend>盖包注意事项:</legend>
                    <div class="jumbotron">
                        <p style="font-size: 16px;line-height: 28px;">
                            ①ERP301以下（不包含301）版本，项目组需要编译MyWorkflow项目<br/>
                            ②本次更新<font color="red">有新增文</font>，需要使用编辑器将新增文件包含到项目中再编译<br>
                            ③<font color="red">强烈建议</font>:先停用ERP再更新此更新包，是有血的教训的<br>
                            ④<font color="red">检查</font>是否配置小平台，请移步<a href="http://km.mysoft.net.cn:8111/CodeKnowledge/Detail-3cba059c-82d3-476e-8c22-adda1c248ec4.aspx">小平台ajax配置</a>
                            </p>
                    </div>
                </fieldset>
            </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade my_image bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>