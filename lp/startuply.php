<?php
if (logged_in()) {
    header('Location: /profile');
}
?>
<!doctype html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <title>Home</title>
  <meta name="description" content="Startups template">
  <meta name="keywords" content="Startups template">
  <link rel="shortcut icon" type="image/png" href="/images/favicon.png">
  <link rel="stylesheet" type="text/css" href="assets2/css/custom-animations.css" />
  <link rel="stylesheet" type="text/css" href="assets2/css/lib/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets2/css/style.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

  <?php require_once __DIR__."/../analyticstracking.php" ?>

  <!-- Polymer -->
  <script src="/components/webcomponentsjs/webcomponents-lite.min.js"></script>
  <link rel="import" href="/components/paper-button/paper-button.html">
  <link rel="import" href="/components/paper-dialog/paper-dialog.html">
  <link rel="import" href="/components/paper-input/paper-input.html">
  <style>
  .recruiting-dialog {
    width: 400px;
    height: 250px;
    padding-left: 25px;
    padding-right: 25px;
  }
  paper-button {
    background-color: inherit;
    color: inherit;
  }
  </style>

  <!--[if lt IE 9]>
    <script src="assets2/js/html5shiv.js"></script>
    <script src="assets2/js/respond.min.js"></script>
  <![endif]-->
</head>

