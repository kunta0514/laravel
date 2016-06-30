<style type="text/css">
    label{
        font-weight: 600;
        font-size: 16px;
        margin-left: 7px;
        color: #555;
    }
</style>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="id" id="id" value={{$demand->id}}>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <i class="fa fa-list-ul "></i>
                    <label for="demand_name">需求</label>
                    <textarea class="form-control" rows="5" placeholder="@if(empty($demand->demand_name)) 请输入需求、故事描述... @else {{$demand->demand_name}} @endif" name="demand_name" id="demand_name">{{$demand->demand_name}}</textarea>
                </div>
                <div class="form-group">
                    <i class="fa fa-list-ul "></i>
                    <label for="acceptance">验收标准</label>
                    <textarea class="form-control" placeholder="@if(empty($demand->acceptance)) 请输入验收标准... @else {{$demand->acceptance}} @endif" name="acceptance" id="acceptance">{{$demand->acceptance}}</textarea>
                </div>
                <div class="form-group">
                    <label for="comment">评论</label>
                    <textarea class="form-control" placeholder="@if(empty($demand->comment)) 请输入备注、评论... @else {{$demand->comment}} @endif" name="comment" id="comment">{{$demand->comment}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            {{--<div class="col-sm-12">--}}
                {{--<div class="form-group">--}}
                    {{--<label for="select_status" class="control-label">状态</label>--}}
                    {{--<div>--}}
                        {{--<select class="form-control" id="select_status" name="status">--}}
                            {{--@foreach(Config('params.task_status') as $key=>$value)--}}
                                {{--<option value="{{$key}}" @if ($key === $demand->status) selected @endif>{{$value}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="select_status">状态</label>
                    <div>
                        <select class="form-control" id="select_status" name="status">
                            @foreach(Config('params.task_status') as $key=>$value)
                                <option value="{{$key}}" @if ($key === $demand->status) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="col-sm-6">
                <div class="form-group">

                    <label for="PRI">优先级</label>
                    <div >
                        <input type="number" id="PRI" class="form-control" placeholder="请输入.." value="{{$demand->PRI}}">
                    </div>
                </div>

            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="PRI">Sprint</label>
                    <div>
                        <input type="text" id="Sprint" class="form-control" placeholder="请输入.." value="{{$demand->sprint_name}}">
                    </div>
                </div>
            </div>
        </div>

    </form>
</div><!-- /.modal-content -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消
    </button>
    <button type="button" class="btn btn-primary" id="btnSubmit" data-ok="modal">
        确定
    </button>
</div>

<script type="text/javascript">
    $('#btnSubmit').on('click',function(){
        var demand = {
            demand_name:$('#demand_name').val(),
            acceptance:$('#acceptance').val(),
            comment:$('#comment').val(),
            status:$('#select_status').val()
        };
        console.log($('#id').val());
        //TODO::收集页面元素校验
        $.ajax({
            type: 'POST',
            data: demand,
            url: '/demand/update/'+ $('#id').val(),
            success: function (data) {
//                console.log(data);
//                location.reload();
            }
        })
    });
</script>