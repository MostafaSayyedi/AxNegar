<div id="topp"></div>
<!-- footer -->
<style>
    .nav-item nav-link{
        font-size: 0.9rem!important;
    }
    #topp{
        height: 100px;
    }
    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        #topp{
            height: 220px;
        }
    }
    #footer{
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        background-color: #2c292f;
        z-index: 99;
    }
</style>
<footer  style="background-color: #2c292f" id="footer">
    <div class="container">
        <div class="row ">
            <div class=" col-md-2 text-center text-md-left ">
                <div class="py-2">
                    <div style="margin-top: 8px" class=" text-white"><a href="{{ route('contactus') }}"><span style="font-size: .8rem" class="mx-2 irsans text-gray ">تماس با ما</span></a></div>
                </div>
            </div>
            <div class=" col-md-1 text-center text-md-left ">
                <div class="py-2">
                    <div style="margin-top: 8px" class="text-white"><a href="{{ route('aboutus') }}"><span style="font-size: .8rem" class="mx-2 irsans text-gray ">در باره ما</span></a></div>
                </div>
            </div>
            <div class=" col-md-4 text-white text-center text-md-left ">
                <div class="py-2 ">
{{--                    <div>--}}
                        <p style="font-size: .8rem;margin-top: 8px" class="text-gray text-white desc"> <i class="fa fa-map-marker mx-2 "></i>
                            لورم ایپسوم...لورم ایپسوم...لورم ایپسوم...لورم ایپسوم...
                            لورم ایپسوم...لورم ایپسوم...لورم ایپسوم...لورم ایپسوم...لورم ایپسوم...
                            لورم ایپسوم...لورم ایپسوم...لورم ایپسوم...</p>
{{--                    </div>--}}
                </div>
            </div>
            <div class="  col-md-4 text-white text-center text-md-left ">
              <div class="py-2 center">
                    <a href="#"><i class="fab fa-instagram fa-2x text-primary mx-3"></i></a>
                    <a href="#"><i class="fab fa-facebook fa-2x text-primary mx-3"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-2x text-info mx-3"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-2x text-danger mx-3"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>


