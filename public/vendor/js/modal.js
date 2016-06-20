/* jshint laxcomma: true */
/* ========================================================================
 * Bootstrap: modal.js v3.3.1
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */
/*


 方法
 .modal(options)
 将页面中的某块内容作为模态框激活。接受可选参数object.
 $('#myModal').modal({ keyboard: false })
 .modal('toggle')

 手动打开或关闭模态框。在模态框显示或隐藏之前返回到调用函数中（也就是，在触发 shown.bs.modal 或 hidden.bs.modal 事件之前）。
 $('#myModal').modal('toggle')
 .modal('show')

 手动打开模态框。在模态框显示之前返回到调用函数中 （也就是，在触发 shown.bs.modal 事件之前）。
 $('#myModal').modal('show')
 .modal('hide')

 手动隐藏模态框。在模态框隐藏之前返回到调用函数中 （也就是，在触发 hidden.bs.modal 事件之前）。
 $('#myModal').modal('hide')
 .modal('okHide')

 手动关闭弹层并触发okHide逻辑. 在模态框隐藏之前返回到调用函数中 (i.e. before the hidden event occurs).
 $('#myModal').modal('okHide')
 .modal('handleUpdate')

 执行一次自适应。用于弹层高度发生变化时。(当浏览器窗口resize时会自动自适应)
 $('#myModal').modal('handleUpdate')

 事件：

 show  当show实例方法被调用时，事件会立即执行. 如果是通过click事件调用的，click的那个元素的relatedTarget属性将是可用的
 shown 这个事件将会在模态框对用户可见时被调用（css动画结束后）如果是通过click事件调用的，click的那个元素的relatedTarget属性将是可用的
 hide  事件将在hide实例方法被调用后执行.
 hidden  事件会在模态框对用户不可见（css动画结束）后调用
 okHide  事件会在调用了hide 实例方法后执行.其他不变，不过是点击了“确认”按钮时执行的回调，返回false可阻止弹层关闭
 okHidden  事件在模态框对用户不可见（css动画结束）后执行，点击“确认”按钮后弹层已经关闭后的回调
 loaded  new 事件将会在模态框使用 remote 参数加载完内容后被调用
 */

