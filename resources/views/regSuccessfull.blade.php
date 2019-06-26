@extends('layouts.registerSale')

@section('content')

<div id="app">
    <div class = "text-center"><img style = "margin-top:30px" class = "register_step_logo" src = "assets/img/Assiqura_Logo.png"/></div>
    <div class = "thankpage-text">Hai firmato il contratto con successo!</div>
    <div class = "thankpage-link-to-new" ><a href = "{{ url('/') }}" style = "text-decoration: none !important;">Nuova registrazione</a></div>
</div>
<div id="lds-ellipsis" style="display:none"><div></div><div></div><div></div><div></div></div>
@endsection

@section('scripts')
<script src="assets/js/script.min.js"></script>
@endsection

@section('css')
<link rel="stylesheet" href="assets/css/main.css">
<style>
#lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
#lds-ellipsis div {
  position: absolute;
  top: 27px;
  width: 11px;
  height: 11px;
  border-radius: 50%;
  background: #fff;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
#lds-ellipsis div:nth-child(1) {
  left: 6px;
  animation: lds-ellipsis1 0.6s infinite;
}
#lds-ellipsis div:nth-child(2) {
  left: 6px;
  animation: lds-ellipsis2 0.6s infinite;
}
#lds-ellipsis div:nth-child(3) {
  left: 26px;
  animation: lds-ellipsis2 0.6s infinite;
}
#lds-ellipsis div:nth-child(4) {
  left: 45px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(19px, 0);
  }
}

</style>
@endsection

<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    function setCookie(cname, cvalue, exdays) {
     var d = new Date();
     d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
     var expires = "expires="+d.toUTCString();
     document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
   }
    function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
    }

    function checkCookie() {
    var user = getCookie("redUrls");
     if (user != "") {
     document.getElementById('lds-ellipsis').style.display="block";
     var urlsArr =JSON.parse(getCookie("redUrls")); 
     var firstUrl = urlsArr.shift();
     console.log(firstUrl);
     $value = JSON.stringify(urlsArr);
     setCookie('redUrls',$value,1);
     window.open(firstUrl, '_self');
    } else {
        document.getElementById('lds-ellipsis').style.display="none";  
   }
}
     
    $(document).ready(function(){
        $.ajax({
            url: "/download_finished_document_background?sale_id={!! $sale_id !!}",
            type: "GET"
        });  
         checkCookie();
    });
</script>
