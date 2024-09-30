<div class="main-menu">
    <div class="container">
       <div class="row">
          <div class="col-md-12">
             <ul>
                @if (Route::has('login'))
                   @auth
                       
                   <li>
                      <a href="/profile">{{ Auth::user()->name }}</a>
                      <ul>
                         <li><a href="/profile">پروفایل</a></li>
                         @if (JWTAuth::user()->is_admin)
                           <li><a href="/admin-panel">پنل ادمین</a></li>
                         @endif
                         <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <li><x-dropdown-link :href="route('logout')"
                               onclick="event.preventDefault();
                                           this.closest('form').submit();">
                           {{ __('خروج') }}
                               </x-dropdown-link></li>
                            
                         </form>
                      </ul>
                   </li>
                   @else
                   
                   <li><a href="/login" class="mybtn"><i class="fa fa-user-o"></i>ورود</a></li>

                   @if (Route::has('register'))
                       
                   <li><a href="/register" class="mybtn"><i class="fa fa-user-plus"></i>ثبت نام</a</li>
                      
                   @endif
                   @endauth 
                   
                @endif
                <li><a href="/basket" class="mybtn"><i class="fa fa-cart-arrow-down"></i>سبد : <span id="cart-items">{{ $cartItems }}</span></a></li>

             </ul>
          </div>
       </div>
    </div>
 </div> 
 