<div class="box box-info" style="border-top-color: #d2d6de;">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 5px">
                @if(isset($url))
                    <a href="{{$url}}" class="btn btn-sm btn-default" title="返回"><span class="hidden-xs">&nbsp;返回</span></a>
                @else
                    <a href="javascript:history.back();" class="btn btn-sm btn-default" title="返回"><span class="hidden-xs">&nbsp;返回</span></a>
                @endif
            </div>
        </div>
    </div>
</div>