<body id="landing-page" class="landing-page">
  <!-- Preloader -->
  <div class="preloader-mask">
    <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
  </div>

  <header>
    <nav class="navigation navigation-header">
      <div class="container">
        <div class="navigation-brand">
          <div class="brand-logo">
            <!-- Maybe go back in an add in the cool looking to color alt logo-->
            <a href="index.html" class="logo"></a><a href="index.html" class="logo logo-alt"></a>
          </div>
        </div>
        <button class="navigation-toggle">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navigation-navbar collapsed">
          <ul class="navigation-bar navigation-bar-left">
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="/pricing">Prices</a></li>
            <li><a href="#feedback">Feedback</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="https://blog.gosizzle.io">Blog</a></li>
            <li><a href="#guarantee">Contacts</a></li>
          </ul>
          <ul class="navigation-bar navigation-bar-right">
            <li><a href="register.html">Login</a></li>
            <li class="featured"><a class="btn btn-sm btn-outline-color" href="/pricing">Sign up</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div id="hero" class="static-header window-height video-version hero-section light-text clearfix">
    <div class="container">
      <div class="heading-block align-center">
        <h1>How Important is Your Time?</h1>
        <h5>Recruiting Automation for Recruiting Agencies, RPO, or Corporate HR</h5>
      </div>
      <div class="video-wrapper">
        <div class="container animated" data-animation="fadeInUp" data-delay="400" data-duration="700">
          <div class="video-container">
            <div class="embed-container">
              <iframe src="https://www.youtube.com/embed/uHzRX-8jC3s?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="clients" class="clients-section align-center">
    <div class="container">
      <ul class="list-inline logos">
        <li><img class="animated" data-animation="fadeInDown" data-duration="500" src="assets2/img/logos/Logo-Sizzle-IQ.png" alt="mashable" /></li>
        <li><img class="animated" data-animation="fadeInUp" data-duration="500" data-delay="200" src="assets2/img/logos/Logo-Sizzle-SP.png" alt="tnw" /></li>
        <!--<li><img class="animated" data-animation="fadeInDown" data-duration="500" data-delay="400" src="assets2/img/logos/Logo-Sizzle-PL.png" alt="virgin" /></li>-->
        <li><img class="animated" data-animation="fadeInUp" data-duration="500" data-delay="600" src="assets2/img/logos/Logo-Sizzle-RA.png" alt="microsoft" /></li>
      </ul>
    </div>
  </div>

  <section id="about" class="section about-section align-center dark-text">
    <div class="container">

      <ul class="nav nav-tabs alt">
        <li class="active"><a href="#first-tab-alt" data-toggle="tab">MARKET</a></li>
        <li><a href="#second-tab-alt" data-toggle="tab">AUTOMATION</a></li>
        <li><a href="#third-tab-alt" data-toggle="tab">INTEGRATION</a></li>
      </ul>

      <div class="tab-content alt">
        <div class="tab-pane active" id="first-tab-alt">
          <div class="section-content row">
            <div class="col-sm-6 animated" data-delay="200" data-duration="700" data-animation="fadeInLeft">
              <img src="assets2/img/features/people.jpg" class="img-responsive" alt="process 3" />
            </div>
            <div class="col-sm-6 animated" data-delay="200" data-duration="700" data-animation="fadeInRight">
              <br/>
              <article class="align-center">
                <h3>FOR EVERY <span class="highlight">RECRUITER</span></h3>
                <p class="sub-title">Saving time is valuable for every recruiter.</p>
                <p>With Sizzle's machine learning platform and advanced models you know that you are not only saving time, but using the best automated marketing and sales practices to increase your recruitment pipeline, while filtering out poor candidates.</p>
                <br/>
                <?php /*<a href="#" class="btn btn-outline-color">Platform Overview</a>*/?>
                <a href="https://www.gosizzle.io/token/recruiting/8982ef2eebe2ef3c5" class="btn btn-outline-color" target="_blank">See Live Example</a>
              </article>
            </div>
          </div>
        </div>

        <div class="tab-pane" id="second-tab-alt">
          <div class="section-content row">
            <div class="col-sm-6 pull-right animated" data-delay="200" data-duration="700" data-animation="fadeInRight">
              <img src="assets2/img/features/PHONE_ONE_Cropped.jpg" class="img-responsive pull-right" alt="process 2" />
            </div>
            <div class="col-sm-6 animated" data-delay="200" data-duration="700" data-animation="fadeInLeft">
              <br/><br/>
              <article class="align-center">
                <h3>NEW AGE <span class="highlight">TECHNOLOGY</span></h3>
                <p class="sub-title">Sizzle uses cutting edge technology at the core<br/> of its automation platform</p>
                <p>In his igitur partibus duabus nihil erat, quod Zeno commuta rest gestiret. Sed virtutem ipsam inchoavit, nihil ampliusuma. Scien tiam pollicentur, quam non erat mirum sapientiae lorem cupido patria esse cariorem. Quae qui non vident, nihilamane umquam magnum ac cognitione.</p>
              </article>
            </div>
          </div>
        </div>

        <div class="tab-pane" id="third-tab-alt">
          <div class="section-header align-center">
            <h2>3 <span class="highlight">EASY</span> STEPS</h2>
            <p class="sub-header animated" data-duration="700" data-animation="zoomIn">
              It is easier than ever to get started with Sizzle!
              <br />If you skip our free trial...
            </p>
          </div>
          <div class="section-content row animated" data-duration="700" data-delay="200" data-animation="fadeInDown">
            <div class="col-sm-4">
              <article class="align-center">
                <i class="material-icons md-48">contact_mail</i>
                <span class="heading">SEND US AN EMAIL</span>
                <p class="thin" >To begin all it takes is a job description<br />and an email! Just email us a job description<br /> Preferably web based or word doc!</p>
              </article>
              <!--<span class="icon icon-arrows-04"></span>-->
            </div>
            <div class="col-sm-4">
              <article class="align-center">
                <i class="material-icons md-48">settings</i>
                <span class="heading">OUR SYSTEM RUNS</span>
                <p class="thin" >Sit tight for an hour while our system process<br />the job description you just sent us.<br />Guaranteed turn around within an hour!</p>
              </article>
              <!--<span class="icon icon-arrows-04"></span>-->
            </div>
            <div class="col-sm-4">
              <article class="align-center">
                <i class="material-icons md-48">markunread_mailbox</i>
                <span class="heading">RECEIVE TOKEN</span>
                <p class="thin" >After being processed your new Token is sent straight to your inbox. Also for those who have integrated with us your job board page is also updated!</p>
              </article>
            </div>
          </div>
          <br/>
          <br/>
        </div>
      </div>
    </div>
  </section>

  <hr class="no-margin" />

  <section id="process" class="section process-section align-center dark-text">
    <div class="container">
      <div class="section-content row">
        <div class="col-sm-6 pull-right animated" data-duration="500" data-animation="fadeInRight">
          <!--Why is this image staying small even thought I tried to make it larger (and the image itself is larger)-->
          <img src="assets2/img/features/DESKTOP_ONE_Cropped.jpg" class="img-responsive" alt="process 2" width="1200" height="800"/>
        </div>
        <div class="col-sm-6 align-left animated" data-duration="500" data-animation="fadeInLeft">
          <br/><br/>
          <article>
            <h3>A MODERN <span class="highlight">STARTUP</span></h3>
            <p class="sub-title">Think outside the app! Time consuming apps are so 2000s.<br/> Join the modern startup world where everything is automated.</p>
            <p>We aren't just another app. Apps are time consuming. Sizzle is automatic. Apps have endless forms to filled out with. Sizzle is formless (insert joke)! Apps are another thing to learn. Sizzle only requires the mastery of the attachment button in your favortie email client.</p>
          </article>
        </div>

        <hr class="clearfix" />

        <div class="col-sm-6 animated" data-duration="500" data-animation="fadeInLeft">
          <img src="assets2/img/features/helmet.jpg" class="img-responsive" alt="process 3" />
        </div>
        <div class="col-sm-6 align-right animated" data-duration="500" data-animation="fadeInRight">
          <br/><br/>
          <article>
            <h3>HANG <span class="highlight">ON TO</span> YER HELMET</h3>
            <p class="sub-title">Sell the Sizzle, Not the Steak</p>
            <p> Sizzle is designed to not just improve your companies ability to attract candidates, but we are hear to put your recruiting firm on the rocket ship to success. We expect you to have more passive candidates respond to you, leading to more placements, stronger revenue, and an improved brand that grows your client base without ever having to truly change your current process.</p>
          </article>
        </div>

      </div>
    </div>
  </section>

  <section id="newsletter" class="long-block newsletter-section light-text">
    <div class="container align-center">
      <div class="col-sm-12 col-lg-5 animated" data-animation="fadeInLeft" data-duration="500">
        <article>
          <h2>GET LIVE UPDATES</h2>
           <p class="">No spam promise - only latest news and prices!</p>
        </article>
      </div>
      <div class="col-sm-12 col-lg-7 animated" data-animation="fadeInRight" data-duration="500">
        <form class="form mailchimp-form subscribe-form" style="padding-top: 10px;" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
          <div class="form-group form-inline">
            <input size="15" type="text" class="form-control required" name="FULLNAME" placeholder="Your name" />
            <input size="25" type="email" class="form-control required" name="EMAIL" placeholder="your@email.com" />
            <input type="submit" class="btn btn-outline" value="SUBSCRIBE" />
            <span class="response"><? require_once('assets2/mailchimp/inc/store-address.php'); if($_GET['submit']){ echo storeAddress(); } ?></span>
          </div>
        </form>
      </div>
    </div>
  </section>

  <section id="features" class="section features-section align-center inverted">
    <div class="container">
      <div class="section-content">
        <div class="featured-tab">
          <ul class="list-unstyled">
            <li class="active">
              <a href="#home" data-toggle="tab">
                <div class="tab-info">
                  <div class="tab-title">Visual</div>
                  <div class="tab-desc">We scrape the web to put together powerful, relevant visuals to create engagement</div>
                </div>
                <!--<div class="tab-icon"><span class="icon icon-multimedia-20"></span></div>-->
              </a>
            </li>
            <li>
              <a href="#profile" data-toggle="tab">
                <div class="tab-info">
                  <div class="tab-title">Information Packed</div>
                  <div class="tab-desc">Scraping the web allows us to provide essential material in non-overwhelming format</div>
                </div>
                <!--<div class="tab-icon"><span class="icon icon-seo-icons-27"></span></div>-->
              </a>
            </li>
            <li>
              <a href="#messages" data-toggle="tab">
                <div class="tab-info">
                  <div class="tab-title">Candidate Engagement Focused</div>
                  <div class="tab-desc">If you do not provide a great experience you will lose engagement</div>
                </div>
                <!-- <div class="tab-icon"><span class="icon icon-seo-icons-28"></span></div>-->
              </a>
            </li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane in active" id="home"><img src="assets2/img/features/Good_Images/LAPTOP_ONE_Cropped.png" class="img-responsive animated" data-duration="900" data-animation="flip3dInTop" alt="macbook" /></div>
            <div class="tab-pane" id="profile"><img src="assets2/img/features/Good_Images/iPAD_ONE_Cropped.png" class="img-responsive animated" data-duration="900" data-animation="roll3dInLeft" alt="macbook" /></div>
            <div class="tab-pane" id="messages"><img src="assets2/img/features/Good_Images/LAPTOP_PHONE_ONE_Cropped.png" class="img-responsive animated" data-duration="900" data-animation="fadeInRight" alt="macbook" /></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--
  <section id="features-list" class="section features-list-section align-center dark-text">
    <div class="container">
      <div class="clearfix animated" data-duration="500" data-animation="fadeInRight">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-office-44 highlight"></i>
            <span class="heading">FEATURE 1</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-shopping-18 highlight"></i>
            <span class="heading">FEATURE 2</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-seo-icons-27 highlight"></i>
            <span class="heading">FEATURE 3</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-office-24 highlight"></i>
            <span class="heading">FEATURE 4</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
      </div>
      <div class="clearfix animated" data-duration="500" data-delay="500" data-animation="fadeInLeft">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-graphic-design-13 highlight"></i>
            <span class="heading">FEATURE 5</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-arrows-37 highlight"></i>
            <span class="heading">FEATURE 6</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-badges-votes-14 highlight"></i>
            <span class="heading">FEATURE 7</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <article class="align-center">
            <i class="icon icon-badges-votes-16 highlight"></i>
            <span class="heading">FEATURE 8</span>
            <p class="">Sit amet, consectetur adipiscing elit. In hac divisione rem ipsam prorsus probo elegantiam desidero. </p>
          </article>
        </div>
      </div>
    </div>
  </section>
