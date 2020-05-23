<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">{{$title}}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><em class="fa fa-minus"></em></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><em class="fa fa-times"></em></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped">
                @foreach($envs as $env)
                    <tr>
                        <td style="width: 120px;">{{ $env['name'] }}</td>
                        <td>{!! $env['value'] !!}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>