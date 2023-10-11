<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text to Video</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <form id="msform" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data"> 
    @csrf
    <a href="{{route('home')}}" class="home" ></a>
    <!-- Tittle -->
    <div class="tittle">
      <h1>Text to Video</h1>
      <p>Generate new character videos with pose animations from your video and character descriptions.</p>
      @if(session('success'))
          <p>{{ session('success') }}</p>
      @endif

      @if(session('error'))
          <p style="color: red">{{ session('error') }}</p>
      @endif
    </div>
    <!-- progressbar -->
    <ul id="progressbar">
      {{-- <li class="active">Verify Phone</li>   --}}
      <li class="active">Upload Video</li> 
      <li>Prompt Description</li>
      <li>Result</li>
    </ul>
    <!-- fieldsets -->
    <fieldset>
      <h3>Tải lên video của bạn</h3>
      <h6>Vui lòng tải lên video có chuyển động cần sử dụng.</h6>
      <div class="input-group"> 
        <div class="custom-file">
          <input type="file" name="inputvideo" class="custom-file-input" id="upload" accept="video/*">
          <label class="custom-file-label" for="upload"><i class="ion-android-cloud-outline"></i>Chọn video</label>
        </div>
      </div>
      <div class="done_text" id="fileUploadDone" style="display: none;"> 
        <a href="#" class="don_icon"><i class="ion-android-done"></i></a> 
        <h6>Đã chọn file!</h6> 
      </div> 

      <button type="button" class="next action-button"><i class="ion-android-arrow-forward"></i> Tiếp tục</button>  
    </fieldset>
    <fieldset>
      <h3>Tạo 1 đoạn mô tả nhân vật</h3>
      <h6>To generate the character videos from pose and text description.</h6> 
      <div class="form-group"> 
        <select name="language" id="language" class="product_select" >
          <option value="1">Tiếng Việt</option>
          <option value="0">English</option>        
        </select>
      </div>
      <div class="form-group fg_2"> 
        <textarea class="form-control" name="textprompt" id="textprompt" rows="5" cols="30" placeholder="Nhập Prompt mô tả nhân vật..."></textarea>
      </div>
      <button type="button" class="action-button previous previous_button">Trở lại</button>
      <button type="button" class="next action-button" onclick="submitForm()"><i class="ion-ios-color-wand-outline"></i> Tạo Video</button>  
    </fieldset>  
    <fieldset>
      <h3>Kết quả Video</h3>
      <h6>To generate the character videos from pose and text description.</h6>
      <div class="form-group fg_3" style="display:none">
        <video width="100%" id="processedVideo" controls loop>
          <source src="{{url('results/zzzzA_Iron_man_on_the_beach.mp4')}}" type="video/mp4">
        </video> 
        <br><br>
        <a href="{{url('results/zzzzA_Iron_man_on_the_beach.mp4')}}" class="action-button" download><i class="ion-android-download"></i> Tải về</a>
      </div>    
    </fieldset>
  </form>  
</section>
<div class='fullloader' id="loader" style="display:none">
  <div class='container'>
    <div class='loader'>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--text'></div>
    </div>
  </div>
</div>

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

<script>
  $(document).ready(function() {
    $("#language").change(function() {
        var selectedValue = $(this).val();
        if (selectedValue === "0") {
            $("#textprompt").attr("placeholder", "Enter character description prompt...");
        } else if (selectedValue === "1") {
            $("#textprompt").attr("placeholder", "Nhập Prompt mô tả nhân vật...");
        } else {
            $("#textprompt").attr("placeholder", "Nhập Prompt mô tả nhân vật...");
        }
    });
});
  const fileInput = document.getElementById('upload');
  const fileUploadDiv = document.getElementById('fileUploadDone');

  fileInput.addEventListener('change', function () {
      if (fileInput.files.length > 0) {
          fileUploadDiv.style.display = 'block';
      } else {
          fileUploadDiv.style.display = 'none';
      }
  });

  function nextFieldset(targetFieldset) {
    $("#loader").show();
    $(".fg_3").hide();
    setTimeout(() => {
        $("#loader").hide();
        $(".fg_3").show();
    }, 10000); 
  }

  function submitForm() {
    $("#loader").show();
    var videoinput = $('#upload')[0].files[0];
    var textprompt = $('#textprompt').val();
    var selectlang = $('#language').val();

    var formData = new FormData();
    formData.append('inputvideo', videoinput);
    formData.append('textprompt', textprompt);
    formData.append('language', selectlang);

      $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: 'upload',
          type: 'POST',
          data: formData,
          contentType: false, 
          processData: false, 
          success: function (response) {
            // console.log(response);
              nextFieldset(3); 
          },
          error: function (xhr) {
            $("#loader").show();
              if (xhr.status === 400) {
                  var errorResponse = JSON.parse(xhr.responseText);
                  var errorMessage = errorResponse.error;
                  alert(errorMessage);
                  window.location.href = '/upload'; 
              } else {
                  console.error('Lỗi không xác định');
              }
          }
      });
  }
</script>
<script>
    (function ($) {
  "use strict";

  //* Form js
  function verificationForm() {
    //jQuery time
    var current_fs, next_fs, previous_fs; 
    var left, opacity, scale; 
    var animating; 

    $(".next").click(function () {
      if (animating) return false;
      animating = true;

      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //activate next step on progressbar using the index of next_fs
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        {
          opacity: 0
        },
        {
          step: function (now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = now * 50 + "%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
              transform: "scale(" + scale + ")",
              position: "absolute"
            });
            next_fs.css({
              left: left,
              opacity: opacity
            });
          },
          duration: 800,
          complete: function () {
            current_fs.hide();
            animating = false;
          },
          //this comes from the custom easing plugin
          easing: "easeInOutBack"
        }
      );
    });

    $(".previous").click(function () {
      if (animating) return false;
      animating = true;

      current_fs = $(this).parent();
      previous_fs = $(this).parent().prev();

      //de-activate current step on progressbar
      $("#progressbar li")
        .eq($("fieldset").index(current_fs))
        .removeClass("active");

      //show the previous fieldset
      previous_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        {
          opacity: 0
        },
        {
          step: function (now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = (1 - now) * 50 + "%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
              left: left
            });
            previous_fs.css({
              transform: "scale(" + scale + ")",
              opacity: opacity
            });
          },
          duration: 800,
          complete: function () {
            current_fs.hide();
            animating = false;
          },
          //this comes from the custom easing plugin
          easing: "easeInOutBack"
        }
      );
    });

    $(".submit").click(function () {
      return false;
    });
  }
  function nice_Select(){
      if ( $('.product_select').length ){ 
          $('select').niceSelect();
      };
  }; 
  /*Function Calls*/
  verificationForm();
  nice_Select ();
})(jQuery);

</script>
</html>
