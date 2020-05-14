@foreach(config('laravelrestbuilder.menu') as $key => $value)
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        {{$key}}
    </div>    
    <!-- {{json_encode($value)}} -->
    @if( !isset($value['0']) )
        @foreach($value as $key_2 => $value_2)
            <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{$key_2}}" aria-expanded="true" aria-controls="collapse{{$key_2}}">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{$key_2}}</span>
            </a>
            <div id="collapse{{$key_2}}" class="collapse" aria-labelledby="heading{{$key_2}}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">{{$key_2}} :</h6>                    
                
                @foreach($value_2 as $value_3)
                    <a class="collapse-item" href="{{url('/')}}{{ $value_3['url'] }}">{{$value_3['name']}}</a>
                @endforeach
                </div>
            </div>
        @endforeach    
    @else
        @foreach($value as $value_2)
            <a class="collapse-item" href="{{url('/')}}{{ $value_2['url'] }}">{{$value_2['name']}}</a>
        @endforeach
    @endif            
    </li>
@endforeach