+ function($) {
    'use strict';
    //移除boostrap对modal按钮的事件代理
    $(document).off('click', '[data-toggle="modal"]');

    $.template = _.template;
    // MODAL CLASS DEFINITION
    // ======================

    var Modal = function(element, options) {
        this.options = options;
        this.$body = $(document.body);
        if (element === null) {
            // 下行表示该对话框是静态方法调用生成的
            this.isStaticInvoke = true;
            element = $(Modal.COMPILEDTPL({
                title: options.title,
                body: options.body,
                id: options.id,
                okbtn: options.okbtn,
                cancelbtn: options.cancelbtn
            }));
            this.$body.append(element)
        }
        this.$element = $(element);
        this.$backdrop = null;
        this.isShown = null;
        this.scrollbarWidth = 0;
        // 初始化options参数差异
        this.initOptions();
    };

    Modal.COMPILEDTPL = $.template('' + '<div class="modal fade " tabindex="-1" role="dialog"  id="<%=id%>">' + '<div class="modal-dialog">' + '<div class="modal-content">' + '<div class="modal-header">' + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + '<h5 class="modal-title"><%=title%></h5>' + '</div>' + '<div class="modal-body"><%=body%></div>' + '<div class="modal-footer">' + '<button type="button" class="btn btn-default" data-dismiss="modal"><%=cancelbtn%></button>' + '<button type="button" class="btn btn-primary" data-ok="modal"><%=okbtn%></button>' + '</div>' + '</div>' + '</div>' + '</div>');
    Modal.TRANSITION_DURATION = 300;
    Modal.BACKDROP_TRANSITION_DURATION = 150;

    Modal.prototype = {

        // 初始化options参数差异
        initOptions: function() {
            var self = this,
                $ele = this.$element,
                $dialog = $ele.find('.modal-dialog'),
                options = this.options,
                optWidth = options.width;
		   // (options.remote)  && (options.transition = false);
            // 设置是否加过渡动画
            !options.transition && $ele.removeClass('fade');
            // 是否显示关闭按钮
            !options.closebtn && $dialog.find('.close').remove();
            // 是否显示取消按钮
            !options.cancelbtn && $dialog.find('.modal-footer .btn-default').remove();
            // 设置是否指定宽度类型
            if (optWidth) {
                var widthMap = {
                    small: 'modal-sm',
                    large: 'modal-lg',
                    normal: ''
                };
                if (widthMap[optWidth]) {
                    $dialog.removeClass('modal-sm modal-lg').addClass(widthMap[optWidth])
                } else {
                    $dialog.width(optWidth)
                }
            }
            if (options.minHeight) {
                $ele.find('.modal-body').css('min-height', options.minHeight)
            }
            // 是否显示脚部
            !options.hasfoot && $dialog.find('.modal-footer').remove();
            // 加载远端内容
            if (options.remote) {
                $ele.find('.modal-content')
                .load(this.options.remote, $.proxy(function() {
                    $ele.trigger('loaded');
                    var fn = this.options.loaded;
                    typeof fn == 'function' && fn.call(this);
                    if (options.height) {
                        $ele.find('.modal-body').css({ overflow: 'auto', height: options.height });
                    }
                    if(options.remote && typeof $.fn.loader == 'function'){
                		$ele.find('.modal-body').loader('hide');
                	  }
                     //if (!$.support.transition || !this.options.transition) {
                         //self.handleUpdate();
                     //}
                    self.handleUpdate();
                }, this))
            }
        },

        show: function(_relatedTarget) {
            var self = this;
            var e = $.Event('show', { relatedTarget: _relatedTarget });
            this.$element.trigger(e);
            if (this.isShown || e.isDefaultPrevented()) return;
            this.isShown = true;
            this.checkScrollbar();
            this.setScrollbar();
            this.$body.addClass('modal-open');
            this.escape();
            this.resize();

            // 分发okHide okHidden cancelHide cancelHidden事件
            this.$element.on('click.dismiss', '[data-dismiss="modal"]', $.proxy(this.hide, this)).on('click.ok', ':not(.disabled)[data-ok="modal"]', $.proxy(this.okHide, this));

            this.backdrop(function() {
                var transition = $.support.transition && self.$element.hasClass('fade');

                if (!self.$element.parent().length) {
                    self.$element.appendTo(self.$body); // don't move modals dom position
                }

                self.$element
                    .show()
                    .scrollTop(0);

                if (self.options.backdrop) self.adjustBackdrop();
                self.selfAdapt();

                if (transition) {
                    self.$element[0].offsetWidth; // force reflow
                }

                self.$element
                    .addClass('in')
                    .attr('aria-hidden', false);

                self.enforceFocus();

                if(self.options.remote && typeof $.fn.loader == 'function'){
                	self.$element.find('.modal-body').loader();
                }

                var e = $.Event('shown', { relatedTarget: _relatedTarget });

                function callbackAfterTransition() {
                    self.$element.trigger('focus').trigger(e);
                    if (self.options.timeout > 0) {
                        self.timeid = setTimeout(function() {
                            self.hide();
                        }, self.options.timeout)
                    }
                }

                transition ?
                    self.$element.find('.modal-dialog') // wait for modal to slide in
                    .one('bsTransitionEnd', function() {
                        callbackAfterTransition()
                    })
                    .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
                    callbackAfterTransition()

            });
            return self.$element
        },

        hide: function(e) {
            if (e) e.preventDefault();
            var $ele = this.$element;

            e = $.Event('hide');

            // 不需要显示trigger('okHide') okHide回调会在this.okHide方法里被调用.注意此时e.type不是okHide而是click
            this.hideReason != 'ok' && $ele.trigger('cancelHide');
            $ele.trigger(e);

            if (!this.isShown || e.isDefaultPrevented()) return;

            this.isShown = false;

            this.escape();
            this.resize();

            $(document).off('focusin');

            $ele
                .removeClass('in')
                .attr('aria-hidden', true)
                // 注销事件
                .off('click.dismiss click.ok');

            $.support.transition && $ele.hasClass('fade') ?
                $ele
                .one('bsTransitionEnd', $.proxy(this.hideModal, this))
                .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
                this.hideModal()
        },

        // 不需要显示trigger('okHide') okHide回调会在this.okHide方法里被调用.注意此时e.type不是okHide而是click
        okHide: function(e) {
            var self = this;

            function hideWithOk() {
                self.hideReason = 'ok';
                self.hide(e)
            }

            // 如果e为undefined而不是事件对象，则说明不是点击确定按钮触发的执行，而是手工调用，
            // 那么直接执行hideWithOk
            if (!e) {
                hideWithOk();
                return
            }

            var fn = this.options.okHide,
                // 点击弹层脚部的确定后是否关闭弹层，默认关闭
                ifNeedHide = true;
            if (!fn) {
                var eventArr = $._data(this.$element[0], 'events').okHide;
                if (eventArr && eventArr.length) {
                    fn = eventArr[eventArr.length - 1].handler;
                }
            }

            typeof fn == 'function' && (ifNeedHide = fn.call(this, e));
            // 显式返回false，则不关闭对话框
            if (ifNeedHide !== false) {
                hideWithOk();
            }

            return this.$element
        },

        enforceFocus: function() {
            $(document)
                .off('focusin') // guard against infinite focus loop
                .on('focusin', $.proxy(function(e) {
                    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                        this.$element.trigger('focus');
                    }
                }, this))
        },

        escape: function() {
            if (this.isShown && this.options.keyboard) {
                this.$element.on('keydown.dismiss', $.proxy(function(e) {
                    e.which == 27 && this.hide()
                }, this))
            } else if (!this.isShown) {
                this.$element.off('keydown.dismiss');
            }
        },

        resize: function() {
            if (this.isShown) {
                $(window).on('resize', $.proxy(this.handleUpdate, this))
            } else {
                $(window).off('resize')
            }
        },

        hideModal: function() {
            var self = this,
                $ele = this.$element;
            $ele.hide();
            this.backdrop(function() {
                if($('.modal.in').length < 1){
                    self.$body.removeClass('modal-open');
                }
                self.resetAdjustments();
                self.resetScrollbar();

                $ele.trigger(self.hideReason == 'ok' ? 'okHidden' : 'cancelHidden');
                self.hideReason = null;
                $ele.trigger('hidden');

                // 销毁静态方法生成的dialog元素 , 默认只有静态方法是remove类型
                self.isStaticInvoke && $ele.remove()

            })
        },

        removeBackdrop: function() {
            this.$backdrop && this.$backdrop.remove();
            this.$backdrop = null
        },

        backdrop: function(callback) {
            var self = this,
                animate = this.$element.hasClass('fade') ? 'fade' : '',
                doAnimate, bgcolor, bgcolorStyle;
            if (this.isShown && this.options.backdrop) {
                doAnimate = $.support.transition && animate;
                bgcolor = this.options.bgcolor;
                bgcolorStyle = bgcolor == '#000' ? '' : (' style="background:' + bgcolor + ';" ');

                this.$backdrop = $('<div class="modal-backdrop ' + animate + '"' + bgcolorStyle + '/>')
                    .prependTo(this.$element)
                    .on('click.dismiss', $.proxy(function(e) {
                        if (e.target !== e.currentTarget) return;
                        this.options.backdrop == 'static' ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this)
                    }, this));

                if (doAnimate) this.$backdrop[0].offsetWidth;

                this.$backdrop.addClass('in');

                if (!callback) return;

                doAnimate ?
                    this.$backdrop
                    .one('bsTransitionEnd', callback)
                    .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
                    callback()

            } else if (!this.isShown && this.$backdrop) {
                this.$backdrop.removeClass('in');

                var callbackRemove = function() {
                    self.removeBackdrop();
                    callback && callback();
                };
                $.support.transition && this.$element.hasClass('fade') ?
                    this.$backdrop
                    .one('bsTransitionEnd', callbackRemove)
                    .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
                    callbackRemove()

            } else if (callback) {
                callback()
            }
        },

        handleUpdate: function() {
            if (this.options.backdrop) this.adjustBackdrop();
            this.selfAdapt();
        },

        adjustBackdrop: function() {
            this.$backdrop
                .css('height', 0)
                .css('height', this.$element[0].scrollHeight)
        },

        selfAdapt: function() {
            var $ele = this.$element,
                $dialog = $ele.find('.modal-dialog'),
                windowHeight = document.documentElement.clientHeight,
                dialogHeight = $dialog.height(),
                modalIsOverflowing = dialogHeight + 30 > windowHeight;
            // 对话框高度较小则尽量居中定位
            if (!modalIsOverflowing) {
                $dialog.css('margin-top', Math.round((windowHeight - dialogHeight) / 2.618));
            } else {
                $dialog.css('margin-top', 30);
            }

            $ele.css({
                paddingLeft: !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
                paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
            })
        },

        resetAdjustments: function() {
            this.$element.css({
                paddingLeft: '',
                paddingRight: ''
            })
        },

        checkScrollbar: function() {
            this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight;
            this.scrollbarWidth = this.measureScrollbar();
        },

        setScrollbar: function() {
            var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10);
            if (this.bodyIsOverflowing && !$(document.body).hasClass('modal-open')) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
        },

        resetScrollbar: function() {
            if(!$(document.body).hasClass('modal-open')){
                this.$body.css('padding-right', '')
            }
        },

        measureScrollbar: function() { // thx walsh
            var scrollDiv = document.createElement('div');
            scrollDiv.className = 'modal-scrollbar-measure';
            this.$body.append(scrollDiv);
            var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
            this.$body[0].removeChild(scrollDiv);
            return scrollbarWidth
        },

        toggle: function(_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
        }
    };

    // MODAL PLUGIN DEFINITION
    // =======================

    function Plugin(option, _relatedTarget) {
        // this指向dialog元素Dom，
        // each让诸如 $('#qqq, #eee').modal(options) 的用法可行。
        return this.each(function() {
            var $this = $(this),
                data = $this.data('modal'),
                options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option);
            // 这里判断的目的是：第一次show时实例化dialog，之后的show则用缓存在data-modal里的对象。
            if (!data) $this.data('modal', (data = new Modal(this, options)));
            // 如果是$('#xx').modal('toggle'),务必保证传入的字符串是Modal类原型链里已存在的方法。否则会报错has no method。
            if (typeof option == 'string') data[option](_relatedTarget);
            else if (options.show) data.show(_relatedTarget)
        })
    }

    Modal.DEFAULTS = {
        backdrop: false,
        show: true,
        bgcolor: '#000',
        keyboard: false,
        hasfoot: true,
        cancelbtn: true,
        closebtn: true,
        transition: true,
        title:'',
        height: null,
        minHeight: 40,
        width: null
    };

    var old = $.fn.modal;

    $.fn.modal = Plugin;
    $.fn.modal.Constructor = Modal;


    // MODAL NO CONFLICT
    // =================

    $.fn.modal.noConflict = function() {
        $.fn.modal = old;
        return this
    };

    // MODAL DATA-API
    // ==============

    $(document).on('click.data-api', '[data-toggle="modal"]', function(e) {
        var $this = $(this),
            href = $this.attr('href'),
            // $target这里指dialog本体Dom(若存在),通过data-target="#foo"或href="#foo"指向
            $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))), // strip for ie7
            // remote,href属性如果以#开头，表示等同于data-target属性
            option = $target.data('modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data());
        if ($this.is('a')) e.preventDefault();

        $target.one('show', function(showEvent) {
            if (showEvent.isDefaultPrevented()) return; // only register focus restorer if modal will actually get shown
            $target.one('hidden', function() {
                $this.is(':visible') && $this.trigger('focus')
            })
        });
        Plugin.call($target, option, this)
    });

    /* 弹层静态方法，用于很少重复，不需记住状态的弹层，可方便的直接调用，最简单形式就是$.alert('我是alert')
     * 若弹层内容是复杂的Dom结构， 建议将弹层html结构写到模版里，用$(xx).modal(options) 调用
     *
     * example
     * $.alert({
     *  title: '自定义标题'
     *  body: 'html' // 必填
     *  okbtn : '好的'
     *  cancelbtn : '雅达'
     *  closebtn: true
     *  keyboard: true   是否可由esc按键关闭
     *  backdrop: true   决定是否为模态对话框添加一个背景遮罩层。另外，该属性指定'static'时，表示添加遮罩层，同时点击模态对话框的外部区域不会将其关闭。
     *  bgcolor : '#123456'  背景遮罩层颜色
     *  width: {number|string(px)|'small'|'normal'|'large'}推荐优先使用后三个描述性字符串，统一样式
     *  timeout: {number} 1000    单位毫秒ms ,dialog打开后多久自动关闭
     *  transition: {Boolean} 是否以动画弹出对话框，默认为true。HTML使用方式只需把模板里的fade的class去掉即可
     *  hasfoot: {Boolean}  是否显示脚部  默认true
     *  remote: {string} 如果提供了远程url地址，就会加载远端内容,之后触发loaded事件
     *  show:     fn --------------function(e) {}
     *  shown:    fn
     *  hide:     fn
     *  hidden:   fn
     *  okHide:   function(e) {alert('点击确认后、dialog消失前的逻辑,
     *            函数返回true（默认）则dialog关闭，反之不关闭;若不传入则默认是直接返回true的函数
     *            注意不要人肉返回undefined！！')}
     *  okHidden: function(e) {alert('点击确认后、dialog消失后的逻辑')}
     *  cancelHide: fn
     *  cancelHidden: fn
     * })
     *
     */
    $.extend({
        _modal: function(dialogCfg, customCfg) {
            var modalId = +new Date(),
                finalCfg = $.extend({}, Modal.DEFAULTS,
                    dialogCfg, { id: modalId, okbtn: '确定', width: 'small' },
                    (typeof customCfg == 'string' ? { body: customCfg } : customCfg)),
                // 第一个参数传null，使构造函数走TPL组装弹层的逻辑
                dialog = new Modal(null, finalCfg),
                $ele = dialog.$element;

            // 添加各种弹层行为逻辑 监听器
            function _bind(id, eList) {
                var eType = ['show', 'shown', 'hide', 'hidden', 'okHidden', 'cancelHide', 'cancelHidden'];
                $.each(eType, function(k, v) {
                    if (typeof eList[v] == 'function') {
                        $(document).on(v, '#' + id, $.proxy(eList[v], $('#' + id)[0]))
                    }
                })
            }

            _bind(modalId, finalCfg);
            $ele.data('modal', dialog).modal('show');
            // 静态方法对话框返回对话框元素的jQuery对象
            return $ele
        },
        // 为最常见的alert，confirm建立$.modal的快捷方式，
        alert: function(content, title, hidden) {
            var defaults = {
                type: 'alert',
                title: '提示',
                cancelbtn: false,
                keyboard: false
            };
            var tmpTpl = $.template(
                '<div class="dialog_tip">' +
                '<span class="tip_icon info"></span>' +
                '<div class="text"><%=content%></div>' +
                '</div>');
            var config;
            if ($.isPlainObject(content)) {
                config = content;
                config.body = tmpTpl({ content: config.body });
            } else {
                if ($.isFunction(title)) {
                    config = {
                        title: '提示',
                        body: tmpTpl({ content: content }),
                        hidden: title
                    }
                } else {
                    config = {
                        title: title,
                        body: tmpTpl({ content: content }),
                        hidden: hidden
                    };
                }
            }
            return $._modal(defaults, config);
        },
        confirm: function(content, title, okHidden, cancelHidden) {
            var defaults = {
                type: 'confirm',
                title: '提示',
                cancelbtn: '取消',
                keyboard: false
            };
            var tmpTpl = $.template(
                '<div class="dialog_tip">' +
                '<span class="tip_icon question"></span>' +
                '<div class="text"><%=content%></div>' +
                '</div>');
            var config;
            if ($.isPlainObject(content)) {
                config = content;
                config.body = tmpTpl({ content: config.body });
            } else {
                if ($.isFunction(title)) {
                    config = {
                        title: '提示',
                        body: tmpTpl({ content: content }),
                        okHidden: title,
                        cancelHidden: okHidden
                    };
                } else {
                    config = {
                        title: title,
                        body: tmpTpl({ content: content }),
                        okHidden: okHidden,
                        cancelHidden: cancelHidden
                    };
                }
            }
            return $._modal(defaults, config);
        },
        modal: function(content, title, okHidden, cancelHidden) {
            var defaults = {
                type: 'confirm',
                title: '',  //默认打开标题
                cancelbtn: '取消',
                footer: true
            };
            var config;
            if ($.isPlainObject(content)) {
                config = content;
            } else {
                if ($.isFunction(title)) {
                    config = {
                        title: '提示',
                        body: content,
                        okHidden: title,
                        cancelHidden: okHidden
                    };
                } else {
                    config = {
                        title: title,
                        body: content,
                        okHidden: okHidden,
                        cancelHidden: cancelHidden
                    };
                }
            }
            return $._modal(defaults, config);
        }
    })
}(jQuery);
