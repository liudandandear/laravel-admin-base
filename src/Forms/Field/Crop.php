<?php

namespace AdminBase\Forms\Field;

use AdminBase\Utility\HttpHelper;
use AdminBase\Utility\JsonHelper;
use AdminBase\Utility\JwtHelper;
use Encore\Admin\Form\Field\ImageField;
use Encore\Admin\Form\Field\File;
use Encore\Admin\Admin;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Crop extends File
{
    use ImageField;

    protected $basename = null;

    private $ratioW = 100;

    private $ratioH = 100;

    protected $view = 'common::cropper';

    protected static $css = [
        '/vendor/cropper/cropper.min.css',
    ];

    protected static $js = [
        '/vendor/cropper/cropper.min.js',
        '/vendor/cropper/layer/layer.js'
    ];

    protected function preview()
    {
        return $this->objectUrl($this->value);
    }

    /**
     * @param $base64ImageContent
     * @return bool
     * @throws Exception
     */
    private function storeBase64Image($base64ImageContent)
    {
        //匹配出图片的格式
        if (! preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64ImageContent, $result)) {
            return false;
        }

        $extension    = $result[2];
        $directory    = public_path('upload/images');
        $file_name    = $this->getStoreBasename() . '.' . $extension;
        $file_content = base64_decode(str_replace($result[1], '', $base64ImageContent));
        $file_path    = $directory . '/' . $file_name;

        if(!is_dir($directory)) {
            mkdir($directory, 0755);
        }
        if ((file_put_contents($file_path, $file_content, FILE_IGNORE_NEW_LINES)) === false) {
            return false;
        }

        $uploadUrl = config('custom.res_api');
        //生成token
        $userData = [
            'uid' => \Encore\Admin\Facades\Admin::user()->id, //用户id
            'cli' => 1,  //客户端id
        ];

        $token = JwtHelper::instance()->encode($userData);
        $res = HttpHelper::uploadFile($uploadUrl. '/upload?token='.$token, $file_path);
        if ($res) {
            $fileData = JsonHelper::decode($res);
            if ($fileData['code'] == 200) {
                unlink($file_path);
                return $fileData['files'][0]['url'];
            }
        }
        return false;
    }

    /**
     * @author Mike <zhengzhe94@gmail.com>
     * @param $basename
     * @return $this
     */
    public function basename($basename)
    {
        if ($basename) {
            $this->basename = $basename;
        }

        return $this;
    }

    /**
     * @author Mike <zhengzhe94@gmail.com>
     * @return mixed|null|string
     */
    protected function getStoreBasename()
    {
        if ($this->basename instanceof \Closure) {
            return $this->basename->call($this);
        }

        if (is_string($this->basename)) {
            return $this->basename;
        }

        return md5(uniqid());
    }

    /**
     * @param array|UploadedFile $base64
     * @return array|bool|mixed|string|UploadedFile
     * @throws Exception
     */
    public function prepare($base64)
    {
        //检查是否是base64编码
        if (preg_match('/data:image\/.*?;base64/is',$base64)) {
            $imagePath = $this->storeBase64Image($base64);
            $this->destroy();
            $this->callInterventionMethods($imagePath);
            return $imagePath;
        } else {
            $directory = ltrim($this->getDirectory(), '/');
            $directory = str_replace('/',"\/",$directory);
            preg_match('/' . $directory . '\/.*/is',$base64,$matches);
            return isset($matches[0]) ? $matches[0] : $base64;
        }
    }

    public function cRatio($width,$height)
    {
        if (!empty($width) and is_numeric($width)) {
            $this->attributes['data-w'] = $width;
        } else {
            $this->attributes['data-w'] = $this->ratioW;
        }
        if (!empty($height) and is_numeric($height)) {
            $this->attributes['data-h'] = $height;
        } else {
            $this->attributes['data-h'] = $this->ratioH;
        }
        return $this;
    }

    public function render()
    {
        $this->name = $this->formatName($this->column);

        if (!empty($this->value)) {
            $this->value = filter_var($this->preview());
        }

        $this->script = <<<EOT

//图片类型预存
var cropperMIME = '';

function getMIME(base64)
{
    var preg = new RegExp('data:(.*);base64','i');
    var result = preg.exec(base64);
    return result[1];
}

function cropper(imgSrc,id,w,h)
{
    
    var cropperImg = '<div id="cropping-div"><img id="cropping-img" src="'+imgSrc+'"><\/div>';
    
    
    //生成弹层模块
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //样式类名
        area: ['800px', '600px'],
        closeBtn: 2, //第二种关闭按钮
        anim: 2,
        resize: false,
        shadeClose: false, //关闭遮罩关闭
        title: '图片剪裁器',
        content: cropperImg,
        btn: ['剪裁','原图','清空'],
        btn1: function(){
            var cas = cropper.getCroppedCanvas({
                width: w,
                height: h
            });
            //剪裁数据转换base64
            var base64url = cas.toDataURL(cropperMIME);
            //替换预览图
            $('#'+id+'-img').attr('src',base64url);
            //替换提交数据
            $('#'+id+'-input').val(base64url);
            //销毁剪裁器实例
            cropper.destroy();
            layer.closeAll('page');
        },
        btn2:function(){
            //默认关闭框
            //销毁剪裁器实例
            cropper.destroy();
        },
        btn3:function(){
            //清空表单和选项
            //销毁剪裁器实例
            cropper.destroy();
            layer.closeAll('page');
            //清空预览图
            $('#'+id+'-img').removeAttr('src');
            //清空提交数据
            $('#'+id+'-input').val('');
            //清空文件选择器
            $('#'+id+'-file').val('');
        }
    });

    var image = document.getElementById('cropping-img');
    var cropper = new Cropper(image, {
        aspectRatio: w / h,
        viewMode: 2,
    });
}

$('.cropper-btn').click(function(){
    var id = $(this).attr('data-id');
    $('#'+id+'-file').click();
});

//在input file内容改变的时候触发事件
$('.cropper-file').change(function(){
    var id = $(this).attr('data-id');
    var w = $(this).attr('data-w');
    var h = $(this).attr('data-h');
    
    //获取input file的files文件数组;
    //这边默认只能选一个，但是存放形式仍然是数组，所以取第一个个素使用[0];
    var file = $(this)[0].files[0];
    //创建用来读取此文件的对象
    var reader = new FileReader();
    //使用该对象读取file文件
    reader.readAsDataURL(file);
    //读取文件成功后执行的方法函数
    reader.onload = function(e){
        //选择所要显示图片的img，要赋值给img的src就是e中target下result里面的base64编码格式的地址
        $('#'+id+'-img').attr('src',e.target.result);
        cropperMIME = getMIME(e.target.result);
        //调取剪切函数（内部包含了一个弹出框）
        cropper(e.target.result,id,w,h);
        $('#'+id+'-input').val(e.target.result);
    };
});

//点击图片触发弹层
$('.cropper-img').click(function(){
    var id = $(this).attr('data-id');
    var w = $(this).attr('data-w');
    var h = $(this).attr('data-h');
    cropper($(this).attr('src'),id,w,h);
});

EOT;

        if (!$this->display) {
            return '';
        }

        Admin::script($this->script);

        return view($this->getView(), $this->variables());
    }

}
