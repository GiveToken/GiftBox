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
    new_password: null,
    first_name: user.first_name,
    last_name: user.last_name,
    level: user.level,
    level_text: user.user_level,
    email: user.email_address,
    username: user.username ? user.username : "",
    name: user.first_name + " " + user.last_name,
    views: 'XX',
    location: user.location,
    position: user.position,
    company: user.company,
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

  tokens: tokens,

  viewers: [
    {id: 0, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 1, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 2, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 3, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
    {id: 4, email:'username@yourdomain.com', firstName: 'John', lastName: 'Smith', type: 'viewer'},
  ],

  users: [
    {id: 0, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 1, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 2, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 3, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
    {id: 4, username: 'jsmith25', firstName: 'John', lastName: 'Smith'},
  ],

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
    if (this.profile.new_password) {
      $.ajax({
        type: "POST",
        data: this.profile,
        url: "/ajax/change_password",
        async: false
      }).done(function(data, textStatus, jqXHR){
        response = textStatus;
      });
      alert("You have successfully changed your password");
    }
  }

};
