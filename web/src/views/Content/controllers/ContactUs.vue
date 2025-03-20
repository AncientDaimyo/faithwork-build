<template>
    <div class="page-wrapper">
        <HeaderCommon />
        <div class="info-content-page">
            <p class="contact-us-heading">
                Контакты
            </p>
            <div class="contact-us-article">
                <p>
                    <strong>Email:</strong> <a href="mailto:clothing@faithwork.ru">clothing@faithwork.ru</a>
                </p>
                <p>
                    <strong>ИНН:</strong> 434547177915
                </p>
                <p>Скоро тут будет форма обратной связи, но мы её еще не сделали, поэтому пишите на Email, ответим в
                    течение
                    часа на любой вопрос, даже как сделать сырники.</p>
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