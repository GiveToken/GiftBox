var AccountInfo = React.createClass({

  getInitialState: function() {
    return this.getState(this.props);
  },

  componentWillReceiveProps: function(nextProps) {
    var props = jQuery.extend({}, this.props, nextProps);
    this.setState(this.getState(props));
  },

  getState: function(props) {
    var state = props || {};
    return state;
  },

  handleChangeAllowTokenResponses: function(event) {
    // flip 'Y' to 'N' and vice versa
    event.target.value = event.target.value === 'Y' ? 'N' : 'Y';
    this.handleChange(event);
  },

  handleChangeReceiveTokenNotifications: function(event) {
    // flip 'Y' to 'N' and vice versa
    event.target.value = event.target.value === 'Y' ? 'N' : 'Y';
    this.handleChange(event);
  },

  handleChange: function(event) {
    var name = $('.form-control[name=name]').val();
    var email = $('.form-control[name=email]').val();
    var password = $('.form-control[name=password]').val();
    var about = $('.form-control[name=about]').val();
    var position = $('.form-control[name=position]').val();
    var receive_token_notifications = $('input[name=receive_token_notifications]').val() === 'Y' ? 'N' : 'Y';
    var allow_token_responses = $('input[name=allow_token_responses]').val() === 'Y' ? 'N' : 'Y';
    var linkedin = $('.form-control[name=linkedin]').val();
    
    var company = $('.form-control[name=company]').val();
    var website = $('.form-control[name=website]').val();
    
    var profile = jQuery.extend({},
      this.props.profile,
      { 
        name: name,
        email: email,
        password: password,
        about: about,
        position: position,
        receive_token_notifications: receive_token_notifications,
        allow_token_responses: allow_token_responses,
        linkedin: linkedin
      });
    var organization = jQuery.extend({}, this.props.organization, {name: company, website: website});
    
    this.setState({
      profile: profile,
      organization: organization
    });
  },

  editProfile: function() {
    var profile = jQuery.extend({}, this.props.profile, this.state.profile);
    var organization = jQuery.extend({}, this.props.organization, this.state.organization);
    AccountStore.editProfile({profile: profile, organization: organization});
  },

  render: function() {

    var wantsToReceiveTokenResponseNotifications = this.state.profile.receive_token_notifications === 'Y';
    var allowTokenResponses = this.state.profile.allow_token_responses === 'Y';
    var disabled = {};
    if (this.state.profile.admin === 'N') {
      disabled['disabled'] = 'disabled';
    }

    return <div className="tab-pane active" id="account">
      <h2 className="profile-title">Profile Settings</h2>
      <div className="form-horizontal form-bordered">
        <h3>Your Info</h3>
        <hr />
        <div className="form-group">
          <label className="col-sm-1 control-label">Name</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Name" className="form-control tooltips" name="name" value={this.state.profile.name} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Email</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Email" className="form-control tooltips" name="email" value={this.state.profile.email} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Password</label>
          <div className="col-sm-10">
            <input type="password" placeholder="*******************" className="form-control tooltips" name="password" value={this.state.profile.new_password} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">About</label>
          <div className="col-sm-10">
            <textarea type="text" placeholder="About" className="form-control tooltips" name="about" value={this.state.profile.about} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">LinkedIn</label>
          <div className="col-sm-10">
            <input type="text" placeholder="LinkedIn URL" className="form-control tooltips" name="linkedin" value={this.state.profile.linkedin} onChange={this.handleChange} />
          </div>
        </div>
        <h3>Token Settings</h3>
        <hr />
        <div className="form-group">
          <div className="checkbox col-sm-offset-1 col-sm-10">
            <label>
              <input type="checkbox" name="allow_token_responses" checked={allowTokenResponses} onChange={this.handleChangeAllowTokenResponses} />
              Allow Token Responses?
            </label>
          </div>
        </div>
        <div className="form-group">
          <div className="checkbox col-sm-offset-1 col-sm-10">
            <label>
              <input type="checkbox" name="receive_token_notifications" checked={wantsToReceiveTokenResponseNotifications} onChange={this.handleChangeReceiveTokenNotifications} />
              Receive Token Response Notifications by Email?
            </label>
          </div>
        </div>
        <h3>Company Info</h3>
        <hr />
        <div className="form-group">
          <label className="col-sm-1 control-label">Company</label>
          <div className="col-sm-10">
            <input type="text" {...disabled} placeholder="Company" className="form-control tooltips" name="company" value={this.state.organization.name} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Recruiting Website</label>
          <div className="col-sm-10">
            <input type="text" {...disabled} placeholder="Recruiting Website" className="form-control tooltips" name="website" value={this.state.organization.website} onChange={this.handleChange} />
          </div>
        </div>
        <div className="form-group">
          <label className="col-sm-1 control-label">Position</label>
          <div className="col-sm-10">
            <input type="text" placeholder="Position" className="form-control tooltips" name="position" value={this.state.profile.position} onChange={this.handleChange} />
          </div>
        </div>
      </div>
      <button className="col-sm-offset-7 col-sm-5 save-button btn btn-primary" onClick={this.editProfile}>Save</button>
      <div className="status-message" />
   </div>;
 },

 findByName: function(array, name) {
   return array.filter(function(item) {
     return item.name === name;
   })[0];
 },

});
