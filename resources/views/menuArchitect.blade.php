@foreach(config('laravelrestbuilder.menu') as $key => $value)
    <li class="app-sidebar__heading">{{$key}}</li>
    <!-- {{json_encode($value)}} -->
    @if( !isset($value['0']) )
        @foreach($value as $key_2 => $value_2)
            <li>
                <a href="#">
                    <i class="metismenu-icon pe-7s-diamond"></i>
                    {{$key_2}}
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                @foreach($value_2 as $value_3)
                    <li>
                        <a href="{{url('/')}}{{ $value_3['url'] }}">
                            <i class="metismenu-icon"></i>
                            {{$value_3['name']}}
                        </a>
                    </li>
                @endforeach
                </ul>
            </li>
        @endforeach    
    @else
        @foreach($value as $value_2)
            <li>
                <a href="{{url('/')}}{{ $value_2['url'] }}">
                    <i class="metismenu-icon"></i>
                    {{$value_2['name']}}
                </a>
            </li>
        @endforeach
    @endif
    
@endforeach