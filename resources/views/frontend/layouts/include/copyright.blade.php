<div class="copyright_area">
    <div class="container">
        <div class="row align-items-center">
            <div class="co-lg-6 col-md-6 col-sm-12 col-12">
                <div class="copyright_left">
                    <p>Copyright © {{ date('Y') }} All Rights Reserved</p>
                </div>
            </div>
            <div class="co-lg-6 col-md-6 col-sm-12 col-12">
                <div class="copyright_right">
                    <ul>
                       @if ($setting->facebook_url)
                       <li>
                           <a href="{{ $setting->facebook_url }}"><i class="fab fa-facebook"></i></a>
                       </li>
                       @endif
                       @if ($setting->twitter_url)
                       <li>
                           <a href="{{ $setting->twitter_url }}"><i class="fab fa-twitter-square"></i></a>
                       </li>
                       @endif
                       @if ($setting->instagram_url)
                       <li>
                           <a href="{{ $setting->instagram_url }}"><i class="fab fa-instagram"></i></a>
                       </li>
                       @endif
                       @if ($setting->linkedin_url)
                       <li>
                           <a href="{{ $setting->linkedin_url }}"><i class="fab fa-linkedin"></i></a>
                       </li>
                       @endif
                       @if ($setting->youtube_url)
                       <li>
                           <a href="{{ $setting->youtube_url }}"><i class="fab fa-youtube"></i></a>
                       </li>
                       @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
