<?php
use \Sizzle\Database\RecruitingTokenResponse;

if (!logged_in() || !is_admin()) {
    header('Location: '.'/');
}

define('TITLE', 'S!zzle - Add City');
require __DIR__.'/../header.php';
?>
<!-- Polymer -->
<script src="/components/webcomponentsjs/webcomponents-lite.min.js"></script>
<link rel="import" href="/components/paper-menu/paper-menu.html">
<link rel="import" href="/components/paper-item/paper-item.html">
<link rel="import" href="/components/paper-input/paper-input.html">
<link rel="import" href="/components/paper-dropdown-menu/paper-dropdown-menu.html">

<style>
body {
  background-color: white;
}
#city-form {
  margin-top: 100px;
}
</style>
</head>
<body id="add-city-body">
  <div>
    <?php require __DIR__.'/../navbar.php';?>
  </div>
  <div class="row" id="city-form">
    <div class="col-sm-offset-3 col-sm-6">
      <h1>Add/Edit City</h1>
      <i>
        "Don't put garbage in the database." - Gandhi
      </i>
      <div class="form-group">
        <paper-input
          error-message="This is a required field"
          label="City Name"
          id="name">
          <iron-icon icon="arrow-drop-down" id="city-dropdown-button" suffix></iron-icon>
        </paper-input>
      </div>
      <paper-menu id="city-menu">
      </paper-menu>

      <div id="add-message"></div>
      <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Details</a></li>
          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Images</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
            <form>
              <input type="hidden" name="name" class="city-name"></input>
              <input type="hidden" name="city_id" class="city-id"></input>
              <div class="form-group">
                <input type="text" class="form-control" id="population" name="population" placeholder="Population" required>
              </div>
              <div class="form-group col-sm-6">
                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" required>
              </div>
              <div class="form-group col-sm-6">
                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="county" name="county" placeholder="County" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="timezone" name="timezone" placeholder="Timezone" required>
              </div>
              <h3>Temperatures</h3>
              <div class="form-group form-inline">
                <input type="text" class="form-control" id="temp_hi_spring" name="temp_hi_spring" placeholder="Spring High" required>
                <input type="text" class="form-control" id="temp_lo_spring" name="temp_lo_spring" placeholder="Spring Low" required>
                <input type="text" class="form-control" id="temp_avg_spring" name="temp_avg_spring" placeholder="Spring Average" required>
              </div>
              <div class="form-group form-inline">
                <input type="text" class="form-control" id="temp_hi_summer" name="temp_hi_summer" placeholder="Summer High" required>
                <input type="text" class="form-control" id="temp_lo_summer" name="temp_lo_summer" placeholder="Summer Low" required>
                <input type="text" class="form-control" id="temp_avg_summer" name="temp_avg_summer" placeholder="Summer Average" required>
              </div>
              <div class="form-group form-inline">
                <input type="text" class="form-control" id="temp_hi_fall" name="temp_hi_fall" placeholder="Fall High" required>
                <input type="text" class="form-control" id="temp_lo_fall" name="temp_lo_fall" placeholder="Fall Low" required>
                <input type="text" class="form-control" id="temp_avg_fall" name="temp_avg_fall" placeholder="Fall Average" required>
              </div>
              <div class="form-group form-inline">
                <input type="text" class="form-control" id="temp_hi_winter" name="temp_hi_winter" placeholder="Winter High" required>
                <input type="text" class="form-control" id="temp_lo_winter" name="temp_lo_winter" placeholder="Winter Low" required>
                <input type="text" class="form-control" id="temp_avg_winter" name="temp_avg_winter" placeholder="Winter Average" required>
              </div>
              <button type="submit" class="btn btn-success" id="submit-city">Submit</button>
            </form>
          </div>
          <div role="tabpanel" class="tab-pane" id="profile">
            <form>
              <input type="hidden" name="city_id" class="city-id"></input>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile" name="exampleInputFile">
                <input type="hidden" id="image_file" name="image_file">
                <p class="help-block">Please only upload public domain photos.</p>
              </div>
              <button type="submit" class="btn btn-success" id="submit-images">Submit</button>
            </form>
          </div>
        </div>

      </div>


    </div>
  </div>
    <?php require __DIR__.'/../footer.php';?>
  <script>
  $(document).ready(function(){
    $('#city-menu').hide();
    $('#city-dropdown-button').on('click', function() {
      $('#city-menu').toggle();
    })
    $('#name').on('keyup', function(){
      $('.city-name').val($('#name').val());
      $.post(
        '/ajax/city/get_list',
        {'typed':$('#name').val()},
        function (data) {
          if (data.success == 'true') {
            menuItems = '';
            $.each(data.data, function(index, city){
              menuItems += '<paper-item id="'+city.id+'">'+city.name+'</paper-item>';
            });
            $('#city-menu').html(menuItems);
            $('#city-menu').children('paper-item').each(function(index, item){
              $(this).on('click',function(){
                $('#name').val($(this).html().trim())
                $('#city-menu').hide()
                $.post(
                  '/ajax/city/get/'+$(this).attr('id'),
                  {},
                  function (data) {
                    $('.city-name').val(data.data.name);
                    $('.city-id').val(data.data.id);
                    $('#population').val(data.data.population);
                    $('#longitude').val(data.data.longitude);
                    $('#latitude').val(data.data.latitude);
                    $('#county').val(data.data.county);
                    $('#country').val(data.data.country);
                    $('#timezone').val(data.data.timezone);
                    $('#temp_hi_spring').val(data.data.temp_hi_spring);
                    $('#temp_lo_spring').val(data.data.temp_lo_spring);
                    $('#temp_avg_spring').val(data.data.temp_avg_spring);
                    $('#temp_hi_summer').val(data.data.temp_hi_summer);
                    $('#temp_lo_summer').val(data.data.temp_lo_summer);
                    $('#temp_avg_summer').val(data.data.temp_avg_summer);
                    $('#temp_hi_fall').val(data.data.temp_hi_fall);
                    $('#temp_lo_fall').val(data.data.temp_lo_fall);
                    $('#temp_avg_fall').val(data.data.temp_avg_fall);
                    $('#temp_hi_winter').val(data.data.temp_hi_winter);
                    $('#temp_lo_winter').val(data.data.temp_lo_winter);
                    $('#temp_avg_winter').val(data.data.temp_avg_winter);
                  },
                  'json'
                );
              });
            })
            $('#city-menu').show()
          } else {
            //$('#add-message').html('So you want to add a new city, eh? Doublecheck the spelling real quick. Okay, still looks good? Just remember, what you create EVERY customer will have access to.')
            $('#city-menu').hide()
          }
        },
        'json'
      );
    });
    $('#submit-city').on('click', function (event) {
      event.preventDefault();

      // save info in the database
      if ($('#city-id').val() == undefined) {
        url = '/ajax/city/add';
        $.post(url, $('form').serialize(), function(data) {
          if (data.success === 'true') {
            $('#city-form').html("<h1>New City Created!</h1>It's like Sim City around here, but without Godzilla.");
            $('#city-form').css('margin-bottom','500px');
            window.scrollTo(0, 0);
          } else {
            alert('All fields required!');
          }
        });
      } else {
        //update existing city
      }
    });
  });
  </script>
</body>
</html>
