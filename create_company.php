<?php
use \Sizzle\Bacon\{
    Text\HTML,
    Database\RecruitingCompany,
    Database\RecruitingCompanyImage,
    Database\RecruitingCompanyVideo,
    Database\RecruitingToken,
    Database\User
};

if (!logged_in()) {
  login_then_redirect_back_here();
}

$user_id = $_SESSION['user_id'] ?? '';
$referrer = $_GET['referrer'] ?? '';

if (isset($_GET['id'])) {
    $token_company = new RecruitingCompany($_GET['id']);
    $user = new User($user_id);
    if (isset($token_company->organization_id)
        && $token_company->organization_id != $user->organization_id
        && !is_admin()
    ) {
        header('Location: '.APP_URL.'tokens');
    }
    $token_images = (new RecruitingCompanyImage())->getByCompanyId((int) $token_company->id);
    $token_videos = (new RecruitingCompanyVideo())->getByCompanyId((int) $token_company->id);
} else {
    $token_company = new RecruitingCompany();
    $token_images = array();
    $token_videos = array();
}

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

define('TITLE', 'S!zzle - Create Recruiting Company');
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
    <link rel="import" href="/components/paper-button/paper-button.html">
    <link rel="import" href="/components/paper-input/paper-textarea.html">
    <link rel="import" href="/components/paper-dropdown-menu/paper-dropdown-menu.html">
    <link rel="import" href="/components/paper-dialog/paper-dialog.html">
    <link rel="import" href="/components/paper-fab/paper-fab.html">
    <link rel="import" href="/components/paper-progress/paper-progress.html">

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
        #progress-bar {
          width: 100%;
          height: 70px;
          padding: 7px 0px 0px 70px;
        }
        .progress-text.active {
          color: #009688;
        }
        #use-existing-company-button {
          margin-left: 50px;
          margin-right: 50px;
        }
        paper-progress {
          width: 100%;
        }
    </style>

