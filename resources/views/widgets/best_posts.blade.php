 
@if (! $posts == null)
       
   <div class="container">
    <div class="row">
      @foreach ($posts as $post)
          
      <div class="col-md-4">
         <div class="blog-content">
            <figure>
               <img src="data:{{ $post->images[0]->mime_type }};base64,{{ base64_encode($post->images[0]->image) }}" class="w-100" alt="{{ $post->images[0]->alternative_text }}">
            </figure>
            <h5><i class="fa fa-title"></i>{{$post->title}}</h5>
            <p>{{substr($post->description, 0, 200)}} ...</p>
            <ul>
               <li><i class="fa fa-bars"></i>دسته بندی : 
               @foreach ($post->genres as $genre)
               ,{{$genre->title}}
               @endforeach
               </li>
               <li><i class="fa fa-calendar-o"></i>نوشته شده در : {{$post->created_at}}</li>
            </ul>
            <a href="/post/{{ $post->id }}" class="mybtn"><i class="fa fa-continuous"></i>ادامه مطلب&raquo;</a>	
         </div>
      </div>
      @endforeach
    </div>
 </div>
@endif