<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-envelope"></i> {{ sc_store('email') }}</a></li>
                            <li><a href="#"> Most Customised Online Shopping Experience | Apekade.lk</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @php
                                $cartsCount = \Cart::count();
                            @endphp
                            <li><a href="{{ route('wishlist') }}"><span class="cart-qty  sc-wishlist"
                                                                        id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span><i
                                            class="fa fa-star"></i> {{ trans('front.wishlist') }}</a></li>
                            {{--<li><a href="{{ route('compare') }}"><span class="cart-qty sc-compare"
                                                                       id="shopping-compare">{{ Cart::instance('compare')->count() }}</span><i
                                            class="fa fa-crosshairs"></i> {{ trans('front.compare') }}</a></li>--}}
                            @guest
                                <li><a href="{{ route('login') }}"><i
                                                class="fa fa-lock"></i> {{ trans('front.login') }}
                                    </a></li>
                            @else
                                <li><a href="{{ route('member.index') }}"><i
                                                class="fa fa-user"></i> {{ trans('front.account') }}</a></li>
                                <li><a href="{{ route('logout') }}" rel="nofollow" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();"><i
                                                class="fa fa-power-off"></i> {{ trans('front.logout') }}</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @endguest

                        </ul>
                    </div>
                </div>
                {{-- <div class="col-sm-6">
                     <div class="btn-group pull-right">
                         <div class="btn-group locale">
                             @if (count($languages)>1)
                                 <button type="button" class="btn btn-default dropdown-toggle usa"
                                         data-toggle="dropdown"><img
                                             src="{{ asset($languages[app()->getLocale()]['icon']) }}"
                                             style="height: 25px;">
                                     <span class="caret"></span>
                                 </button>
                                 <ul class="dropdown-menu">
                                     @foreach ($languages as $key => $language)
                                         <li><a href="{{ url('locale/'.$key) }}"><img
                                                         src="{{ asset($language['icon']) }}" style="height: 25px;"></a>
                                         </li>
                                     @endforeach
                                 </ul>
                             @endif
                         </div>
                         @if (count($currencies)>1)
                             <div class="btn-group locale">
                                 <button type="button" class="btn btn-default dropdown-toggle usa"
                                         data-toggle="dropdown">
                                     {{ sc_currency_info()['name'] }}
                                     <span class="caret"></span>
                                 </button>
                                 <ul class="dropdown-menu">
                                     @foreach ($currencies as $key => $currency)
                                         <li><a href="{{ url('currency/'.$currency->code) }}">{{ $currency->name }}</a>
                                         </li>
                                     @endforeach
                                 </ul>
                             </div>
                         @endif
                     </div>
                 </div>--}}
            </div>
        </div>
    </div><!--/header_top-->
    <div class="header-middle"><!--header-middle-->
        <div class="container">
                       <div class="row">
                <div class="col-lg-2">
                    <div class="logo pull-left">
                        <a href="{{ route('home') }}"><img style="width: 150px;" src="{{ asset(sc_store('logo')) }}"
                                                           alt=""/></a>
                    </div>
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-5">
                    <form id="searchbox" method="get" action="{{ route('search') }}">
                        <div class="input-group"><input id="search_input" class="form-control"
                                                        placeholder="{{ trans('front.search_form.keyword') }}..."
                                                        name="keyword"
                                                        aria-label="Text input with segmented button dropdown">
                            <div class="input-group-btn">

                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"> All Categories <span
                                            class="caret"></span><span
                                            class="sr-only">Toggle Dropdown</span></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                                <button type="submit" class="btn btn-default" id="btnSearch"><i
                                            class="fa fa-search"></i></button>
                            </div>
                        </div><!-- /input-group -->
                        <div style="position: fixed;z-index: 10000;" id="products_list"></div>
                    </form>
                </div><!-- /.col-lg-6 -->

                <div class="col-lg-4">

                    <div class="custom-block"><span style="margin-top:4px;color:#787d7f;display:block;font-size: 10px">CALL US NOW FOR ANY INQUIRY OR ORDER BY PHONE<br><b
                                    style="color:#606669;font-size:15px;font-weight:600;display:block;line-height:27px;font-family: 'Oswald';"> <i class="fa fa-phone"></i> {{ sc_store('phone') }} | IF NO ANSWER DROP SMS</b></span>
                    </div>

                </div>
                <div class="col-lg-1">
                    <div class="pull-right">
                        <a href="{{ route('cart') }}"><span class="cart-qty sc-cart"
                                                            id="shopping-cart">{{ Cart::instance('default')->count() }}</span><i
                                    class="fa fa-shopping-basket fa-2x"></i> {{--{{ trans('front.cart_title') }}--}}</a>
                    </div>
                </div>
            </div><!-- /.row -->
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse" id="header_menu">
                            <li><a href="{{ route('home') }}" class="active">{{ trans('front.home') }}</a></li>
                            <li class="dropdown"><a href="#">{{ trans('front.shop') }}<i
                                            class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{ route('product.all') }}">{{ trans('front.all_product') }}</a></li>
                                    {{-- <li><a href="{{ route('compare') }}">{{ trans('front.compare') }}</a></li>--}}
                                    {{-- <li><a href="{{ route('cart') }}">{{ trans('front.cart_title') }}</a></li>--}}
                                    <li><a href="{{ route('categories') }}">{{ trans('front.categories') }}</a></li>
                                    <li><a href="{{ route('brands') }}">{{ trans('front.brands') }}</a></li>
                                    <li><a href="{{ route('vendors') }}">{{ trans('front.vendors') }}</a></li>
                                </ul>
                            </li>

                            {{--<li><a href="{{ route('news') }}">{{ trans('front.blog') }}</a></li>--}}

                            @if (!empty(sc_config('Content')))
                                <li class="dropdown"><a href="#">{{ trans('front.cms_category') }}<i
                                                class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @php
                                            $nameSpace = sc_get_module_namespace('Cms','Content').'\Models\CmsCategory';
                                            $cmsCategories = (new $nameSpace)->where('status', 1)->get();
                                        @endphp
                                        @foreach ($cmsCategories as $cmsCategory)
                                            <li>
                                                <a href="{{ $cmsCategory->getUrl() }}">{{ sc_language_render($cmsCategory->title) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif

                            @if (!empty($layoutsUrl['menu']))
                                @foreach ($layoutsUrl['menu'] as $url)
                                    <li>
                                        <a {{ ($url->target =='_blank')?'target=_blank':''  }} href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
