<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <!-- Target -->
    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        @if($valid == 0)
            <div class="alert alert-danger">注意：请您用同对待您的密码一样的安全等级来保护您的应急恢复密钥</div>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal-code"
                    style="margin-right: 20px;">获取恢复秘钥
            </button>
            <div class="modal fade" id="myModal-code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">用于二次验证的App</h4>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="3" id="recovery-code">{{$recoveryCode}}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <a id="copy-code" class="btn btn-info" data-clipboard-target="#recovery-code">复制</a>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" style="display: none" class="btn btn-success" id="open-secret" data-toggle="modal"
                    data-target="#myModal">开启二次验证
            </button>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">用于二次验证的App</h4>
                        </div>
                        <div class="modal-body">
                            <div class="sweet-content">
                                <div class="sweet-content-content">
                                    <p>启用双重身份验证以提高帐户的安全性。</p>
                                    <div class="panel-body">
                                        打开您的双重认证移动应用程序, 并扫描以下 QR 条码，<a href="https://authy.com/download/" target="_blank">下载地址</a>:
                                        <p data-v-09174a1a=""><img data-v-09174a1a="" id="barcode"
                                                                   alt="Image of QR barcode"
                                                                   src="{{$inlineUrl}}">
                                            <br data-v-09174a1a="">
                                            如果您的双重认证移动应用程序不支持 QR 条码, 请在下面的代码中输入:
                                            <code data-v-09174a1a="" id="secretkey">{{$secretKey}}</code></p>
                                        <p>请验证您刚设置的新设备:</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="one_time_password" class="col-sm-2 control-label">验证码</label>
                                        <div class="col-sm-10">
                                            <input id="one_time_password" type="number"
                                                   autofocus="autofocus" required="required"
                                                   name="one_time_password" placeholder=""
                                                   class="form-control"
                                                   style="width: 100px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="recovery_code" value="{{$recoveryCode}}">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary check-2fa">验证</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">关闭二次验证</button>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">用于二次验证的App</h4>
                        </div>
                        <div class="modal-body">
                            <div class="sweet-content">
                                <div class="sweet-content-content">
                                    <p style="color:red;">关闭双重身份验证会降低帐户的安全性，谨慎操作。</p>
                                    <div class="form-group">
                                        <label for="one_time_password" class="col-sm-2 control-label">验证码</label>
                                        <div class="col-sm-10">
                                            <input id="one_time_password" type="number"
                                                   autofocus="autofocus" required="required"
                                                   name="one_time_password" placeholder=""
                                                   class="form-control"
                                                   style="width: 100px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary check-2fa">验证</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <script type="text/javascript">
            $(function () {
                var clipboard = new ClipboardJS('#copy-code');

                clipboard.on('success', function (e) {
                    $("#open-secret").show();
                    layer.msg('复制成功');
                });

                clipboard.on('error', function (e) {
                    layer.msg('复制失败');
                });

                $(".check-2fa").on('click', function () {
                    $('#myModal').modal('hide')
                });
                $("#copy-code").on('click', function () {
                    $('#myModal-code').modal('hide')
                });
            });
        </script>
        @include('admin::form.help-block')
    </div>
</div>