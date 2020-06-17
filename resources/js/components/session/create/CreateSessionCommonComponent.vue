<template>
    <div>
        <div v-if="message['status']===true" class="alert alert-success" role="alert">
            {{ message['message'] }}
        </div>
        <div v-if="message['status']===false" class="alert alert-danger" role="alert">
            {{ message['message'] }}
        </div>
        <div class="row">
            <div class="col-lg-4">
                <multiselect
                        v-model="selectedCinemaName"
                        :options="cinemasNames"
                        :multiple="false"
                        :close-on-select="true"
                        :placeholder="'Выберите кинотеатр'"
                        @input="onSelectCinemaSelector"
                ></multiselect>
                <multiselect
                        v-if="selectedCinemaName"
                        v-model="selectedHallName"
                        :options="cinemaHalls"
                        :multiple="false"
                        :close-on-select="true"
                        :placeholder="'Выберите зал'"
                        @input="onSelectHallSelector"
                ></multiselect>
            </div>
            <div class="col-lg-4">
                <multiselect
                    v-if="selectedHallName"
                    v-model="selectedFilm"
                    :options="assignedFilms"
                    :multiple="false"
                    :close-on-select="true"
                    :placeholder="'Выберите фильм'"
                    @input="onSelectFilmSelector"
                ></multiselect>
                <div class="row" v-if="selectedFilm">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="start-date">Дата старта сеансов:</label>
                            <input type="date" class="form-control" id="start-date" v-model="startDate" :min="startDate"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="end-date">Дата конца сеансов:</label>
                            <input type="date" class="form-control" id="end-date" v-model="endDate" :min="startDate"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" v-if="schedule.length !== 0">
                    <div class="card-header">
                        Сеансы
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label for="allSessions">
                                <input type="checkbox" id="allSessions" v-model="allSessions"> Выбрать все сеансы
                            </label>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="time in schedule">
                            <div class="input-group">
                                <label :for="'time' + time" style="margin: 0">
                                    <input type="checkbox" :id="'time' + time" v-model="selectedTime" :value="time">{{ time }}
                                </label>
                            </div>
                        </li>
                    </ul>
                    <div class="card-footer">
                        <button v-on:click="createSessions" class="btn btn-primary">Создать сеансы</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'cinemas',
        ],
        data: function () {
            return {
                cinemasNames: [],
                selectedCinemaName: '',
                selectedCinema: '',
                selectedHallName: '',
                selectedHall: '',
                cinemaHalls: [],
                selectedFilm: '',
                assignedFilms: [],
                selectedFilmData: [],
                startDate: '',
                endDate: '',
                schedule: [],
                selectedTime: [],
                maxNumberOfSessions: 0,
                message: []
            }
        },
        mounted() {
            console.log('CreateSessionCommonComponent mounted.');
            this.getCinemasNames();
        },
        computed: {
            allSessions: {
                get() {
                    return this.selectedTime.length === this.schedule.length;
                },
                set(val) {
                    this.selectedTime = val == true ? this.schedule : [];
                }
            }
        },
        methods: {
            getCinemasNames: function () {
                for (let i = 0; i < this.cinemas.length; i++) {
                    this.cinemasNames.push(this.cinemas[i].name);
                }
            },
            onSelectCinemaSelector: function () {
                this.cinemaHalls = [];
                this.selectedCinema = this.cinemas.find(cinema => cinema.name === this.selectedCinemaName);

                for (let i = 0; i < this.selectedCinema.hall.length; i++) {
                    this.cinemaHalls.push(this.selectedCinema.hall[i].name);
                }
            },
            onSelectHallSelector: function () {
                this.selectedHall = this.selectedCinema.hall.find(h => h.name === this.selectedHallName);

                axios.get('/film/get-films/' + this.selectedHall.id).then((response) => {
                    let films = JSON.parse(response.data.films);

                    for (let i = 0; i < films.length; i++) {
                        this.assignedFilms.push(films[i].name + ' - ' + films[i].year);
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            },
            onSelectFilmSelector: function () {
                let film = this.selectedFilm.split(' - ');
                axios.get('/film/get-film/' + film[0] + '/' + film[1]).then((response) => {
                    this.selectedFilmData = response.data.film;
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });

                this.startDate  = this.selectedFilmData['start'];
                this.endDate    = this.selectedFilmData['end'];
                this.schedule   = [];

                let startWorkTime = 9;
                let endWorkTime = 24;

                let workTimeInMinutes = (endWorkTime - startWorkTime) * 60;

                this.maxNumberOfSessions = Math.trunc(workTimeInMinutes / this.selectedFilmData.duration);

                let timeInMinutes = startWorkTime * 60;
                let hour = 0;
                let minutes = 0;
                let session = '';
                let breakTime = 20;
                let balance = 0;

                this.schedule.push(startWorkTime + ':00');

                for (let i = 0; i < this.maxNumberOfSessions; i++) {
                    timeInMinutes = timeInMinutes +  this.selectedFilmData.duration;

                    balance = (timeInMinutes - Math.trunc(timeInMinutes / 60) * 60)  % 10;
                    timeInMinutes = timeInMinutes + breakTime - balance;

                    hour = Math.trunc(timeInMinutes / 60);
                    minutes = timeInMinutes - hour * 60;

                    session = hour.toString().length < 2 ? session = '0' + hour : session = hour.toString();
                    session = minutes.toString().length < 2 ? session = session + ':0' + minutes : session = session + ':' + minutes;

                    this.schedule.push(session);
                }
            },
            createSessions: function () {
                this.message = [];
                axios.post('/session', {
                    timearr:    this.selectedTime,
                    startdate:  this.startDate,
                    enddate:    this.endDate,
                    hallid:     this.selectedHall.id,
                    filmid:     this.selectedFilmData.id
                }).then((response) => {
                    console.log(response);
                    if (response.data.status === true) {
                        this.message['status'] = true;
                        this.message['message'] = response.data.message;
                    }
                    else {
                        this.message['status'] = false;
                        this.message['message'] = response.data.message;
                    }
                }).catch(error => {
                    // here catch error messages from laravel validator and show them
                });
            }
        },
    }
</script>
