<div class="container">
    <div class="w-100 mt-2 fixed-bottom bg-transparent ">
        <div class="row m-0">
            @if($active == 'Home')
                <div class="col-3 p-2  rounded" >
                <!-- <div class="col-4 p-2 bg-primary rounded" > -->
                    <a href="{{route('home.index')}}"><img class="img-fluid nav-active mx-auto d-block mb-1" src="{{asset('assets/img/011-house.png')}}" alt=""></a>
                    <!-- <p class="col-12 text-center m-0 p-0">Beranda</p> -->
                    <div class="titik mt-2 text-center mx-auto"></div>
                </div>
            @else
                <div class="col-3 p-2" >
                    <a href="{{route('home.index')}}"><img class="img-fluid mx-auto d-block mb-1" src="{{asset('assets/img/011-house.png')}}" alt=""></a>
                    <p class="col-12 text-center m-0 p-0">Beranda</p>
                </div>
            @endif
            
            @if($active == 'Ayat')
                <div class="col-3 p-2  rounded" >
                <!-- <div class="col-4 p-2  bg-primary rounded" > -->
                    <a href="{{route('ayat.index')}}"><img class="img-fluid nav-active mx-auto d-block mb-1" src="{{asset('assets/img/024-books.png')}}" alt=""></a>
                    <!-- <p class="col-12 text-center m-0 p-0">Firman</p> -->
                    <div class="titik mt-2 text-center mx-auto"></div>

                </div>
            @else
                <div class="col-3 p-2" >
                    <a href="{{route('ayat.index')}}"><img class="img-fluid mx-auto d-block mb-1"  src="{{asset('assets/img/024-books.png')}}" alt=""></a>
                    <p class="col-12 text-center m-0 p-0">Firman</p>
                </div>
            @endif

            @if($active == 'Tulis')
                <div class="col-3 p-2  rounded" >
                <!-- <div class="col-4 p-2  bg-primary rounded" > -->
                    <a href="{{route('tulisfirman.index')}}"><img class="img-fluid nav-active mx-auto d-block mb-1" src="{{asset('assets/img/050-edition.png')}}" alt=""></a>
                    <!-- <p class="col-12 text-center m-0 p-0">Firman</p> -->
                    <div class="titik mt-2 text-center mx-auto"></div>

                </div>
            @else
                <div class="col-3 p-2" >
                    <a href="{{route('tulisfirman.index')}}"><img class="img-fluid mx-auto d-block mb-1"  src="{{asset('assets/img/050-edition.png')}}" alt=""></a>
                    <p class="col-12 text-center m-0 p-0">Tulis</p>
                </div>
            @endif

            @if($active == 'Profile')
                <div class="col-3 p-2 rounded" >
                <!-- <div class="col-4 p-2  bg-primary rounded" > -->
                    <a href="{{route('profile.index')}}"><img class="img-fluid nav-active mx-auto d-block mb-1"  src="{{asset('assets/img/user.png')}}" alt=""></a>
                    <!-- <p class="col-12 text-center m-0 p-0">Saya</p> -->
                    <div class="titik mt-2 text-center mx-auto"></div>

                </div>
            @else
                <div class="col-3 p-2" >
                    <a href="{{route('profile.index')}}"><img class="img-fluid mx-auto d-block mb-1"  src="{{asset('assets/img/user.png')}}" alt=""></a>
                    <p class="col-12 text-center m-0 p-0">Saya</p>
                </div>
            @endif
            
            <!-- <div class="col-3 p-2" >
                <a href=""><img class="img-fluid mx-auto d-block mb-1" style="max-height:35px;"  src="{{asset('assets/img/067-mortarboard.png')}}" alt=""></a>
                <p class="col-12 text-center m-0 p-0">Profil</p>
            </div> -->
        </div>
    </div>
</div>
