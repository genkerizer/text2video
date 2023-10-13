<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text to Video</title>
    <meta property="og:description" content="Generate new character videos with pose animations from your video and character descriptions." />
    <meta property="og:image" content="{{ url('asset/bg.jpg') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="{{url('asset/style.css?t=7')}}">
</head>
<body>
<svg id="demo" viewBox="0 0 1600 600" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
      <stop id="stop1a" offset="0%" stop-color="#12a3b4"></stop>
      <stop id="stop1b" offset="100%" stop-color="#ff509e"></stop>
    </linearGradient>
    <linearGradient id="grad2" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
      <stop id="stop2a" offset="0%" stop-color="#e3bc13"></stop>
      <stop id="stop2b" offset="100%" stop-color="#00a78f"></stop>
    </linearGradient>
  </defs>
  <rect id="rect1" x="0" y="0" width="1600" height="600" stroke="none" fill="url(#grad1)"></rect>
  <rect id="rect2" x="0" y="0" width="1600" height="600" stroke="none" fill="url(#grad2)"></rect>
</svg>
<section class="multi_step_form"> 
  {{-- <a href="{{url('results/zzzzA_Iron_man_on_the_beach.mp4')}}" class="action-button" >Trang chủ</a>  --}}
  <div id="msform"> 
    <!-- Tittle -->
    <div class="tittle">
      <h1>Text to Video</h1>
      <p>Generate new character videos with pose animations from your video and character descriptions.</p>
      <a href="{{route("upload.form")}}" class="action-button">Create Video</a>
    </div>
    <div class="table">
      <div class="table-header">
        {{-- <div class="header__item">ID</div> --}}
        <div class="header__item">Prompt</div>
        <div class="header__item">Video input</div>
        <div class="header__item">Video output</div>
      </div>
      <div class="table-content"> 
        @foreach($generators as $generator)
        <div class="table-row">   
          {{-- <div class="table-data">{{$generator->id}}</div> --}}
          <div class="table-data">{{"(".$generator->id."): ".$generator->description_prompt}}</div>
          <div class="table-data"><a target="_blank" href="{{url('videos/'.$generator->inputvideo)}}">{{$generator->inputvideo}}</a></div>
          <div class="table-data">@if($generator->outputvideo)<a target="_blank" href="{{url('results/'.$generator->outputvideo)}}">{{$generator->outputvideo}}</a>@else {{'---'}} @endif</div>
        </div>
        @endforeach
        <div style="text-align: center">{{$generators->links()}}</div>
        
      </div>
    </div>
    <br><br>
    <p>*API: <a target="_blank" href="{{route('getdata')}}">Get Data</a> | Method:GET( id,prompt,video,lang )</p>
    <p>*API: <a target="_blank" href="{{route('senddata')}}">Send Data</a> | Method:POST( id,video )</p>
  </div>  
</section> 
<!-- End Multi step form -->    
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stats.js/r16/Stats.min.js"></script>
<script src="{{url('asset/main.js')}}"></script>
</html>
