<template>
    <div class="page-wrapper">
        <HeaderCommon />
            <div class="info-content-page">
                <p class="delivery-heading">
                    Бесплатная доставка
                </p>
                <div class="delivery-article">
                    Бесплатная доставка осуществляется при заказе от 5000 ₽ до пункта выдачи заказов CDEK, Почта РФ.
                    При оформлении заказа от 5000 ₽ вы можете указать предпочтительный вариант доставки CDEK или
                    Почта РФ.
                </div>
                <p class="delivery-heading">
                    Доставка Почтой РФ
                </p>
                <div class="delivery-article">
                    В настоящее время доставка осуществляется только в пределах РФ.
                    Стоимость доставки в отделение Почты РФ высчитывается на странице оформления заказа и зависит от
                    расстояния до пункта назначения.
                    Товары отправляются из Санкт-Петербурга или Кирова.
                </div>
                <p class="delivery-heading">
                    Время доставки
                </p>
                <div class="delivery-article">
                    Товар передается в транспортную компанию в течение 24 часов с момента поступления средств на
                    счёт при малой загрузке, иначе время передачи товара увеличивается до 72 часов. После отправки на
                    ваш email предоставляется трек-код для отслеживания посылки.
                    Срок доставки зависит от удаленности пункта назначения до нашего склада, однако в среднем
                    доставка осуществляется за 5-10 календарных дней.
                </div>
            </div>
        <div class="delivery-picture">
            <img src="../pic/FW_GIRL_FACE_black.png" />
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