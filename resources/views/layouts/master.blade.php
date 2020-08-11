
<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.inc.head')
    @yield('css')
</head>

<body>
 
  <!-- container section start -->
  <section id="container" class="">
    @include('layouts.inc.header')
    @include('layouts.inc.sidebar')
    <section id="main-content">
      <div class="wrapper">
          @yield('content')
      </div>
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

  <!-- javascripts -->
 @include('layouts.inc.script')
  <script>
      $(document).ready(function(){
           $.ajaxSetup({
              async:false,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
      });
     
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
       
    </script>
   
 
</body>

</html>
