@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Trang chủ</a>
        {{-- <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span> --}}
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
   
    <div class="products-section container">
        <div class="sidebar">
            <h3>Thể loại</h3>
            <ul>
                @foreach ($categories as $category)
                    <li class="{{ setActiveCategory($category->slug) }}"><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div id="jssor_1" style="position:relative;margin:0 auto; margin-bottom:40px;top:0px;left:0px;width:760px;height:280px;overflow:hidden;visibility:hidden;">
                <!-- Loading Screen -->
                <div data-u="loading" class="jssorl-004-double-tail-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                    <img style="height: 280px" style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="https://salt.tikicdn.com/cache/w584/ts/banner/9d/24/03/a725380918783bff6ea5b970ce3cb791.jpg" />
                </div>
                <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:760px;height:280px;overflow:hidden;">
                    <div style="background-color:transparent;">
                        <img data-u="image" style="height: 280px" src="https://salt.tikicdn.com/cache/w584/ts/banner/ee/cb/8e/e26d7098ea2daebf5088c14fa87e54eb.jpg" />
                        <div data-ts="flat" data-p="320" style="left:144px;top:80px;width:550px;height:90px;position:absolute;overflow:hidden;">
                            <div data-to="50% 50%" data-ts="preserve-3d" data-t="0" style="left:550px;top:0px;width:550px;height:90px;position:absolute;overflow:hidden;">
                                <div data-to="50% 50%" data-ts="preserve-3d" data-arr="1" style="left:20px;top:18px;width:200px;height:20px;position:absolute;color:#edf1f2;font-size:16px;font-weight:700;line-height:1.2;letter-spacing:0.1em;"></div>
                                <div data-to="50% 50%" data-ts="preserve-3d" data-arr="2" style="left:19px;top:36px;width:600px;height:30px;position:absolute;color:#edf1f2;font-size:24px;line-height:1.2;letter-spacing:0.05em;"><span style="font-weight:900;color:#e04338;"></span></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img data-u="image" style="height: 280px" src="https://salt.tikicdn.com/cache/w584/ts/banner/f0/29/75/c1eb6372020ecfe508057b0ba7080c71.jpg" />
                        <div data-ts="flat" data-p="2720" data-po="50% 48%" style="left:0px;top:0px;width:760px;height:280px;position:absolute;">
                            <div data-to="50% 50%" data-ts="preserve-3d" data-t="3" style="left:400px;top:-30px;width:500px;height:400px;position:absolute;">
                                <div data-to="50% 50%" data-ts="preserve-3d" data-t="4" style="left:0px;top:0px;width:500px;height:400px;position:absolute;">
                                    <div data-to="50% 50%" data-ts="preserve-3d" data-t="5" style="left:0px;top:0px;width:500px;height:400px;position:absolute;">
                                        <div data-to="50% 50%" data-ts="preserve-3d" data-t="6" style="left:0px;top:0px;width:500px;height:400px;position:absolute;">
                                            <div data-to="50% 50%" data-t="7" style="left:-50px;top:175px;width:600px;height:38px;position:absolute;opacity:0;color:#00a186;font-size:32px;font-weight:700;line-height:1.2;text-align:center;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img data-u="image" style="height: 280px" src="https://salt.tikicdn.com/cache/w584/ts/banner/f5/b2/fb/14caf22dc35e7ce1fbd72bb8b5dd913f.jpg" />
                        <div data-ts="flat" data-p="2720" data-po="50% 48%" style="left:0px;top:0px;width:760px;height:280px;position:absolute;">
                            <div data-to="50% 50%" data-ts="preserve-3d" data-arr="8" style="left:-2px;top:20px;width:1000px;height:20px;position:absolute;opacity:0;color:#0ff2f2;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:1.2;letter-spacing:1.3em;text-align:center;"></div>
                        </div>
                    </div>
                    <div style="background-color:#000000;">
                        <img data-u="image" style="height: 280px" style="opacity:0.5;" src="https://salt.tikicdn.com/cache/w584/ts/banner/18/a3/2b/0af35528ab0bda01014dfb723c906ebb.jpg" />
                        <div data-ts="flat" data-p="1800" data-po="50% -100%" style="left:120px;top:90px;width:600px;height:300px;position:absolute;">
                            <svg viewbox="0 0 200 200" width="200" height="200" data-t="10" style="left:66px;top:21px;display:block;position:absolute;opacity:0.6;overflow:visible;">
                                <path stroke-dasharray="0,700" fill="none" stroke="#ffffff" d="M0,100C0,44.77152 44.77152,0 100,0C155.22848,0 200,44.77152 200,100C200,155.22848 155.22848,200 100,200C44.77152,200 0,155.22848 0,100Z" data-t="9"></path>
                            </svg>
                            <svg viewbox="0 0 80 80" width="80" height="80" data-t="12" style="left:3px;top:124px;display:block;position:absolute;opacity:0.6;overflow:visible;">
                                <path stroke-dasharray="0,400" fill="none" stroke="#ffffff" shape-rendering="crispEdges" d="M80,80L0,80L0,0L80,0Z" data-t="11"></path>
                            </svg>
                            <svg viewbox="0 0 500 200" data-to="50% 50%" width="500" height="200" data-t="13" style="left:50px;top:50px;display:block;position:absolute;opacity:0;overflow:visible;">
                                <g>
                                    <text fill="#ffffff" x="17" y="110" style="position:absolute;font-family:Montserrat,sans-serif;font-size:32px;font-weight:300;overflow:visible;">
                                    </text>
                                    <text fill="#ffffff" x="188" y="110" style="position:absolute;font-family:Montserrat,sans-serif;font-size:32px;font-weight:500;letter-spacing:0.1em;overflow:visible;">
                                    </text>
                                    <text fill="#ff3700" x="218" y="130" style="position:absolute;font-family:Montserrat,sans-serif;font-size:16px;font-weight:900;letter-spacing:0.1em;overflow:visible;">
                                    </text>
                                    <text fill="#ff3700" x="333" y="130" style="position:absolute;opacity:0.8;font-family:Montserrat,sans-serif;font-size:16px;font-weight:700;letter-spacing:0.1em;overflow:visible;">
                                    </text>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <img data-u="image" style="height: 280px" src="https://salt.tikicdn.com/cache/w292/ts/banner/01/99/96/8d2c82b0f9023f470cfb84b2fe6d3d91.jpg" />
                        <div data-ts="flat" data-p="500" style="left:160px;top:-30px;width:800px;height:200px;position:absolute;">
                            <div data-arr="14" style="left:0px;top:36px;width:800px;height:70px;position:absolute;opacity:0;color:#199494;font-family:'Roboto Condensed',sans-serif;font-size:32px;font-weight:400;line-height:1.2;letter-spacing:-0.05em;text-align:center;text-shadow:2px 1px #d9d99a;">ADDING&nbsp;&nbsp;<span style="font-size:2em;"></span><span style="font-size:1.6em;"></span></div>
                            <div data-arr="15" style="left:0px;top:106px;width:800px;height:48px;position:absolute;opacity:0;color:#0d4d4d;font-family:'Roboto Condensed',sans-serif;font-size:20px;font-weight:400;line-height:1.2;letter-spacing:0.2em;text-align:center;text-shadow:1px 1px #d9d99a;">CREATING GREEN <span style="font-size:2em;"></span></div>
                        </div>
                    </div>
                </div><a data-scale="0" href="https://www.jssor.com" style="display:none;position:absolute;">slider html</a>
                <!-- Bullet Navigator -->
                <div data-u="navigator" class="jssorb031" style="position:absolute;bottom:16px;right:16px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                    <div data-u="prototype" class="i" style="width:13px;height:13px;">
                        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                            <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                        </svg>
                    </div>
                </div>
                <!-- Arrow Navigator -->
                <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    </svg>
                </div>
                <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    </svg>
                </div>
            </div>
            <div class="products-header">
                <h1 class="stylish-heading">{{ $categoryName }}</h1>
                <div>
                    <strong>Price: </strong>
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'low_high']) }}">Thấp đến cao</a> |
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'high_low']) }}">Cao đến thấp</a>

                </div>
            </div>

            <div class="products text-center">
            
                @forelse ($products as $product)
                    <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}"><img style="width:200px; height: 200px"src="{{ productImage($product->image) }}" alt="product"></a>
                        <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                        <div class="product-price">{{ $product->presentPrice() }}</div>
                    </div>
                @empty
                    <div style="text-align: left">No items found</div>
                @endforelse
            </div> <!-- end products -->

            <div class="spacer"></div>
            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>

