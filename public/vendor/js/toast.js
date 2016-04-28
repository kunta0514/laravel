/**
 * toast.js
 **/
/**
 * 参数说明：
 * @param {string} position 'top center' 显示位置，可选top,left,right,center,bottom,bottom,middle,默认为center middle,可省略写
 * @param {string} type 'info' 提示类型，可选success,info,warning,error
 * @param {int} timeout 3000 自动隐藏时间
 * @param {boolean} closeOnClick true 是否允许点击自己控制弹出框关闭
 * @param {string} text  ''  弹出框显示文字
 *
 * 示例：
 *  $.toast("自定义消息");
 *  $.toast("提交成功", "success");
 *  $.toast("提交成功", "success", "bottom center");
 *  $.toast({
 *      text: '自定义文案',
 *      type: 'danger',
 *      position: 'top left'
 *  });

 * 1.可直接调用$.toast('字符串');改变提示文字
 * 2.可调用$.toast().show();$.toast().hide();手动控制提示框显示和消失
 * $.toast({text:'button topright warning',type:'warning',position:'top right'}).show();
 * $.toast().hide();
**/

! function($) {
    "use strict";

    var template = '<div class=" toast"><h5 class="toast_text msg-con"></h5><s class="msg-icon"></s></div>';

    var Toast = function(options) {
        var $toast = null;
        if (typeof options === typeof 'a') {
            this.options = $.extend({}, this.defaults);
            this.options.text = options;
            if (arguments[2]) {
                this.options.position = arguments[2];
            }
            if (arguments[1]) {
                this.options.type = arguments[1];
            }

        } else {
            this.options = $.extend({}, this.defaults, options);
        }
        return this.render();
    };

    Toast.prototype = {
        Constructor: Toast,
        render: function() {
            var options = this.options;
            var message = ".toast";
            var text = ".toast_text";
            var cssPrefix = "toast-";
            $(message).remove();
            this.el = $(template);
            this.el.appendTo(document.body);
            $(text).html(options.text);
            options.position.replace(/(\S+)/g, cssPrefix);
            this.el.addClass(options.position).addClass(cssPrefix + options.type);
            this.show();
             if(options.closeButton){
               this.el.addClass('show-close-btn');
             }
            if (options.closeOnClick) {
                this.el.click($.proxy(this.hide, this));
            }
        },
        hide: function(callback) {
            var self = this.el;
            if (!$.support.transition) {
                self.animate({ 'opacity': '0' }, 500, function() {
                    self.removeClass('toast-in');
                });
            } else {
                self.removeClass('toast-in');
            }
            setTimeout(function() { self.remove() }, 1000);
        },
        show: function(duration, callback) {
            var classes = this.el.attr("class");
            var vertical = this.el.hasClass('top') && "top" || this.el.hasClass('bottom') && "bottom" || "middle";
            var horizontal = this.el.hasClass('left') && "left" || this.el.hasClass('right') && "right" || "center";
            if (horizontal == "center") {
                var mlwidth = -(this.el.outerWidth() / 2);
                this.el.css("margin-left", mlwidth + "px");
            }
            if (vertical == "middle") {
                var mtheight = -(this.el.height() / 2);
                this.el.css("margin-top", mtheight);
            }
            var addclass = function() {
                var self = this.el;
                if(!$.support.transition){
                    self.animate({'opacity':'1'},500,function(){
                        self.addClass('toast-in');
                    });
                }else{
                    self.addClass('toast-in');
                }
            };

            setTimeout($.proxy(addclass, this));
            setTimeout($.proxy(this.hide, this), this.options.timeout);
        }
    };

    var old = $.toast;
    $.extend({
        toast : function (arg1, arg2, arg3) {
        return new Toast(arg1, arg2, arg3);
        }
    });

    Toast.prototype.defaults = {
        position: 'top center',
        type: 'info',
        // speed: 500,
        timeout: 3000,
        // closeButton: false,
        closeOnClick: true,
        text: ''
    };

    $.toast.Constructor = Toast;

    $.toast.noConflict = function() {
        $.toast = old;
        return this;
    };

}(window.jQuery);
