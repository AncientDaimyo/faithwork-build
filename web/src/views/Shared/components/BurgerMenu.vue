<template>
    <div class="burger-menu" :class="{ 'is-open': isOpen }">
        <button class="burger-button" @click="toggleMenu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="menu" v-if="isOpen">
            <ul>
                <li><a href="/shop">Каталог</a></li>
                <li><a href="/info/size_guide">Размерная сетка</a></li>
                <li><a href="/info/contact_us">Контакты</a></li>
                <li><a href="/info/about_us">О нас</a></li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useBurgerMenuStore } from '../../../stores/burgerMenu.js';


const menuStore = useBurgerMenuStore();
const isOpen = computed(() => menuStore.isOpen);

const toggleMenu = () => {
    menuStore.toggle();
};
</script>

<style lang="scss" scoped>
.burger-menu {
    position: absolute;
    left: calc(var(--menu-spacing) + 1rem);
    height: calc(var(--logo-width) + 2rem);
    align-items: center;
    justify-content: center;
    display: flex; // Default display for mobile
    

    .burger-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 2rem;
        height: var(--logo-width);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        z-index: 45;

        span {
            width: 1.5rem;
            height: 0.15rem;
            background: #fff;
            transition: all 0.3s ease-in-out;
            margin-bottom: 0.3rem;
        }
    }

    &.is-open {
        .burger-button {
            span:nth-child(1) {
                transform: rotate(45deg) translate(0.2rem, 0.2rem);
            }

            span:nth-child(2) {
                opacity: 0;
            }

            span:nth-child(3) {
                transform: rotate(-45deg) translate(0.45rem, -0.45rem);
            }
        }
    }

    .menu {
        position: fixed; // Use fixed to cover the entire viewport
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;
        background: #000;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-100%);
        opacity: 0;
        transition: opacity 0.3s ease-in-out 1s;
        z-index: 40;

        ul {
            list-style: none;
            display: flex;
            flex-flow: column;
            padding: 0;
            margin: 0;
            height: 100%;
            justify-content: center;
            align-items: center;

            li {
                padding: 1rem;

                a {
                    font-size: var(--font-size);
                    text-decoration: none;
                    color: #fff;
                }
            }
        }
    }

    &.is-open .menu {
        transform: translateY(0%);
        transition: transform 0.3s ease-in-out 1s, opacity 1s ease-in-out;
        opacity: 1;
    }
}

@media (min-width: 769px) {
    .burger-menu {
        display: none; // Hide on desktop
    }
}
</style>