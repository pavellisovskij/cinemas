<template>
    <div class="container-fluid">
        <div class="hall" :style="'width: ' + width + 'px'">
            <div v-for="(row, indexOfRow) in hallConverted" class="rowInHall">
                <div v-for="(place, indexOfCell) in row" class="cell">
                    <div v-if="place == false" class="passage">
                    </div>
                    <div v-else class="place" @mouseenter="calculatePosition(indexOfCell)">
                        <div class="info" :style="'left: ' + (position + 10)  + 'px'">
                            Ряд: {{ indexOfRow + 1 }} Место: {{ indexOfCell + 1 }}
                            <br>
                            {{ place.name }} - {{ place.amount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'hall',
        ],
        data: function () {
            return {
                width: 0,
                hallConverted: null,
                position: 0,
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.hallConverted = JSON.parse(this.hall);
            this.width = this.hallConverted[0].length * 20;
        },
        methods: {
            calculatePosition: function (index) {
                this.position = index * 20 + 20;
            },
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
    .info {
        display:none;
        background: #1d2124;
        color: white;
        -moz-box-shadow:0 5px 5px rgba(0,0,0,0.3);
        -webkit-box-shadow:0 5px 5px rgba(0,0,0,0.3);
        box-shadow:0 5px 5px rgba(0,0,0,0.3);
    }
    .cell:hover .info {
        display:block;
        position:absolute;
        top: -20px;
        z-index:9999;
        padding: 10px;
        min-width: 130px;
        height: 60px;
    }
    .cell .info::after {
        content: " ";
        position: absolute;
        top: 20px;
        right: 100%; /* To the left of the tooltip */

        border-width: 10px;
        border-style: solid;
        border-color: transparent #1d2124 transparent transparent;
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
