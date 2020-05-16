<style>
    .label {
        cursor: pointer;
    }

    .progress {
        display: none;
        margin-bottom: 1rem;
    }

    .alert {
        display: none;
    }

    .img-container img {
        max-width: 100%;
    }
    #img{
        max-width: 300px;
        max-height: 300px;
        border: 1px solid #ddd;
        box-shadow: 1px 1px 5px 0 #a2958a;
        padding: 6px;
        float: left;
        clear: both;
    }
</style>
<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="input-group">
        <label class="label" data-toggle="tooltip">
            <div data-id="logo" class="btn btn-info pull-left" id="avatar">浏览</div>
            <img class="rounded" id="img" style="display: none" alt="" />
            <input type="file" class="sr-only" id="input" name="image" accept="image/*">
        </label>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
        <div class="alert" role="alert"></div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">裁切图片</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="image" src="" alt="" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="crop">裁切</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', function () {
                var avatar = document.getElementById('avatar');
                var image = document.getElementById('image');
                var input = document.getElementById('input');
                var img = $("#img");
                var $progress = $('.progress');
                var $progressBar = $('.progress-bar');
                var $alert = $('.alert');
                var $modal = $('#myModal');
                var cropper;

                $('[data-toggle="tooltip"]').tooltip();

                input.addEventListener('change', function (e) {
                    var files = e.target.files;
                    var done = function (url) {
                        input.value = '';
                        image.src = url;
                        $alert.hide();
                        $modal.modal('show');
                    };
                    var reader;
                    var file;
                    var url;

                    if (files && files.length > 0) {
                        file = files[0];

                        if (URL) {
                            done(URL.createObjectURL(file));
                        } else if (FileReader) {
                            reader = new FileReader();
                            reader.onload = function (e) {
                                done(reader.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                });

                $modal.on('shown.bs.modal', function () {
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 3,
                    });
                }).on('hidden.bs.modal', function () {
                    cropper.destroy();
                    cropper = null;
                });

                document.getElementById('crop').addEventListener('click', function () {
                    var initialAvatarURL;
                    var canvas;

                    $modal.modal('hide');

                    img.show();
                    if (cropper) {
                        canvas = cropper.getCroppedCanvas();
                        initialAvatarURL = avatar.src;

                        img.attr('src', canvas.toDataURL());
                        $progress.show();
                        $alert.removeClass('alert-success alert-warning');
                        canvas.toBlob(function (blob) {
                            var formData = new FormData();

                            formData.append('files', blob, 'avatar.jpg');
                            $.ajax('/server/php/index.php', {
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,

                                xhr: function () {
                                    var xhr = new XMLHttpRequest();

                                    xhr.upload.onprogress = function (e) {
                                        var percent = '0';
                                        var percentage = '0%';

                                        if (e.lengthComputable) {
                                            percent = Math.round((e.loaded / e.total) * 100);
                                            percentage = percent + '%';
                                            $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                                        }
                                    };

                                    return xhr;
                                },

                                success: function () {
                                    $alert.show().addClass('alert-success').text('成功啦');
                                },

                                error: function () {
                                    avatar.src = initialAvatarURL;
                                    $alert.show().addClass('alert-warning').text('上传失败了');
                                },

                                complete: function () {
                                    $progress.hide();
                                },
                            });
                        });
                    }
                });
            });
        </script>

        @include('admin::form.help-block')

    </div>
</div>