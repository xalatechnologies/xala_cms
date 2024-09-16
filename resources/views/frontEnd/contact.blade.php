@extends('frontEnd.layouts.master')

@section('content')
 <?php
        $title_var = "title_" . @Helper::currentLanguage()->code;
        $title_var2 = "title_" . config('smartend.default_language');
        $details_var = "details_" . @Helper::currentLanguage()->code;
        $details_var2 = "details_" . config('smartend.default_language');
        if ($Topic->$title_var != "") {
            $title = $Topic->$title_var;
        } else {
            $title = $Topic->$title_var2;
        }
        if ($Topic->$details_var != "") {
            $details = $details_var;
        } else {
            $details = $details_var2;
        }
        $section = "";
        try {
            if ($Topic->section->$title_var != "") {
                $section = $Topic->section->$title_var;
            } else {
                $section = $Topic->section->$title_var2;
            }
        } catch (Exception $e) {
            $section = "";
        }
        ?>
     
 <!-- Contact Us Section -->
    <section class="contact-us-section bg-grey py-5">
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-12 text-center">
                   <h2 class="section-title">{{ __('frontend.contactTitle') }}</h2>
                    <p class="section-subtitle mb-5">{{ __('frontend.contactDescription') }} </p>
                </div>
            </div>

            <!-- Contact Form & Info Section -->
            <div class="row align-items-stretch contact-us-row g-0">
                <!-- Contact Form -->
                <div class="col-lg-6">
                        {{Form::open(['route'=>['contactPageSubmit'],'method'=>'POST','class'=>'php-email-form contact-form p-5 bg-white h-100 rounded','id'=>'contactForm'])}}
                        <div class="row">
                            <div class="col-md-12 form-group">
                                {!! Form::text('contact_name',"", array('placeholder' => __('frontend.yourName'),'class' => 'form-control','id'=>'contact_name','required'=>'required')) !!}
                            </div>
                            <div class="col-md-12 form-group mt-3 mt-md-0">
                                {!! Form::email('contact_email',"", array('placeholder' => __('frontend.yourEmail'),'class' => 'form-control','id'=>'contact_email','required'=>'required')) !!}
                            </div>
                            <div class="col-md-12 form-group mt-3 mt-md-0">
                                {!! Form::text('contact_phone',"", array('placeholder' => __('frontend.phone'),'class' => 'form-control','id'=>'contact_phone','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            {!! Form::text('contact_subject',"", array('placeholder' => __('frontend.subject'),'class' => 'form-control','id'=>'contact_subject','required'=>'required')) !!}
                        </div>
                        <div class="form-group mt-3">
                            {!! Form::textarea('contact_message','', array('placeholder' => __('frontend.message'),'class' => 'form-control','id'=>'contact_message','rows'=>'10','required'=>'required')) !!}
                        </div>

                        @if(config('smartend.nocaptcha_status'))
                            <div class="form-group mb-3">
                                {!! NoCaptcha::renderJs(@Helper::currentLanguage()->code) !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        <div class="submit-message"></div>
                        <div>
                            <button type="submit" id="contactFormSubmit" class="btn btn-lg cta-button cta-button-primary"><i
                                    class="fa-solid fa-paper-plane"></i> {{ __('frontend.sendMessage') }}</button>
                        </div>
                        {{Form::close()}}
                </div>

                <!-- Contact Information -->
                <div class="col-lg-6">
                    <div class="contact-info d-flex flex-column bg-dark-green justify-content-between h-100">
                        <div class="contact-info-header">
                            <h3>{{ __('frontend.contactInformationTitle') }}</h3>
                            <p>{{ __('frontend.contactInformationDescription') }}</p>

                            <div class="contact-info-labels mt-4 py-3">
                                <ul class="contact-details">
                                    <li><i class="bi bi-telephone"></i> {{ Helper::GeneralSiteSettings("contact_t3") }} | {{ Helper::GeneralSiteSettings("contact_t5") }}</li>
                                    <li><i class="bi bi-envelope"></i> {{ Helper::GeneralSiteSettings("contact_t6") }} </li>
                                    <li><i class="bi bi-geo-alt"></i> {{ Helper::GeneralSiteSettings("contact_t1_" . @Helper::currentLanguage()->code) }}</li>
                                    <li><i class="bi bi-clock"></i> {{ __('frontend.contactInformationOpeningHours') }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="contact-info-footer">
                            <div class="social-icons mt-4">
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontEnd.topic.maps")

    @include('frontEnd.layouts.popup',['Popup'=>@$Popup])
@endsection

@push('before-styles')
    <link rel="stylesheet"
          href="{{ URL::asset('assets/frontend/vendor/intl-tel-input/css/intlTelInput.min.css') }}?v={{ Helper::system_version() }}"/>
@endpush
@push('after-scripts')
    <script
        src="{{ URL::asset('assets/frontend/vendor/intl-tel-input/js/intlTelInput.min.js') }}?v={{ Helper::system_version() }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#contactForm').submit(function (evt) {
                evt.preventDefault();
                let btn = $('#contactFormSubmit');
                btn.html("<img src=\"{{ asset('assets/dashboard/images/loading.gif') }}\" style=\"height: 20px\"/> {!! __('frontend.sendMessage') !!}");
                btn.prop('disabled', true);
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route("contactPageSubmit") }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        let stat = 'alert-danger';
                        if (result.stat === 'success') {
                            stat = 'alert-success';
                            $('#contactForm')[0].reset();
                        }
                        let confirm = '<div class="alert ' + stat + ' alert-dismissible fade show mt-3" role="alert">' + result.msg + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        $("#contactForm .submit-message").html(confirm);
                        btn.html('<i class="fa-solid fa-paper-plane"></i> {!! __('frontend.sendMessage') !!}');
                        btn.prop('disabled', false);
                    }
                });
                return false;
            });
        });

        var iti = window.intlTelInput(document.querySelector("#contact_phone"), {
            showSelectedDialCode: true,
            countrySearch: true,
            initialCountry: "auto",
            separateDialCode: true,
            hiddenInput: function() {
                return {
                    phone: "contact_phone_full",
                    country: "contact_phone_country_code"
                };
            },
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode.toLowerCase());
                    iti.setCountry(countryCode.toLowerCase());
                });
            },
            utilsScript: "{{ URL::asset('assets/frontend/vendor/intl-tel-input/js/utils.js') }}?v={{ Helper::system_version() }}",
        });
    </script>
@endpush
