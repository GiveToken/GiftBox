<?php
use \Sizzle\Bacon\{
    Text\HTML,
    Database\City,
    Database\RecruitingCompany,
    Database\RecruitingToken
};

if (!logged_in()) {
  login_then_redirect_back_here();
}

$user_id = $_SESSION['user_id'] ?? '';

if (isset($_GET['id'])) {
    $token = new RecruitingToken($_GET['id'], 'long_id');
    if ($token->user_id != $user_id && !is_admin()) {
        header('Location: '.APP_URL.'/tokens');
    }
    $token_company = new RecruitingCompany($token->recruiting_company_id);
} else {
    $token = new RecruitingToken();
}

$city = ($token->getCities())[0] ?? new City();
$city_name = $city->name ?? '';

function paper_text($label, $id, $value, $required = false)
{
    echo PHP_EOL;
    echo '              <paper-input value="'.htmlspecialchars($value).'" '.($required ? 'required error-message="This is a required field"' : null).' label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'"></paper-input>'.PHP_EOL;
}
function paper_textarea($label, $id, $value, $required = false)
{
    echo PHP_EOL;
    echo '              <paper-textarea value="'.htmlspecialchars($value).'" '.($required ? 'required error-message="This is a required field"' : null).' label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'" rows="1">'.PHP_EOL;
    echo '              </paper-textarea>'.PHP_EOL;
}
function paper_dropdown($label, $id, $options, $selected_index = null, $required = false)
{
    echo '      <paper-dropdown-menu '.($required ? 'required error-message="This is a required field"' : null).' class="recruiting-field" label="'.$label.'" id="'.$id.'" name="'.str_replace('-', '_', $id).'">'.PHP_EOL;
    echo '        <paper-menu class="dropdown-content"'.(is_null($selected_index) ? null : ' selected="'.$selected_index.'"').'>'.PHP_EOL;
    foreach ($options as $value => $option) {
        echo '          <paper-item id="'.$value.'">'.ucwords($option).'</paper-item>'.PHP_EOL;
    }
    echo '        </paper-menu>'.PHP_EOL;
    echo '      </paper-dropdown-menu>'.PHP_EOL;
}

define('TITLE', 'S!zzle - Create Recruiting Token');
require __DIR__.'/header.php';
?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/css/create_recruiting.min.css">

    <!-- Polymer -->
    <script src="/components/webcomponentsjs/webcomponents-lite.min.js"></script>

    <link rel="import" href="/components/iron-icons/iron-icons.html">
    <link rel="import" href="/components/iron-icon/iron-icon.html">
    <link rel="import" href="/components/iron-form/iron-form.html">
    <link rel="import" href="/components/paper-menu/paper-menu.html">
    <link rel="import" href="/components/paper-item/paper-item.html">
    <link rel="import" href="/components/paper-icon-button/paper-icon-button.html">
    <link rel="import" href="/components/paper-input/paper-input.html">
    <link rel="import" href="/components/paper-header-panel/paper-header-panel.html">
    <link rel="import" href="/components/paper-toolbar/paper-toolbar.html">
    <link rel="import" href="/components/paper-styles/paper-styles.html">
    <link rel="import" href="/components/paper-card/paper-card.html">
    <link rel="import" href="/components/paper-checkbox/paper-checkbox.html">
    <link rel="import" href="/components/paper-button/paper-button.html">
    <link rel="import" href="/components/paper-input/paper-textarea.html">
    <link rel="import" href="/components/paper-dropdown-menu/paper-dropdown-menu.html">
    <link rel="import" href="/components/paper-dialog/paper-dialog.html">
    <link rel="import" href="/components/paper-fab/paper-fab.html">
    <link rel="import" href="/components/paper-slider/paper-slider.html">

    <style is="custom-style">
        .center-column {
          margin-top: 100px;
        }
        .field-container {
          text-align: left;
        }
        paper-card {
            display: block;
            width: 100%;
            background: #424242;
            margin-top: 20px;
            --paper-card-header-color: white;
            --paper-card-header-text: {font-weight: normal;}
        }
        paper-card#send-token-via {
            display: none;
        }
        paper-input, paper-textarea, paper-dropdown-menu {
            --paper-input-container-focus-color: #1094F7;
            --paper-input-container-input-color: white
        }
        paper-button {
            background: #009688;
            color: white;
        }
        paper-button.dialog-button {
            background: #2193ED;
            font-size: 14px;
            margin-top: 0px;
            margin-bottom: 20px;
            border: 0px;
        }
        .library-button {
            margin: 10px 0px;
            width: 100%;
        }
        iron-icon {
            margin-right: 10px;
            color: #676767;
        }
        paper-toolbar {
            --paper-toolbar-background: #111111
        }
        #progress-bar {
            width: 100%;
            height: 70px;
            padding: 7px 0px 0px 70px;
        }
        #token-strength {
            width: 100%;
            height: 300px;
        }
        paper-fab{
            --paper-fab-background: #2193ED;
            display: inline-block;
            vertical-align: middle;
        }
        paper-fab.progress-fab {
            margin-left: 10px;
        }
        paper-dialog {
            --paper-dialog-background-color: #424242;
            color: white;
             --paper-dialog-title: {font-size: 24px; font-weight: 300; margin-top: 10px}
        }
        paper-dialog#status-dialog {
            --paper-dialog-background-color: #303030;
        }
        .company-social-site-td {
          border:0;
          font-size: 18px;
        }
        .company-social-user-td {
          border:0;
          padding-bottom: 20px;
          padding-left: 5px;
          width: 500px;
          font-size: 18px;
        }
        .progress-text.active {
          color: #009688;
        }
        .paper-checkbox-0 #checkboxLabel.paper-checkbox {
          color: white;
        }
        paper-checkbox {
          --paper-checkbox-label-color: white;
          --paper-checkbox-checkmark-color: black;
          --paper-checkbox-checked-color: white;
        }
    </style>

