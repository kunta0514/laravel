<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2016/3/1
 * Time: 11:15
 */

return [
    'task_tabs' => [//任务tab
        0 => '待处理',
        1 => '进行中',
        2 => '已完成',
        3 => '全部'
    ],
    'task_status' => [//任务状态
        0 => '待处理',
        1 => '开发中',
        2 => '测试中',
        3 => '已完成',
        4 => '项目终止'
    ],
    'work_type' => [//工作类型
        0 => '开发',
        1 => '测试'
    ],
    'ekp_task_type' => [//任务类型
        0 => 'BUG',
        1 => '需求',
        2 => '修复',
        3 => '内部',
        4 => '产品',
        5 => '专项',
        6 => '疑难',
        7 => '咨询'
    ],
    'task_type' => [//任务类型
        0 => '需求',
        1 => '产品BUG',
        2 => '项目BUG',
    ],
    'user_type' => [ //用户类型
        0 => '开发',
        1 => '测试',
    ],
    'customer_level' => [ //用户类型
        0 => '一般客户',
        10 => '项目重点客户',
        20 => '移动重点客户',
        30 => '区域重点客户',
    ],
    'customer_source' => [ //同步来源
        0 => '工作流源码库',
        1 => 'EKP配置库',
        2 => '移动配置库',
    ],
    'customer_update_type' => [ //升级类型
        0 => '未升级',
        1 => '标准更新包升级',
        2 => '手工包升级',
    ],
    'customized_key' => [
        '工作流',
        '审批',
        //'微助手',
        '流程',
        '电子签章'
    ],
    'common_urls' => [ //常用链接
        '客户配置管理' => 'http://pd.mysoft.net.cn/ConfigManage/ConfigLibList.aspx',
        '需求列表' => 'http://pd.mysoft.net.cn/Requirement/MyPendingList.aspx?DataMode=Card',
        '知识库' => 'http://km.mysoft.net.cn:8111/CodeKnowledge/List.aspx',
        '老系统' => 'http://10.5.10.38:53537/Task/ActiveTask.aspx',
        '移动小工具' => '/solution/mobile',
        '工作流FAQ' => '/solution/faq',
    ],
];