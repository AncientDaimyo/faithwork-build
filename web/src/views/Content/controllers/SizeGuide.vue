<template>
    <div class="page-wrapper">
        <HeaderCommon />
        <div class="info-content-page">
            <p class="size-guide-heading">
                Размерная сеткa
            </p>
            <div class="size-guide-article">
                Мы сделали для вас отдельную страницу для выбора размерной сетки всех типов наших товаров
            </div>
            <div class="size-guide-border-block">
                <p class="size-guide-border"></p>
            </div>
            <div class="size-guide-picture">
                <p>Tee</p>
                <img src="../pic/FW_GIRL_FACE_black.png" />
            </div>
        </div>
        <FooterSecond />
    </div>
</template>

<script>
import HeaderCommon from '../../Shared/controllers/HeaderCommon.vue'
import FooterSecond from '../../Shared/controllers/FooterSecond.vue'

export default {
    components: {
        HeaderCommon,
        FooterSecond,
    }
}
</script>