@endsection

@section('extra-js')

    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
    <script src="{{asset ('js/jssor.slider-28.0.0.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        window.jssor_1_slider_init = function() {

            var jssor_1_SlideoTransitions = [
              [{b:500,d:1000,x:0,e:{x:6}}],
              [{b:-1,d:1,x:100,p:{x:{d:1,dO:9}}},{b:0,d:2000,x:0,e:{x:6},p:{x:{dl:0.1}}}],
              [{b:-1,d:1,x:200,p:{x:{d:1,dO:9}}},{b:0,d:2000,x:0,e:{x:6},p:{x:{dl:0.1}}}],
              [{b:-1,d:1,rX:20,rY:90},{b:0,d:4000,rX:0,e:{rX:1}}],
              [{b:-1,d:1,rY:-20},{b:0,d:4000,rY:-90,e:{rY:7}}],
              [{b:-1,d:1,sX:2,sY:2},{b:1000,d:3000,sX:1,sY:1,e:{sX:1,sY:1}}],
              [{b:-1,d:1,sX:2,sY:2},{b:1000,d:5000,sX:1,sY:1,e:{sX:3,sY:3}}],
              [{b:-1,d:1,tZ:300},{b:0,d:2000,o:1},{b:3500,d:3500,tZ:0,e:{tZ:1}}],
              [{b:-1,d:1,x:20,p:{x:{o:33,r:0.5}}},{b:0,d:1000,x:0,o:0.5,e:{x:3,o:1},p:{x:{dl:0.05,o:33},o:{dl:0.02,o:68,rd:2}}},{b:1000,d:1000,o:1,e:{o:1},p:{o:{dl:0.05,o:68,rd:2}}}],
              [{b:-1,d:1,da:[0,700]},{b:0,d:600,da:[700,700],e:{da:1}}],
              [{b:600,d:1000,o:0.4}],
              [{b:-1,d:1,da:[0,400]},{b:200,d:600,da:[400,400],e:{da:1}}],
              [{b:800,d:1000,o:0.4}],
              [{b:-1,d:1,sX:1.1,sY:1.1},{b:0,d:1600,o:1},{b:1600,d:5000,sX:0.9,sY:0.9,e:{sX:1,sY:1}}],
              [{b:0,d:1000,o:1,p:{o:{o:4}}}],
              [{b:1000,d:1000,o:1,p:{o:{o:4}}}]
            ];

            var jssor_1_options = {
              $AutoPlay: 1,
              $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_1_SlideoTransitions
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $SpacingX: 16,
                $SpacingY: 16
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 760;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <link href="//fonts.googleapis.com/css?family=Montserrat:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&subset=latin-ext,cyrillic-ext,vietnamese,latin,cyrillic" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,regular,italic,700,700italic&subset=latin-ext,greek-ext,cyrillic-ext,greek,vietnamese,latin,cyrillic" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script type="text/javascript">jssor_1_slider_init();
    </script>
     <style>
        /*jssor slider loading skin double-tail-spin css*/
        .jssorl-004-double-tail-spin img {
            height: 280px;
            animation-name: jssorl-004-double-tail-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-004-double-tail-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /*jssor slider bullet skin 031 css*/
        .jssorb031 {position:absolute;}
        .jssorb031 .i {position:absolute;cursor:pointer;}
        .jssorb031 .i .b {fill:#000;fill-opacity:0.6;stroke:#fff;stroke-width:1600;stroke-miterlimit:10;stroke-opacity:0.8;}
        .jssorb031 .i:hover .b {fill:#fff;fill-opacity:1;stroke:#000;stroke-opacity:1;}
        .jssorb031 .iav .b {fill:#fff;stroke:#000;stroke-width:1600;fill-opacity:.6;}
        .jssorb031 .i.idn {opacity:.3;}

        /*jssor slider arrow skin 051 css*/
        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style>
@endsection
