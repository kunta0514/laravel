@extends('templates.reportnav')
@section('content')
<!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
<div id="main" style="width:100%;height:550px;"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var page_data=<?=$page_data?>;
    var customer_data=page_data.data;
    var customer_names= $.map(customer_data,function(item){
        return item.cname;
    });
    var abubug= $.map(customer_data,function(item){
        return item.abubug;
    });
    var selfbug=$.map(customer_data,function(item){
        return item.selfbug;
    });
    var demand=$.map(customer_data,function(item){
        return item.demand;
    });
    var task_type=Array('需求','产品BUG','项目BUG');
    option = {
        title:{
            text:(new Date()).getFullYear()+"年度 TOP 10 活跃客户数据",
            subtext: '数据来自任务系统',
        },
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            },
        },
        legend: {
            data:task_type,
            right:'12%'
        },
        grid: {
            containLabel: true,
            top:80,
        },
        xAxis : [
            {
                type : 'category',
                data : customer_names
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'需求',
                type:'bar',
                data:demand
            },
            {
                name:'产品BUG',
                type:'bar',
                stack: '产品BUG',
                data:selfbug
            },
            {
                name:'项目BUG',
                type:'bar',
                stack: '项目BUG',
                data:abubug
            }
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>

@stop