</head>
<body>
  <div>
    <?php require_once __DIR__.'/navbar.php';?>
  </div>
    <div class="center-column">
      <paper-card id="progress-bar">
        <a href="<?php echo '/create_recruiting?id='.$referrer;?>">
          <paper-fab icon="looks one" class="progress-fab">1</paper-fab>
        </a>
        <span class="progress-text">Job Info</span>
        <div class="progress-line"></div>
        <paper-fab icon="looks one" class="progress-fab"></paper-fab>
        <span class="progress-text active"><strong>Company Info</strong></span>
        <div class="progress-line"></div>
        <paper-fab icon="looks one" class="progress-fab"></paper-fab>
        <span class="progress-text">Send Token</span>
      </paper-card>
        <div id="left-column">
            <form is="iron-form" id="recruiting-company-form">
              <input type="hidden" id="id" name="recruiting_company_id" value="<?php echo $token_company->id ?>">
              <input type="hidden" id="recruiting-token-id" name="recruiting_token_id" value="<?php echo $referrer;?>">

                    <paper-card id="company-info" heading="Important Company Info">
                        <i>Changes will affect every token associated with this company.</i>
                        <div class="field-container">
                            <?php paper_text('Company Name', 'company', $token_company->name); ?>
                            <?php //paper_text('Company Website', 'company-website', $token_company->website); ?>
                            <?php paper_textarea('Company Description', 'company-description', HTML::from($token_company->description ?? '')); ?>
                            <?php paper_textarea('Company Values', 'company-values', HTML::from($token_company->values ?? '')); ?>
                        </div>
                    </paper-card>
                    <paper-card id="company-images" heading="Company Images">
                        <div class="field-container">
                            <div class="icon-bar">
                                <span class="icon-bar-text">Add Images From: </span>
                                <div class="icon-container">
                                    <input class="hidden-file-input" type="file" multiple id="select-image-file" />
                                    <a class="icon-link" id="desktop-icon-link" href="javascript:void(0)" onclick="$('#select-image-file').trigger('click')"><i class="fa fa-laptop fa-2x add-icon"></i></a>
                                </div>
                            </div>
                            <?php if (count($token_images) > 0) {?>
                              <div class="thumbnail-list-container" id="company-image-container">
                              <?php
                              $i = 0;
                              foreach ($token_images as $token_image) {
                                  $image_path = FILE_STORAGE_PATH.$token_image['file_name'];
                                  $image_id = str_replace('.', '_', $token_image['file_name']);
                                  $image_id = str_replace(' ', '_', $image_id);
                                  $image_id = str_replace('(', '_', $image_id);
                                  $image_id = str_replace(')', '_', $image_id);
                                  echo '<div class="thumbnail-container">';
                                  echo '<div class="inner-thumbnail-container">';
                                  echo '<div class="image-thumbnail-image">';
                                  echo '<img class="recruiting-token-image photo-thumbnail" id="'.$image_id.'" data-id="'.$token_image['id'].'" src="'.$image_path.'">';
                                  echo '</div>';
                                  echo '<div class="image-thumbnail-buttons">';
                                  if ('Y' == $token_image['logo']) {
                                    echo '<paper-button id="mark-logo-button-'.$i.'" raised class="remove-button" style="color:black;background:#2193ED;")disabled>LOGO</paper-button>';
                                  } else {
                                    echo '<paper-button id="mark-logo-button-'.$i.'" raised class="remove-button" data-saved="true" onclick="markImageLogo(\''.$token_image['id'].'\', \''.$i.'\')">MARK LOGO</paper-button>';
                                  }
                                  if ('Y' == $token_image['mobile']) {
                                    echo '<paper-button id="mark-mobile-button-'.$i.'" raised class="remove-button" style="color:black;background:#2193ED;")disabled>MOBILE IMAGE</paper-button>';
                                  } else {
                                    echo '<paper-button id="mark-mobile-button-'.$i.'" raised class="remove-button" data-saved="true" onclick="markImageMobile(\''.$token_image['id'].'\', \''.$i.'\')">USE ON MOBILE</paper-button>';
                                  }
                                  echo '<paper-button raised class="remove-button" data-saved="true" onclick="removeImageById(\''.$image_id.'\')">REMOVE</paper-button>';
                                  echo '</div>';
                                  echo '</div>';
                                  echo '</div>';
                                  $i++;
                              }
                              echo '</div>';
                            } else { ?>
                              <div class="thumbnail-list-container" id="company-image-container" hidden></div>
                            <?php } ?>
                        </div>
                    </paper-card>
                    <paper-card id="company-videos" heading="Company Videos">
                        <div class="field-container">
                            <div class="icon-bar">
                                <span class="icon-bar-text">Add Videos From: </span>
                                <div class="icon-container">
                                    <paper-button class="icon-button" raised onclick="openVideoDialog()">WEB ADDRESS</paper-button>
    <!--                            <a class="icon-link" id="desktop-icon-link" href="javascript:void(0)" onclick="$('#select-video-file').trigger('click')"><i class="fa fa-laptop fa-2x add-icon"></i></a>
                                    <a class="icon-link" id="dropbox-icon-link" href="javascript:void(0)" onclick="openDropBoxImage()"><i class="fa fa-dropbox fa-2x add-icon"></i></a>
                                    <a class="icon-link" href="javascript:void(0)" onclick="selectFacebookImage()"><i class="fa fa-facebook-square fa-2x add-icon"></i></a>
                                    <paper-button class="icon-button" raised onclick="library()">LOCAL LIBRARY</paper-button>
    -->
                                </div>
                            </div>
                            <?php if (count($token_videos) > 0) {?>
                              <div class="thumbnail-list-container" id="company-video-container">
                              <?php
                              foreach ($token_videos as $token_video) {
                                  $image_id = $token_video['source_id'];
                                  switch ($token_video['source']) {
                                      case 'youtube':
                                      $thumbnail_src = "https://img.youtube.com/vi/$image_id/0.jpg";
                                      break;
                                      case 'vimeo':
                                      /*$vimeo_json_url = "https://vimeo.com/api/v2/video/$image_id.json";
                                      ob_start();
                                      $handle = curl_init();
                                      curl_setopt($handle, CURLOPT_POST, true);
                                      curl_setopt($handle, CURLOPT_URL, $vimeo_json_url);
                                      $response = curl_exec($handle);
                                      $json = ob_get_contents();
                                      ob_end_clean();
                                      $return = json_decode($json);*/
                                      $thumbnail_src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Vimeo_Logo.svg/500px-Vimeo_Logo.svg.png';
                                      //$thumbnail_src = $return[0]->thumbnail_medium;
                                      break;
                                  }
                                  echo '<div class="thumbnail-container">';
                                  echo '  <div class="inner-thumbnail-container">';
                                  echo '      <img class="recruiting-token-video photo-thumbnail" id="'.$image_id.'" data-id="'.$token_video['id'].'" src="'.$thumbnail_src.'">';
                                  echo '      <paper-button raised class="remove-button" data-saved="true" onclick="removeImageById(\''.$image_id.'\')">REMOVE</paper-button>';
                                  echo ' </div>';
                                  echo '</div>';
                              }
                              echo '</div>';
                            } else { ?>
                              <div class="thumbnail-list-container" id="company-video-container" hidden></div>
                            <?php } ?>
                        </div>
                    </paper-card>
                    <paper-card id="company-social-media" heading="Company Social Media">
                        <div class="field-container">
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://facebook.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-facebook', $token_company->facebook); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://linkedin.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-linkedin', $token_company->linkedin); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://youtube.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-youtube', $token_company->youtube); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://twitter.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-twitter', $token_company->twitter); ?>
                                </td>
                              </tr>
                            </table>
                            <table>
                              <tr>
                                <td class="company-social-site-td">
                                  https://plus.google.com/
                                </td>
                                <td class="company-social-user-td">
                                  <?php paper_text('', 'company-google-plus', $token_company->google_plus); ?>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </paper-card>
            </form>
        </div>
        <div id="right-column" class="pull-right">
          <div class="button-container">
            <paper-button raised onclick="backToToken('<?php echo $referrer;?>')">BACK</paper-button>
            <paper-button id="save-continue-button" raised onclick="saveCompany()">SAVE &amp; CONTINUE</paper-button>
          </div>
          <div class="button-container">
            <paper-button raised onclick="chooseCompany()" id="use-existing-company-button">
              USE EXISTING COMPANY
            </paper-button>
          </div>
          <!--
          <div class="button-container">
            <paper-button raised onclick="initLinkedIn()" id="linkedin-scrape-button">
              IMPORT FROM LINKEDIN
            </paper-button>
          </div>
        -->
          <div class="button-container">
            <paper-button raised onclick="skipCompany()" id="skip-company-button">
              Skip COMPANY
            </paper-button>
          </div>
       </div>
    </div>

    <paper-dialog class="recruiting-dialog" id="use-existing-company-dialog" modal>
        <h2>Use Existing Company</h2>
        <form is="iron-form" id="use-existing-company-form">
            <div class="field-container">
            <?php
                $companies = is_admin() ? (new RecruitingCompany())->getAll() : (new RecruitingToken())->getUserCompanies((int) $user_id);
                $options = array();
                foreach ($companies as $co) {
                    $options[$co['id']] = '' != $co['name'] ? $co['name'] : 'Unnamed Company';
                }
                paper_dropdown('Select a Company to use', 'company-to-use', $options, null, true);
            ?>
            </div>
        </form>
        <div class="buttons">
            <paper-button class="dialog-button" onclick="processCompany()">Use</paper-button>
            <paper-button dialog-dismiss class="dialog-button">Cancel</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="linkedin-dialog" modal>
      <h2>Import company information from LinkedIn</h2>
      <paper-input id="linkedin-url" label="Enter your company's LinkedIn URL" autofocus></paper-input>
      <div class="buttons">
        <paper-button id="linkedin-submit-button" class="dialog-button" onclick="processLinkedIn()">Submit</paper-button>
        <paper-button id="linkedin-cancel-button" dialog-dismiss class="dialog-button" onclick="cancelLinkedIn()">Cancel</paper-button>
      </div>

      <paper-dialog class="recruiting-dialog" id="alert-dialog" modal>
        <h2>Warning</h2>
        <p>"Select" will replace data already in the form</p>
        <paper-button id="alert-ok">Ok</paper-button>
        <paper-button id="alert-cancel">Cancel</paper-button>
      </paper-dialog>

      <div id="linkedin-progress">
        <paper-progress indeterminate></paper-progress>
      </div>

    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="video-dialog" modal>
        <h2>Upload video from web address</h2>
        <paper-input id="video-dialog-url" label="Paste video embed URL here" autofocus></paper-input>
        <div class="buttons">
            <paper-button class="dialog-button video-dialog-button" onclick="processVideoURL()">Add</paper-button>
            <paper-button dialog-dismiss class="dialog-button video-dialog-button" onclick="cancelVideoURL()">Cancel</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="validation-dialog" modal>
        <h2>Problem...</h2>
        <p id="validation-message">No message supplied</p>
        <div class="buttons">
            <paper-button dialog-dismiss class="dialog-button" id="validation-button">OK</paper-button>
        </div>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="status-dialog">
        <p id="status-message">No message supplied</p>
    </paper-dialog>

    <paper-dialog class="recruiting-dialog" id="leaving-alert" modal>
      <h2>Warning</h2>
      <p>Leaving this page will erase data already in the form</p>
      <paper-button dialog-dismiss class="dialog-button" id="leaving-ok">Ok</paper-button>
      <paper-button dialog-dismiss class="dialog-button" id="leaving-cancel">Cancel</paper-button>
    </paper-dialog>

    <?php require_once __DIR__.'/footer.php';?>

    <!-- JavaScript -->
    <script src="components/Autolinker.js/dist/Autolinker.min.js"></script>
    <script src="js/create_recruiting.min.js?v=<?php echo VERSION;?>"></script>
    <script src="js/linkedin-scraper.min.js?v=<?php echo VERSION;?>"></script>
    <script 
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>
    <script>
    /**
     * Adds existing company choice to form & hides form elements
     */
    function processCompany() {
      if ($("#use-existing-company-form")[0].validate()) {
        setStatus("Attaching company...");
        var menu = $("#company-to-use")[0].contentElement;
        var companyId = menu.selectedItem.id;
        window.location = '/create_company?id='+companyId+'&referrer=<?php echo $referrer;?>';
      }
    }

    /**
     * Skips this step
     */
    function skipCompany() {
      window.location = '/send_recruiting?referrer='+null+'&id=<?php echo $referrer;?>';
    }

    /**
     * Markes ye imagge fur mobile
     */
    function markImageMobile(id, index) {
      var url = '/ajax/recruiting_company_image/mobile';
      var params = {id: id};
      $.post(url, params, function(data){
        if('true' == data.success) {
          $('#mark-mobile-button-'+index).prop("disabled",true);;
          $('#mark-mobile-button-'+index).html('MOBILE IMAGE');
          $('#mark-mobile-button-'+index).css('color', 'black');
          $('#mark-mobile-button-'+index).css('background', '#2193ED');
        }  else {
          alert('Failed setting for mobile. ');
        }
      },'json').fail(function() {
        alert('Failed to set for mobile.');
      });
    }

    /**
     * Markes ye imagge til logo
     */
    function markImageLogo(id, index) {
      var url = '/ajax/recruiting_company_image/logo';
      var params = {id: id};
      $.post(url, params, function(data){
        if('true' == data.success) {
          $('#mark-logo-button-'+index).prop("disabled",true);;
          $('#mark-logo-button-'+index).html('LOGO');
          $('#mark-logo-button-'+index).css('color', 'black');
          $('#mark-logo-button-'+index).css('background', '#2193ED');
        }  else {
          alert('Failed setting logo.');
        }
      },'json').fail(function() {
        alert('Failed to set logo.');
      });
    }

    $( document ).ready(function() {
      var textFields = [
        '#company',
        '#company-description',
        '#company-values',
        '#company-facebook',
        '#company-linkedin',
        '#company-youtube',
        '#company-twitter',
        '#company-google-plus'
      ];

      var fields = function() {
        var _fields = false;
        textFields.map(function(elem) {
          if ($(elem).val().length !== 0) {
            _fields = true;
          }
        });
        return _fields;
      };

      var images = function() {
        return $('#company-image-container').children().length !== 0;
      };

      var videos = function() {
        return $('#company-video-container').children().length !== 0;
      };

      $('#leaving-alert')[0].close();

      var leaving = function(href) {
        var $box = $('#leaving-alert')[0];
        $('#leaving-ok').click(function() {
          window.location.href = href;
        });
        $box.open();
      };

      // handle links to another page
      $('a').click(function(e) {
        var href = $(this).attr('href');
        if (href !== 'javascript:void(0)' && href !== undefined) {
          /*if (fields() || images() || videos()) {
            e.preventDefault();
            leaving(href);
          }*/
        }
      });

      // handle back button, reload, and tab closed
      window.onbeforeunload = function() {
        //if (fields() || images() || videos()) return '';
      };

      $('#select-image-file').on('change', handleImageFileSelect);
      $('#company-image-container').data('deleted', []);
      $('#company-video-container').data('deleted', []);
      $('.recruiting-token-image').each(function() {
        var img = $(this);
        img.data('saved', true);
      });
      $('.recruiting-token-video').each(function() {
        var img = $(this);
        img.data('saved', true);
      });
    });
    </script>
</body>
</html>
