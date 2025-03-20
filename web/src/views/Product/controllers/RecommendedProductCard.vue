<template>
    <div class="product-card-container">
        <div class="product-card" @mouseenter="showImage = true" @mouseleave="showImage = false">
            <a :href="route + product.uuid" class="product-card-link">
                <div class="product-card-image-wrapper">
                    <img class="product-card-image" src="/src/views/Shared/pic/FW_GIRL_FACE_black_2x3.png" alt="Product Image">
                </div>
            </a>
            <div class="product-card-details">
                <div class="product-card-name">{{ product.name }}</div>
                <div class="product-card-cost">{{ product.cost.split('.')[0] }}₽</div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    'product': Object,
});
</script>

<script>
export default {
    data() {
        return {
            route: '/shop/'
        }
    },
    created() {
        if (typeof product === "undefined") {
            this.name = '';
            this.cost = '';
            this.image = '';
        } else {
            this.name = this.product.name;
            this.cost = this.product.cost;
            this.image = this.product.image;
        }
    }
}
</script>