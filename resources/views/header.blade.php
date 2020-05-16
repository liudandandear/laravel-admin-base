<div style='padding-left: 20px'>
    @if($update_time)
    <span>数据更新时间:{{$update_time}}</span>
    @endif
    <span style="float:right">
                合计：
                @foreach($data as $header)
            {{$header['title']}} <span style='color: #ff0000;padding: 10px'>{{$header['number']}}</span>
        @endforeach
        </span>
</div>
