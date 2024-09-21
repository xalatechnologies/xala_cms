 <!-- Contact Us Section -->
    <section id="Contact" class="contact-us-section bg-grey py-5">
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
                        {{Form::open(['route'=>['contactPageSubmit'],'method'=>'POST','class'=>'php-email-form contact-form p-5 bg-white h-100 rounded','id'=>'contactForm', 'novalidate' => true])}}
                        <div class="row">
                            <div class="col-md-12 form-group">
                            {!! Form::text('contact_name', "", array('placeholder' => __('frontend.yourName'), 'class' => 'form-control', 'id' => 'contact_name', 'required' => 'required', 'pattern' => '[A-Za-z\s]{3,}', 'title' => 'Name must be at least 3 characters and contain only letters and spaces')) !!}
                            <span class="error-message" id="error-contact_name"></span>
                        </div>

                        <div class="col-md-12 form-group mt-3 mt-md-0">
                            {!! Form::email('contact_email', "", array('placeholder' => __('frontend.yourEmail'), 'class' => 'form-control', 'id' => 'contact_email', 'required' => 'required', 'pattern' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$', 'title' => 'Please enter a valid email address (e.g., example@domain.com).')) !!}
                            <span class="error-message" id="error-contact_email"></span>
                        </div>

                        <div class="col-md-12 form-group mt-3 mt-md-0">
                            {!! Form::text('contact_phone', "", array('placeholder' => __('frontend.phone'), 'class' => 'form-control', 'id' => 'contact_phone', 'required' => 'required', 'pattern' => '[0-9]{10,15}', 'title' => 'Phone number should be between 10-15 digits')) !!}
                            <span class="error-message" id="error-contact_phone"></span>
                        </div>

                        <div class="form-group mt-3">
                            {!! Form::text('contact_subject', "", array('placeholder' => __('frontend.subject'), 'class' => 'form-control', 'id' => 'contact_subject', 'required' => 'required', 'minlength' => '5', 'title' => 'Subject must be at least 5 characters')) !!}
                            <span class="error-message" id="error-contact_subject"></span>
                        </div>

                        <div class="form-group mt-3">
                            {!! Form::textarea('contact_message', '', array('placeholder' => __('frontend.message'), 'class' => 'form-control', 'id' => 'contact_message', 'rows' => '10', 'required' => 'required', 'minlength' => '10', 'title' => 'Message must be at least 10 characters')) !!}
                            <span class="error-message" id="error-contact_message"></span>
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
                                <a href="{{Helper::GeneralSiteSettings('social_link1')}}" target="_blank"><i class="bi bi-facebook"></i></a>
                                <a href="{{Helper::GeneralSiteSettings('social_link2')}}" target="_blank"><i class="bi bi-twitter"></i></a>
                                <a href="{{Helper::GeneralSiteSettings('social_link4')}}" target="_blank"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 

@push('after-scripts')
<script>
    var validationMessages = @json([
        'required' => __('validation.required'),
        'email' => __('validation.email'),
        'minlength' => __('validation.minlength', ['min' => 5]),
        'phone' => __('validation.phone'),
    ]);
</script>
<script>
    document.getElementById('contactForm').addEventListener('submit', function (event) {
        let isValid = true;

        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        // Name validation
        let name = document.getElementById('contact_name');
        if (name.value.trim() === '') {
            isValid = false;
            document.getElementById('error-contact_name').textContent = validationMessages.required.replace(':attribute', 'Name');
        }

        // Email validation
        let email = document.getElementById('contact_email');
        let emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
        if (!emailPattern.test(email.value)) {
            isValid = false;
            document.getElementById('error-contact_email').textContent = validationMessages.email;
        }

        // Phone validation
        let phone = document.getElementById('contact_phone');
        let phonePattern = /^[0-9]{8,15}$/;
        if (!phonePattern.test(phone.value)) {
            isValid = false;
            document.getElementById('error-contact_phone').textContent = validationMessages.phone;
        }

        // Subject validation
        let subject = document.getElementById('contact_subject');
        if (subject.value.length < 5) {
            isValid = false;
            document.getElementById('error-contact_subject').textContent = validationMessages.minlength.replace(':attribute', 'Subject');
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('contactForm');
        const inputs = form.querySelectorAll('input, textarea');

        inputs.forEach(function(input) {
            input.addEventListener('input', function () {
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            });
        });
    });
</script>

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
    </script>
@endpush
