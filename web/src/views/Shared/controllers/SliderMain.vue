<template>
  <swiper 
  :modules="modules" 
  :slides-per-view="1" 
  :space-between="50"
  :autoplay="{pauseOnMouseEnter: true}"
  loop
  parallax
  :speed="2000"
  navigation 
  :pagination="{ clickable: true }"
  :scrollbar="{ draggable: true }" 
  @swiper="onSwiper" 
  @slideChange="onSlideChange">

      <swiper-slide class="swiper-slide">
        <div class="title" data-swiper-parallax="-3000" data-swiper-parallax-duration="4000">
          <h1>QUALITY</h1>
        </div>
        <img src="../pic/vorotnik.jpg" alt="">
      </swiper-slide>

      <swiper-slide class="swiper-slide">
        <div class="title" data-swiper-parallax="-3000" data-swiper-parallax-duration="4000">
          <h1>TRUST</h1>
        </div>
        <img src="../pic/shov.jpg" alt="">
      </swiper-slide>

      <swiper-slide class="swiper-slide">
        <div class="title" data-swiper-parallax="-3000" data-swiper-parallax-duration="4000">
          <h1>MODERN</h1>
        </div>
        <img src="../pic/vorotniksbirkoy.jpg" alt="">
      </swiper-slide>


    ...
  </swiper>
</template>
<script>
// import Swiper core and required modules
import { Navigation, Pagination, Autoplay, Parallax, A11y } from 'swiper/modules';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css/bundle';
import 'swiper/css/autoplay'
import 'swiper/css/parallax'

// Import Swiper styles
export default {
  components: {
    Swiper,
    SwiperSlide,
  },
  setup() {
    const onSwiper = (swiper) => {
      console.log(swiper);
    };
    const onSlideChange = () => {
      console.log('slide change');
    };
    return {
      onSwiper,
      onSlideChange,
      modules: [Navigation, Pagination, Autoplay, Parallax, A11y],
    };
  },
};
</script>