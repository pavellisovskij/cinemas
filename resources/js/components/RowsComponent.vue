<template>
    <div class="container">
        <a v-on:click="addHorizontalPassage" v-bind:class="[!seats ? 'disabled' : '']" class="btn btn-success">Добавить горизонтальный проход</a>
        <a v-on:click="clearHall" v-bind:class="[!seats ? 'disabled' : '']" class="btn btn-warning">Очистить</a>

        <div class="hall" :style="'width: ' + width + 'px'">
            <div v-for="(row, index) in hall" class="rowInHall">
                <div class="delete-button" v-on:click="deleteRow(index)" :style="'left: ' + (width + 10)  + 'px'">Удалить ряд</div>
                <div v-for="place in row" class="cell">
                    <div v-if="place == false" class="passage">

                    </div>
                    <div v-else class="place">

                    </div>
                </div>
            </div>
        </div>

        <div v-if="hall.length > 0"  class="container">
            <div class="form-group">
                <label for="name">Наименование зала:</label>
                <input v-model="name" type="text" name="name" class="form-control" id="name" required>
            </div>
            <a v-on:click="addHall" class="btn btn-success">Добавить зал</a>
        </div>
    </div>
</template>


<script>
    export default {
        props: [
            'rows',
            'width',
            'seats',
            'cinemaId'
        ],
        data: function () {
            return {
                hall: [],
                name: ""
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addHorizontalPassage: function () {
                let horizontalPassage = [];
                for (let i = 0; i < this.seats; i++) {
                    horizontalPassage.push(false);
                }
                this.hall.push(horizontalPassage);
            },
            deleteRow: function (index) {
                this.hall.splice(this.hall[index], 1);
            },
            clearHall: function () {
                this.hall = [];
            },
            addHall: function () {
                axios.post('/cinema/' + this.cinemaId + '/hall', {
                    hall: JSON.stringify(this.hall),
                    name: this.name
                }).then(response => {
                    if (response.data.type == 'success') {
                        window.location.href = '/cinema/' + this.cinemaId + '/hall/' + response.data.id;
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            }
        },
        watch: {
            rows: function(rows) {
                for (let i = 0; i < rows.length; i++) {
                    this.hall.push(rows[i]);
                }
                //this.rows = [];
            }
        }
    }
</script>

<style>
    .hall {
        position: relative;
        right: 0px;
        left: 0px;
        margin: auto;
    }
    .rowInHall {
        position: relative;
        height: 20px;
        width: auto;
        margin: 1px 0px;
    }
    .delete-button {
        display:none;
        /*margin-left:-350px;*/
        padding: 10px;

        /*margin-top:17px;*/
        background: red;
        color: white;
        /*height:200px;*/
        -moz-box-shadow:0 5px 5px rgba(0,0,0,0.3);
        -webkit-box-shadow:0 5px 5px rgba(0,0,0,0.3);
        box-shadow:0 5px 5px rgba(0,0,0,0.3);
    }
    .rowInHall:hover .delete-button {
        display:block;
        position:absolute;
        top:-10px;
        height: 40px;
        /*left: 10px; !*поменять здесь*!*/
        width: 110px;
        z-index:9999;
        cursor: pointer;
    }
    .rowInHall .delete-button::after {
        content: " ";
        position: absolute;
        top: 25%;
        right: 100%; /* To the left of the tooltip */

        border-width: 10px;
        border-style: solid;
        border-color: transparent red transparent transparent;
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
