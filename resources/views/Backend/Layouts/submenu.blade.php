@foreach($childs as $child)
<a class="collapse-item" href="{{env('APP_URL')}}{{$child['slug']}}">{{$child['name']}}</a>
   @if($child['relations'])
   
   <div id="collapse{{$child['id']}}" class="collapse" aria-labelledby="heading{{$child['id']}}" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">    
            @include('Backend.Layouts.submenu',['childs' => $child['relations']])
        </div>
    </div>  
   @endif

@endforeach