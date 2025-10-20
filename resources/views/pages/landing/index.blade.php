<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
new
#[Layout('layouts.landing')]
class extends Component {};
?>
<div>
    <section class="slider slider-layout2">
        <div class="slick-carousel carousel-dots-light m-slides-0"
            data-slick='{"slidesToShow": 1,"autoplay": true, "arrows": true, "dots": true, "speed": 700,"fade": true,"cssEase": "linear"}'
        >
            <div class="slide-item bg-overlay align-v-h">
                <div class="bg-img"><img src="landing/assets/images/sliders/5.jpg" alt="slide img"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-xl-7">
                            <div class="slide-content">
                                <h2 class="slide-title">Helping All Types Of Industries And Facilities Sector
                                </h2>
                                <p class="slide-desc">We have already made huge strides in our sustainability
                                    journey by investing in
                                    plastic recycling and energy from waste infrastructure low carbon
                                    collections, leading to reduction
                                    in nation carbon emissions.</p>
                                <div class="d-flex align-items-center flex-wrap">
                                    <a class="btn btn-white-style2 btn-xl btn-xhight mr-30" href="services.html">
                                        <span>Explore Our Services</span>
                                        <i class="icon-arrow-right-up"></i>
                                    </a>
                                    <a class="btn btn-white btn-outlined btn-xhight" href="about-us.html">
                                        <span>More About Us</span>
                                    </a>
                                </div>
                            </div><!-- /.slide-content -->
                        </div><!-- /.col-xl-7 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.slide-item -->
            <div class="slide-item bg-overlay align-v-h">
                <div class="bg-img"><img src="landing/assets/images/sliders/6.jpg" alt="slide img"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-xl-7">
                            <div class="slide-content">
                                <h2 class="slide-title">A Wide Range Of Services For Home And All Business!</h2>
                                <p class="slide-desc">We have already made huge strides in our sustainability
                                    journey by investing in
                                    plastic recycling and energy from waste infrastructure low carbon
                                    collections, leading to reduction
                                    in nation carbon emissions.</p>
                                <div class="d-flex align-items-center flex-wrap">
                                    <a class="btn btn-white-style2 btn-xl btn-xhight mr-30" href="services.html">
                                        <span>Explore Our Services</span>
                                        <i class="icon-arrow-right-up"></i>
                                    </a>
                                    <a class="btn btn-white btn-outlined btn-xhight" href="about-us.html">
                                        <span>More About Us</span>
                                    </a>
                                </div>
                            </div><!-- /.slide-content -->
                        </div><!-- /.col-xl-7 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.slide-item -->
        </div><!-- /.carousel -->
    </section><!-- /.slider -->
</div>
