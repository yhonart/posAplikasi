<div class="row">
    @foreach($personalia as $p)
        <div class="col-md-4 col-12">
            <div class="attachment-block clearfix">
                @if($p->image_name<>"")
                    <img class="attachment-img" src="{{asset('public/images/user.png')}}" alt="Attachment Image">     
                @elseif($p->gender=="Woman" AND $p->image_name=="")
                    <img class="attachment-img" src="{{asset('public/images/woman.png')}}" alt="Attachment Image">
                @elseif($p->gender=="Man" AND $p->image_name=="")
                    <img class="attachment-img" src="{{asset('public/images/man.png')}}" alt="Attachment Image">   
                @else
                             
                @endif
            
                <div class="attachment-pushed">
                    <h4 class="attachment-heading">{{$p->employee_name}}</h4>
                
                    <div class="attachment-text">
                        <i class="fa-solid fa-briefcase text-info"></i> {{$p->jobdesc}}
                        <br>
                        <i class="fa-solid fa-phone"></i> {{$p->phone_number}}
                    </div>
                    <hr>
                    <a href="#" class="btn btn-info">Detail <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    @endforeach
</div>