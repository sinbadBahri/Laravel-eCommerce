


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


          <!--Section: Comments-->
          <section class="border-bottom mb-3">
            <p class="text-center"><strong>Comments: 3</strong></p>

            <!-- Comment -->
            <div class="row mb-4">
              <div class="col-2">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(24).jpg"
                  class="img-fluid shadow-1-strong rounded" alt="" />
              </div>

              <div class="col-10">
                <p class="mb-2"><strong>Marta Dolores</strong></p>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio est ab iure
                  inventore dolorum consectetur? Molestiae aperiam atque quasi consequatur aut?
                  Repellendus alias dolor ad nam, soluta distinctio quis accusantium!
                </p>
              </div>
            </div>

            <!-- Comment -->
            <div class="row mb-4">
              <div class="col-2">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(25).jpg"
                  class="img-fluid shadow-1-strong rounded" alt="" />
              </div>

              <div class="col-10">
                <p class="mb-2"><strong>Valeria Groove</strong></p>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio est ab iure
                  inventore dolorum consectetur? Molestiae aperiam atque quasi consequatur aut?
                  Repellendus alias dolor ad nam, soluta distinctio quis accusantium!
                </p>
              </div>
            </div>

            <!-- Comment -->
            <div class="row mb-4">
              <div class="col-2">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(26).jpg"
                  class="img-fluid shadow-1-strong rounded" alt="" />
              </div>

              <div class="col-10">
                <p class="mb-2"><strong>Antonia Velez</strong></p>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio est ab iure
                  inventore dolorum consectetur? Molestiae aperiam atque quasi consequatur aut?
                  Repellendus alias dolor ad nam, soluta distinctio quis accusantium!
                </p>
              </div>
            </div>
          </section>
          <!--Section: Comments-->

          <!--Section: Reply-->
          <section>
            <p class="text-center"><strong>Leave a reply</strong></p>

            <form>
              <!-- Name input -->
              <div class="form-outline mb-4" data-mdb-input-init>
                <input type="text" id="form4Example1" class="form-control" />
                <label class="form-label" for="form4Example1">Name</label>
              </div>

              <!-- Email input -->
              <div class="form-outline mb-4" data-mdb-input-init>
                <input type="email" id="form4Example2" class="form-control" />
                <label class="form-label" for="form4Example2">Email address</label>
              </div>

              <!-- Message input -->
              <div class="form-outline mb-4" data-mdb-input-init>
                <textarea class="form-control" id="form4Example3" rows="4"></textarea>
                <label class="form-label" for="form4Example3">Text</label>
              </div>

              <!-- Checkbox -->
              <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form4Example4" checked />
                <label class="form-check-label" for="form4Example4">
                  Send me a copy of this comment
                </label>
              </div>

              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                Publish
              </button>
            </form>
          </section>
          <!--Section: Reply-->
        </div>

 
  @endsection