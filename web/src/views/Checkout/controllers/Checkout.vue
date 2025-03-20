<template>

    <form class="custom-field-user-info" @submit.prevent="onSubmit">

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.name" pattern="[A-Za-z\s]+" />
            <span v-if="v$.form.name.$error">
                {{ v$.form.name.$errors[0].$message }}
            </span>
            <span class="placeholder">Имя</span>
        </label>

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.surname" pattern="[A-Za-z\s]+" />
            <span v-if="v$.form.surname.$error">
                {{ v$.form.surname.$errors[0].$message }}
            </span>
            <span class="placeholder">Фамилия</span>
        </label>

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.patronymic" pattern="[A-Za-z\s]+" />
            <span v-if="v$.form.patronymic.$error">
                {{ v$.form.patronymic.$errors[0].$message }}
            </span>
            <span class="placeholder">Отчество</span>
        </label>

        <label class="custom-field one">
            <input type="email" placeholder=" " v-model="state.form.email"
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
            <span v-if="v$.form.email.$error">
                {{ v$.form.email.$errors[0].$message }}
            </span>
            <span class="placeholder">Email</span>
        </label>

        <label class="custom-field one">
            <input type="tel"
            id="phone"
            placeholder=" " 
            v-model="state.form.telephone"
            @input="formatPhoneNumber"
            pattern="\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}" />
            <span v-if="v$.form.telephone.$error">
                {{ v$.form.telephone.$errors[0].$message }}
            </span>
            <span for="phone" class="placeholder">Телефон</span>
        </label>

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.city" />
            <span v-if="v$.form.city.$error">
                {{ v$.form.city.$errors[0].$message }}
            </span>
            <span class="placeholder">Город</span>
        </label>

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.street" />
            <span v-if="v$.form.street.$error">
                {{ v$.form.street.$errors[0].$message }}
            </span>
            <span class="placeholder">Улица</span>
        </label>

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.house" />
            <span v-if="v$.form.house.$error">
                {{ v$.form.house.$errors[0].$message }}
            </span>
            <span class="placeholder">Дом</span>
        </label>

        <label class="custom-field one">
            <input type="text" placeholder=" " v-model="state.form.apartment" />
            <span v-if="v$.form.apartment.$error">
                {{ v$.form.apartment.$errors[0].$message }}
            </span>
            <span class="placeholder">Квартира</span>
        </label>


        <input type="submit" />


    </form>

    {{ this.name }}

</template>


<script>
import useValidate from '@vuelidate/core'
import { required, minLength, email, numeric } from '@vuelidate/validators'
import { reactive, computed } from 'vue'
export default {
    setup() {
        const state = reactive({
            form: {
                name: '',
                surname: '',
                patronymic: '',
                email: '',
                telephone: '',
                city: '',
                street: '',
                house: '',
                apartment: '',
                products: []
            }
        })

        const rules = computed(() => {
            return {
                form: {
                    name: { required, minLength: minLength(2) },
                    surname: { required, minLength: minLength(2) },
                    patronymic: { required, minLength: minLength(2) },
                    email: { required, email },
                    telephone: { required, numeric },
                    city: { required, minLength: minLength(2) },
                    street: { required, minLength: minLength(2) },
                    house: { required, minLength: minLength(1) },
                    apartment: { required, numeric },
                }
            }
        })

        const v$ = useValidate(rules, state)

        return {
            state,
            v$,
        }
    },

    methods: {
        async onSubmit() {
            if (this.getCookie('cart', true)) {
                this.state.products = JSON.parse(this.getCookie('cart'));
                let response = await fetch('/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(this.state.form)
                });

                this.response = await response.json();
            }
            else {
                alert('Корзина пуста');
            }
        },
    },
    getCookie(name, json = false) {
        if (!name) {
            return undefined;
        }
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()\[\]\\\/+^])/g, '\\$1') + "=([^;]*)"
        ));
        if (matches) {
            let res = decodeURIComponent(matches[1]);
            if (json) {
                try {
                    return JSON.parse(res);
                }
                catch (e) { }
            }
            return res;
        }

        return undefined;
    },
    formatPhoneNumber(event) {
        const input = event.target;
        const value = input.value.replace(/\D/g, ''); // Удаляем все нецифровые символы
        let formattedValue = '';

        if (value.length >= 1) formattedValue += '+7 ';
        if (value.length >= 3) formattedValue += '(' + value.substring(1, 4) + ') ';
        if (value.length >= 7) formattedValue += value.substring(4, 7) + '-';
        if (value.length >= 10) formattedValue += value.substring(7, 10) + '-';

        input.value = formattedValue;
    },
}

</script>