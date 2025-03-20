import { defineStore } from "pinia";
import axios from "axios"; // Импортируем axios

export const useProductRecomendationStore = defineStore(
  "productRecomendationStore",
  {
    state: () => ({
      recommendedProducts: [],
      allProducts: [], // Добавляем состояние для хранения всех продуктов
    }),
    actions: {
      async fetchRecommendedProducts() {
        try {
          // Получаем все продукты с сервера
          const response = await axios.get(
            "https://127.0.0.1:8000/api/product/get-products"
          );
          this.allProducts = response.data;

          // Выбираем 10 случайных продуктов
          this.recommendedProducts = this.getRandomProducts(10);
        } catch (error) {
          console.error("Ошибка при загрузке рекомендованных товаров:", error);
        }
      },
      getRandomProducts(count) {
        // Функция для выбора случайных продуктов
        const shuffledProducts = [...this.allProducts].sort(
          () => 0.5 - Math.random()
        );
        return shuffledProducts.slice(0, count);
      },
    },
  }
);
