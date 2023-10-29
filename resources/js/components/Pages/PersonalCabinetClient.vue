<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="sign-in-area ptb-100">
            <div class="container" style="margin-top: 137px;">
                <div class="section-title">
                    <h2>Добро пожаловать в личный кабинет</h2>
                </div>
            </div>
            <div class="sign-in-form">
                <h2 class="text-center">Персональные данные</h2>
                <form id="personalData" @submit.prevent="changeMode">
                    <div class="form-group mt-2">
                        <label for="SecondName">Фамилия</label>
                        <input type="text" class="form-control" :readonly="!redactUserData" id="SecondName"
                               v-model="data_client.SecondName" placeholder="Фамилия">
                    </div>

                    <div class="form-group mt-2">
                        <label for="FirstName">Имя</label>
                        <input type="text" class="form-control" id="FirstName" :readonly="!redactUserData"
                               v-model="data_client.FirstName" placeholder="Имя">
                    </div>

                    <div class="form-group mt-2">
                        <label for="MiddleName">Отчество</label>
                        <input type="text" class="form-control" id="MiddleName" :readonly="!redactUserData"
                               v-model="data_client.MiddleName" placeholder="Отчество">
                    </div>

                    <div class="form-group mt-2">
                        <label for="NumberPhone">Номер телефона</label>
                        <input type="text" class="form-control" id="NumberPhone" :readonly="!redactUserData"
                               v-model="data_client.NumberPhone" placeholder="Номер телефона">
                    </div>

                    <div class="form-group mt-2">
                        <label for="Address">Адрес</label>
                        <input type="text" class="form-control" id="Address" :readonly="!redactUserData"
                               v-model="data_client.Address" placeholder="Адрес">
                    </div>

                    <div class="form-group mt-2">
                        <label for="City">Город</label>
                        <select class="form-control" aria-label="Default select example" :disabled="!redactUserData"
                                v-model="data_client.city_id">
                            <option value="null">Не указано</option>
                            <option :value="city.id" v-for="city in cities">{{ city.Name }}</option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="City">Дата рождения</label>
                        <VueDatePicker :disabled="!redactUserData"
                                       clearable
                                       :locale="locale"
                                       button-validate="Ok"
                                       button-cancel="Cancel"
                                       validate
                                       name="Выберите вашу дату рождения"
                                       placeholder="Выберите ваш день рождения"
                                       fullscreen-mobile
                                       :max-date="this.max_date.toISOString().substr(0, 10)"
                                       v-model="birthday_client"
                                       @onOpen="menu = true"
                                       @onClose="menu = false"
                                       format="DD-MM-YYYY"/>
                    </div>

                    <div class="text-center">
                        <button type="submit" id="submit_button" class="btn default-btn-one">Редактировать</button>
                        <button type="submit" id="submit_button" @click="cancelChanges" class="btn default-btn-one"
                                v-if="redactUserData">Отменить изменения
                        </button>
                    </div>
                </form>
            </div>


        </div>
        <div class="service-area mt-5 mb-5">
            <div class="container">
                <div class="section-title">
                    <h2>Мои заявки в адвокатское бюро</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-12">
                        <template v-if="requests.length>0">
                            <div class="faq-accordion">
                                <ul class="accordion">
                                    <li class="accordion-item" @click="Method1(item.id)" v-bind:class="{'d-none': item.id === null}"
                                        v-for="item in paginatedData">
                                        <a class="accordion-title" href="javascript:void(0)" >
                                            <i class="las la-plus"></i>
                                            Заявка №{{ item.id }}. Тема: {{ item.Topic }}
                                        </a>
                                        <div class="accordion-content" v-if="item.id !== null">
                                            <p>
                                                {{ item.Description }}
                                            </p>
                                            <h6>Статус: <span>{{ item.Status }}</span></h6>
                                            <h6>Дата заявки: <span>{{ new Date(item.DateRequest).getDate() }}.{{
                                                    new Date(item.DateRequest).getMonth()
                                                    + 1
                                                }}.{{ new Date(item.DateRequest).getFullYear() }}</span></h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button id="button_redact" @click="Redact(item)"
                                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                            class="btn default-btn-one w-100">
                                                        Редактировать
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button id="button_delete" @click="RemoveRequest(item.id)"
                                                            class="btn default-btn-one w-100">
                                                        Удалить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <ul class="pagination">
                                <li class="page-item">
                                    <button @click="previousPage"
                                            v-bind:class="{'disabled':currentPage === 1}"
                                            class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </button>
                                </li>
                                <li class="page-item"
                                    v-for="pageNumber in visiblePageNumbers"
                                    v-bind:class="{'active': pageNumber===currentPage}">
                                    <button
                                        :key="pageNumber"
                                        @click="goToPage(pageNumber)"
                                        class="page-link">{{ pageNumber }}
                                    </button>
                                </li>
                                <li class="page-item">
                                    <button @click="nextPage"
                                            v-bind:class="{'disabled':currentPage === totalPages}"
                                            class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </button>
                                </li>
                            </ul>
                            <button id="make_request" @click="Create" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop"
                                    class="btn default-btn-one w-100 mt-5">Создать заявку
                            </button>
                        </template>
                        <div class="d-flex flex-column" v-else>
                            <h2 class="text-center">У вас еще нет заявок. Обращайтесь к нам прямо сейчас</h2>
                            <button id="make_request" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                    class="btn default-btn-one">Создать заявку
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="faq-image">
                            <img src="/photos/request.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>


        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Заявка на обращение в адвокатское бюро</h5>
                    </div>
                    <div class="modal-body">
                        <div class="sign-in-form">
                            <form id="NewRequestByUser">
                                <div class="form-group mt-2">
                                    <label for="SecondName">Тема</label>
                                    <input v-bind:class="{ 'is-invalid': errorsNewRequests.errorsTheme.length >0 }"
                                           type="text" class="form-control" id="Thema"
                                           v-model="new_request.topic" placeholder="Тема обращения">
                                    <div class="invalid-feedback" v-if="errorsNewRequests.errorsTheme.length >0">
                                        <div class="col-lg-12">
                                            <ul>
                                                <li v-for="item in errorsNewRequests.errorsTheme">
                                                    <i class="las la-exclamation-circle"></i>
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="SecondName">Описание проблемы</label>
                                    <textarea
                                        v-bind:class="{ 'is-invalid': errorsNewRequests.errorsDescription.length >0 }"
                                        type="text" class="form-control" id="Description"
                                        v-model="new_request.description" placeholder="Описание проблемы"></textarea>
                                    <div class="invalid-feedback" v-if="errorsNewRequests.errorsDescription.length >0">
                                        <div class="col-lg-12">
                                            <ul>
                                                <li v-for="item in errorsNewRequests.errorsDescription">
                                                    <i class="las la-exclamation-circle"></i>
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="CloseButton" @click="ClearDataNewRequest" class="btn btn-secondary"
                                data-bs-dismiss="modal">Закрыть
                        </button>
                        <button type="button" @click="ValidateAndSendData" class="btn btn-primary">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </fragment>
