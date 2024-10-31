@extends('layout.app')

@section('title')
  Home
@endsection

@section('content')
  <!-- Hero Section  Start -->
  <section id="slider" class="slider slide-overlay-black">
    <!-- START REVOLUTION -->
    <div class="rev_slider_wrapper">
      <div id="slider2" class="rev_slider" data-version="5.0">
        <ul>
          <li data-index="rs-6" data-transition="fade" data-slotamount="default" data-hideafterloop="0"
            data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300"
            data-thumb="assets/images/resources/banner/main-demo/banner1.jpg" data-rotate="0" data-saveperformance="off"
            data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6=""
            data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
            <!-- MAIN IMAGE -->
            <img src="{{ asset('assets/images/resources/banner/main-demo/banner1.jpg') }}" alt="a"
              title="main-slider-backround-1" width="1920" height="1200" data-bgposition="center center"
              data-duration="13000" data-ease="Power0.easeInOut" data-scalestart="100" data-scaleend="110"
              data-rotatestart="0" data-rotateend="0" data-blurstart="0" data-blurend="0" data-offsetstart="0 0"
              data-offsetend="0 0" data-bgparallax="7" class="rev-slidebg" data-no-retina="" />
            <!-- LAYERS -->
            <!-- LAYER NR. 1 -->
            <div class="tp-caption tp-resizeme" id="slide-6-layer-1" data-x="['left','left','left','left']"
              data-hoffset="['-89','-7','15','0']" data-y="['middle','middle','middle','middle']"
              data-voffset="['-110','-73','-111','-131']" data-fontsize="['85','65','50','40']"
              data-lineheight="['92','78','63','53']" data-letterspacing="['-9','-8','-7','-4']"
              data-width="['804','627','517','297']" data-height="none" data-whitespace="normal" data-type="text"
              data-responsive_offset="on"
              data-frames='[{"delay":500,"speed":300,"frame":"0","from":"x:350px;opacity:0;","to":"o:1;","ease":"Power1.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeIn"}]'
              data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
              data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
              style="
                    z-index: 5;
                    font-size: 35px;
                    line-height: 92.71px;
                    font-weight: 700;
                    font-family: 'Unbounded', cursive;
                    color: #ffffff;
                    letter-spacing: 1px;
                    text-transform: capitalize;
                  ">
              "Music Distribution India"
            </div>
            <!-- LAYER NR. 2 -->
            <div class="tp-caption tp-resizeme" id="slide-6-layer-2" data-x="['left','left','left','left']"
              data-hoffset="['-81','0','15','3']" data-y="['middle','middle','middle','middle']"
              data-voffset="['59','59','59','10']" data-fontsize="['18','18','18','14']"
              data-lineheight="['30','30','30','22']" data-width="['610','610','515','292']" data-height="none"
              data-whitespace="normal" data-type="text" data-responsive_offset="on"
              data-frames='[{"delay":600,"speed":300,"frame":"0","from":"x:300px;opacity:0;","to":"o:1;","ease":"Power1.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeIn"}]'
              data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
              data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
              style="
                    color: #ffffff;
                    font-size: 18px;
                    line-height: 300;
                    font-weight: 400;
                    font-family: 'Michroma', sans-serif;
                  ">
              Made in India Made for Indian Artists.
            </div>
            @if (isCustomerLoggedIn())
              <a class="tp-caption btn-lnk tp-resizeme" href="{{ route('filament.customer.auth.login') }}" target="_blank"
                id="slide-6-layer-3" data-x="['left','left','left','left']" data-hoffset="['-80','0','15','3']"
                data-y="['middle','middle','middle','middle']" data-voffset="['183','183','183','140']"
                data-responsive_offset="on"
                data-frames='[{"delay":750,"speed":300,"frame":"0","from":"x:250px;opacity:0;","to":"o:1;","ease":"Power1.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeIn"}]'
                data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                data-paddingright="[30,30,30,30]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[30,30,30,30]"
                style="z-index: 7; text-decoration: none"><i class="fab fa-apple"></i>Go to Dashboard
              </a>
            @else
              <!-- LAYER NR. 3 -->
              <a class="tp-caption btn-lnk tp-resizeme" href="{{ route('filament.customer.auth.login') }}"
                target="_blank" id="slide-6-layer-3" data-x="['left','left','left','left']"
                data-hoffset="['-80','0','15','3']" data-y="['middle','middle','middle','middle']"
                data-voffset="['183','183','183','140']" data-responsive_offset="on"
                data-frames='[{"delay":750,"speed":300,"frame":"0","from":"x:250px;opacity:0;","to":"o:1;","ease":"Power1.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeIn"}]'
                data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                data-paddingright="[30,30,30,30]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[30,30,30,30]"
                style="z-index: 7; text-decoration: none"><i class="fab fa-apple"></i>Login
              </a>
              <!-- LAYER NR. 4 -->
              <a class="tp-caption btn-lnk v2 tp-resizeme" href="{{ route('filament.customer.auth.register') }}"
                target="_blank" id="slide-6-layer-4" data-x="['left','left','left','left']"
                data-hoffset="['110','200','200','3']" data-y="['middle','middle','middle','middle']"
                data-voffset="['183','183','183','190']" data-responsive_offset="on"
                data-frames='[{"delay":750,"speed":300,"frame":"0","from":"x:250px;opacity:0;","to":"o:1;","ease":"Power1.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power2.easeIn"}]'
                data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                data-paddingright="[30,30,30,30]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[30,30,30,30]"
                style="z-index: 7; text-decoration: none"><i class="fab fa-spotify"></i>Register
              </a>
            @endif
          </li>
        </ul>
      </div>
      <!-- END REVOLUTION SLIDER -->
    </div>
    <!-- END OF SLIDER WRAPPER -->

  </section>
  <!-- Hero Section End -->
  <section class="block">
    <div class="container">
      <div class="row about-sec">
        <div class="col-lg-12">
          <div class="about-us wow fadeInLeft text-center">
            <h2>India #1 Music Distribution Service </h2>
            <span>"Music Distribution India"</span>
            <p>
              India #1 Music Distribution service Music Distributon India Company Co. is a digital music aggregator from
              India. Music Distribution India Company avail individual artists and music producers get their music on
              iTunes, JioSaavn, Wynk, Gaana, Spotify, Google Play Music, Shazam, other music streaming platforms, and
              digital music stores. भारत की #1 संगीत वितरण सेवाएँ संगीत वितरण इंडिया कंपनी कंपनी भारत की एक डिजिटल संगीत
              एग्रीगेटर है। म्यूजिक डिस्ट्रीब्यूशन इंडिया कंपनी व्यक्तिगत कलाकारों और संगीत निर्माताओं को उनका लाभ देती है
            </p>
          </div>
          <!--about-us end-->
        </div>
      </div>
    </div>
  </section>
  <section class="block">
    <div class="container text-center">
      <div class="title-sec black wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <h2>Founder - Summy SKji</h2>
      </div><!--title-sec end-->
      <img class="wow fadeInUp" src="{{ asset('assets\images\resources\logo\founder1.jpeg') }}" alt=""
        style="visibility: visible; animation-name: fadeInUp; width:30%; height:auto;">
    </div>
    </div>
  </section>
  <section class="block">
    <div class="container">
      <div class="title-sec black text-center wow fadeInUp">
        <h2>DISTRIBUTE YOUR MUSIC WORLDWIDE</h2>
      </div>
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="jl-show">
            <img src="{{ asset('assets\images\resources\services\video.jpg') }}" alt="">
            <h2 class="show-st">Upload And Distribute Your <span>Music</span></h2>
            <div class="show-caption">
              <h3 class="show-location">Music Distribution India Upload your music, we deliver your music on JioSaavn,
                Wynk Music, Gaana, Resso, Spotify and more 150+ music platforms. म्यूजिक डिस्ट्रीब्यूशन इंडिया पर अपना
                संगीत अपलोड करें, हम आपका संगीत JioSaavn, Wynk Music, Gaana, Resso, Spotify और अधिक 150+ संगीत
                प्लेटफार्मों पर वितरित करते हैं।</h3>
            </div>
          </div>
          <!--jl-show end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="jl-show">
            <img src="{{ asset('assets\images\resources\services\airtel.jpg') }}" alt="">
            <h2 class="show-st">Unlimited Caller Tune<span> (Jio , Airtel, VI And BSNL)</span></h2>
            <div class="show-caption">
              <h3 class="show-location">Music Distribution India We create your music on CRBT (callertune) on various
                telecom network/operators. Our Callertune partners - JioSaavn/Jio, Wynk/Airtel, VI & BSNL, MTNL, etc.</h3>
            </div>
          </div>
          <!--jl-show end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="jl-show">
            <img src="{{ asset('assets\images\resources\services\insta.jpg') }}" alt="">
            <h2 class="show-st"><i class="fab fa-instagram"></i> Instagram </br><i class="fab fa-facebook"></i>
              Facebook
              <span>Profile Linking</span>
            </h2>
            <div class="show-caption">
              <h3 class="show-location">Music Distribution India gives you free Instagram Facebook profile linking with
                the help of which you can link your song with your Instagram account.</h3>
            </div>
          </div>
          <!--jl-show end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="jl-show">
            <img src="{{ asset('assets\images\resources\services\youtube.jpg') }}" alt="">
            <h2 class="show-st">Youtube <span>Monetization</span></h2>
            <div class="show-caption">
              <h3 class="show-location">Music Distribution India Monetize your music on YouTube and get paid when other people use your music. यूट्यूब मुद्रीकरण