-->

  <section id="awards" class="section awards-section align-center dark-text animated" data-animation="fadeInDown" data-duration="500">
    <div class="container">
      <div class="section-header">
        <h2><span class="highlight">OUR</span> Recognition</h2>
        <p class="sub-header">
          Sizzle is being talked about in a number of publications
          <br />Sell the Sizzle!
        </p>
      </div>
      <div class="section-content">
        <ul class="list-inline logos">
          <!-- need to invert the colors, needs to be light grey not pressed, dark grey when pressed -->
          <li><a href="http://www.eremedia.com/ere/lever-raises-more-money/" target="_blank"><img src="assets2/img/logos/Pub-Sizzle-ERE.png" alt="ERE" /></a></li>
          <li><a href="http://recruitingdaily.com/media-candidate-response-rate/" target="_blank"><img src="assets2/img/logos/Pub-Sizzle-RD.png" alt="RD" /></a></li>
        </ul>
      </div>
    </div>
  </section>
<?php /*
  <section id="feedback" class="section feedback-section align-center light-text">
    <div class="container animated" data-animation="fadeInDown" data-duration="500">
      <div class="section-header">
        <h2>WHAT <span class="highlight">SIZZLERS</span> SAY</h2>
      </div>
      <div class="section-content">
        <!-- BEGIN SLIDER CONTENT -->
        <div class="col-sm-10 col-sm-offset-1">
          <div class="flexslider testimonials-slider align-center">
            <ul class="slides">
              <li>
                <div class="testimonial align-center clearfix">
                  <blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non bibendum metus. Aenean vel rutrum velit. Duis aliquet augue non augue volutpat, ut viverra est sagittis. Duis elementum mi mauris, nec rhoncus dolor consectetur vitae lorem ipsum.</blockquote>
                </div>
              </li>
              <li>
                <div class="testimonial align-center clearfix">
                  <blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non bibendum metus. Aenean vel rutrum velit. Duis aliquet augue non augue volutpat, ut viverra est sagittis. Duis elementum mi mauris, nec rhoncus dolor consectetur vitae lorem ipsum.</blockquote>
                </div>
              </li>
              <li>
                <div class="testimonial align-center clearfix">
                  <blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non bibendum metus. Aenean vel rutrum velit. Duis aliquet augue non augue volutpat, ut viverra est sagittis. Duis elementum mi mauris, nec rhoncus dolor consectetur vitae lorem ipsum.</blockquote>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- END SLIDER -->
      </div>
    </div>
  </section>

  <section id="feedback-controls" class="section feedback-controls-section align-center light-text animated" data-animation="fadeInDown" data-duration="500">
    <div class="container">
      <div class="col-md-10 col-md-offset-1">
        <!-- BEGIN CONTROLS -->
        <div class="flex-manual">
          <div class="col-xs-12 col-sm-4 wrap">
            <div class="switch flex-active">
              <img alt="client" src="assets2/img/people/profile-1.jpg" class="sm-pic img-circle pull-left" width="69" height="70">
              <p>
                <span class="highlight">CHRIS MURDOCK</span><br/>Founder of <span class="highlight">IQ Talent</span>
              </p>
            </div>
          </div>

          <div class="col-xs-12 col-sm-4 wrap">
            <div class="switch pull-left">
              <img alt="client" src="assets2/img/people/profile-2.jpg" class="sm-pic img-circle pull-left" width="69" height="70">
              <p>
                <span class="highlight">JOHN DOESOME</span><br/>Accountant at <span class="highlight">Vell Inc.</span>
              </p>
            </div>
          </div>

          <div class="col-xs-12 col-sm-4 wrap">
            <div class="switch">
              <img alt="client" src="assets2/img/people/profile-1.jpg" class="sm-pic img-circle pull-left" width="68" height="69">
              <p>
                <span class="highlight">PETER MOOSOME</span><br/>VP Marketing at <span class="highlight">Footbook</span>
              </p>
            </div>
          </div>
        </div>
        <!-- END CONTROLS -->
      </div>
    </div>
  </section>
*/?>
  <section id="team" class="section team-section align-center dark-text">
    <div class="container">
      <div class="section-header">
        <h2>BEHIND <span class="highlight">THE</span> SCENES</h2>
        <p class="sub-header">
          Lets meet the team that has made this product a reality!
        </p>
        <p>Every member of the Sizzle team brings something different. We are firm believers in the mindset of don’t just be great… be different! We have gamers, a history buff, and a sports-a-holic, but one thing brings us all together… Star Wars (Oh wait… I meant Sizzle. But seriously, have you seen the new trailer?)</p>
      </div>
      <div class="section-content row">
        <div class="col-md-3 col-sm-3 col-xs-6 animated" data-animation="fadeInDown" data-duration="500">
          <div class="team-member">
            <div class="photo-wrapper">
              <div class="overlay-wrapper">
                <img src="assets2/img/people/team-1.jpg" alt="">
                <div class="overlay-content">
                  <div class="text-wrapper">
                    <div class="text-container">
                      <p>Gary has always been excited by new ideas, and he can't settle until those ideas become a reality. A math nerd at heart, Gary loves to push his logic and analytical skills to the test with his creations.</p>
                    </div>
                  </div>
                  <ul class="socials-block">
                    <li><a href="#" class="email" title="Email"><i class="fa fa-envelope-o"></i></a></li>
                    <li><a href="#" class="twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" class="facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="linked_in" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <h5 class="name">Gary Peters</h5>
            <p class="position">Co-Founder &amp; CEO</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-6 animated" data-animation="fadeInUp" data-delay="200" data-duration="500">
          <div class="team-member">
            <div class="photo-wrapper">
              <div class="overlay-wrapper">
                <img src="assets2/img/people/team-2.jpg" alt="">
                <div class="overlay-content">
                  <div class="text-wrapper">
                    <div class="text-container">
                      <p>Robbie is the sports geek of the crew. A sales pro that has no off switch when it comes to people, and he is constantly looking to learn more about others and help you grow.</p>
                    </div>
                  </div>
                  <ul class="socials-block">
                    <li><a href="#" class="email" title="Email"><i class="fa fa-envelope-o"></i></a></li>
                    <li><a href="#" class="twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" class="facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="linked_in" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <h5 class="name">Robbie Zettler</h5>
            <p class="position">Co-Founder &amp; CRO</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-6 animated" data-animation="fadeInDown" data-delay="400" data-duration="500">
          <div class="team-member">
            <div class="photo-wrapper">
              <div class="overlay-wrapper">
                <img src="assets2/img/people/team-3.jpg" alt="">
                <div class="overlay-content">
                  <div class="text-wrapper">
                    <div class="text-container">
                      <p>Run. Code. Beer. Repeat.</p>
                    </div>
                  </div>
                  <ul class="socials-block">
                    <li><a href="bwogsland@gosizzle.io" class="email" title="Email"><i class="fa fa-envelope-o"></i></a></li>
                    <li><a href="https://twitter.com/wogsland" class="twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.facebook.com/wogsland" class="facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://www.linkedin.com/in/wogsland" class="linked_in" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <h5 class="name">Bradley Wogsland</h5>
            <p class="position">Senior Developer</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-6 animated" data-animation="fadeInUp" data-delay="600" data-duration="500">
          <a href="/careers">
            <div class="team-member">
              <div class="photo-wrapper">
                <div class="overlay-wrapper">
                  <img src="assets2/img/people/team-4.jpg" alt="">
                  <div class="overlay-content">
                    <div class="text-wrapper">
                      <div class="text-container">
                        <p>Are you interested at working at one of Nashville's top startups? Reach out to Gary Peters to learn how you can become part of the Sizzle team!</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <h5 class="name">You?</h5>
              <p class="position">Developer</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section id="guarantee" class="long-block light-text guarantee-section">
    <div class="container">
      <div class="col-md-12 col-lg-9">
        <i class="icon icon-seo-icons-24 pull-left"></i>
        <article class="pull-left">
          <h2>TRY US NOW FOR FREE!</h2>
          <p class="thin">Want to see what it looks like to Sizzle? Send us a Job Description.</p>
        </article>
      </div>

      <div class="col-md-12 col-lg-3">
        <a class="btn btn-outline" style="margin-top: 7px;" onclick="uploadDescription()">UPLOAD</a>
      </div>
    </div>
  </section>

  <footer id="footer" class="footer light-text">
    <div class="container">
      <div class="footer-content row">
        <div class="col-sm-4 col-xs-12">
          <div class="logo-wrapper">
            <img width="130" height="45" src="assets2/img/Logo-Sizzle-Sizzle.png" alt="logo" />
          </div>
          <p>Life is short and your time is valuable. Our mission is to save you and your clients time while bringing them a quality product that fully services their needs.</p>
          <p><strong>Gary Peters, Founder</strong>.</p>
        </div>
        <div class="col-sm-5 social-wrap col-xs-12">
          <strong class="heading">Social Networks</strong>
          <ul class="list-inline socials">
            <li><a href="https://www.facebook.com/GoSizzle/"><span class="icon icon-socialmedia-08"></span></a></li>
            <li><a href="https://www.linkedin.com/company/7585107"><span class="icon icon-socialmedia-05"></span></a></li>
            <li><a href="https://twitter.com/Go_Sizzle"><span class="icon icon-socialmedia-06"></span></a></li>
          </ul>
        </div>
        <div class="col-sm-3 col-xs-12">
          <strong class="heading">Our Contacts</strong>
          <ul class="list-unstyled">
            <li><span class="icon icon-chat-messages-14"></span><a href="mailto:token@gosizzle.io">token@gosizzle.io</a></li>
            <li><span class="icon icon-seo-icons-34"></span>Nashville, TN 37204</li>
            <li><span class="icon icon-seo-icons-17"></span>(901)-486-7886</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="copyright">Giftly Inc, 2016. All rights reserved.</div>
  </footer>

  <div class="back-to-top"><i class="fa fa-angle-up fa-3x"></i></div>

  <paper-dialog class="recruiting-dialog" id="upload-dialog" modal>
    <h2>Upload Your Job Description</h2>
    <form id="description-upload">
      <input class="hidden-file-input" type="file" id="select-list-file" name="listFile" hidden />
      <paper-input id="upload-email" label="Email" name="email" onclick="" autofocus></paper-input>
      <paper-input id="upload-file" label="File Name" name="fileName" onclick="fireHiddenFileInput('#select-list-file')"></paper-input>
    </form>
    <i>We'll make it S!zzle...</i>
    <div class="">
      <paper-button class="dialog-button" onclick="sizzleUpload()">UPLOAD</paper-button>
      <paper-button dialog-dismiss class="dialog-button" onclick="cancelUpload()">CANCEL</paper-button>
    </div>
  </paper-dialog>

  <paper-dialog class="recruiting-dialog" id="upload-process" modal>
    <div id="upload-errors"></div>
    <div class="">
      <paper-button id="try-again-button" class="dialog-button" onclick="tryAgain()" hidden>TRY AGAIN</paper-button>
      <paper-button id="cancel-again-button" dialog-dismiss class="dialog-button" onclick="cancelUpload()" hidden>CANCEL</paper-button>
      <paper-button id="cancel-again-button" dialog-dismiss class="dialog-button" onclick="cancelUpload()" hidden>CANCEL</paper-button>
    </div>
  </paper-dialog>

  <!--[if lt IE 9]>
    <script type="text/javascript" src="assets2/js/jquery-1.11.3.min.js?ver=1"></script>
  <![endif]-->
  <!--[if (gte IE 9) | (!IE)]><!-->
    <script type="text/javascript" src="assets2/js/jquery-2.1.4.min.js?ver=1"></script>
  <!--<![endif]-->

  <script type="text/javascript" src="assets2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.flexslider-min.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.appear.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.plugin.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.countdown.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.waypoints.min.js"></script>
  <script type="text/javascript" src="assets2/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="assets2/js/toastr.min.js"></script>
  <script type="text/javascript" src="assets2/js/startuply.js"></script>

  <script>
  $( document ).ready(function() {
    url = '/ajax/slackbot/<?php echo $_SERVER['REMOTE_ADDR'];?>';
    $.post(url);

    $('#select-list-file').change(function() {
      var filename = $('#select-list-file').val().replace('C:\\fakepath\\', '');
      /*if ($('#select-list-file:file')[0].files[0].type !== "text/plain") {
        $('#upload-file label').html('<font color="red">Please choose a text file</font>');
        $('#upload-file').val('');
      } else {*/
        $('#upload-file label').html('File Name');
        $('#upload-file').val(filename);
      //}
    });
  });

  /**
   * Opens the Upload Dialog
   */
  function uploadDescription() {
    $('#upload-dialog')[0].open();
  }

  /**
   * Closes the Upload Dialog
   */
  function cancelUpload() {
    $('#upload-errors').html('');
    $('#upload-dialog')[0].close();
    $('#upload-process')[0].close();
  }

  /**
   * Registers click on hidden file input.
   *
   * @param {String} identifier The jQuery identifier to click
   */
  function fireHiddenFileInput(identifier) {
     $(identifier).trigger('click');
  }

  /**
   * Attempts to upload the job description to the ajax endpoint & presents success or error
   */
  function sizzleUpload() {
    var invalid = false;
    if ('' == $('#upload-file').val()) {
      $('#upload-file label').html('<font color="red">Please choose a file</font>');
      invalid = true;
    }
    if ('' == $('#upload-email').val()) {
      $('#upload-email label').html('<font color="red">Please enter an email</font>');
      invalid = true;
    }
    if (!invalid) {
      $('#upload-dialog')[0].close();
      $('#upload-errors').html('Processing...');
      $('#upload-process')[0].open();
      var formData = new FormData($('#description-upload')[0]);
      $.ajax({
        url: '/ajax/email/signup/upload/',
        type: 'post',
        data: formData,
        dataType: 'json',
        headers: {
          "X-FILENAME": $('#select-list-file').val(),
        },
        success: function(data, textStatus){
          var message = data.data.message+'<br />';
          if(data.success === 'true') {
            $('#upload-errors').css('color','white');
            window.location = '/thankyou?action=emailsignup';
          }  else {
            if (data.data.errors.length) {
              $('#upload-errors').css('color','red');
              message += '<strong>Errors:</strong><br />';
              $.each(data.data.errors, function(index, error) {
                message += error+'<br />';
              })
            }
            $('#try-again-button').removeAttr('hidden');
            $('#cancel-again-button').removeAttr('hidden');
          }
          $('#upload-errors').html(message);
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
      }).fail(function() {
        $('#upload-errors').html('Uploading job description failed.');
        $('#try-again-button').removeAttr('hidden');
        $('#cancel-again-button').removeAttr('hidden');
      });
    }
  }

  /**
   * Reverts modal
   */
  function tryAgain() {
    $('#upload-process')[0].close();
    $('#upload-dialog')[0].open();
    //$('#upload-file').val('');
    $('#try-again-button').attr('hidden','hidden');
    $('#cancel-again-button').attr('hidden','hidden');
  }
  </script>
</body>
</html>
