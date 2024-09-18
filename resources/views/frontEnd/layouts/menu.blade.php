@if(Helper::GeneralWebmasterSettings("header_menu_id") >0)
    <?php
    // Get list of main menu links
    $MenuLinks = \App\Helpers\SiteMenu::List(Helper::GeneralWebmasterSettings("header_menu_id"));
    ?>
    @if(count($MenuLinks)>0)
        <nav id="navbar" class="navbar">
            <ul>
                @foreach($MenuLinks as $MenuLink)
                    <li class="{{ (@$MenuLink->sub)?"dropdown":"" }}"><a
                            class="nav-link {{ \App\Helpers\SiteMenu::ActiveLink(url()->current(),@$MenuLink,@$WebmasterSection) }}"
                            href="{{ @$MenuLink->url }}" target="{{ @$MenuLink->target }}">
                            {!! (@$MenuLink->icon)?"<i class='".@$MenuLink->icon."'></i> ":"" !!} {{ @$MenuLink->title }}
                            @if(@$MenuLink->sub)
                                <i class="drop-arrow bi bi-chevron-down"></i>
                            @endif
                        </a>

                        @if(@$MenuLink->sub)
                            <ul>
                                @foreach($MenuLink->sub as $SubLink)
                                    <li class="{{ (@$SubLink->sub)?"dropdown":"" }}"><a class="nav-link"
                                                                                        href="{{ @$SubLink->url }}"
                                                                                        target="{{ @$SubLink->target }}">{!! (@$SubLink->icon)?"<i class='".@$SubLink->icon."'></i> ":"" !!} {{ @$SubLink->title }}
                                            @if(@$SubLink->sub)
                                                <i class="drop-arrow bi bi-chevron-{{ @Helper::currentLanguage()->right }}"></i>
                                            @endif
                                        </a>
                                        @if(@$SubLink->sub)
                                            <ul>
                                                @foreach($SubLink->sub as $SubLink2)
                                                    <li class="{{ (@$SubLink2->sub)?"dropdown":"" }}"><a
                                                            class="nav-link"
                                                            href="{{ @$SubLink2->url }}"
                                                            target="{{ @$SubLink2->target }}">{!! (@$SubLink2->icon)?"<i class='".@$SubLink2->icon."'></i> ":"" !!} {{ @$SubLink2->title }}
                                                            @if(@$SubLink2->sub)
                                                                <i class="drop-arrow bi bi-chevron-{{ @Helper::currentLanguage()->right }}"></i>
                                                            @endif
                                                        </a>
                                                        @if(@$SubLink2->sub)
                                                            <ul>
                                                                @foreach($SubLink2->sub as $SubLink3)
                                                                    <li><a
                                                                            class="nav-link"
                                                                            href="{{ @$SubLink3->url }}"
                                                                            target="{{ @$SubLink3->target }}">{!! (@$SubLink3->icon)?"<i class='".@$SubLink3->icon."'></i> ":"" !!} {{ @$SubLink3->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>

        @if(count(Helper::languagesList()) >1)
                <div class="dropdown header-dropdown language-buttons">
                    <button class="btn dropdown-toggle" type="button" id="dropdownLangBtn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        @if(@Helper::currentLanguage()->icon !="")
                            <img
                                src="{{ asset('assets/dashboard/images/flags/'.@Helper::currentLanguage()->icon.".svg") }}"
                                alt="{{ @Helper::currentLanguage()->title }}" loading="lazy">
                        @endif
                        
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownLangBtn">
                        @foreach(Helper::languagesList() as $ActiveLanguage)
                            <a href="{{ Helper::languageURL($ActiveLanguage->code, @$page_type , @$page_id) }}"
                               class="dropdown-item">
                                @if($ActiveLanguage->icon !="")
                                    <img
                                        src="{{ asset('assets/dashboard/images/flags/'.$ActiveLanguage->icon.".svg") }}"
                                        alt=" {{ $ActiveLanguage->title }}" loading="lazy">
                                @endif
                            </a>
                        @endforeach
                    </ul>
                </div>
            @endif
        
    @endif
@endif

@push('after-scripts')
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    if (window.innerWidth <= 768) {
        // Close navbar-mobile on click
        const menuItems = document.querySelectorAll('.navbar-mobile .menu-item'); // Adjust selector if necessary
        menuItems.forEach(function(item) {
            item.addEventListener('click', function() {
                document.querySelector('.navbar-mobile').classList.remove('active'); // Adjust class if needed
            });
        });
    }
});
</script>
@endpush
