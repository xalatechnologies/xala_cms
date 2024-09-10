<?php
$bg_color = Helper::GeneralSiteSettings("style_color2");
$footer_style = "background: " . $bg_color;
if (Helper::GeneralSiteSettings("style_footer_bg") != "") {
    $bg_file = URL::to('uploads/settings/' . Helper::GeneralSiteSettings("style_footer_bg"));
    $footer_style = "style='background-image: url($bg_file);'";
}
if (Helper::GeneralSiteSettings("style_footer") != 1) {
    $footer_style = "style=padding:0";
}
$contacts_cols = 3;
if (!Helper::GeneralSiteSettings("style_subscribe")) {
    $contacts_cols = 4;
}
?>
<!-- Footer Section -->
<footer class="footer-section bg-black">
    <div class="container">
        <div class="row">
            <!-- Logo and Description -->
            <div class="col-md-5 footer-logo">
                <img src="{{ URL::to('uploads/media/logo_white.svg') }}" alt="{{ Helper::GeneralSiteSettings("site_title_" . @Helper::currentLanguage()->code) }}">
                <p class="footer-description">
                    {{ Helper::GeneralSiteSettings("site_desc_" . @Helper::currentLanguage()->code) }}
                </p>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4 px-3 footer-contact">
                <div class="contact-item">
                    <i class="bi bi-telephone-fill"></i> {{ Helper::GeneralSiteSettings("contact_t3") }} | {{ Helper::GeneralSiteSettings("contact_t5") }}
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope-fill"></i> {{ Helper::GeneralSiteSettings("contact_t6") }}
                </div>
                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill"></i> {{ Helper::GeneralSiteSettings("contact_t1_" . @Helper::currentLanguage()->code) }}
                </div>
                <div class="contact-item">
                    <i class="bi bi-clock-fill"></i> {{ __('frontend.contactInformationOpeningHours') }}
                </div>
            </div>

            <!-- Social Links -->
            <div class="col-md-3 footer-social">
                <p>{{ __('frontend.footerSocialMediaLinks') }}</p>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="footer-bottom">
            <ul class="footer-links">
             <?php
                        // Get list of footer menu links by group Id
                        $MenuLinks = \App\Helpers\SiteMenu::List(Helper::GeneralWebmasterSettings("footer_menu_id"));
                        $max_menu_cols = 2;
                        if (!Helper::GeneralSiteSettings("style_subscribe")) {
                            $max_menu_cols = 4;
                        }
                        $mi = 0;
                        ?>
                @foreach($MenuLinks as $MenuLink)
                                <li><a href="{{ @$SubLink->url }}" target="{{ @$SubLink->target }}">{{ @$MenuLink->title }}</a></li>

                @endforeach
            </ul>
            <div class="footer-copyright">
                © 2000-2024, All Rights Reserved
            </div>
        </div>
    </div>
</footer>

@if(Helper::GeneralSiteSettings('social_link10'))
<a href="https://wa.me/{{Helper::GeneralSiteSettings('social_link10')}}" class="whatsapp_float" target="_blank" aria-label="Whatsapp" rel="noopener noreferrer">
    <i class="fa fa-whatsapp"></i>
</a>
@endif
@if (@Auth::check())
@if(!Helper::GeneralSiteSettings("site_status"))
<div class="text-center alert alert-warning m-0">
    <div class="h6 mb-0">
        {{__('backend.websiteClosedForVisitors')}}
    </div>
</div>
@endif
@endif
