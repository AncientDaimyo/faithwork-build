<template>
    <figure class="product-card-wrapper" @mouseenter="showImage = true" @mouseleave="showImage = false">
        <a :href="route + props.product.uuid"></a>
        <!-- 
        <img class="product-card-image" :src="imageSrc" :alt="props.product.name" 
        -->
        <img class="product-card-image" src="/src/views/Shared/pic/FW_GIRL_FACE_black_2x3.png"
            alt="Product Image">
        <p class="product-card-name">{{ props.product.name }}</p>
        <p class="product-card-cost">{{ props.product.cost.split('.')[0] }} ₽</p>
    </figure>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const route = '/shop/';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const showImage = ref(false);

const imageSrc = computed(() => {
    return showImage.value ? props.product.hover_image : props.product.image;
});

const productName = ref(null);
const truncatedProductName = ref('');

const truncateText = () => {
    if (productName.value) {
        const originalText = props.product.name;
        if (originalText.length > 25) {
            truncatedProductName.value = originalText.slice(0, 25) + '...';
        } else {
            truncatedProductName.value = originalText;
        }
    }
};

onMounted(() => {
    truncateText();
});
</script>