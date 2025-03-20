<template>
    <vue-marquee-slider id="marquee-slider-text" 
    :space="10" 
    :speed="12000" 
    :width="550">
        <span>Бегущая по своим делам строка</span>
        <span>Бегущая по своим делам строка</span>
        <span>Бегущая по своим делам строка</span>
    </vue-marquee-slider>
</template>

<script setup>
import { VueMarqueeSlider } from 'vue3-marquee-slider';
import '/node_modules/vue3-marquee-slider/dist/style.css'
</script>
