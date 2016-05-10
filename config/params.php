<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2016/3/1
 * Time: 11:15
 */

return [
    'task_tabs' =>[//任务tab
        0 => '待处理',
        1 => '进行中',
        2 => '已完成',
        3 => '全部'
    ],
    'task_status' =>[//任务状态
        0 => '待处理',
        1 => '开发中',
        2 => '测试中',
        3 => '已完成',
        4 => '全部'
    ],
    'work_type'=>[//工作类型
        0=>'开发',
        1=>'测试'
    ],
    'task_type'=>[//任务类型
        0=>'BUG',
        1=>'需求',
        2=>'修复',
        3=>'内部',
        4=>'产品',
        5=>'专项',
        6=>'疑难',
        7=>'咨询'
    ],
    'user_type'=>//用户类型
        [
            0=>'开发',
            1=>'测试',
        ],
    'customized_key'=>[
        '工作流',
        '审批',
        //'微助手',
        '流程',
        '电子签章'
    ],
    'common_urls'=>//常用链接
    [
        '客户配置管理'=>'http://pd.mysoft.net.cn/ConfigManage/ConfigLibList.aspx',
        '需求列表'=>'http://pd.mysoft.net.cn/Requirement/MyPendingList.aspx?DataMode=Card',
        '知识库'=>'http://km.mysoft.net.cn:8111/CodeKnowledge/List.aspx',
        '老系统'=>'http://10.5.10.38:53537/Task/ActiveTask.aspx',
        '移动小工具'=>'/solution/mobile',
        '工作流FAQ'=>'/solution/faq',
    ],
];