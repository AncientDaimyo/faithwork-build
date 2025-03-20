<template>
  <div class="page-wrapper">
    <HeaderRide />
    <div class="shop-page">
      <div class="product-card-wrapper" v-for="product in products" :key="product.uuid">
        <a :href="`/shop/${product.uuid}`" class="product-card-link">
          <img class="product-card-image" src="/src/views/Shared/pic/FW_GIRL_FACE_black_2x3.png"
          alt="Product Image">
          <div class="product-card-content">
            <div class="product-card-name">{{ product.name }}</div>
            <div class="product-card-cost">{{ product.cost }} ₽</div>
          </div>
        </a>
      </div>
    </div>
    <FooterSecond />
  </div>
</template>

<script>
import HeaderRide from "../../Shared/controllers/HeaderRide.vue";
import FooterSecond from "../../Shared/controllers/FooterSecond.vue";
import axios from "axios";

export default {
  components: {
    HeaderRide,
    FooterSecond,
  },
  data() {
    return {
      products: [],
      apiHost: import.meta.env.VITE_API_HOST,
      apiRoute: '/api/product/get-products',
    };
  },
  created() {
    console.log(this.apiUrl);
    axios.get(`${this.apiHost}${this.apiRoute}`)
      .then((response) => {
        this.products = response.data;
      })
      .catch((error) => {
        console.error("Ошибка при загрузке продуктов:", error);
      });
  }
};
</script>



<!-- <template>
  <div class="page-wrapper">
    <HeaderRide />
    <div class="shop-page">
      <ProductCard v-for="product in products" :key="product.uuid" :product="product" />
    </div>
    <FooterSecond />
  </div>
</template>

<script>
import HeaderRide from "../../Shared/controllers/HeaderRide.vue";
import FooterSecond from "../../Shared/controllers/FooterSecond.vue";
import ProductCard from "./ProductCard.vue";
import axios from "axios";

export default {
  components: {
    HeaderRide,
    FooterSecond,
    ProductCard,
  },
  data() {
    return {
      products: [],
    };
  },
  created() {
    axios.get("https://127.0.0.1:8000/api/product/get-products")
      .then((response) => {
        this.products = response.data;
      })
      .catch((error) => {
        console.error("Ошибка при загрузке продуктов:", error);
      });
  }
};
</script> -->