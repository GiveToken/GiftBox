var glassdoorData = {};

$(document).ready(function() {
  $('#glassdoor-cname')
    .keydown(function() {
      $('label').css('color', '');
      $('#glassdoor-cname').attr('label', "Enter your company's name");
      $('#glassdoor-submit-button')
        .text('Submit')
        .attr('onclick', 'processGlassdoor()');
    });
  $('#glassdoor-submit-button').text('Submit');
  $('#glassdoor-progress').hide();
});

function initGlassdoor() {
  $('#glassdoor-dialog')[0].open();
  resetGlassdoorSubmit();
}

function resetGlassdoorSubmit() {
  $('#glassdoor-submit-button')
    .text('Submit')
    .attr('onclick', 'processGlassdoor()');
}

function processGlassdoor() {
  var cname = $('#glassdoor-cname').val();
  if (cname.length === 0) {
    $('label').css('color', 'red');
    $('#glassdoor-cname').attr('label', "Enter your company's name");
  } else {
    openGlassdoor(cname);
  }
}

function openGlassdoor(cname) {
  $.ajax({
    type: 'GET',
    url: 'http://api.glassdoor.com/api/api.htm',
    dataType: 'jsonp',
    data: {
      'v': 1,
      'format': 'json',
      't.p': 76164,
      't.k': 'cXzYgugsXrC',
      'userip': '24.6.216.224',
      'useragent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36',
      'action': 'employers',
      'q': cname
    },
    beforeSend: function() {
      $('#glassdoor-progress').show();
    },
    complete: function() {
      $('#glassdoor-progress').hide();
    },
    success: function(d) {
      var company = d['response']['employers'][0];
      if (company === undefined) {
        $('label').css('color', 'red');
        $('#glassdoor-cname').attr('label', 'Glassdoor company not found');
      } else {
        $('label').css('color', 'green');
        $('#glassdoor-cname').attr('label', 'Glassdoor company and information found');
        $('#glassdoor-submit-button')
          .text('Select')
          .attr('onclick', 'addGlassdoorData()');

        glassdoorData['name'] = company['name'];
        glassdoorData['website'] = company['website'];
        glassdoorData['image'] = company['squareLogo'];

        $.ajax({
          type: 'POST',
          url: '/ajax/glassdoor-scraper',
          dataType: 'json',
          data: {'link': glassdoorData['image']},
          success: function(d) {
            glassdoorData['key'] = d['data'];
          },
          error: function(x, s, e) {
            console.error(e);
          }
        });
      }
    },
    error: function() {
      $('label').css('color', 'red');
      $('#glassdoor-cname').attr('label', 'Error. Please try again later.');
    }
  });
}

function addGlassdoorData() {
  var alert = false;
  var fields = ['#company', '#company-description'];
  for (var i = 0; i < fields.length; i++) {
    if ($(fields[i]).val().length > 0) {
      alert = true;
      break;
    }
  }
  if ($('#company-image-container').children().length !== 0) alert = true;
  if (alert) {
    $('#glassdoor-alert-dialog')[0].open();
    $('#glassdoor-alert-ok').click(function() {
      clearGlassdoorExisting();
      _addGlassdoorData();
      $('#glassdoor-alert-dialog')[0].close();
    });
    $('#glassdoor-alert-cancel').click(function() {
      $('#glassdoor-alert-dialog')[0].close();
      resetGlassdoor();
    });
  } else {
    _addGlassdoorData();
  }
}

function _addGlassdoorData() {
  $('#company').val(glassdoorData['name']);
  $('#company-description').val(glassdoorData['website']);
  addGlassdoorImage();
  resetGlassdoor();
}

function addGlassdoorImage() {
  var img = null;
  var key = glassdoorData['key'];
  if (glassdoorData['image'].length > 0) {
    img = $('<img class="recruiting-token-image" id="glassdoor-' + key + '">');
    $(img).attr('src', glassdoorData['image']);
    img.data('file', null);
    img.data('name', 'glassdoor-' + key);
    img.data('saved', false);
    img.data('scraped', true);
    img.data('linkedin', false);
    createThumbnail(img, 'company-image-container');
  }
}

function clearGlassdoorExisting() {
  var parent = '#company-image-container';
  var container = '.photo-thumbnail';
  var images = $(container);
  for (var i = 0; i < images.length; i++) {
    var id = $(images[i]).attr('id');
    var key = id.slice(-10);
    $.ajax({
      type: 'POST',
      url: 'ajax/glassdoor-scraper',
      dataType: 'json',
      data: {'clear': key},
      error: function(x, s, e) {
        console.error(e);
      }
    });
  }
  $(parent).children().length > 0 ? $(parent).empty() : null;
}

function resetGlassdoor() {
  $('#glassdoor-dialog')[0].close();
  $('label').css('color', '');
  $('#glassdoor-cname').attr('label', "Enter your company's name");
  $('#glassdoor-cname').val('');
  $('#glassdoor-progress').hide();
  resetGlassdoorSubmit();
}

function cancelGlassdoor() {
  $('label').css('color', '');
  $('#glassdoor-cname').attr('label', "Enter your company's name");
  $('#glassdoor-cname').val('');
  $('#glassdoor-progress').hide();
  resetGlassdoorSubmit();
  $.ajax({
    type: 'POST',
    dataType: 'json',
    data: {'clear': glassdoorData['key']},
    url: '/ajax/glassdoor-scraper',
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
}
