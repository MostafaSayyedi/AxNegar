<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}"><!--<![endif]-->
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('pageTitle')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow"/>
    <meta name="keywords" content="css3, css-only, fullscreen, background, slideshow, images, content"/>
    <meta name="author" content="Codrops"/>
{{--    <link rel="shortcut icon" href="../favicon.ico">--}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
{{--    <link href="https://plugins.krajee.com/assets/prod/all-krajee.min.css" media="all" rel="stylesheet" type="text/css" />--}}

    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('usr/css/demo.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('usr/css/style1.css') }}"/>
    <link rel="stylesheet" href="{{asset('/css/persian-datepicker.min.css') }}">

    <link href="https://cdn.rawgit.com/rastikerdar/sahel-font/v1.0.0-alpha23/dist/font-face.css" rel="stylesheet"
          type="text/css"/>
    <script type="text/javascript" src="{{ asset('usr/js/modernizr.custom.86080.js') }}"></script>
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="{{ asset('usr/css/bootstrap-rtl.min.css') }}" media="screen">
    <!-- Fonts -->
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0d3a8c2455.js" crossorigin="anonymous"></script>
</head>
@yield('css')
<body id="page">
@include('sweet::alert')
@if(Session::has('fail'))
    <script type="text/javascript">
        swal({
            title:'Oops!',
            text:"{{Session::get('fail')}}",
            type:'error',
            timer:5000
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);
    </script>
@endif
@if(Session::has('success'))
    <script type="text/javascript">
        swal({
            title:'تبریک',
            text:"{{Session::get('success')}}",
            type:'success',
            timer:6000
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);
    </script>
@endif
<!-- Carousel 100% Fullscreen -->
<!-- Navigation -->
@if (\Request::is('/') )
    <style>
        .fixed-top {
            position: fixed;
        }

    </style>
    @else
    <style>
        .fixed-top {
            position: static;
        }
        .navbar-nav a {
            font-size: 0.8rem !important;
        }
    </style>
    @endif

<nav style="background-color:rgba(0, 0, 0, 0.75) !important" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a href="{{route('welcome')}}" class="navbar-brand">Brand</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form style="width:100%;" class="form" action="{{ route('images.search.index') }}" method="get">
    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav">
            @if (Route::has('login'))
                @if(auth()->check())
            <a href="{{ route('user.showInfo') }}" class="nav-item nav-link">تنظیمات</a>
            <a href="{{ route('upload.create') }}" class="nav-item nav-link">آپلود عکس</a>
            <a href="{{ route('welcomeaccount',['username'=>auth()->user()->user_name]) }}" class="nav-item nav-link">پروفایل</a>
                @endif
                    <a href="{{ route('explore') }}" class="nav-item nav-link">کاوش</a>
                    <a href="{{ route('contactus') }}" class="nav-item nav-link">تماس با ما</a>
                    <a href="{{ route('aboutus') }}" class="nav-item nav-link">درباره ما</a>
            <a href="{{ route('user.copyright.index') }}" class="nav-item nav-link">پیگیری حق نشر</a>
            @endif

        </div>
        <form class="form" action="{{ route('images.search.index') }}" method="get">
        <div @if(auth()->check()) class="col-md-1"
             @else
             class="col-md-2"
            @endif
        >
            <div class="input-group">
                <select name="category_id" class="browser-default custom-select">
                    <option disabled selected>دسته بندی</option>
                    @foreach(\App\Category::all() as $category)
                        <option class="" value="{{$category->id}}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
            <div class="col-md-1">
                <div class="form-groupp">
                    <input name="time_start" placeholder="از تاریخ" type="text" class="time-start form-control">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-groupp">
                    <input name="time_end" placeholder="تا تاریخ" type="text" class="time-end form-control">
                </div>
            </div>
        <div @if(auth()->check()) class="col-md-3"
        @else
        class="col-md-4"
             @endif
        >
            <div class="input-group">
                <input type="text" name="title" class="form-control" placeholder="جستجو">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>

        </form>
        @if (Route::has('login'))
            <div class="navbar-nav">
                @auth
                    <a  class="nav-item nav-link" href="{{ url(auth()->user()->user_name) }}">خانه</a>
                    <a  class="nav-item nav-link" href="{{ url('/logout') }}">خروج</a>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-link">ورود</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-item nav-link">ثبت نام</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
    </form>
</nav>
{{--<div style="margin-top: 10px;"></div>--}}
@include('errors')
@yield('body')

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
{{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"--}}
{{--        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"--}}
{{--        crossorigin="anonymous"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
<script src="{{ asset('js/jquery-3-4-1.js') }}"></script>
<script src="{{ asset('js/persian-date.min.js') }}"></script>
<script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/exif-js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/purify.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x (for popover and tooltips). You can also use the bootstrap js
   3.3.x versions without popper.min.js. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js"></script>
<!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/themes/fas/theme.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/locales/LANG.js"></script>--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        crossorigin="anonymous"></script>--}}
{{--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}
<script src="{{ asset('usr/js/bootstrap.min.js') }}"></script>
{{--for explore --}}
<script type='text/javascript' src='{{ asset('js/jquery.galereya.js') }}'></script>
<script type='text/javascript' src='{{ asset('js/js/jquery.justifiedGallery.min.js') }}'></script>

<link rel='stylesheet' href='{{ asset('css/jquery.galereya.css') }}' type='text/css'/>
<link rel='stylesheet' href='{{ asset('css/justifiedGallery.min.css') }}' type='text/css'/>
<!-- Site footer -->

</body>
@yield('js')
@if (\Request::is('account/photo/upload/*') )

<script>
    $(".imgAdd").click(function(){
        $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
    });
    $(document).on("click", "i.del" , function() {
        $(this).parent().remove();
    });
    $(function() {
        $(document).on("change",".uploadFile", function()
        {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                }
            }

        });
    });
    (function($) {

        var BinaryFile = function(strData, iDataOffset, iDataLength) {
            var data = strData;
            var dataOffset = iDataOffset || 0;
            var dataLength = 0;

            this.getRawData = function() {
                return data;
            };

            if (typeof strData == "string") {
                dataLength = iDataLength || data.length;

                this.getByteAt = function(iOffset) {
                    return data.charCodeAt(iOffset + dataOffset) & 0xFF;
                };
            } else if (typeof strData == "unknown") {
                dataLength = iDataLength || IEBinary_getLength(data);

                this.getByteAt = function(iOffset) {
                    return IEBinary_getByteAt(data, iOffset + dataOffset);
                };
            }

            this.getLength = function() {
                return dataLength;
            };

            this.getSByteAt = function(iOffset) {
                var iByte = this.getByteAt(iOffset);
                if (iByte > 127)
                    return iByte - 256;
                else
                    return iByte;
            };

            this.getShortAt = function(iOffset, bBigEndian) {
                var iShort = bBigEndian ?
                    (this.getByteAt(iOffset) << 8) + this.getByteAt(iOffset + 1) : (this.getByteAt(iOffset + 1) << 8) + this.getByteAt(iOffset);
                if (iShort < 0) iShort += 65536;
                return iShort;
            };
            this.getSShortAt = function(iOffset, bBigEndian) {
                var iUShort = this.getShortAt(iOffset, bBigEndian);
                if (iUShort > 32767)
                    return iUShort - 65536;
                else
                    return iUShort;
            };
            this.getLongAt = function(iOffset, bBigEndian) {
                var iByte1 = this.getByteAt(iOffset),
                    iByte2 = this.getByteAt(iOffset + 1),
                    iByte3 = this.getByteAt(iOffset + 2),
                    iByte4 = this.getByteAt(iOffset + 3);

                var iLong = bBigEndian ?
                    (((((iByte1 << 8) + iByte2) << 8) + iByte3) << 8) + iByte4 : (((((iByte4 << 8) + iByte3) << 8) + iByte2) << 8) + iByte1;
                if (iLong < 0) iLong += 4294967296;
                return iLong;
            };
            this.getSLongAt = function(iOffset, bBigEndian) {
                var iULong = this.getLongAt(iOffset, bBigEndian);
                if (iULong > 2147483647)
                    return iULong - 4294967296;
                else
                    return iULong;
            };
            this.getStringAt = function(iOffset, iLength) {
                var aStr = [];
                for (var i = iOffset, j = 0; i < iOffset + iLength; i++, j++) {
                    aStr[j] = String.fromCharCode(this.getByteAt(i));
                }
                return aStr.join("");
            };

            this.getCharAt = function(iOffset) {
                return String.fromCharCode(this.getByteAt(iOffset));
            };
            this.toBase64 = function() {
                return window.btoa(data);
            };
            this.fromBase64 = function(strBase64) {
                data = window.atob(strBase64);
            };
        };

        var BinaryAjax = (function() {

            function createRequest() {
                var oHTTP = null;
                if (window.XMLHttpRequest) {
                    oHTTP = new XMLHttpRequest();
                } else if (window.ActiveXObject) {
                    oHTTP = new ActiveXObject("Microsoft.XMLHTTP");
                }
                return oHTTP;
            }

            function getHead(strURL, fncCallback, fncError) {
                var oHTTP = createRequest();
                if (oHTTP) {
                    if (fncCallback) {
                        if (typeof(oHTTP.onload) != "undefined") {
                            oHTTP.onload = function() {
                                if (oHTTP.status == "200") {
                                    fncCallback(this);
                                } else {
                                    if (fncError) fncError();
                                }
                                oHTTP = null;
                            };
                        } else {
                            oHTTP.onreadystatechange = function() {
                                if (oHTTP.readyState == 4) {
                                    if (oHTTP.status == "200") {
                                        fncCallback(this);
                                    } else {
                                        if (fncError) fncError();
                                    }
                                    oHTTP = null;
                                }
                            };
                        }
                    }
                    oHTTP.open("HEAD", strURL, true);
                    oHTTP.send(null);
                } else {
                    if (fncError) fncError();
                }
            }

            function sendRequest(strURL, fncCallback, fncError, aRange, bAcceptRanges, iFileSize) {
                var oHTTP = createRequest();
                if (oHTTP) {

                    var iDataOffset = 0;
                    if (aRange && !bAcceptRanges) {
                        iDataOffset = aRange[0];
                    }
                    var iDataLen = 0;
                    if (aRange) {
                        iDataLen = aRange[1] - aRange[0] + 1;
                    }

                    if (fncCallback) {
                        if (typeof(oHTTP.onload) != "undefined") {
                            oHTTP.onload = function() {

                                if (oHTTP.status == "200" || oHTTP.status == "206" || oHTTP.status == "0") {
                                    this.binaryResponse = new BinaryFile(this.responseText, iDataOffset, iDataLen);
                                    this.fileSize = iFileSize || this.getResponseHeader("Content-Length");
                                    fncCallback(this);
                                } else {
                                    if (fncError) fncError();
                                }
                                oHTTP = null;
                            };
                        } else {
                            oHTTP.onreadystatechange = function() {
                                if (oHTTP.readyState == 4) {
                                    if (oHTTP.status == "200" || oHTTP.status == "206" || oHTTP.status == "0") {
                                        this.binaryResponse = new BinaryFile(oHTTP.responseBody, iDataOffset, iDataLen);
                                        this.fileSize = iFileSize || this.getResponseHeader("Content-Length");
                                        fncCallback(this);
                                    } else {
                                        if (fncError) fncError();
                                    }
                                    oHTTP = null;
                                }
                            };
                        }
                    }
                    oHTTP.open("GET", strURL, true);

                    if (oHTTP.overrideMimeType) oHTTP.overrideMimeType('text/plain; charset=x-user-defined');

                    if (aRange && bAcceptRanges) {
                        oHTTP.setRequestHeader("Range", "bytes=" + aRange[0] + "-" + aRange[1]);
                    }

                    oHTTP.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 1970 00:00:00 GMT");

                    oHTTP.send(null);
                } else {
                    if (fncError) fncError();
                }
            }

            return function(strURL, fncCallback, fncError, aRange) {

                if (aRange) {
                    getHead(
                        strURL,
                        function(oHTTP) {
                            var iLength = parseInt(oHTTP.getResponseHeader("Content-Length"), 10);
                            var strAcceptRanges = oHTTP.getResponseHeader("Accept-Ranges");

                            var iStart, iEnd;
                            iStart = aRange[0];
                            if (aRange[0] < 0)
                                iStart += iLength;
                            iEnd = iStart + aRange[1] - 1;

                            sendRequest(strURL, fncCallback, fncError, [iStart, iEnd], (strAcceptRanges == "bytes"), iLength);
                        }
                    );

                } else {
                    sendRequest(strURL, fncCallback, fncError);
                }
            };

        }());

        var EXIF = {};

        (function() {

            var bDebug = false;

            EXIF.Tags = {

                // version tags
                0x9000: "ExifVersion", // EXIF version
                0xA000: "FlashpixVersion", // Flashpix format version

                // colorspace tags
                0xA001: "ColorSpace", // Color space information tag

                // image configuration
                0xA002: "PixelXDimension", // Valid width of meaningful image
                0xA003: "PixelYDimension", // Valid height of meaningful image
                0x9101: "ComponentsConfiguration", // Information about channels
                0x9102: "CompressedBitsPerPixel", // Compressed bits per pixel

                // user information
                0x927C: "MakerNote", // Any desired information written by the manufacturer
                0x9286: "UserComment", // Comments by user

                // related file
                0xA004: "RelatedSoundFile", // Name of related sound file

                // date and time
                0x9003: "DateTimeOriginal", // Date and time when the original image was generated
                0x9004: "DateTimeDigitized", // Date and time when the image was stored digitally
                0x9290: "SubsecTime", // Fractions of seconds for DateTime
                0x9291: "SubsecTimeOriginal", // Fractions of seconds for DateTimeOriginal
                0x9292: "SubsecTimeDigitized", // Fractions of seconds for DateTimeDigitized

                // picture-taking conditions
                0x829A: "ExposureTime", // Exposure time (in seconds)
                0x829D: "FNumber", // F number
                0x8822: "ExposureProgram", // Exposure program
                0x8824: "SpectralSensitivity", // Spectral sensitivity
                0x8827: "ISOSpeedRatings", // ISO speed rating
                0x8828: "OECF", // Optoelectric conversion factor
                0x9201: "ShutterSpeedValue", // Shutter speed
                0x9202: "ApertureValue", // Lens aperture
                0x9203: "BrightnessValue", // Value of brightness
                0x9204: "ExposureBias", // Exposure bias
                0x9205: "MaxApertureValue", // Smallest F number of lens
                0x9206: "SubjectDistance", // Distance to subject in meters
                0x9207: "MeteringMode", // Metering mode
                0x9208: "LightSource", // Kind of light source
                0x9209: "Flash", // Flash status
                0x9214: "SubjectArea", // Location and area of main subject
                0x920A: "FocalLength", // Focal length of the lens in mm
                0xA20B: "FlashEnergy", // Strobe energy in BCPS
                0xA20C: "SpatialFrequencyResponse", //
                0xA20E: "FocalPlaneXResolution", // Number of pixels in width direction per FocalPlaneResolutionUnit
                0xA20F: "FocalPlaneYResolution", // Number of pixels in height direction per FocalPlaneResolutionUnit
                0xA210: "FocalPlaneResolutionUnit", // Unit for measuring FocalPlaneXResolution and FocalPlaneYResolution
                0xA214: "SubjectLocation", // Location of subject in image
                0xA215: "ExposureIndex", // Exposure index selected on camera
                0xA217: "SensingMethod", // Image sensor type
                0xA300: "FileSource", // Image source (3 == DSC)
                0xA301: "SceneType", // Scene type (1 == directly photographed)
                0xA302: "CFAPattern", // Color filter array geometric pattern
                0xA401: "CustomRendered", // Special processing
                0xA402: "ExposureMode", // Exposure mode
                0xA403: "WhiteBalance", // 1 = auto white balance, 2 = manual
                0xA404: "DigitalZoomRation", // Digital zoom ratio
                0xA405: "FocalLengthIn35mmFilm", // Equivalent foacl length assuming 35mm film camera (in mm)
                0xA406: "SceneCaptureType", // Type of scene
                0xA407: "GainControl", // Degree of overall image gain adjustment
                0xA408: "Contrast", // Direction of contrast processing applied by camera
                0xA409: "Saturation", // Direction of saturation processing applied by camera
                0xA40A: "Sharpness", // Direction of sharpness processing applied by camera
                0xA40B: "DeviceSettingDescription", //
                0xA40C: "SubjectDistanceRange", // Distance to subject

                // other tags
                0xA005: "InteroperabilityIFDPointer",
                0xA420: "ImageUniqueID" // Identifier assigned uniquely to each image
            };

            EXIF.TiffTags = {
                0x0100: "ImageWidth",
                0x0101: "ImageHeight",
                0x8769: "ExifIFDPointer",
                0x8825: "GPSInfoIFDPointer",
                0xA005: "InteroperabilityIFDPointer",
                0x0102: "BitsPerSample",
                0x0103: "Compression",
                0x0106: "PhotometricInterpretation",
                0x0112: "Orientation",
                0x0115: "SamplesPerPixel",
                0x011C: "PlanarConfiguration",
                0x0212: "YCbCrSubSampling",
                0x0213: "YCbCrPositioning",
                0x011A: "XResolution",
                0x011B: "YResolution",
                0x0128: "ResolutionUnit",
                0x0111: "StripOffsets",
                0x0116: "RowsPerStrip",
                0x0117: "StripByteCounts",
                0x0201: "JPEGInterchangeFormat",
                0x0202: "JPEGInterchangeFormatLength",
                0x012D: "TransferFunction",
                0x013E: "WhitePoint",
                0x013F: "PrimaryChromaticities",
                0x0211: "YCbCrCoefficients",
                0x0214: "ReferenceBlackWhite",
                0x0132: "DateTime",
                0x010E: "ImageDescription",
                0x010F: "Make",
                0x0110: "Model",
                0x0131: "Software",
                0x013B: "Artist",
                0x8298: "Copyright"
            };

            EXIF.GPSTags = {
                0x0000: "GPSVersionID",
                0x0001: "GPSLatitudeRef",
                0x0002: "GPSLatitude",
                0x0003: "GPSLongitudeRef",
                0x0004: "GPSLongitude",
                0x0005: "GPSAltitudeRef",
                0x0006: "GPSAltitude",
                0x0007: "GPSTimeStamp",
                0x0008: "GPSSatellites",
                0x0009: "GPSStatus",
                0x000A: "GPSMeasureMode",
                0x000B: "GPSDOP",
                0x000C: "GPSSpeedRef",
                0x000D: "GPSSpeed",
                0x000E: "GPSTrackRef",
                0x000F: "GPSTrack",
                0x0010: "GPSImgDirectionRef",
                0x0011: "GPSImgDirection",
                0x0012: "GPSMapDatum",
                0x0013: "GPSDestLatitudeRef",
                0x0014: "GPSDestLatitude",
                0x0015: "GPSDestLongitudeRef",
                0x0016: "GPSDestLongitude",
                0x0017: "GPSDestBearingRef",
                0x0018: "GPSDestBearing",
                0x0019: "GPSDestDistanceRef",
                0x001A: "GPSDestDistance",
                0x001B: "GPSProcessingMethod",
                0x001C: "GPSAreaInformation",
                0x001D: "GPSDateStamp",
                0x001E: "GPSDifferential"
            };

            EXIF.StringValues = {
                ExposureProgram: {
                    0: "Not defined",
                    1: "Manual",
                    2: "Normal program",
                    3: "Aperture priority",
                    4: "Shutter priority",
                    5: "Creative program",
                    6: "Action program",
                    7: "Portrait mode",
                    8: "Landscape mode"
                },
                MeteringMode: {
                    0: "Unknown",
                    1: "Average",
                    2: "CenterWeightedAverage",
                    3: "Spot",
                    4: "MultiSpot",
                    5: "Pattern",
                    6: "Partial",
                    255: "Other"
                },
                LightSource: {
                    0: "Unknown",
                    1: "Daylight",
                    2: "Fluorescent",
                    3: "Tungsten (incandescent light)",
                    4: "Flash",
                    9: "Fine weather",
                    10: "Cloudy weather",
                    11: "Shade",
                    12: "Daylight fluorescent (D 5700 - 7100K)",
                    13: "Day white fluorescent (N 4600 - 5400K)",
                    14: "Cool white fluorescent (W 3900 - 4500K)",
                    15: "White fluorescent (WW 3200 - 3700K)",
                    17: "Standard light A",
                    18: "Standard light B",
                    19: "Standard light C",
                    20: "D55",
                    21: "D65",
                    22: "D75",
                    23: "D50",
                    24: "ISO studio tungsten",
                    255: "Other"
                },
                Flash: {
                    0x0000: "Flash did not fire",
                    0x0001: "Flash fired",
                    0x0005: "Strobe return light not detected",
                    0x0007: "Strobe return light detected",
                    0x0009: "Flash fired, compulsory flash mode",
                    0x000D: "Flash fired, compulsory flash mode, return light not detected",
                    0x000F: "Flash fired, compulsory flash mode, return light detected",
                    0x0010: "Flash did not fire, compulsory flash mode",
                    0x0018: "Flash did not fire, auto mode",
                    0x0019: "Flash fired, auto mode",
                    0x001D: "Flash fired, auto mode, return light not detected",
                    0x001F: "Flash fired, auto mode, return light detected",
                    0x0020: "No flash function",
                    0x0041: "Flash fired, red-eye reduction mode",
                    0x0045: "Flash fired, red-eye reduction mode, return light not detected",
                    0x0047: "Flash fired, red-eye reduction mode, return light detected",
                    0x0049: "Flash fired, compulsory flash mode, red-eye reduction mode",
                    0x004D: "Flash fired, compulsory flash mode, red-eye reduction mode, return light not detected",
                    0x004F: "Flash fired, compulsory flash mode, red-eye reduction mode, return light detected",
                    0x0059: "Flash fired, auto mode, red-eye reduction mode",
                    0x005D: "Flash fired, auto mode, return light not detected, red-eye reduction mode",
                    0x005F: "Flash fired, auto mode, return light detected, red-eye reduction mode"
                },
                SensingMethod: {
                    1: "Not defined",
                    2: "One-chip color area sensor",
                    3: "Two-chip color area sensor",
                    4: "Three-chip color area sensor",
                    5: "Color sequential area sensor",
                    7: "Trilinear sensor",
                    8: "Color sequential linear sensor"
                },
                SceneCaptureType: {
                    0: "Standard",
                    1: "Landscape",
                    2: "Portrait",
                    3: "Night scene"
                },
                SceneType: {
                    1: "Directly photographed"
                },
                CustomRendered: {
                    0: "Normal process",
                    1: "Custom process"
                },
                WhiteBalance: {
                    0: "Auto white balance",
                    1: "Manual white balance"
                },
                GainControl: {
                    0: "None",
                    1: "Low gain up",
                    2: "High gain up",
                    3: "Low gain down",
                    4: "High gain down"
                },
                Contrast: {
                    0: "Normal",
                    1: "Soft",
                    2: "Hard"
                },
                Saturation: {
                    0: "Normal",
                    1: "Low saturation",
                    2: "High saturation"
                },
                Sharpness: {
                    0: "Normal",
                    1: "Soft",
                    2: "Hard"
                },
                SubjectDistanceRange: {
                    0: "Unknown",
                    1: "Macro",
                    2: "Close view",
                    3: "Distant view"
                },
                FileSource: {
                    3: "DSC"
                },

                Components: {
                    0: "",
                    1: "Y",
                    2: "Cb",
                    3: "Cr",
                    4: "R",
                    5: "G",
                    6: "B"
                }
            };

            function addEvent(oElement, strEvent, fncHandler) {
                if (oElement.addEventListener) {
                    oElement.addEventListener(strEvent, fncHandler, false);
                } else if (oElement.attachEvent) {
                    oElement.attachEvent("on" + strEvent, fncHandler);
                }
            }

            function imageHasData(oImg) {
                return !!(oImg.exifdata);
            }

            function getImageData(oImg, fncCallback) {
                BinaryAjax(
                    oImg.src,
                    function(oHTTP) {
                        var oEXIF = findEXIFinJPEG(oHTTP.binaryResponse);
                        oImg.exifdata = oEXIF || {};
                        if (fncCallback) fncCallback();
                    }
                );
            }

            function findEXIFinJPEG(oFile) {
                var aMarkers = [];

                if (oFile.getByteAt(0) != 0xFF || oFile.getByteAt(1) != 0xD8) {
                    return false; // not a valid jpeg
                }

                var iOffset = 2;
                var iLength = oFile.getLength();
                while (iOffset < iLength) {
                    if (oFile.getByteAt(iOffset) != 0xFF) {
                        if (bDebug) console.log("Not a valid marker at offset " + iOffset + ", found: " + oFile.getByteAt(iOffset));
                        return false; // not a valid marker, something is wrong
                    }

                    var iMarker = oFile.getByteAt(iOffset + 1);

                    // we could implement handling for other markers here,
                    // but we're only looking for 0xFFE1 for EXIF data

                    if (iMarker == 22400) {
                        if (bDebug) console.log("Found 0xFFE1 marker");
                        return readEXIFData(oFile, iOffset + 4, oFile.getShortAt(iOffset + 2, true) - 2);
                        // iOffset += 2 + oFile.getShortAt(iOffset+2, true);
                        // WTF?

                    } else if (iMarker == 225) {
                        // 0xE1 = Application-specific 1 (for EXIF)
                        if (bDebug) console.log("Found 0xFFE1 marker");
                        return readEXIFData(oFile, iOffset + 4, oFile.getShortAt(iOffset + 2, true) - 2);

                    } else {
                        iOffset += 2 + oFile.getShortAt(iOffset + 2, true);
                    }

                }

            }

            function readTags(oFile, iTIFFStart, iDirStart, oStrings, bBigEnd) {
                var iEntries = oFile.getShortAt(iDirStart, bBigEnd);
                var oTags = {};
                for (var i = 0; i < iEntries; i++) {
                    var iEntryOffset = iDirStart + i * 12 + 2;
                    var strTag = oStrings[oFile.getShortAt(iEntryOffset, bBigEnd)];
                    if (!strTag && bDebug) console.log("Unknown tag: " + oFile.getShortAt(iEntryOffset, bBigEnd));
                    oTags[strTag] = readTagValue(oFile, iEntryOffset, iTIFFStart, iDirStart, bBigEnd);
                }
                return oTags;
            }

            function readTagValue(oFile, iEntryOffset, iTIFFStart, iDirStart, bBigEnd) {
                var iType = oFile.getShortAt(iEntryOffset + 2, bBigEnd);
                var iNumValues = oFile.getLongAt(iEntryOffset + 4, bBigEnd);
                var iValueOffset = oFile.getLongAt(iEntryOffset + 8, bBigEnd) + iTIFFStart;

                switch (iType) {
                    case 1: // byte, 8-bit unsigned int
                    case 7: // undefined, 8-bit byte, value depending on field
                        if (iNumValues == 1) {
                            return oFile.getByteAt(iEntryOffset + 8, bBigEnd);
                        } else {
                            var iValOffset = iNumValues > 4 ? iValueOffset : (iEntryOffset + 8);
                            var aVals = [];
                            for (var n = 0; n < iNumValues; n++) {
                                aVals[n] = oFile.getByteAt(iValOffset + n);
                            }
                            return aVals;
                        }
                        break;

                    case 2: // ascii, 8-bit byte
                        var iStringOffset = iNumValues > 4 ? iValueOffset : (iEntryOffset + 8);
                        return oFile.getStringAt(iStringOffset, iNumValues - 1);
                    // break;

                    case 3: // short, 16 bit int
                        if (iNumValues == 1) {
                            return oFile.getShortAt(iEntryOffset + 8, bBigEnd);
                        } else {
                            var iValOffset = iNumValues > 2 ? iValueOffset : (iEntryOffset + 8);
                            var aVals = [];
                            for (var n = 0; n < iNumValues; n++) {
                                aVals[n] = oFile.getShortAt(iValOffset + 2 * n, bBigEnd);
                            }
                            return aVals;
                        }
                    // break;

                    case 4: // long, 32 bit int
                        if (iNumValues == 1) {
                            return oFile.getLongAt(iEntryOffset + 8, bBigEnd);
                        } else {
                            var aVals = [];
                            for (var n = 0; n < iNumValues; n++) {
                                aVals[n] = oFile.getLongAt(iValueOffset + 4 * n, bBigEnd);
                            }
                            return aVals;
                        }
                        break;
                    case 5: // rational = two long values, first is numerator, second is denominator
                        if (iNumValues == 1) {
                            return oFile.getLongAt(iValueOffset, bBigEnd) / oFile.getLongAt(iValueOffset + 4, bBigEnd);
                        } else {
                            var aVals = [];
                            for (var n = 0; n < iNumValues; n++) {
                                aVals[n] = oFile.getLongAt(iValueOffset + 8 * n, bBigEnd) / oFile.getLongAt(iValueOffset + 4 + 8 * n, bBigEnd);
                            }
                            return aVals;
                        }
                        break;
                    case 9: // slong, 32 bit signed int
                        if (iNumValues == 1) {
                            return oFile.getSLongAt(iEntryOffset + 8, bBigEnd);
                        } else {
                            var aVals = [];
                            for (var n = 0; n < iNumValues; n++) {
                                aVals[n] = oFile.getSLongAt(iValueOffset + 4 * n, bBigEnd);
                            }
                            return aVals;
                        }
                        break;
                    case 10: // signed rational, two slongs, first is numerator, second is denominator
                        if (iNumValues == 1) {
                            return oFile.getSLongAt(iValueOffset, bBigEnd) / oFile.getSLongAt(iValueOffset + 4, bBigEnd);
                        } else {
                            var aVals = [];
                            for (var n = 0; n < iNumValues; n++) {
                                aVals[n] = oFile.getSLongAt(iValueOffset + 8 * n, bBigEnd) / oFile.getSLongAt(iValueOffset + 4 + 8 * n, bBigEnd);
                            }
                            return aVals;
                        }
                        break;
                }
            }

            function readEXIFData(oFile, iStart, iLength) {
                if (oFile.getStringAt(iStart, 4) != "Exif") {
                    if (bDebug) console.log("Not valid EXIF data! " + oFile.getStringAt(iStart, 4));
                    return false;
                }

                var bBigEnd;

                var iTIFFOffset = iStart + 6;

                // test for TIFF validity and endianness
                if (oFile.getShortAt(iTIFFOffset) == 0x4949) {
                    bBigEnd = false;
                } else if (oFile.getShortAt(iTIFFOffset) == 0x4D4D) {
                    bBigEnd = true;
                } else {
                    if (bDebug) console.log("Not valid TIFF data! (no 0x4949 or 0x4D4D)");
                    return false;
                }

                if (oFile.getShortAt(iTIFFOffset + 2, bBigEnd) != 0x002A) {
                    if (bDebug) console.log("Not valid TIFF data! (no 0x002A)");
                    return false;
                }

                if (oFile.getLongAt(iTIFFOffset + 4, bBigEnd) != 0x00000008) {
                    if (bDebug) console.log("Not valid TIFF data! (First offset not 8)", oFile.getShortAt(iTIFFOffset + 4, bBigEnd));
                    return false;
                }

                var oTags = readTags(oFile, iTIFFOffset, iTIFFOffset + 8, EXIF.TiffTags, bBigEnd);

                if (oTags.ExifIFDPointer) {
                    var oEXIFTags = readTags(oFile, iTIFFOffset, iTIFFOffset + oTags.ExifIFDPointer, EXIF.Tags, bBigEnd);
                    for (var strTag in oEXIFTags) {
                        switch (strTag) {
                            case "LightSource":
                            case "Flash":
                            case "MeteringMode":
                            case "ExposureProgram":
                            case "SensingMethod":
                            case "SceneCaptureType":
                            case "SceneType":
                            case "CustomRendered":
                            case "WhiteBalance":
                            case "GainControl":
                            case "Contrast":
                            case "Saturation":
                            case "Sharpness":
                            case "SubjectDistanceRange":
                            case "FileSource":
                                oEXIFTags[strTag] = EXIF.StringValues[strTag][oEXIFTags[strTag]];
                                break;

                            case "ExifVersion":
                            case "FlashpixVersion":
                                oEXIFTags[strTag] = String.fromCharCode(oEXIFTags[strTag][0], oEXIFTags[strTag][1], oEXIFTags[strTag][2], oEXIFTags[strTag][3]);
                                break;

                            case "ComponentsConfiguration":
                                oEXIFTags[strTag] =
                                    EXIF.StringValues.Components[oEXIFTags[strTag][0]] + EXIF.StringValues.Components[oEXIFTags[strTag][1]] + EXIF.StringValues.Components[oEXIFTags[strTag][2]] + EXIF.StringValues.Components[oEXIFTags[strTag][3]];
                                break;
                        }
                        oTags[strTag] = oEXIFTags[strTag];
                    }
                }

                if (oTags.GPSInfoIFDPointer) {
                    var oGPSTags = readTags(oFile, iTIFFOffset, iTIFFOffset + oTags.GPSInfoIFDPointer, EXIF.GPSTags, bBigEnd);
                    for (var strTag in oGPSTags) {
                        switch (strTag) {
                            case "GPSVersionID":
                                oGPSTags[strTag] = oGPSTags[strTag][0] + "." + oGPSTags[strTag][1] + "." + oGPSTags[strTag][2] + "." + oGPSTags[strTag][3];
                                break;
                        }
                        oTags[strTag] = oGPSTags[strTag];
                    }
                }

                return oTags;
            }

            EXIF.getData = function(oImg, fncCallback) {
                if (!oImg.complete) return false;
                if (!imageHasData(oImg)) {
                    getImageData(oImg, fncCallback);
                } else {
                    if (fncCallback) fncCallback();
                }
                return true;
            };

            EXIF.getTag = function(oImg, strTag) {
                if (!imageHasData(oImg)) return;
                return oImg.exifdata[strTag];
            };

            EXIF.getAllTags = function(oImg) {
                if (!imageHasData(oImg)) return {};
                var oData = oImg.exifdata;
                var oAllTags = {};
                for (var a in oData) {
                    if (oData.hasOwnProperty(a)) {
                        oAllTags[a] = oData[a];
                    }
                }
                return oAllTags;
            };

            EXIF.pretty = function(oImg) {
                if (!imageHasData(oImg)) return "";
                var oData = oImg.exifdata;
                var strPretty = "";
                for (var a in oData) {
                    if (oData.hasOwnProperty(a)) {
                        if (typeof oData[a] == "object") {
                            strPretty += a + " : [" + oData[a].length + " values]\r\n";
                        } else {
                            strPretty += a + " : " + oData[a] + "\r\n";
                        }
                    }
                }
                return strPretty;
            };

            EXIF.readFromBinaryFile = function(oFile) {
                return findEXIFinJPEG(oFile);
            };

            // function loadAllImages()
            // {
            //     var aImages = document.getElementsByTagName("img");
            //     var callb = function() {
            //         EXIF.getData(this);
            //     };
            //     for (var i=0;i<aImages.length;i++) {
            //         if (aImages[i].getAttribute("exif") == "true") {
            //             if (!aImages[i].complete) {
            //                 addEvent(aImages[i], "load", callb);
            //             } else {
            //                 EXIF.getData(aImages[i]);
            //             }
            //         }
            //     }
            // }

            // automatically load exif data for all images with exif=true when doc is ready
            // $(document).ready(loadAllImages);

            // load data for images manually
            $.fn.exifLoad = function(fncCallback) {
                return this.each(function() {
                    EXIF.getData(this, fncCallback);
                });
            };

            $.fn.exif = function(strTag) {
                var aStrings = [];
                this.each(function() {
                    aStrings.push(EXIF.getTag(this, strTag));
                });
                return aStrings;
            };

            $.fn.exifAll = function() {
                var aStrings = [];
                this.each(function() {
                    aStrings.push(EXIF.getAllTags(this));
                });
                return aStrings;
            };

            $.fn.exifPretty = function() {
                var aStrings = [];
                this.each(function() {
                    aStrings.push(EXIF.pretty(this));
                });
                return aStrings;
            };

            var getFilePart = function(file) {
                if (file.slice) {
                    filePart = file.slice(0, 131072);
                } else if (file.webkitSlice) {
                    filePart = file.webkitSlice(0, 131072);
                } else if (file.mozSlice) {
                    filePart = file.mozSlice(0, 131072);
                } else {
                    filePart = file;
                }

                return filePart;
            };

            $.fn.fileExif = function(callback) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var content = event.target.result;

                    var binaryResponse = new BinaryFile(content);

                    callback(EXIF.readFromBinaryFile(binaryResponse));
                };

                reader.readAsBinaryString(getFilePart(this[0].files[0]));
            };

            $.fileExif = function(file, callback) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var content = event.target.result;

                    var binaryResponse = new BinaryFile(content);

                    callback(EXIF.readFromBinaryFile(binaryResponse));
                };

                reader.readAsBinaryString(getFilePart(file));
            };

        })();

    })(jQuery);

    $(function() {
        var someCallback = function(exifObject) {
            console.log(exifObject)
            if(exifObject.GPSLongitude){
                var location= exifObject.GPSLongitude[2]+'/'+ exifObject.GPSLatitude[2];
            }else{
                var location= '_';
            }
            $('#cameraModel').val(exifObject.Model);
            $('#cameraMake').val(exifObject.Make);
            $('#Location').val(location);
            $('#DateTime').val(exifObject.DateTime);
            $('#aperture').val('f/'+exifObject.FNumber);
            $('#exposureTime').val(exifObject.ExposureTime + ' seg.');
            $('#version').val(exifObject.ExifVersion);
            $('#flash').val(exifObject.Flash);
            $('#focalDistance').val(exifObject.FocalLength + 'mm');
            $('#ISO').val(exifObject.ISOSpeedRatings);
            // Uncomment the line below to examine the
            // EXIF object in console to read other values
            //console.log(exifObject);
        }
        try {
            $('#images').change(function() {
                $('#exif').removeAttr('hidden');
                $(this).fileExif(someCallback);
            });
        } catch (e) {
            alert(e);
        }
    })
</script>
@endif
<script type="text/javascript">

    $(document).ready(function () {
        $(".birthday").pDatepicker(
            {
                initialValue: false,
                format: 'YYYY,MM,DD',
                'persian': {
                    'locale': 'fa',
                    'showHint': false,
                    'leapYearMode': 'algorithmic' // "astronomical"
                },
                'autoClose': true,
            }
        );
        $(".time-start").pDatepicker(
            {
                initialValue: false,
                format: 'YYYY,MM,DD',
                'persian': {
                    'locale': 'fa',
                    'showHint': false,
                    'leapYearMode': 'algorithmic' // "astronomical"
                },
                'autoClose': true,
            }
        );
        $(".time-end").pDatepicker(
            {
                initialValue: false,
                format: 'YYYY,MM,DD',
                'persian': {
                    'locale': 'fa',
                    'showHint': false,
                    'leapYearMode': 'algorithmic' // "astronomical"
                },
                'autoClose': true,
            }
        );
    });

</script>
</html>