"Music Distribution India" YouTube पर अपने संगीत से कमाई करें और जब अन्य लोग आपके संगीत का उपयोग करें तो कॉपीराइट क्लेम से भी आपको कमाई होगी और उस कमाई का सीधे अपने बैंक मै भुगतान प्राप्त करें।</h3>
            </div>
          </div>
          <!--jl-show end-->
        </div>
      </div>
    </div>
  </section>
  <section class="block black-bg playlist-sec">
    <div class="container">
      <div class="title-sec wow fadeInUp">
        <h2>Distribute On</h2>
      </div>
      <!--title-sec end-->
      <div class="d-flex justify-content-around flex-wrap align-items-center">
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft text-center justify-content-center">
            <img src="{{ asset('assets\images\resources\icons\facebook-svgrepo-com.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft  text-center justify-content-center" data-wow-delay="400ms">
            <img src="{{ asset('assets\images\resources\icons\instagram-svgrepo-com.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft  text-center justify-content-center" data-wow-delay="600ms">
            <img src="{{ asset('assets\images\resources\icons\jiosaavn.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft  text-center justify-content-center">
            <img src="{{ asset('assets\images\resources\icons\spotify.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft  text-center justify-content-center" data-wow-delay="200ms">
            <img src="{{ asset('assets\images\resources\icons\youtube.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft  text-center justify-content-center" data-wow-delay="200ms">
            <img src="{{ asset('assets\images\resources\icons\wynk-music-svgrepo-com.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="mb-3">
          <div class="partner-logo wow fadeInLeft  text-center justify-content-center" data-wow-delay="200ms">
            <h1 class="text-white">Many More To Come</h1>
          </div>
          <!--partner-logo end-->
        </div>
      </div>
      <div class="contact-text">
        <ul>
          <li>CONTACT</li>
          <li>INFO@musicdistributionindia.in</li>
        </ul>
      </div>
      <!--contact-text end-->
    </div>
  </section>
  <section class="block">
    <div class="container">
      <div class="title-sec black text-center wow fadeInUp">
        <h2>Our Services</h2>
      </div>
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="card cardks1">
            <div class="image">
              <img src="{{ asset('assets\images\resources\services\2.jpg') }}" alt="">
            </div>
            <div class="content">
              <a href="#">
                <span class="title">
                  Content ID
                </span>
              </a>

              <p class="desc">
                Music Distribute India's YouTube Content ID feature employs digital fingerprinting technology to identify,
                manage, and protect your music on YouTube, allowing you to track, monetize, or block your content to
                safeguard your copyright.
              </p>

              <a class="action" href="javascript:;">
                Explore more
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="card cardks1">
            <div class="image">
              <img src="{{ asset('assets\images\resources\services\3.jpg') }}" alt="">
            </div>
            <div class="content">
              <a href="#">
                <span class="title">
                  Callertune (CRBT)
                </span>
              </a>

              <p class="desc">
                We create your music on CRBT (callertune) on various telecom network/operators. Our Callertune partners -
                JioSaavn/Jio, Wynk/Airtel, VI & BSNL, MTNL, etc.
              </p>

              <a class="action" href="javascript:;">
                Explore more
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="card cardks1">
            <div class="image">
              <img src="{{ asset('assets\images\resources\services\1.jpg') }}" alt="">
            </div>
            <div class="content">
              <a href="#">
                <span class="title">
                  Video Distribution
                </span>
              </a>

              <p class="desc">
                Music Distibution India ensures your music videos reach a global audience with our efficient Video
                Distribution
                feature, maximizing visibility and audience engagement.
              </p>

              <a class="action" href="javascript:;">
                Explore more
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
          <div class="card cardks1">
            <div class="image">
              <img src="{{ asset('assets\images\resources\services\4.jpg') }}" alt="">
            </div>
            <div class="content">
              <a href="#">
                <span class="title">
                  Artist Services
                </span>
              </a>

              <p class="desc">
                Instagram Profile Linking, Official Artist Channel (OAC), Wynk/Jiosaavn/Spotify Profile Claim. Artist
                profile creation, etc.
              </p>

              <a class="action" href="javascript:;">
                Explore more
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="block">
    <div class="container">
      <div class="row about-sec">
        <div class="col-lg-6">
          <div class="about-us wow fadeInLeft">
            <h2>250+ Stores</h2>
            <span>“Why Choose Music Distribution India”</span>
            <p>
              Unlimited music distribution - Get your music on Gaana, JioSaavan, Wynk Music, Spotify, iTunes/Apple Music,
              Shazam, Tidal, Amazon Music, TikTok, Tencent & 150+ more music platforms. Release on more stores and get
              more fans and more money. We provide a caller tune facility on India's all cellular networks. Share your
              music and grow your fan base and view trends, keep 100% safe music royalties, and view trends. Distribute,
              license & monetize at all in one place!
            </p>
            <ul class="socio-links">
              <li>
                <a href="javascript:;" title=""><i class="fab fa-twitter"></i></a>
              </li>
              <li>
                <a href="javascript:;" title=""><i class="fab fa-google-plus-g"></i></a>
              </li>
              <li>
                <a href="javascript:;" title=""><i class="fab fa-facebook-f"></i></a>
              </li>
              <li>
                <a href="javascript:;" title=""><i class="fab fa-instagram"></i></a>
              </li>
            </ul>
          </div>
          <!--about-us end-->
        </div>
        <div class="col-lg-6">
          <div class="about-image wow fadeInRight">
            <img src="{{ asset('assets/images/resources/img4.png') }}" alt="" />
          </div>
          <!--about-image end-->
        </div>
      </div>
    </div>
  </section>
  <section class="block black-bg">
    <div class="container">
      <div class="sec-title">
        <h2>Music Distribution Plans</h2>
      </div>
      <!--sec-title end-->
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card cardks1 mb-3">
            <div class="content">
              <a href="#">
                <span class="title">
                  For 1 Year
                </span>
                <span class="title">
                  One Artist
                </span>
              </a>

              <p class="desc">
              <ul>
                <li>Unlimited Songs Release</li>
                <li>CallerTune ( Live in 7 to 10 day )</li>
                <li>Instagram Facebook Profile Linking With Song</li>
                <li>YouTube Content ID (Live In 1 Week)</li>
                <li>Free ISRC UPC Codes</li>
                <li>Instagram Facebook Monetization</li>
                <li>Legal Copyright ©️ & Takedown</li>
                <li>Copyright Cleam Remove Our Songs</li>
                <li>Song Aproval Same Day</li>
                <li>Song Live In 1 Week</li>
                <li>Royalties Earning Report ( 3 to 4 Monthly)</li>
                <li>Royalties Earning Share</li>
                <li>Customer Service Free</li>
                <li>Artist Name Is Label Name</li>
              </ul>
              </p>

              <a class="action" href="javascript:;">
                Free
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
          <!--jl-show end-->
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card cardks1 mb-3">
            <div class="content">
              <a href="#">
                <span class="title">
                  For 1 Year
                </span>
                <span class="title">
                  Single Artist
                </span>
              </a>
              <ul>
                <li>Unlimited Release</li>
                <li>Unlimited Callers Tune (Jio , Airtel Vi And BSNL)</li>
                <li>Artist Instagram Facebook Profile 🔗 Linking With Song</li>
                <li>Copyright ©️ & Publisher Line</li>
                <li>YouTube Content ID( In 3 to 5 Days)</li>
                <li>Coustom Label Name</li>
                <li>Release 250+ Music Platforms</li>
                <li>Song Aprove Same Day</li>
                <li>24 Hours To 48 Hours Me Song Live</li>
                <li>85 % Royaltie Earnings</li>
                <li>4 Monthly Payment End Earning Report</li>
                <li>Video Free Distribution</li>
              </ul>
              <a href="javascript:;">
              <span class="title">
                  Exclusive Service
                </span>
              </a>
            <ul>
                <li>Official Artist Channel</li>
                <li>Video Distribution</li>
                <li>Vevo Channel</li>
                <li>Instagram Profile Linking Freee</li>
                <li>Free ISRC & UPC Codes</li>
                <li>Free CallerTune</li>
                <li>YouTube Content ID</li>
                <li>Facebook Instagram Content ID</li>
              </ul>
              <a class="action" href="javascript:;">
                ₹2,500
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
          <!--jl-show end-->
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card cardks1 mb-3">
            <div class="content">
              <a href="#">
                <span class="title">
                  For 1 Year
                </span>
                <span class="title">
                  Label Distribution
                </span>
                <span class="title">
                  Unlimited Artist
                </span>
              </a>
              <ul>
                <li>Unlimited Release</li>
                <li>Unlimited Callers Tune (Jio , Airtel Vi And BSNL)</li>
                <li>Artist Instagram Facebook Profile 🔗 Linking With Song</li>
                <li>Copyright ©️ & Publisher Line</li>
                <li>YouTube Content ID( In 3 to 5 Days)</li>
                <li>Coustom Label Name</li>
                <li>Release 250+ Music Platforms</li>
                <li>Song Aprove Same Day</li>
                <li>24 Hours To 48 Hours Me Song Live</li>
                <li>85 % Royaltie Earnings</li>
                <li>4 Monthly Payment End Earning Report</li>
                <li>Video Free Distribution</li>
              </ul>
              <a href="javascript:;">
              <span class="title">
                  Exclusive Service
                </span>
              </a>
            <ul>
                <li>Official Artist Channel</li>
                <li>Video Distribution</li>
                <li>Vevo Channel</li>
                <li>Instagram Profile Linking Freee</li>
                <li>Free ISRC & UPC Codes</li>
                <li>Free CallerTune</li>
                <li>YouTube Content ID</li>
                <li>Facebook Instagram Content ID</li>
              </ul>
              <a class="action" href="javascript:;">
                ₹2,500
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
          <!--jl-show end-->
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="card cardks1 mb-3">
            <div class="content">
              <a href="#">
                <span class="title">
                  For 1 Year
                </span>
                <span class="title">
                  Unlimited Artist (Best Value)
                </span>
                <span class="title">
                  Unlimited Coustom Label
                </span>
              </a>
              <ul>
                <li>Unlimited Songs Release</li>
                <li>CallerTune ( Live in 7 to 10 day )</li>
                <li>Instagram Facebook Profile Linking With Song</li>
                <li>YouTube Content ID (Live In 3 to 5 Days)e</li>
                <li>Free ISRC UPC Codes</li>
                <li>Instagram Facebook Monetization</li>
                <li>Legal Copyright ©️ & Takedown</li>
                <li>Copyright Cleam Remove Our Songs</li>
                <li>Song Aproval Same Day</li>
                <li>Song Live In 1 to 5 Day</li>
                <li>Royalties Earning Report ( 3 to 4 Monthly)</li>
                <li>80% Earning Share (80% Label 20% Company)</li>
                <li>Customer Service Free</li>
              </ul>
              <a href="javascript:;">
              <span class="title">
                  Exclusive Service
                </span>
              </a>
            <ul>
                <li>Unlimited Coustom Label Name </li>
                <li>Unlimited Music Video Distribution</li>
              </ul>
              <a class="action" href="javascript:;">
                ₹15,000
                <span aria-hidden="true">
                  →
                </span>
              </a>
            </div>
          </div>
          <!--jl-show end-->
        </div>
      </div>
    </div>
  </section>


  <section class="video-section overlay-bg">
    <div class="container">
      <div class="vid-text wow zoomIn">
        <div class="about-us wow fadeInLeft text-center">
          <h2 class="text-white">India #1 Music Distribution Service</h2>
          <span class="text-white">“Music Distribution India”</span>
          <p class="text-white">
            भारत की #1 संगीत वितरण सेवाएँ संगीत वितरण इंडिया कंपनी कंपनी भारत की एक डिजिटल संगीत एग्रीगेटर है। म्यूजिक
            डिस्ट्रीब्यूशन इंडिया कंपनी व्यक्तिगत कलाकारों और संगीत निर्माताओं को उनका लाभ देती है
          </p>

        </div>
      </div>
      <!--vid-text end-->
    </div>
  </section>



  <section class="block" style="display:none;">
    <div class="container">
      <div class="title-sec black text-center wow fadeInUp">
        <h2>Last Shorts</h2>
      </div>
      <!--title-sec end-->
      <div class="row reels-section">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="reel-col wow fadeInLeft">
            <div class="reel-thumb">
              <iframe width="458" height="814" src="https://www.youtube.com/embed/Lssi0T6rHEo" title=""
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen=""></iframe>
            </div>
            <div class="reel-info">
              <h3>Rainy Night</h3>
              <p>History of Synth music, there is probably no one.</p>
              <ul class="reel-social">
                <li>
                  <a href="javascript:;" title=""><i class="fab fa-instagram"></i></a>
                </li>
                <li>
                  <a href="javascript:;" title=""><i class="fab fa-youtube"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <!--reel-col end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="reel-col wow fadeInUp" data-wow-delay="200ms">
            <div class="reel-thumb">
              <iframe width="458" height="814" src="https://www.youtube.com/embed/J4lknAwyyWs" title=""
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen=""></iframe>
            </div>
            <div class="reel-info">
              <h3>Landscape</h3>
              <p>History of Synth music, there is probably no one.</p>
              <ul class="reel-social">
                <li>
                  <a href="javascript:;" title=""><i class="fab fa-instagram"></i></a>
                </li>
                <li>
                  <a href="javascript:;" title=""><i class="fab fa-youtube"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <!--reel-col end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="reel-col wow fadeInRight" data-wow-delay="400ms">
            <div class="reel-thumb">
              <iframe width="458" height="814" src="https://www.youtube.com/embed/hkLEdSjlqXQ" title=""
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen=""></iframe>
            </div>
            <div class="reel-info">
              <h3>Cyborg Life</h3>
              <p>History of Synth music, there is probably no one.</p>
              <ul class="reel-social">
                <li>
                  <a href="javascript:;" title=""><i class="fab fa-instagram"></i></a>
                </li>
                <li>
                  <a href="javascript:;" title=""><i class="fab fa-youtube"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <!--reel-col end-->
        </div>
      </div>
    </div>
  </section>

  <section class="block black-bg networks-section">
    <div class="container">
      <div class="title-sec wow fadeInUp">
        <h2>Our Music Distribution Partner</h2>
      </div>
      <!--title-sec end-->
      <div class="row">
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft">
            <img src="{{ asset('assets\images\resources\icons\jiosaavn.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft" data-wow-delay="200ms">
            <img src="{{ asset('assets\images\resources\icons\wynk-music-svgrepo-com.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft" data-wow-delay="400ms">
            <img src="{{ asset('assets\images\resources\icons\hungama.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft" data-wow-delay="600ms">
            <img src="{{ asset('assets/images/resources/logo1.png') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft">
            <img src="{{ asset('assets\images\resources\icons\instagram-svgrepo-com.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft" data-wow-delay="200ms">
            <img src="{{ asset('assets\images\resources\icons\facebook-svgrepo-com.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
        <div class="col-lg-3 mb-3">
          <div class="partner-logo wow fadeInLeft" data-wow-delay="400ms">
            <img src="{{ asset('assets\images\resources\icons\spotify.svg') }}" alt="" />
          </div>
          <!--partner-logo end-->
        </div>
      </div>
      <div class="contact-text">
        <ul>
          <li>CONTACT</li>
          <li>INFO@musicdistributionindia.in</li>
        </ul>
      </div>
      <!--contact-text end-->
    </div>
  </section>
  <section class="block">
    <div class="container">
      <div class="title-sec black text-center wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <h2>Your Favourite Artists</h2>
      </div><!--title-sec end-->
      <div class="row gallery-row">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="graphy-column wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
            <div class="graphy-image">
              <img src="{{ asset('assets/images/resources/team/15.jpg') }}" alt="">
              <a href="javascript:;" title="" class="ext-link"></a>
            </div>
            <div class="graphy-info">
              <h3><a href="javasrcipt:;" title="">Sonali S</a></h3>
              <span>Singer/Model/Management</span>
            </div>
          </div><!--graphy-column end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="graphy-column wow fadeIn" data-wow-delay="200ms"
            style="visibility: visible; animation-delay: 200ms; animation-name: fadeIn;">
            <div class="graphy-image">
              <img src="{{ asset('assets/images/resources/team/14.jpg') }}" alt="">
              <a href="javascript:;" title="" class="ext-link"></a>
            </div>
            <div class="graphy-info">
              <h3><a href="javascript:;" title="">Devender Ahelawat</a></h3>
              <span>Singer/Lyrics/Composer</span>
            </div>
          </div><!--graphy-column end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="graphy-column wow fadeIn" data-wow-delay="400ms"
            style="visibility: visible; animation-delay: 400ms; animation-name: fadeIn;">
            <div class="graphy-image">
              <img src="{{ asset('assets/images/resources/team/13.jpg') }}" alt="">
              <a href="javascript:;" title="" class="ext-link"></a>
            </div>
            <div class="graphy-info">
              <h3><a href="javascript:;" title="">KP Kundu & Bintu Pabra</a></h3>
              <span>Singer/Lyrics/Composer</span>
            </div>
          </div><!--graphy-column end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="graphy-column wow fadeIn" data-wow-delay="600ms"
            style="visibility: visible; animation-delay: 600ms; animation-name: fadeIn;">
            <div class="graphy-image">
              <img src="{{ asset('assets/images/resources/team/12.jpg') }}" alt="">
              <a href="javascript:;" title="" class="ext-link"></a>
            </div>
            <div class="graphy-info">
              <h3><a href="javascript:;" title="">B Praak Harrdy Sandhu & Jaani</a></h3>
              <span>Singer/Lyrics/Music/Composer</span>
            </div>
          </div><!--graphy-column end-->
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="graphy-column wow fadeIn" data-wow-delay="800ms"
            style="visibility: visible; animation-delay: 800ms; animation-name: fadeIn;">
            <div class="graphy-image">
              <img src="{{ asset('assets/images/resources/team/16.jpg') }}" alt="">
              <a href="javascript:;" title="" class="ext-link"></a>
            </div>
            <div class="graphy-info">
              <h3><a href="javascript:;" title="">Sumit Goswami</a></h3>
              <span>Singer/Lyrics/Composer</span>
            </div>
          </div><!--graphy-column end-->
        </div>
      </div>
    </div>
  </section>
@endsection
