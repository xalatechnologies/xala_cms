<?php
$TechnologiesLimit = 12; ; // 0 = all
$Technologies = Helper::Topics(16, 0, $TechnologiesLimit, 1);
?>
@if(count($Technologies)>0)
<section id="Tools" class="tools-section py-5 bg-light-green">
    <div class="container">
        <!-- Section Title -->
        <div class="row mb-4 text-center">
            <div class="col-12">
                <h2 class="tools-title">{{ __('frontend.technologiesTitle') }}</h2>
                <p class="section-subtitle">{{ __('frontend.technologiesdesc') }}</p>
            </div>
        </div>

        <!-- Tools Cards Grid -->
        <div class="row tools-grid">
            @foreach($Technologies->sortBy('id') as $Technology)
            <?php
                    if ($Technology->$title_var != "") {
                        $title = $Technology->$title_var;
                    } else {
                        $title = $Technology->$title_var2;
                    }

                     $url = $Technology->seo_url_slug_en;
                    ?>

            <a href="{{ "technologies/".$url }}" class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="tool-card text-center p-3">
                    <img src="{{ URL::to('uploads/topics/'.$Technology->photo_file) }}" alt="{{ $title }}" class="img-fluid tool-logo mb-2">
                    <p class="tool-label">{{ $title }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="more-btn">
                    <a href="contact" class="btn cta-button cta-button-primary"> {{ __('frontend.getintouch') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
