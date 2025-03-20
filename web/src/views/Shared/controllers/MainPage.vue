<template>
    <HeaderMain />
    <VideoMain />
    <ProductRecomendations />
    <SliderMain />
    <FooterMain />
  </template>
  
  <script>
  import HeaderMain from './HeaderMain.vue';
  import VideoMain from './VideoMain.vue';
  import ProductRecomendations from '../../Product/controllers/ProductRecommendations.vue';
  import SliderMain from './SliderMain.vue';
  import MarqueeMain from './MarqueeMain.vue';
  import FooterMain from './FooterMain.vue';
  import { useProductRecomendationStore } from '../../../stores/productRecomendation.js';
  import { onMounted } from 'vue';
  
  export default {
    components: {
      HeaderMain,
      VideoMain,
      ProductRecomendations,
      SliderMain,
      MarqueeMain,
      FooterMain
    },
    setup() {
      const productRecomendationStore = useProductRecomendationStore();
  
      // Загружаем рекомендуемые продукты при монтировании компонента
      onMounted(() => {
        productRecomendationStore.fetchRecommendedProducts();
      });
  
      return {};
    }
  }
  </script>