 
@if (! $posts == null)
       
   <div class="container">
    <div class="row">
      @foreach ($posts as $post)
          
      <div class="col-md-4">
         <div class="blog-content">
            <figure>
               <img src="{{ asset('img/off/watch/1.jpg') }}" class="w-100">
            </figure>
            <h5><i class="fa fa-title"></i>{{$post->title}}</h5>
            <p>{{$post->description}}</p>
            <ul>
               <li><i class="fa fa-bars"></i>دسته بندی : 
               @foreach ($post->genres as $genre)
               ,{{$genre->title}}
               @endforeach
               </li>
               <li><i class="fa fa-calendar-o"></i>نوشته شده در : {{$post->created_at}}</li>
            </ul>
            <a href="#" class="mybtn"><i class="fa fa-continuous"></i>ادامه مطلب&raquo;</a>	
         </div>
      </div>
      @endforeach
    </div>
 </div>
@endif