</head>
<body>
  <div>
    <?php require_once __DIR__.'/navbar.php';?>
  </div>
    <div class="center-column">
        <paper-card id="progress-bar">
                <paper-fab icon="looks one" class="progress-fab">1</paper-fab>
                <span class="progress-text active"><strong>Job Info</strong></span>
                <div class="progress-line"></div>
                <paper-fab icon="looks one" class="progress-fab"></paper-fab>
                <span class="progress-text">Company Info</span>
                <div class="progress-line"></div>
                <paper-fab icon="looks one" class="progress-fab"></paper-fab>
                <span class="progress-text">Send Token</span>
        </paper-card>
        <div id="left-column">
            <form is="iron-form" id="recruiting-token-form">
                <input type="hidden" id="id" name="id" value="<?php echo $token->id ?>">
                <input type="hidden" id="long-id" name="long_id" value="<?php echo $token->long_id ?>">
                <?php if (isset($token_company)) {
                    $company_name = '' == $token_company->name ? 'Unnamed Company' : $token_company->name;?>
                    <input type="hidden" id="recruiting-company-id" name="recruiting_company_id" value="<?php echo $token->recruiting_company_id ?>">
<!--                    <paper-card id="company-info-header">
                      <div class="card-content" style="height:90px;">
                        <i class="pull-left" style="font-size:25px;padding:15px;font:normal;"><?php echo $company_name;?></i>
                        <a class="pull-right" href="<?php echo "/create_company?id={$token->recruiting_company_id}&referrer={$token->long_id}" ?>"><paper-button>EDIT COMPANY</paper-button></a>
                      </div>
                    </paper-card>-->
                <?php }?>

                <paper-card id="send-token-via" heading="Send Token via">
                    <div id="send-link-list-container">
                        <div class="send-link-container send-link-container-hover">
                            <div class="inner-send-link-container">
                                <div><i class="material-icons send-link-icon">image</i></div>
                                <div class="send-link-text-container">Linked Image</div>
                            </div>
                        </div>
                        <div class="send-link-container send-link-container-hover">
                            <div class="inner-send-link-container">
                                <i class="material-icons send-link-icon">insert_link</i>
                                <div class="send-link-text-container">Link</div>
                            </div>
                        </div>
                        <div class="send-link-container send-link-container-hover">
                            <div class="inner-send-link-container">
                                <i class="material-icons send-link-icon">email</i>
                                <div class="send-link-text-container">Token e-Mail</div>
                            </div>
                        </div>
                    </div>
                    <div id="send-link-content-container">
                        <div class="send-link-content">
                            <p>A linked image has been copied to your clipboard.  Simply go to your email, paste the image in, and send out the email.</p>
                            <p>Certain email providers require an image to be linked separately. All information is provided below.</p>
                        </div>
                        <div class="send-link-content">
                        </div>
                        <div class="send-link-content">
                            <p>Have us email out your Token.  This option will provide you with the greatest analytics and potential for A/B split testing.</p>
                        </div>
                    </div>
                </paper-card>

                <paper-card id="required-info" heading="Required Info">
                    <div class="field-container">
                        <?php
                        paper_text('Job Title', 'job-title', $token->job_title, true);
                        paper_textarea('Job Description', 'job-description', HTML::from($token->job_description ?? ''), true);
                        ?>
                      <paper-input
                        value="<?= $city_name?>"
                        error-message="This is a required field"
                        label="Job Location"
                        id="city-id"
                        name="city_id">
                        <iron-icon icon="arrow-drop-down" id="city-dropdown-button" suffix></iron-icon>
                      </paper-input>
                    </div>
                </paper-card>
                <paper-card id="basic-info" heading="Additional Info">
                    <div class="field-container">
                        <?php paper_textarea('Skills Required', 'skills-required', HTML::from($token->skills_required ?? '')); ?>
                        <?php paper_textarea('Responsibilities', 'responsibilities', HTML::from($token->responsibilities ?? '')); ?>
                        <?php paper_textarea('Perks', 'perks', HTML::from($token->perks ?? '')); ?>
                        <?php paper_text('Link to Apply', 'apply-link', ($token->apply_link ?? '')); ?>
                    </div>
                </paper-card>
                <?php if(is_admin()) { ?>
                    <paper-card id="admin-info" heading="Admin Settings">
                      <div class="field-container">
                        <paper-checkbox
                          id="recruiter-profile"
                          name="recruiter_profile"
                          <?php echo isset($token->recruiter_profile) && 'Y' == $token->recruiter_profile ? 'checked' : '';?>>
                          Show Recruiter Profile
                        </paper-checkbox>
                        <br />
                        <paper-checkbox
                          id="auto-popup"
                          name="auto-popup"
                          <?= (!isset($token->auto_popup) || 'Y' == $token->auto_popup) ? 'checked' : ''?>>
                          Automatic Interest Dialog Popup After <b id="auto-popup-delay"><?=$token->auto_popup_delay ?? 15?></b> Seconds
                        </paper-checkbox>
                        <paper-slider
                          id="delay-slider"
                          value="<?=$token->auto_popup_delay ?? 15?>"
                          max="60"
                          onChange="updateDelay();">
                        </paper-slider>
                        <paper-checkbox
                          id="collect-name"
                          name="collect-name"
                          <?= (!isset($token->collect_name) || 'Y' == $token->collect_name) ? 'checked' : ''?>>
                          Collect Name of Interested Recruits
                        </paper-checkbox>
                        <br />
                      </div>
                      <?php if (isset($token->long_id) && false !== $token->screenshot()) { ?>
                        <div class="field-container" id="screenshot">
                          <img src="/uploads/<?= $token->screenshot()?>" />
                        </div>
                      <?php }?>
                    </paper-card>
                <?php }?>

