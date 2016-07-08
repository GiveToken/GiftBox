// this is a shared clientside data model
// it's just populated with mock data for now
function getSession() {
   var session = null;
   $.ajax({
     url: "/ajax/get_session",
     async: false
   }).done(function(data, textStatus, jqXHR){
     session = data;
   });
   return session;
}

function getUser(){
  var user = null;
  $.ajax({
     url: "/ajax/user/get_current",
     async: false
   }).done(function(data, textStatus, jqXHR){
     user = data;
   });
   return user;
}

function getOrganization() {
  var organization = null;
  $.ajax({
    url: "/ajax/user/get_organization",
    async: false
  }).done(function(data, textStatus, jqXHR){
    organization = data;
  });
  
  return organization;
}

function getTokens(){
  var tokens = null;
  $.ajax({
    url: "/ajax/user/get_tokens",
    async: false
  }).done(function(data, textStatus, jqXHR){
    tokens = data;
  });
  return tokens;
}

var user = getUser()[0];
var organization = getOrganization()[0];
var tokens = getTokens();
for (i=0; i < tokens.length; i++){
  tokens[i].variant = "01";
  tokens[i].name += "-"+tokens[i].id;
}

user.user_level = "Free Trial";
//get user information

var Model = {

  profile: {
    admin: user.admin,
    user_id: user.id,
    password: null,
    face_image: user.face_image,
    first_name: user.first_name,
    last_name: user.last_name,
    level: user.level,
    level_text: user.user_level,
    linkedin: user.linkedin,
    email: user.email_address,
    username: user.username ? user.username : "",
    name: user.first_name + " " + user.last_name,
    views: 'XX',
    position: user.position,
    about: user.about ? user.about : "",
    levels: [
      {1: "Free"},
      {2: "Standard"},
      {3: "Premium"},
    ],
    social: null,
    allow_token_responses: user.allow_token_responses,
    receive_token_notifications: user.receive_token_notifications
  },
  
  organization: {
    name: organization.name,
    website: organization.website
  },

  tokens: tokens,

  editing: null,
  removing: null,

  findById: function(array, id) {
    var result = null;
    array.forEach(function(item) {
      result = item.id === id ? item : result;
    });
    return result;
  },

  deleteToken: function(tokenId) {
    $.ajax({
       type: "POST",
       url: "/ajax/token/delete",
       data: "tokenId=" + tokenId,
       async: false
     }).done(function(data, textStatus, jqXHR){

     });
  },

  saveChanges: function(){
    var response = null;
    this.profile.first_name = this.profile.name.split(' ')[0];
    this.profile.last_name = this.profile.name.substring(this.profile.name.indexOf(' ') + 1);
    
    $.ajax({
      type: "POST",
      data: this.profile,
      url: "/ajax/user/update",
      async: false
    }).done(function(data, textStatus, jqXHR){
      response = textStatus;
    });
    
    $('.status-message').html('Save successful').addClass('visible');
    window.setTimeout(function () {
      $('.status-message').removeClass('visible');
    }, 3000);
  }
};

var State = Model;