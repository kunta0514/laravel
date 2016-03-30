<link href="{{asset('vendor/css/tag.css')}}" rel="stylesheet">
{{--<div class="modal-backdrop fade in"></div>--}}


<div class="modal fade in" aria-hidden="false">
    <div class="modal fade in" aria-hidden="false">
        <div class="tags-view card col-flex modal-dialog">
            <header class="tag-header"><b>标签</b> <a class="close-handler icon icon-remove" data-dismiss="modal"></a>
            </header>
            <section class="tag-body row-flex">
                <aside class="tag-left">
                    <div class="left-header second-header">
                        {{--TODO：事件绑定的结构是如何需要研究下--}}
                        <a class="tag-creator-handler link-add-handler" data-gta="{action: 'add content', type: 'tag', control: 'New Tag'}">
                            <span class="icon icon-circle-cross"></span>新标签 </a>
                    </div>
                    <ul class="tag-list thin-scroll hack-render-bug">
                        <li class="tag-item active" data-id="56fa3c5b601e42414cb3dd7e">
                            <a class="tag tag-handler" data-gta="{action: 'open detail', type: 'tag', control: 'Tag List'}">
                                <span class="tag-label tag-label-blue"></span>
                                <span class="tag-name">还有个标签</span> </a>
                            <a class="tag-menu-toggler icon icon-chevron-down hinted" data-title="更多操作"></a>
                        </li>
                        <li class="tag-item" data-id="56fa3c2260dec14b4c47f7b3">
                            <a class="tag tag-handler" data-gta="{action: 'open detail', type: 'tag', control: 'Tag List'}">
                                <span class="tag-label tag-label-red"></span>
                                <span class="tag-name">呵呵，新标签</span>
                            </a>
                            <a class="tag-menu-toggler icon icon-chevron-down hinted" data-title="更多操作"></a>
                        </li>
                    </ul>
                </aside>
                <section class="tag-right">
                    <div class="right-header second-header">
                        <div class="tag-detail" data-id="56fa3c5b601e42414cb3dd7e">
                            <span class="tag">
                                <span class="tag-label tag-label-blue"></span>
                                <span class="tag-name">还有个标签</span>
                            </span>
                            <a class="tag-info " data-target=".tag-tasks-view">1 项任务</a>，
                            <a class="tag-info disabled" data-target=".tag-events-view">0 个日程</a>，
                            <a class="tag-info disabled" data-target=".tag-posts-view">0 篇分享</a>，
                            <a class="tag-info disabled" data-target=".tag-works-view">0 个文件</a>
                        </div>
                    </div>
                    <div class="tag-content-wrap thin-scroll">
                        <div class="tag-tasks-view fade in" style="">
                            <h3>任务 ・ <span class="tasks-count">1</span></h3>
                            <ul class="task-list">
                                <li class="task" data-id="563c4824f3e08dae552f4747">
                                    <div class="task-priority task-priority-1"><a class="task-priority-hint"></a></div>
                                    <a class="check-box" data-gta="event" data-label="task|check task">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set" data-id="563c4824f3e08dae552f4747" data-gta="event"
                                         data-label="task|open task detail">
                                        <div class="avatar img-circle img-24 no-avatar"></div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content"> 【佛山碧桂园】成本系统【审批流程优化】需求单v1.0
                                                {{--TODO::循环标签库，点击后展开标签对应任务--}}
                                                <a class="task-tag" data-tag="tasklist"> #任务 </a>
                                                <span class="label tag">
                                                    <span class="tag-label tag-label-red"></span>
                                                    <span class="tag-name">呵呵，新标签</span>
                                                </span>
                                                <span class="label tag">
                                                    <span class="tag-label tag-label-blue"></span>
                                                    <span class="tag-name">还有个标签</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tag-events-view fade" style="display: none;">
                            <h3>日程 ・ <span class="events-count">0</span></h3>
                            <ul class="events-list">
                                <div class="event-placeholder placeholder muted">
                                    <a class="icon icon-calendar"></a> <br> 目前还没有日程
                                </div>
                            </ul>
                        </div>
                        <div class="tag-posts-view fade" style="display: none;">
                            <h3>分享 ・ <span class="posts-count">0</span></h3>
                            <ul class="post-list-view"></ul>
                        </div>
                        <div class="tag-works-view fade" style="display: none;">
                            <h3>文件 ・ <span class="works-count">0</span></h3>
                            <ul class="work-list-view"></ul>
                        </div>
                        <div class="tag-entries-view fade" style="display: none;">
                            <h3>账目 ・ <span class="entries-count">0</span></h3>
                            <ul class="tag-entries-list"></ul>
                        </div>
                    </div>
                    <div class="placeholder" style="display: none;">
                        <h3>项目中还没有标签</h3>
                        <p> 你可以通过“新标签”按钮来创建标签。此后，就可以在在这里按照标签来查看项目内容了。 </p>
                    </div>
                </section>
            </section>
        </div>
    </div>

</div>

