<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Добавление новой опции
            </div>
            <div class="card-body">
                <div v-if="message" v-bind:class="'alert alert-'+messageType" role="alert">
                    {{ message }}
                </div>

                <div class="form-group">
                    <label for="optionName">Наименование:</label>
                    <input v-model="name" type="text" name="name" class="form-control" id="optionName" required>
                </div>
                <div class="form-group">
                    <label for="cost">Cтоимость:</label>
                    <input v-model.number="cost" type="number" name="cost" class="form-control" id="cost" min="0.05" step="0.05" required>
                </div>
                <button v-on:click="addNewOption" class="btn btn-primary" type="button">Добавить</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                name:           "",
                cost:           0.00,
                message:        "",
                messageType:    ""
            }
        },
        mounted() {
            console.log('NewOptionComponent mounted.');
        },
        methods: {
            addNewOption: function () {
                axios.post('/option/store', {
                    name: this.name,
                    cost: this.cost
                }).then((response) => {
                    this.message     = response.data.message;
                    this.messageType = response.data.type;
                    if (response.data.type == 'success') {
                        this.name = "";
                        this.cost = 0.00;
                        let option = JSON.parse(response.data.option);
                        this.$emit('sendingNewOption', option);
                    }
                    //this.optionsList.push(JSON.parse(response.data.option));
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
        },
    }
</script>
