<template>
    <div class="container">
        <div class="form-group">
            <label for="maxSeats">Количество мест в ряду (включая проходы):</label>
            <input type="number" v-model="maxSeats" name="maxSeats" class="form-control" id="maxSeats" min="1" max="50" step="1" required>
            <button v-on:click="applyCountOfSeats" class="btn btn-primary">Применить</button>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="seats">Количество мест:</label>
                    <input type="number" v-model="seats" name="seats" class="form-control" id="seats" min="1" :max="maxSeats" step="1" required>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="type">Вид места:</label>
                    <select v-model="type" class="custom-select" name="type" id="type" required>
                        <option v-for="place in places" :value="place">
                            {{ place.name }} - {{ place.amount }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <a v-on:click="putInRow" class="btn btn-primary" v-bind:class="[disabled ? 'disabled' : '']">Добавить места в ряд</a>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <a v-on:click="putInRowPassage" class="btn btn-primary" v-bind:class="[disabled ? 'disabled' : '']">Добавить проход в ряд</a>
                </div>
            </div>
        </div>

        Осталось мест в ряде: {{ remainderOfSeats }}

        <hr>

        <div class="container-fluid">
            <div class="example" :style="'width: ' + widthOfRow + 'px'">
                <div v-for="place in row" class="cell">
                    <div v-if="place == false" class="passage">

                    </div>
                    <div v-else class="place">

                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="count_of_rows">Количество рядов:</label>
                    <input type="number" v-model="countOfRows" name="count_of_rows" class="form-control" id="count_of_rows" min="1" max="50" step="1" required>
                </div>
            </div>
            <div class="col-lg-4">
                <a v-on:click="addRows" class="btn btn-success" v-bind:class="[disabled ? 'disabled' : '']">Добавить ряды</a>
            </div>
            <div class="col-lg-4">
                <a v-on:click="deleteRow" class="btn btn-warning" v-bind:class="[disabled ? 'disabled' : '']">Очистить ряд</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'places'
        ],
        data: function () {
            return {
                disabled: true,
                widthOfRow: 0,
                maxSeats: 0,
                remainderOfSeats: this.maxSeats,
                seats: 1,
                countOfRows: 1,
                type: [],
                rows: [],
                row: []
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            applyCountOfSeats: function () {
                this.row                = [];
                this.widthOfRow         = 20 * this.maxSeats;
                this.remainderOfSeats   = this.maxSeats;
                this.disabled           = false;
                this.$emit('setWidthOfHall', this.widthOfRow, this.maxSeats);
            },
            putInRow: function () {
                let difference = this.remainderOfSeats - this.seats;
                if (difference < 0) {
                    alert('Превышен размер ряда!');
                }
                else {
                    for (let i = 0; i < this.seats; i++) {
                        this.row.push(this.type);
                    }
                    this.remainderOfSeats -= this.seats;
                }
            },
            putInRowPassage: function () {
                let difference = this.remainderOfSeats - 1;
                if (difference < 0) {
                    alert('Превышен размер ряда!');
                }
                else {
                    this.row.push(false);
                    this.remainderOfSeats -= 1;
                }
            },
            addRows: function () {
                for (let i = 0; i < this.countOfRows; i++) {
                    this.rows.push(this.row);
                }
                this.$emit('addRows', this.rows);
                this.rows = [];
            },
            addHorizontalPassage: function () {
                this.$emit('addHorizontalPassage', this.maxSeats);
            },
            deleteRow: function () {
                this.row = [];
                this.remainderOfSeats = this.maxSeats;
            }
        },
        computed: {

        },
    }
</script>

<style>
    .example {
        position: relative;
        right: 0px;
        left: 0px;
        margin: auto;
    }
    .cell {
        display: inline-block;
        width: 20px;
        height: 20px;
    }
    .place {
        background-color: #fcf4ad;
        width: 18px;
        height: 18px;
        border: 2px solid;
        border-color: #1f6fb2;
        margin: 1px;
    }
    .passage {
        background-color: darkgray;
        width: 18px;
        height: 18px;
        margin: 1px;
    }
</style>