</template>

<script>
import {VueDatePicker} from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
import Swal from "sweetalert2";

export default {
    name: "PersonalCabinetClient",
    components: {
        VueDatePicker
    },
    data() {
        return {
            mode: "redact",
            id_redacted_request: null,
            new_request: {
                topic: "",
                description: ""
            },
            request_from_server: {
                default: null
            },
            errorsNewRequests: {
                errorsTheme: [],
                errorsDescription: []
            },
            birthday_client: this.data_client.Birthday,
            max_date: new Date(),
            locale: {lang: 'ru'},
            redactUserData: false,
            menu: false,
            copyUserData: null,
            itemsOnPage: 5,
            currentPage: 1,
            maxVisiblePages: 3,
        }
    },
    created() {
        this.max_date.setFullYear(this.max_date.getFullYear() - 18);
        this.request_from_server = this.requests;
    },
    computed: {
        totalPages() {
            return Math.ceil(this.request_from_server.length / this.itemsOnPage);
        },
        paginatedData() {
            const startIndex = (this.currentPage - 1) * this.itemsOnPage;
            const endIndex = startIndex + this.itemsOnPage;
            let part = this.request_from_server.slice(startIndex, endIndex);
            if(part.length <5)
            {
                while (part.length!==5)
                {
                    part.push({id:null, Topic:null});
                }
            }
            return part;
        },
        visiblePageNumbers() {
            const totalPages = this.totalPages;
            const currentPage = this.currentPage;
            const maxVisiblePages = this.maxVisiblePages;

            if (totalPages <= maxVisiblePages) {
                return Array.from({length: totalPages}, (_, index) => index + 1);
            } else {
                const half = Math.floor(maxVisiblePages / 2);
                let start = currentPage - half;
                let end = currentPage + half;

                if (start <= 0) {
                    start = 1;
                    end = maxVisiblePages;
                } else if (end > totalPages) {
                    start = totalPages - maxVisiblePages + 1;
                    end = totalPages;
                }
                return Array.from({length: end - start + 1}, (_, index) => start + index);
            }
        },
    },
    methods: {
        Method1(id) {
            console.log("ТЫК" + id);
        },
        Create() {
            this.mode = "create";
        },
        Redact(item) {
            this.new_request.topic = item.Topic;
            this.new_request.description = item.Description;
            this.mode = "redact";
            this.id_redacted_request = item.id;
        },
        RemoveRequest(id_request) {
            console.log("RemoveRequest");
            console.log(id_request);
            axios.delete("/deleteRequest/" + id_request)
                .then((response) => {
                    if (!response.data.error) {
                        console.log(response);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Заявка была успешно удалена",
                            showConfirmButton: false,
                            timer: 1500
                        })
                        const index = this.request_from_server.findIndex(item => item.id === id_request);
                        if (index !== -1) {
                            this.request_from_server.splice(index, 1);
                            if (this.paginatedData.length === 0 && this.currentPage > 1) {
                                this.currentPage -= 1;
                            }

                        }

                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
                .catch((error) => {
                    console.log("catch_error");
                    console.log(error);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: error.text,
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
        },
        ClearDataNewRequest() {
            this.new_request.topic = "";
            this.new_request.description = "";
            this.id_redacted_request = null;
        },
        ValidateAndSendData() {
            let resultValidate = this.validate();
            if (!resultValidate) {
                if (this.mode === "create") {
                    axios.post("/createRequest", this.new_request)
                        .then((response) => {
                            if (response.data.errors) // есть ошибки валидации
                            {
                                Object.keys(response.data.errors).map((key) => {
                                    response.data.errors[key].map((elem) => {
                                        if (elem === "topic") {
                                            this.errorsNewRequests.errorsTheme.push({
                                                message: elem
                                            })
                                        } else if (elem === "description") {
                                            this.errorsNewRequests.errorsDescription.push({
                                                message: elem
                                            })
                                        }
                                    })
                                });
                            }
                            if (response.data.error) // есть ошибка при сохранении данных
                            {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: "Ваша заявка была успешно отправлена!",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                document.getElementById("CloseButton").click();
                                this.request_from_server.push(response.data.new_request);
                            }
                        })
                        .catch((error) => {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: error.text,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        });
                    // отправить данные
                } else {
                    const redacted_data = {
                        id: this.id_redacted_request,
                        topic: this.new_request.topic,
                        description: this.new_request.description
                    }
                    axios.put("/redactRequest", redacted_data)
                        .then((response) => {
                            if (response.data.errors) // есть ошибки валидации
                            {
                                Object.keys(response.data.errors).map((key) => {
                                    response.data.errors[key].map((elem) => {
                                        if (elem === "topic") {
                                            this.errorsNewRequests.errorsTheme.push({
                                                message: elem
                                            })
                                        } else if (elem === "description") {
                                            this.errorsNewRequests.errorsDescription.push({
                                                message: elem
                                            })
                                        }
                                    })
                                });
                            }
                            if (response.data.error) // произошла ошибка
                            {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: "Заявка была успешно изменена!",
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                const index = this.request_from_server.findIndex(item => item.id === redacted_data.id);
                                if (index !== -1) {
                                    this.request_from_server[index].Topic = redacted_data.topic;
                                    this.request_from_server[index].Description = redacted_data.description;
                                }
                                document.getElementById("CloseButton").click();
                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        })
                        .catch((error) => {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: error.text,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        });
                }
            }
        },
        validate() {
            let hasError = false;
            this.errorsNewRequests.errorsTheme = [];
            this.errorsNewRequests.errorsDescription = [];
            if (this.new_request.topic.length <= 0) {
                hasError = true;
                this.errorsNewRequests.errorsTheme.push({"message": "Введите тему вашего обращения"});
            }
            if (this.new_request.description.length <= 0) {
                hasError = true;
                this.errorsNewRequests.errorsDescription.push({"message": "Опишите вашу проблему"});
            }
            return hasError;
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
        },
        cancelChanges() {
            this.data_client = {...this.copyUserData};
            this.birthday_client = this.copyUserData.Birthday;
            this.redactUserData = false;
            document.getElementById("submit_button").textContent = "Редактировать";
        },
        changeMode() {
            if (this.redactUserData) {
                this.data_client.Birthday = this.birthday_client;
                axios.post("/save_info_client", this.data_client).then((response) => {
                    if (!response.data.error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Ваши данные были успешно сохранены",
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.copyUserData = {...this.data_client};
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }).catch((error) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: error.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            }
            let button_submit = document.getElementById("submit_button");
            this.redactUserData = !this.redactUserData;
            if (this.redactUserData) {
                this.copyUserData = {...this.data_client};
                button_submit.textContent = "Сохранить изменения";
            } else {
                button_submit.textContent = "Редактировать";
            }
        }
    }
    ,
    props: {
        data_client: {
            default:
                null,
        }
        ,
        cities: {
            default:
                null
        }
        ,
        requests: {
            default:
                null
        }
    }
    ,
}
</script>

<style scoped>

</style>
