
<?php
$ClientsLimit = 6; // 0 = all
$Clients = Helper::Topics(9, 0, $ClientsLimit, 1);
$TextBanners = Helper::Topics(2, 0, $ClientsLimit, 1);
$Technologies = Helper::Topics(16, 0, $ClientsLimit, 1);
?>

@if(count($TextBanners)>0)
@foreach($TextBanners as $TextBanner)
<?php
        try {
            $TextBanner_type = $TextBanner->webmasterBanner->type;
        } catch (Exception $e) {
            $TextBanner_type = 0;
        }
        ?>
@endforeach
<?php
    $title_var = "title_" . @Helper::currentLanguage()->code;
    $title_var2 = "title_" . config('smartend.default_language');
    $details_var = "details_" . @Helper::currentLanguage()->code;
    $details_var2 = "details_" . config('smartend.default_language');
    $file_var = "file_" . @Helper::currentLanguage()->code;
    $file_var2 = "file_" . config('smartend.default_language');
    $link_var = "link_" . @Helper::currentLanguage()->code;

    $col_width = 12;
    if (count($TextBanners) == 2) {
        $col_width = 6;
    }
    if (count($TextBanners) == 3) {
        $col_width = 4;
    }
    if (count($TextBanners) > 3) {
        $col_width = 3;
    }
    ?>

<!-- Our Services Section -->
<section id="Services" class="services-section py-5 position-relative">
    <div class="background-design"></div>
    <div class="container text-center">
        <h2 class="services-title mb-4">{{ __('frontend.services') }}</h2>
        <p class="services-subtitle mb-5">{{ __('frontend.servicesMsg') }}</p>

        <div class="row justify-content-center">
            @foreach($TextBanners->sortBy('id') as $TextBanner)
            <?php
                    if ($TextBanner->$title_var != "") {
                        $BTitle = $TextBanner->$title_var;
                    } else {
                        $BTitle = $TextBanner->$title_var2;
                    }
                    if ($TextBanner->$details_var != "") {
                        $BDetails = $TextBanner->$details_var;
                    } else {
                        $BDetails = $TextBanner->$details_var2;
                    }
                    if ($TextBanner->$file_var != "") {
                        $BFile = $TextBanner->$file_var;
                    } else {
                        $BFile = $TextBanner->$file_var2;
                    }

                    $url = $TextBanner->seo_url_slug_en;
                    ?>

            <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex">
                <div class="service-card p-4 flex-grow-1"> 
                    @if($TextBanner->icon !="")
                    <div class="icon">
                        <i class="fa {{$TextBanner->icon}} fa-3x"></i>
                    </div>
                    @elseif($BFile !="")
                    <img src="{{ URL::to('uploads/banners/'.$BFile) }}" loading="lazy" alt="{{ $BTitle }}" />
                    @endif
                    <h5 class="service-title mt-3">{!! $BTitle !!}</h5>
                    <p>{!! $BDetails !!}</p>
                </div>
            </div>
            @endforeach

        <div class="row">
            <div class="col text-center">
                <a href="#Contact" class="btn cta-button cta-button-primary mt-4">{{ __('frontend.getintouch') }}</a>
            </div>
        </div>

        </div>
</section>

@endif
