<template>
    <div class="page-wrapper">
        <HeaderCommon />
        <div class="info-content-page">
            <p class="about-us-heading">
                Все началось с мечты
            </p>
            <div class="about-us-article">
                FAITHWORK – лаконичный стритстайл бренд одежды, раскрывающий ваши тайные глубинные
                желания. Мы верим в то, что сексуальность каждого человека должна быть раскрыта, не только
                посредством
                его мыслей, фантазий и образов, но и внешнего вида, стиля, одежды.
                Как и в повседневной жизни нам важно видеть в нашем окружений единомышленников, чей разум и тело
                открыты
                не только к новой окружающей реальности, но и к внутренним душевным и ментальным изменениям.
                Присоединяйтесь к FAITHWORK и раскройте внутреннее неосознанное.
            </div>
        </div>
        <div class="about-us-picture">
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