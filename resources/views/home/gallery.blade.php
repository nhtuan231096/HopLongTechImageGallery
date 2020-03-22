<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ảnh thực tế sản phẩm: {{$title}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Ảnh thực tế sản phẩm: {{$title}}</h2>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      @foreach($images as $key=>$image)
	  <?php $active = $key == 0 ? "active" : ""; ?>
      <li data-target="#myCarousel" data-slide-to="{{$key}}" class="{{$active}}"></li>
      @endforeach
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
	  @foreach($images as $key=>$image)
	  <?php $active = $key == 0 ? "active" : ""; ?>
      <div class="item {{$active}}">
        <img src="{{url('uploads/image-gallery')}}/{{$image}}" alt="{{$image}}" style="width:900px;height: 900px">
        <div class="carousel-caption">
          <!-- <h3>Los Angeles</h3> -->
          <!-- <p>LA is always so much fun!</p> -->
        </div>
      </div>
      @endforeach
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</body>
</html>
