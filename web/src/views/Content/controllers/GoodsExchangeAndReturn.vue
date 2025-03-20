<template>
    <div class="page-wrapper">
        <HeaderCommon />
        <div class="info-content-page">
            <p class="goods-exchange-and-return-heading">
                Обмен и возврат
            </p>
            <div class="goods-exchange-and-return-article">
                Любой товар можно обменять или вернуть, при соблюдении следующих условий:<br>
                – Товар не находился в употреблении и сохранены фабричные ярлыки.<br>
                – Срок с момента покупки не превысил 30 календарных дней.<br>
                – При возврате или обмене заказа в интернет магазине расходы на доставку не компенсируются.


                При обмене или возврате онлайн-заказа необходимо написать письмо в нашу службу
                поддержки:<br>
                <a href="mailto:clothing@faithwork.ru">clothing@faithwork.ru</a>
                <br>

                Вещи необходимо отправить на обратный адрес (адрес высылается по требованию клиента).<br>
                Посылка должна быть отправлена без наложенного платежа.<br>
                Возврат денежных средств или обмен осуществляется после того, как посылка с возвратом вернулась на
                склад
                интернет магазина.<br>
                Для возврат денежных средств, клиент обязан предоставить следующую информацию:<br>
                – Наименование банка<br>
                – Расчетный счет<br>
                – БИК банка<br>
                – ФИО<br>
                Стоимость доставки не учитывается (за исключением случаев заводского брака или вами получен
                товар не надлежащего качества)
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