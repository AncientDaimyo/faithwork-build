<script>
import {
  ref,
  onMounted,
  watch,
  computed
} from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import HeaderRide from '../../Shared/controllers/HeaderRide.vue';
import FooterSecond from '../../Shared/controllers/FooterSecond.vue';
import ProductRecommendations from '../../Product/controllers/ProductRecommendations.vue';
import MobileSingleProductSwiper from '../controllers/MobileSingleProductSwiper.vue';
import { useCartStore } from '../../../stores/cart.js';
import { useProductRecomendationStore } from '../../../stores/productRecomendation.js';
import sizeGuideImage from '../../Shared/pic/Razmernaja_Setka-01.png';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

export default {
  components: {
    HeaderRide,
    FooterSecond,
    ProductRecommendations,
    MobileSingleProductSwiper,
    Swiper,
    SwiperSlide
  },
  setup() {
    const route = useRoute(); // Define route
    const router = useRouter();
    const apiHost = import.meta.env.VITE_API_HOST;
    const apiRoute = '/api/product/get-product-by/';
    const product = ref({});
    const isLoading = ref(true);
    const sizeSelected = ref(null);
    const hasJustAdded = ref(false);
    const showError = ref(false);
    const showSizeGuide = ref(false);
    const modalImageSrc = ref(null);
    const modalContent = ref(null);
    const isSliderInitialized = ref(false);

    const cartStore = useCartStore();
    const productRecomendationStore = useProductRecomendationStore();

    const fetchProduct = async () => {
      try {
        const response = await axios.get(`${apiHost}${apiRoute}${route.params.id}`);
        console.log(response.data);
        product.value = response.data;
        isLoading.value = false;
      } catch (error) {
        console.error('Ошибка при получении данных о продукте:', error);
        isLoading.value = false;
      }
    };

    onMounted(() => {
      fetchProduct();
      productRecomendationStore.fetchRecommendedProducts();
    });

    watch(
      () => route.params.id, // Corrected to route.params.id
      async (newId) => {
        console.log('Route ID changed to:', newId);
        if (newId) {
          await fetchProduct();
        }
      }
    );

    const isAnySizeInCart = computed(() => {
      return cartStore.getCartItems.some(
        (item) => item.product.uuid === product.value.uuid
      );
    });

    const isSizeInCart = (productUuid, size) => {
      return cartStore.hasItemWithSize(productUuid, size);
    };

    const addToCart = () => {
      if (sizeSelected.value) {
        cartStore.addToCart(product.value, sizeSelected.value);
        hasJustAdded.value = true;
        showError.value = false;
      } else {
        showError.value = true;
      }
    };

    const goToCart = () => {
      router.push({ name: 'cart' });
      hasJustAdded.value = false;
    };

    const continueShopping = () => {
      router.push({ name: 'shop' });
      hasJustAdded.value = false;
    };

    const openModal = () => {
      modalImageSrc.value = sizeGuideImage;
      showSizeGuide.value = true;
    };

    const closeModal = () => {
      showSizeGuide.value = false;
    };

    const swiperOptions = {
      slidesPerView: 1,
      spaceBetween: 10,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    };

    return {
      product,
      isLoading,
      sizeSelected,
      hasJustAdded,
      showError,
      isAnySizeInCart,
      isSizeInCart,
      addToCart,
      goToCart,
      continueShopping,
      openModal,
      closeModal,
      modalImageSrc,
      modalContent,
      showSizeGuide,
      swiperOptions
    };
  },
};
</script>

<template>
  <HeaderRide />
  <div class="single-product-page-wrapper">
    <MobileSingleProductSwiper />
    <swiper class="my-swiper" :options="swiperOptions">
      <swiper-slide v-for="image in product.images" :key="image">
        <img :src="image" alt="Product Image" class="single-product-image" />
      </swiper-slide>
    </swiper>
    <div class="info">
      <p class="single-product-name">{{ product.name }}</p>
      <p class="single-product-article">{{ product.article }}</p>
      <p class="single-product-cost" v-if="product.cost">
        {{ product.cost.split('.')[0] }} ₽
      </p>

      <div v-if="isLoading">Секундочку, загружаю...</div>
      <div v-else>
        <div class="single-product-description-block">
          <p class="single-product-description">Принт: {{ product.description?.print || 'N/A' }}</p>
          <p class="single-product-description">Плотность: {{ product.description?.density || 'N/A' }}</p>
          <p class="single-product-description">Состав: {{ product.description?.compound || 'N/A' }}</p>
        </div>

        <form class="single-product-size-form" @submit.prevent="addToCart">
          <div class="single-product-size-wrapper">
            <div class="single-product-size-cycle" v-for="size in product.sizes" :key="size" :size="size">
              <input :id="`size-${size}`" type="radio" name="getProductSize" v-model="sizeSelected" :value="size" required
                :disabled="isSizeInCart(product.uuid, size)" />
              <label :for="`size-${size}`" :class="{ disabled: isSizeInCart(product.uuid, size) }">
                {{ size }}
              </label>
            </div>
          </div>
          <div v-if="showError" class="error-message">Пожалуйста, выберите размер</div>

          <div class="single-product-add-to-cart">
            <div class="single-product-cart-buttons">
              <div class="single-product-cart-buttons-add">
                <button v-if="!hasJustAdded" type="button" class="single-product-add-to-cart-button" @click="addToCart">
                  Добавить в корзину
                </button>
              </div>
              <div v-if="hasJustAdded" class="single-product-cart-buttons-after-add">
                <button type="button" class="single-product-go-to-cart" @click="goToCart">
                  Перейти в корзину
                </button>
                <button type="button" class="single-product-continue-shopping" @click="continueShopping">
                  Продолжить покупки
                </button>
              </div>
              <div class="single-product-cart-buttons-after-add">
                <button v-if="isAnySizeInCart && !hasJustAdded" type="button" class="single-product-return-cart"
                  @click="goToCart">
                  Вернуться в корзину
                </button>
              </div>
            </div>
          </div>
          <p class="size-guide-link" @click="openModal">Гайд по размерам</p>
        </form>

        <div v-if="showSizeGuide" class="modal" @click.self="closeModal">
          <div class="modal-content" ref="modalContent">
            <img :src="modalImageSrc" alt="Гайд по размерам" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <h1>Вам понравится:</h1>
  <ProductRecommendations />
  <FooterSecond />
</template>