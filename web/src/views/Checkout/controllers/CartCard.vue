<template>
    <div class="product-card-image-div">
        <img class="product-card-image" v-bind:src="imageDir + image" v-bind:alt="name" />
    </div>
    <div class="product-card-full-info">
        <div class="product-card-naming-block">
            <p class="product-card-name">{{ name }}</p>
            <p class="product-card-article">{{ article }}</p>
            <p class="product-card-description">{{ description }}</p>
        </div>
        <div class="product-card-numbers-block">
            <p class="product-card-cost">{{ cost.split('.')[0] }}</p>
            <p class="product-card-amount">{{ amount }}</p>
            <p class="">{{ size }} </p>
        </div>
    </div>
    <div>
        <button v-on:click="removeFromCart">Удалить товар</button>
    </div>
    <div>
        <button v-on:click="removeCart">Удалить Всё нахуй</button>
    </div>w
</template>

<script setup>
defineProps({
    'id': String,
    'name': String,
    'article': String,
    'image': String,
    'cost': String,
    'amount': String,
    'size' : String
});

</script>

<script>



import $ from 'jquery';

export default {
    data() {
        return {
            showImage: false,
            route: "cart/",
            imageDir: "/images/products/",
            products: [],
            cartItem : {
                id: this.id,
                size: this.size
            }
        };
    },
    methods: {
        removeCart() {
            fetch('/cart/clear', {
                method: 'DELETE',
            })
                .then((response) => response.json())
            $(".cart-page").load('/cart/ajax');
        },

        removeFromCart() {
            fetch('/cart/remove', {
                method: 'DELETE',
                body: JSON.stringify(this.cartItem)
            })
                .then((response) => response.json())
            $(".cart-page").load('/cart/ajax');
        },

    },
}
</script>