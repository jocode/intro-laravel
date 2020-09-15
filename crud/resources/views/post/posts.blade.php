<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
         <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    </head>
    <body>
       
       <div class="container">
         @if($errors->any())
            <div class="alert alert-danger">
              @foreach($errors->all() as $error)
                - {{ $error}} <br/>
              @endforeach
            </div>
          @endif

          <div class="content">
            <div class="title m-b-mb">
              Form Request
            </div>
            <div class="links">
              <form action="{{ route('posts.store')}}" method="POST">
                @csrf
                <input type="text" name="title">
                <input type="submit" value="Enviar">
              </form>
            </div>
          </div>
       </div>
          
    </body>
</html>
