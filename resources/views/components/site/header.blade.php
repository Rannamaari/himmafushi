@php($isHome = request()->routeIs('home'))
<header class="site-header {{ $isHome ? 'site-header-home' : '' }}" data-site-header>
    <div class="page-shell header-inner">
        <a href="{{ route('home') }}" class="brand" aria-label="Himmafushi home">HIMMAFUSHI<span>.</span></a>
        <nav class="desktop-nav" aria-label="Primary navigation" data-desktop-nav>
            <ul>
                @foreach($navigationItems->where('show_in_desktop', true) as $item)
                    @php($hasMenu = $item->menu_style !== 'link' && $item->children->isNotEmpty())
                    <li class="nav-menu-item {{ $item->menu_style === 'mega' ? 'nav-menu-item-wide' : '' }}">
                        @if($hasMenu)
                            <button class="desktop-nav-link {{ $item->isCurrent() ? 'is-active' : '' }}" type="button" aria-expanded="false" aria-controls="nav-menu-{{ $item->id }}" data-menu-toggle="nav-menu-{{ $item->id }}">{{ $item->label }}</button>
                            <div id="nav-menu-{{ $item->id }}" class="nav-dropdown {{ $item->menu_style === 'mega' ? 'nav-dropdown-wide' : 'nav-dropdown-small' }}" hidden data-dropdown>
                                @if($item->menu_heading)<p class="nav-menu-label">{{ $item->menu_heading }}</p>@endif
                                <div class="{{ $item->menu_style === 'mega' ? 'mega-menu-links' : '' }}">
                                    @foreach($item->children as $child)
                                        <a href="{{ $child->destination() }}" @if($child->open_in_new_tab) target="_blank" rel="noopener" @endif>{{ $child->label }} <span>&rarr;</span></a>
                                    @endforeach
                                </div>
                                <a class="nav-menu-cta" href="{{ $item->destination() }}">View all {{ strtolower($item->label) }} <span>&rarr;</span></a>
                            </div>
                        @else
                            <a class="desktop-nav-link {{ $item->isCurrent() ? 'is-active' : '' }}" href="{{ $item->destination() }}" @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif data-nav-link>{{ $item->label }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
            <span class="nav-indicator" aria-hidden="true" data-nav-indicator></span>
        </nav>
        <div class="header-actions"><button class="header-icon-button" type="button" aria-label="Search Himmafushi" aria-controls="site-search" aria-expanded="false" data-search-open><span aria-hidden="true">&#128269;</span></button><a class="plan-stay-button" href="{{ route('guesthouses.index') }}">Plan Your Stay <span aria-hidden="true">&rarr;</span></a><button class="mobile-menu-button" type="button" aria-label="Open menu" aria-controls="mobile-navigation" aria-expanded="false" data-mobile-open><span></span><span></span></button></div>
    </div>
</header>
<div id="mobile-navigation" class="mobile-navigation" hidden data-mobile-navigation><div class="mobile-navigation-inner"><div class="mobile-nav-top"><a href="{{ route('home') }}" class="brand">HIMMAFUSHI<span>.</span></a><button type="button" aria-label="Close menu" data-mobile-close>&times;</button></div><nav aria-label="Mobile navigation"><ol>@foreach($navigationItems->where('show_in_mobile', true) as $item)<li><a href="{{ $item->destination() }}" @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $item->label }}</a></li>@endforeach</ol></nav><a class="mobile-plan-button" href="{{ route('guesthouses.index') }}">Plan Your Stay <span>&rarr;</span></a></div></div>
<x-site.search-overlay />
