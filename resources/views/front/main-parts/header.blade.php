<?php 

use App\Currency;
use App\Http\Helpers\Helpers;
use App\Translations\Language;
use Illuminate\Support\Facades\Route;

?>
<header class="header">
  <div class="wrapper">
    <a class="header__logo text-hidden" href="{{route('home', app()->getLocale())}}" title="{{ __('front.go_to_home') }}">Viajar por patagonia</a>

    <nav class="navigation">
      <ul class="navigation__ul">
        <li class="navigation__li">
          <a class="navigation__link" href="{{route('home', app()->getLocale())}}">{{ ucfirst(__('front.home')) }}</a>
        </li>
        <li class="navigation__li">
          <a class="navigation__link" href="#">{{ ucfirst(__('front.hotels')) }}</a>
        </li>
        <li class="navigation__li">
          <a class="navigation__link" href="#">{{ ucfirst(__('front.cars')) }}</a>
        </li>
      </ul>
    </nav>

    <form action="#" class="search_form">
      <input class="search_form__input" type="search" placeholder="{{ ucfirst(__('front.search')) }}" />
      <button class="search_form__submit">{!! Helpers::load_svg('ico-search') !!}</button>
    </form>

    <?php $currencies = Currency::getAll(); ?>
    <div class="selector">
      
      <div class="selector--current">{!! Helpers::load_svg('lang-pt') !!}{{ ucfirst(__('front.currency')) }}{!! Helpers::load_svg('ico-down') !!}</div>
      <ul class="selector__ul">
        @foreach ($currencies as $currency)
          <li class="selector__li" title="{{ ucfirst(__('front.change_to')) }} {{ __('front.currency') }} {{ $currency->currency }}">{{ $currency->sign }} {{ $currency->iso }}</li>
        @endforeach
      </ul>
    </div>

    <?php 
      $languages = Language::getAll();
      $parameters = Route::current()->parameters();
    ?>
    <div class="selector">
      <div class="selector--current">{!! Helpers::load_svg('lang-es') !!}{{ ucfirst(__('front.language')) }}{!! Helpers::load_svg('ico-down') !!}</div>
      <ul class="selector__ul">
        @foreach ($languages as $language)
          <?php $parameters['locale'] = $language->iso; ?>
          <li class="selector__li">
            <a title="{{ ucfirst(__('front.change_to')) }} {{ __('front.language') }} {{ $language->language }}" href="{{route(Route::currentRouteName(), $parameters )}}">{{ $language->language }}</a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  
</header>