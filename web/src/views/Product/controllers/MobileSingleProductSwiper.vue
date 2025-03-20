<template>
    <div ref="flickingContainer" class="flicking-container">
        <div class="panel" v-for="(image, index) in images" :key="index">
            <img :src="image" alt="Slide image">
        </div>
    </div>
    <div ref="pagination" class="pagination"></div>
</template>

<script>
import { ref, onMounted } from 'vue';
import Flicking from "@egjs/flicking";
import "@egjs/flicking/dist/flicking.css";
import "@egjs/flicking-plugins/dist/pagination.css";
import { Pagination } from '@egjs/flicking-plugins';

export default {
    setup() {
        const flickingContainer = ref(null);
        const pagination = ref(null);
        const images = ref([
            '/image1.jpg',
            '/image2.jpg',
            '/image3.jpg',
            '/image4.jpg',
        ]);
        let flicking;

        onMounted(async () => {
            flicking = new Flicking(flickingContainer.value, {
                circular: false, // Опционально: включить циклическую прокрутку
                bound: true, // Опционально: ограничить прокрутку within viewport
                adaptive: true,  // Опционально: адаптивный размер панелей
                defaultIndex: 0, // Опционально: начальный индекс
                // ... другие опции Flicking
            });

            new Pagination(flicking, {
                element: pagination.value, // Элемент для пагинации
                type: 'bullet', // Тип пагинации (bullet, number)
                // ... другие опции пагинации
            });

            // Событие для изменения активной точки пагинации при переключении слайда
            flicking.on({
                change: () => {
                    // Можно добавить логику для обновления состояния компонента, например, выделения активной точки
                }
            });

        });

        return {
            flickingContainer,
            pagination,
            images,
        };
    },
};
</script>

<style scoped>
.flicking-container {
    width: 100%;
    overflow: hidden;
    /* Важно для корректной работы Flicking */
}

.panel {
    width: 100%;
    text-align: center;
    /* Опционально: центрирование содержимого */
}

.panel img {
    width: 100%;
    display: block;
    /* Важно для корректной работы Flicking с изображениями */
}

.pagination {
    text-align: center;
    /* Центрирование пагинации */
    margin-top: 10px;
    /* Отступ сверху */
}
</style>