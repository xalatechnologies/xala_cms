<?php
$TechnologiesLimit = 12; ; // 0 = all
$Technologies = Helper::Topics(16, 0, $TechnologiesLimit, 1);
?>
@if(count($Technologies)>0)
<section class="tools-section py-5 bg-light-green">
    <div class="container">
        <!-- Section Title -->
        <div class="row mb-4 text-center">
            <div class="col-12">
                <h2 class="tools-title">{{ __('frontend.technologiesTitle') }}</h2>
                <p class="tools-subtitle">{{ __('frontend.technologiesdesc') }}</p>
            </div>
        </div>

        <!-- Tools Cards Grid -->
        <div class="row tools-grid">
            @foreach($Technologies as $Technology)
            <?php
                    if ($Technology->$title_var != "") {
                        $title = $Technology->$title_var;
                    } else {
                        $title = $Technology->$title_var2;
                    }
                    ?>

            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="tool-card text-center p-3">
                    <img src="{{ URL::to('uploads/topics/'.$Technology->photo_file) }}" alt="{{ $title }}" class="img-fluid tool-logo mb-2">
                    <p class="tool-label">{{ $title }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="more-btn">
                    <a href="/technologies" class="btn btn-theme"><i class="fa fa-angle-left"></i>&nbsp; {{ __('frontend.viewMore') }}
                        &nbsp;<i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
