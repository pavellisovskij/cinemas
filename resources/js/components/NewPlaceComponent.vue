<template>
    <div class="container">
        <div v-if="message" v-bind:class="'alert alert-'+messageType" role="alert">
            {{ message }}
        </div>

        <div class="card">
            <div class="card-header">
                Добавление места
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="placeName">Наименование:</label>
                    <input type="text" v-model="name" name="name" class="form-control" id="placeName" required>
                </div>
                <div class="form-group">
                    <label for="price">Начальная стоимость:</label>
                    <input type="number" v-model.number="price" name="price" class="form-control" id="price" min="0.05" step="0.05" required>
                </div>
                <!--<div class="form-group">-->
                    <!--<label for="price">Начальная стоимость:</label>-->
                    <!--<input type="color" v-model.number="price" name="price" class="form-control" id="price" min="0.05" step="0.05" required>-->
                <!--</div>-->
            </div>

            <div class="card-header">
                Доступные опции
            </div>
            <div v-if="options == []" class="card-body">
                <div class="alert alert-secondary" role="alert">
                    Нет опций. Добавьте несколько.
                </div>
            </div>
            <ul v-else class="list-group list-group-flush">
                <li v-for="option in options" class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            :name="option.id"
                            :value="{
                                cost:   option.cost,
                                id:     option.id
                            }"
                            :id="'id-' + option.id"
                            v-model="checkedOptions"
                        >
                        <label :for="'id-' + option.id" class="custom-control-label">{{ option.name }}</label>
                    </div>
                    <span class="badge badge-primary badge-pill">{{ option.cost }}</span>
                </li>
            </ul>
            <div class="card-footer">
                Итоговая стоимость: {{ getAmount }}
                <br/>
                <button v-on:click="addNewPlace" class="btn btn-primary text-right" type="button">Добавить</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'option'
        ],
        data: function () {
            return {
                name:           "",
                price:          0.00,
                options:        [],
                checkedOptions: [],
                amount:         0.00,
                message:        "",
                messageType:    "",
            }
        },
        mounted() {
            console.log('NewPlaceComponent mounted.');
            this.getOptions();
        },
        methods: {
            getOptions: function () {
                axios.get('/option/get').then((response) => {
                    if (response.data.options) {
                        this.options = JSON.parse(response.data.options);
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
            addNewPlace: function () {
                let options = [];
                for (let i = 0; i < this.checkedOptions.length; i++) {
                    options.push(this.checkedOptions[i]['id']);
                }

                axios.post('/place', {
                    namePlace:  this.name,
                    amount:     this.amount,
                    options:    options//JSON.stringify(options)
                }).then((response) => {
                    this.placeMessage = response.data.message;
                    if (response.data.message == 'ok') {
                        this.namePlace      = '';
                        this.price          = 0.00;
                        this.checkedOptions = [];
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
        },
        computed: {
            getAmount: function () {
                this.amount = this.price;
                for (let i = 0; i < this.checkedOptions.length; i++) {
                    this.amount = parseFloat(this.amount) + parseFloat(this.checkedOptions[i]['cost']);
                }
                return this.amount;
            }
        },
        watch: {
            option: function(option) {
                this.options.push(option);
            }
        }
    }
</script>
