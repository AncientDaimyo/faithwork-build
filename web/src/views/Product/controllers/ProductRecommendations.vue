<template>
  <div class="recommendations">
    <div class="recommendations-list" v-if="filteredProducts">
      <RecommendedProductCard v-for="product in filteredProducts" :key="product.uuid" :product="product" />
    </div>
  </div>
</template>

<script>
import { useProductRecomendationStore } from '../../../stores/productRecomendation.js';
import RecommendedProductCard from './RecommendedProductCard.vue';
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
  components: {
    RecommendedProductCard,
  },
  setup() {
    const productRecomendationStore = useProductRecomendationStore();
    const router = useRouter();
    const screenSize = ref(getWindowWidth()); // Получаем начальное значение
    const currentProductId = ref(null);

    const filteredProducts = computed(() => {
      // Логика фильтрации
      let count = 0;
      if (screenSize.value <= 320) {
        count = 3; // Или любое другое значение
      } else if (screenSize.value <= 375) {
        count = 3;
      } else if (screenSize.value <= 425) {
        count = 4;
      } else if (screenSize.value <= 768) {
        count = 4;
      } else if (screenSize.value <= 1024) {
        count = 3;
      } else if (screenSize.value <= 1440) {
        count = 4;
      } else if (screenSize.value <= 1800) {
        count = 4;
      } else {
        count = 5; // Или любое другое значение для больших экранов
      }
      return productRecomendationStore.recommendedProducts.filter(product => product.uuid !== currentProductId.value).slice(0, count);
    });

    onMounted(async () => {
      currentProductId.value = router.currentRoute.value.params.id;
      await productRecomendationStore.fetchRecommendedProducts();
    });

    window.addEventListener('resize', () => {
      screenSize.value = getWindowWidth();
    });

    return {
      filteredProducts,
    };
  },
};

function getWindowWidth() {
  return window.innerWidth;
}
</script>