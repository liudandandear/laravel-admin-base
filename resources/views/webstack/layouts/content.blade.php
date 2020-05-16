@foreach($categories as $category)

    @if(count($category->sites) != 0)

        <h4 class="text-gray"><em class="linecons-tag" style="margin-right: 7px;" id="{{ $category->title }}"></em>{{ $category->title }}</h4>
            @foreach ($category->sites->chunk(4) as $sites)
            <div class="row">
                @foreach($sites as $site)
                    <div class="col-sm-3">
                        <div class="xe-widget xe-conversations box2 label-info" onclick="window.open('{{$site['url']}}', '_blank')" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{$site['title']}}">
                            <div class="xe-comment-entry">
                                <a class="xe-user-img">
                                    <img src="{{ admin_asset("upload") }}/{{$site['thumb']}}" class="lozad img-circle" width="40">
                                </a>
                                <div class="xe-comment">
                                    <a href="#" class="xe-user-name overflowClip_1">
                                        <strong>{{$site['title']}}</strong>
                                    </a>
                                    <p class="overflowClip_2">{{$site['describe']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
    <br>
@endforeach