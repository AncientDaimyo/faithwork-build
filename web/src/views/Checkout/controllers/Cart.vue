<template>
  <div class="page-wrapper">
    <HeaderCommon />
    
      <div class="cart-page">
        <AuthModal :showModal="showModal" @close="closeModal" @continue-checkout="continueCheckout" />


        <div v-if="cartItems.length > 0" class="cart-items-container">
          <div v-for="(item, index) in cartItems" :key="index" class="cart-item">
            <div class="cart-item-image-wrapper">
              <img src="/src/views/Shared/pic/FW_GIRL_FACE_black_2x3.png"
                :alt="item.product.name" class="cart-item-image" @click="goToProductPage(item.product.uuid)" />
            </div>
            <div class="cart-item-info">
              <p class="cart-item-name" @click="goToProductPage(item.product.uuid)" :style="{ cursor: 'pointer' }">
                {{ item.product.name }}
              </p>
              <p class="cart-item-size">Размер: {{ item.size }}</p>
              <div class="cart-item-quantity">
                <button @click="decreaseQuantity(item.product.uuid, item.size)">
                  -
                </button>
                <span>{{ item.quantity }}</span>
                <button @click="increaseQuantity(item.product.uuid, item.size)">
                  +
                </button>
              </div>
              <p class="cart-item-price">
                Цена: {{ item.product.cost }} ₽ (за единицу)
              </p>
              <button @click="removeItem(item.product.uuid, item.size)" class="remove-item">
                Удалить
              </button>
            </div>
          </div>
        </div>



        
        <div v-if="cartItems.length > 0" class="cart-total">
          <div>
            <p>Итого: {{ cartTotalPrice }} ₽</p>
          </div>
          <div class="actions">
            <div class="action_checkout_block">
              <button @click="checkout" class="checkout">
                Оформить заказ
              </button>
            </div>
            <div class="action_clear_cart_block">
              <button @click="clearCart" class="clear-cart">
                Очистить корзину
              </button>
            </div>
          </div>
        </div>


        <div v-else class="empty-cart-message">
          Тут пусто, добавьте товар и случится чудо :)
        </div>
      </div>

    <FooterSecond />
  </div>
</template>

<script>
import { computed, ref } from "vue";
import { useCartStore } from "../../../stores/cart.js";
import HeaderCommon from "../../Shared/controllers/HeaderCommon.vue";
import FooterSecond from "../../Shared/controllers/FooterSecond.vue";
import AuthModal from "../../User/controllers/AuthModal.vue";
import { useUserStore } from "../../../stores/userStore.js";
import { useRouter } from 'vue-router';

export default {
  components: {
    HeaderCommon,
    FooterSecond,
    AuthModal,
  },
  setup() {
    // Используем store для работы с корзиной
    const cartStore = useCartStore();
    // Используем store для работы с пользователем
    const userStore = useUserStore();
    // Используем router для навигации по страницам
    const router = useRouter();

    // Состояние модального окна авторизации
    const showModal = ref(false);

    // Проверяем, авторизован ли пользователь
    const isLoggedIn = computed(() => userStore.isLoggedIn);

    // Функция закрытия модального окна авторизации
    const closeModal = () => {
      showModal.value = false;
      document.body.style.overflow = 'auto';
    };

    // Функция продолжения оформления заказа
    const continueCheckout = () => {
      closeModal();
      // Логика продолжения оформления заказа
      alert("Продолжаем оформление заказа!");
    };

    // Функция оформления заказа
    const checkout = () => {
      if (isLoggedIn.value) {
        alert("Оформление заказа в разработке!");
      } else {
        showModal.value = true;
        document.body.style.overflow = 'hidden';
      }
    };

    // Функция перехода на страницу товара
    const goToProductPage = (productId) => {
      router.push(`/shop/${productId}`);
    };

    // Возвращаем необходимые данные и функции
    return {
      // Список товаров в корзине
      cartItems: computed(() => cartStore.getCartItems),
      // Общая стоимость корзины
      cartTotalPrice: computed(() => cartStore.cartTotalPrice),
      // Функция удаления товара из корзины
      removeItem: cartStore.removeFromCart,
      // Функция увеличения количества товара в корзине
      increaseQuantity: cartStore.increaseQuantity,
      // Функция уменьшения количества товара в корзине
      decreaseQuantity: cartStore.decreaseQuantity,
      // Функция очистки корзины
      clearCart: cartStore.clearCart,
      // Функция оформления заказа
      checkout,
      // Состояние модального окна авторизации
      showModal,
      // Функция закрытия модального окна авторизации
      closeModal,
      // Функция продолжения оформления заказа
      continueCheckout,
      // Функция перехода на страницу товара
      goToProductPage,
    };
  },
};
</script>