

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    cache: false,
    error: function (jqXHR, textStatus, errorThrown) {
        switch (jqXHR.status) {
            case(500):
                $.toast("服务器系统内部错误","error");
                break;
            case(401):
                $.alert('您登陆超时或者无权访问该页，点击"确定"返回登陆页面。', function () {
                    window.location.reload();
                });
                break;
            case(403):
                $.alert('无权限执行此操作，点击"确定"返回登陆页面。', function () {
                    window.location.reload();
                });
                break;
            case(408):
                $.alert('请求超时，点击"确定"返回登陆页面。', function () {
                    window.location.reload();
                });
                break;
            case(302):
                //var Redirect = jqXHR.getResponseHeader("X-Redirect");
                $.loader('hide');
                $.alert('您登陆超时或者无权访问该页，点击"确定"返回登陆页面。',function() {
                    window.location.reload();
                });
                break;
            case (203):
                //var Redirect = jqXHR.getResponseHeader("X-Redirect");
                $.loader('hide');
                $.alert('您登陆超时或者无权访问该页，点击"确定"返回登陆页面。', function () {
                    window.location.reload();
                });
                break;
            case (0):
                break;
            default:
                $.toast("请求超时","error");
        }
    }
});
