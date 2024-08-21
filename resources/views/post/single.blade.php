


@extends('layouts.master')
@section('content')



    <!-- Jumbotron -->
    <div id="intro" class="p-5 text-center bg-light">
      <h1 class="mb-0 h4">{{$singlePost->title}}</h1>
    </div>
  
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-md-8 mb-4">
          <!--Section: Post data-mdb-->
          <section class="border-bottom mb-4">
            
            <img src="data:{{ $singlePost->images[0]->mime_type }};base64,{{ base64_encode($singlePost->images[0]->image) }}" class="img-fluid shadow-2-strong rounded mb-4" alt="{{ $singlePost->images[0]->alternative_text }}">

            
          </section>
          <!--Section: Post data-mdb-->

          <!--Section: Text-->
          <section>
            <p>
              {{$singlePost->description}}
            </p>

          </section>
          <!--Section: Text-->

          <br>
          <br>
          <br>
          <!--Section: Comments-->
          <section class="border-bottom mb-3">
            <p class="text-center"><strong>{{$commentQuantity}} عدد کامنت</strong></p>

            {{-- ------------------ --}}
            @if (! $postComments == null)
            <section style="background-color: #e7effd;">
              <div class="container my-5 py-5 text-body">
                <div class="row d-flex justify-content-center">
                  <div class="col-md-11 col-lg-9 col-xl-7">
                    
                    @foreach ($postComments as $comment)
                        
                    
                    <div class="d-flex flex-start">
                      {{-- <img class="rounded-circle shadow-1-strong me-3"
                        src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(31).webp" alt="avatar" width="65"
                        height="65" /> --}}
                      <div class="card w-100">
                        <div class="card-body p-4">
                          <div class="">
                            <h5>{{$comment->user->name}}</h5>
                            <p class="small">5 hours ago</p>
                            <p>
                              {{$comment->content}}
                            </p>
            
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="d-flex align-items-center">
                                <a href="#!" class="link-muted me-2"><i class="fas fa-thumbs-up me-1"></i></a>
                                <a href="#!" class="link-muted"><i class="fas fa-thumbs-down me-1"></i></a>
                              </div>
                              <div class="form-outline" data-mdb-input-init>
                                <form action="/post/{{$singlePost->id}}/{{$comment->id}}" method="POST">
                                  @csrf
                                  <input name="comment" type="text" id="typeText" placeholder="پاسخ" class="form-control form-control-sm" />
                                </form>
                                </div>
                            </div>
                          </div>

                          @foreach ($comment->children as $reply)
                              
                          <div class="d-flex flex-start mt-4">
                            
                            <div class="flex-grow-1 flex-shrink-1">
                              <div>
                                <div class="d-flex justify-content-between align-items-center">
                                  <p class="mb-1">
                                    {{$reply->user->name}} <span class="small">- 3 hours ago</span>
                                  </p>
                                </div>
                                <p class="small mb-0">
                                  {{$reply->content}}
                                </p>
                              </div>
                              
                            </div>
                            <div class="form-outline" data-mdb-input-init>
                              <form action="/post/{{$singlePost->id}}/{{$reply->id}}" method="POST">
                                @csrf
                                <input name="comment" type="text" id="typeText" placeholder="پاسخ" class="form-control form-control-sm" />
                              </form>
                              </div>
                          </div>

                          @endforeach


                          
                        </div>
                      </div>
                    </div>
                    @endforeach
                    <br>
                    <br>
                    <br>
                    ارسال کامنت
                    <br>
                    <br>


                    <form action="/post/{{$singlePost->id}}/empty" method="POST">
                      @csrf
                      <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                        <div class="d-flex flex-start w-100">
                          <div data-mdb-input-init class="form-outline w-100">
                            <textarea class="form-control" name="comment" id="textAreaExample" rows="4"
                              style="background: #fff;"></textarea>
                          </div>
                        </div>
                        <div class="float-end mt-2 pt-1">
                          <button type="submit" class="btn btn-outline-success">ارسال</button>

                        </form>

                      </div>
                    </div>



                  </div>
                </div>
              </div>
            </section>
            @else    
            
            <form action="/post/{{$singlePost->id}}/empty" method="POST">
              @csrf
            <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
              <div class="d-flex flex-start w-100">
                <div data-mdb-input-init class="form-outline w-100">
                  <textarea name="comment" placeholder="اولیت کامنت این پست را بنویسید..." class="form-control" id="textAreaExample" rows="4"
                    style="background: #fff;"></textarea>
                </div>
              </div>
              <div class="float-end mt-2 pt-1">

                  <button type="submit" class="btn btn-outline-success">ارسال</button>
                </form>

              </div>
            </div>
            @endif
        </div>


<script>
  // Initialization for ES Users
  import { Input, initMDB } from "mdb-ui-kit";

  initMDB({ Input });
</script>
 
<script src="{{ asset('js/comment.js') }}" type="text/javascript"></script>
@endsection