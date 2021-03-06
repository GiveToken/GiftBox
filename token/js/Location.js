Sizzle.Location = {

  /**
   * Handles a click to the location section
   *
   * @param {object} the event
   */
  'click': function(event) {
    var cityId = 0;
    if ($('#location-section').length === 0) {
      if ($(event.target).is('div')) {
        cityId = $(event.target).attr('id').slice(-1) - 1;
      } else {
        cityId = $(event.target).parents('div').attr('id').slice(-1) - 1;
      }
    }
    if (isNaN(cityId)) {
      cityId = 0;
    }
    Sizzle.Location.handleAjaxCityGet(cities[cityId]);
    $('.mdl-layout__drawer').removeClass('is-visible');
    this.$.list.sharedElements = {
      'fade-in': event.target,
      'fade-out': event.target
    };
    this.$.pages.selected = 1;
    $('google-map').resize();
  },

  /**
   * Returns html for a location
   *
   * @param {int} width - 12, 6, 4 or 3
   * @param {int} id - the id of the location in the array of locations
   * @param {string} locName - the name of the location in the array of locations
   * @returns {boolean}
   */
  'getLocationHTML': function (width, id, locName) {
    var returnHTML = '<div class="mdl-card mdl-cell mdl-cell--'+width+'-col mdl-shadow--2dp link-finger"';
    returnHTML += 'id="location-image-grid-'+id+'">';
    returnHTML += '<div class="mdl-cell no-margin location-main-image" id="location-main-image-'+id+'">';
    returnHTML += '<div class="multi-supporting-location" id="supporting-location-'+id+'">';
    returnHTML += '<i class="material-icons">room</i>';
    returnHTML += '<i class="gt-info-location-'+id+'">'+locName+'</i>';
    returnHTML += '</div></div></div>';
    return returnHTML;
  },

  /**
   * Handles the data return from ajax/city/get
   *
   * @param {object} the data
   */
  'handleAjaxCityGet': function(data) {
    if (data.id !== undefined & data.id > 0) {
      $('.gt-info-location').text(data.name);
      if (Sizzle.Util.dataExists(data.population)) {
        $('.gt-city-population').text(Sizzle.Util.numberWithCommas(data.population));
      }
      $('.gt-city-timezone').text(data.timezone);
      $('.gt-city-county').text(data.county);
      $('google-map')[0].latitude = data.latitude;
      $('google-map')[0].longitude = data.longitude;
      if (!setLocationButtons) {
        $('#housing-location-button').click(function(e){
          e.preventDefault();
          var link = document.createElement('a');
          link.href = 'http://www.zillow.com/homes/'+encodeURIComponent(data.name);
          link.target = '_blank';
          if(document.createEvent){
            // for IE 11
            eventMouse = document.createEvent("MouseEvent");
            eventMouse.initMouseEvent("click",true,true,window,0,0,0,0,0,false,false,false,false,0,null);
          } else {
            eventMouse = new MouseEvent('click');
          }
          link.dispatchEvent(eventMouse);
        });
        $('#cost-location-button').click(function(e){
          e.preventDefault();
          var link = document.createElement('a');
          //link.id = 'cost-location-link'
          link.href = 'http://www.bestplaces.net/cost-of-living/';
          link.target = '_blank';
          if(document.createEvent){
            // for IE 11
            eventMouse = document.createEvent("MouseEvent");
            eventMouse.initMouseEvent("click",true,true,window,0,0,0,0,0,false,false,false,false,0,null);
          } else {
            eventMouse = new MouseEvent('click');
          }
          link.dispatchEvent(eventMouse);
          //$('#cost-location-link').click();
        });
        setLocationButtons = true;
      }

      //temps
      var missingTemp = false;
      if (Sizzle.Util.dataExists(data.temp_hi_spring)) {
        $('.gt-city-spring-hi').text(data.temp_hi_spring);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_lo_spring)) {
        $('.gt-city-spring-lo').text(data.temp_lo_spring);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_avg_spring)) {
        $('.gt-city-spring-avg').text(data.temp_avg_spring);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_hi_summer)) {
        $('.gt-city-summer-hi').text(data.temp_hi_summer);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_lo_summer)) {
        $('.gt-city-summer-lo').text(data.temp_lo_summer);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_avg_summer)) {
        $('.gt-city-summer-avg').text(data.temp_avg_summer);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_hi_fall)) {
        $('.gt-city-fall-hi').text(data.temp_hi_fall);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_lo_fall)) {
        $('.gt-city-fall-lo').text(data.temp_lo_fall);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_avg_fall)) {
        $('.gt-city-fall-avg').text(data.temp_avg_fall);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_hi_winter)) {
        $('.gt-city-winter-hi').text(data.temp_hi_winter);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_lo_winter)) {
        $('.gt-city-winter-lo').text(data.temp_lo_winter);
      } else {
        missingTemp = true;
      }
      if (Sizzle.Util.dataExists(data.temp_avg_winter)) {
        $('.gt-city-winter-avg').text(data.temp_avg_winter);
      } else {
        missingTemp = true;
      }
      if (missingTemp) {
        $('#spring-location').remove();
        $('#summer-location').remove();
        $('#fall-location').remove();
        $('#winter-location').remove();
      }

      // image(s)
      assetHost = Sizzle.Util.getAssetHost();
      url = '/ajax/city/get_images';
      postData = {
        'city_id':data.id
      };
      $.post(url, postData, function(imgData) {
        if (imgData.data !== undefined && imgData.data.length > 0) {
          image_file = imgData.data[0];
          $('#location-back').css('background',"url('"+image_file+"') center / cover");
          $('#location-main-image').css('background',"#ffffff url('"+image_file+"') center / cover");
          $('#location-image-grid').css('width','100%');
          // display 1 image
          $('#location-main-image').css('width','100%');
        }
      });
    }
  },

  /**
   * Handles the data return from ajax/recruiting_token/get_cities
   *
   * @param {object} the data
   */
  'handleAjaxGetCities': function(data) {
    cities = data.data;
    if (1 == cities.length) {
      Sizzle.Location.handleAjaxCityGet(cities[0]);
      $('#doublet-location-section').remove();
      $('#triplet-location-section').remove();
    } else if (2 == cities.length) {
      $('#location-section').remove();
      $('#triplet-location-section').remove();

      // first location
      $('.gt-info-location-1').text(cities[0].name);
      url = '/ajax/city/get_images';
      postData = {
        'city_id':cities[0].id
      };
      $.post(url, postData, function(imgData) {
        if (imgData.data !== undefined && imgData.data.length > 0) {
          image_file = imgData.data[0];
          $('#doublet-location-main-image-1').css('background',"url('"+image_file+"') center / cover");
        }
      });

      // second location
      $('.gt-info-location-2').text(cities[1].name);
      url = '/ajax/city/get_images';
      postData = {
        'city_id':cities[1].id
      };
      $.post(url, postData, function(imgData) {
        if (imgData.data !== undefined && imgData.data.length > 0) {
          image_file = imgData.data[0];
          $('#doublet-location-main-image-2').css('background',"url('"+image_file+"') center / cover");
        }
      });
    } else if (3 == cities.length) {
      $('#doublet-location-section').remove();
      $('#location-section').remove();

      // first location
      $('.gt-info-location-1').text(cities[0].name);
      url = '/ajax/city/get_images';
      postData = {
        'city_id':cities[0].id
      };
      $.post(url, postData, function(imgData) {
        if (imgData.data !== undefined && imgData.data.length > 0) {
          image_file = imgData.data[0];
          $('#triplet-location-main-image-1').css('background',"url('"+image_file+"') center / cover");
        }
      });

      // second location
      $('.gt-info-location-2').text(cities[1].name);
      url = '/ajax/city/get_images';
      postData = {
        'city_id':data.data[1].id
      };
      $.post(url, postData, function(imgData) {
        if (imgData.data !== undefined && imgData.data.length > 0) {
          image_file = imgData.data[0];
          $('#triplet-location-main-image-2').css('background',"url('"+image_file+"') center / cover");
        }
      });

      // third location
      $('.gt-info-location-3').text(cities[2].name);
      url = '/ajax/city/get_images';
      postData = {
        'city_id':data.data[2].id
      };
      $.post(url, postData, function(imgData) {
        if (imgData.data !== undefined && imgData.data.length > 0) {
          image_file = imgData.data[0];
          $('#triplet-location-main-image-3').css('background',"url('"+image_file+"') center / cover");
        }
      });
    } else if (3 < cities.length) {
      $('#triplet-location-section').remove();
      $('#doublet-location-section').remove();
      var numCities = cities.length;
      var numExtraCities = cities.length % 3;
      var locationHTML = '';
      cities.forEach(function(value, index){
        if (index < numCities - numExtraCities) {
          locationHTML += Sizzle.Location.getLocationHTML(4, index, value.name);
        } else if (numExtraCities === 2) {
          locationHTML += Sizzle.Location.getLocationHTML(6, index, value.name);
        } else if (numExtraCities === 1) {
          locationHTML += Sizzle.Location.getLocationHTML(12, index, value.name);
        }
        if (index < numCities - 1) {
          locationHTML += getSpacerHTML();
        }
      });
      $('#location-section').html(locationHTML);
      url = '/ajax/city/get_images';
      cities.forEach(function(value, index){
        postData = {
          'city_id':value.id
        };
        $.post(url, postData, function(imgData) {
          if (imgData.data !== undefined && imgData.data.length > 0) {
            image_file = imgData.data[0];
            $('#location-main-image-'+index).css('background',"url('"+image_file+"') center / cover");
          }
        });
      });
    } else { // no location
      $('#triplet-location-section').remove();
      $('#doublet-location-section').remove();
      $('#location-section').remove();
    }
  },
};
