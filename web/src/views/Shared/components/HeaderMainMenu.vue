<template>
    <nav class="header-menu">
        <ul>
            <li class="first">
                <a class="submenu-title" href="/shop">Каталог</a>
            </li>
            <li class="second">
                <span class="submenu-title" @mouseover="showDropdown = true, handleLinkMouseOver"
                    @mouseleave="handleMouseLeave">
                    Покупателям&#9662;
                </span>
            </li>
        </ul>
    </nav>

    <div class="header-submenu" v-show="showDropdown" @mouseover="handleLinkMouseOver" @mouseleave="handleLinkMouseLeave">
        <ul class="submenu-list second">
            <li>
                <a href="/info/size_guide">
                    Размерная сетка
                </a>
            </li>
            <li>
                <a href="/info/contact_us">
                    Контакты
                </a>
            </li>
            <li>
                <a href="/info/about_us">
                    О нас
                </a>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const showDropdown = ref(false);
const timer = ref(null);

const handleMouseLeave = () => {
    clearTimeout(timer.value);
    timer.value = setTimeout(() => {
        showDropdown.value = false;
    }, 450);
};

const handleLinkMouseOver = () => {
    clearTimeout(timer.value);
};

const handleLinkMouseLeave = () => {
    timer.value = setTimeout(() => {
        showDropdown.value = false;
    }, 450);
};
</script>