<?php /*                <div class="button-container">
                    <paper-button raised class="bottom-button" onclick="saveRecruitingToken(true)">SAVE &amp; PREVIEW</paper-button>
                    <a href="#" id="token-preview" target="_blank"></a>
                </div>*/?>
            </form>
        </div>
        <div id="right-column" class="pull-right">
            <?php /*
            <paper-card heading="Token Strength" id="token-strength">
            </paper-card>
            */ ?>
            <div class="button-container">
                <paper-button raised onclick="openToken()">OPEN</paper-button>
                <paper-button id="save-continue-button" raised onclick="saveRecruitingToken()">SAVE &amp; CONTINUE</paper-button>
            </div>
       </div>
    </div>

    <paper-dialog class="recruiting-dialog" id="open-dialog" modal>
        <h2>Open</h2>
        <form is="iron-form" id="open-token-form">
            <div class="field-container">
            <?php
                $user_tokens = (new RecruitingToken())->getUserTokens((int) $user_id);
                $tokens = array();
                foreach ($user_tokens as $tkn) {
                    $tokenCompanyName = ''!=$tkn->company ? $tkn->company : 'Unnamed Company';
                    $tokens[$tkn->long_id] = $tokenCompanyName." - ".$tkn->job_title;
                }
                paper_dropdown('Select a Token to open', 'token-to-open', $tokens, null, true);
            ?>
            </div>
        </form>
        <div class="buttons">
            <paper-button class="dialog-button" onclick="processOpen()">Open</paper-button>
            <paper-button dialog-dismiss class="dialog-button">Cancel</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="validation-dialog" modal>
        <h2 style="margin-bottom:20px">Save Failed</h2>
        <p id="validation-message">No message supplied</p>
        <div class="buttons">
            <paper-button dialog-dismiss class="dialog-button" id="validation-button">OK</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="status-dialog">
        <p id="status-message">No message supplied</p>
    </paper-dialog>

    <?php require_once __DIR__.'/footer.php';?>

    <!-- JavaScript -->
    <script src="components/Autolinker.js/dist/Autolinker.min.js"></script>
    <script src="js/create_recruiting.min.js?v=<?php echo VERSION;?>"></script>
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>
    <script>
    $( document ).ready(function() {
      $('#city-menu').hide();
      $('#city-dropdown-button').on('click', function() {
        $('#city-menu').toggle();
      })
      $('#city-id').on('keyup', function(){
        $.post(
          '/ajax/city/get_list',
          {'typed':$('#city-id').val()},
          function (data) {
            if (data.success == 'true') {
              $('#city-menu').remove()
              menuItems = '<paper-menu id="city-menu">';
              $.each(data.data, function(index, city){
                menuItems += '<paper-item id="'+city.id+'">'+city.name+'</paper-item>';
              });
              menuItems += '</paper-menu>';
              $(menuItems).insertAfter('#city-id');
              $('#city-menu').show()
              $('#city-menu').children().children('paper-item').each(function(index, item){
                $(item).on('click',function(){
                  $('#city-id').val($(this).html().trim())
                  $('#city-menu').hide()
                });
              })
            } else {
              $('#city-menu').hide()
            }
          },
          'json'
        );
      });
    });
    </script>
</body>
</html>
