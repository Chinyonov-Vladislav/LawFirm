<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="sign-in-area ptb-100">
            <div class="container">
                <div class="section-title mt-cabinet-client">
                    <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    <h2>Добро пожаловать в личный кабинет</h2>
                </div>
            </div>
            <div class="sign-in-form ">
                <h2 class="text-center">Персональные данные</h2>
                <form id="personalData" @submit.prevent="changeMode">
                    <div class="form-group mt-2">
                        <label for="SecondName">Фамилия</label>
                        <input type="text" class="form-control" :readonly="!redactUserData" id="SecondName"
                               v-model="data_client.second_name" placeholder="Фамилия">
                    </div>

                    <div class="form-group mt-2">
                        <label for="FirstName">Имя</label>
                        <input type="text" class="form-control" id="FirstName" :readonly="!redactUserData"
                               v-model="data_client.first_name" placeholder="Имя">
                    </div>

                    <div class="form-group mt-2">
                        <label for="MiddleName">Отчество</label>
                        <input type="text" class="form-control" id="MiddleName" :readonly="!redactUserData"
                               v-model="data_client.middle_name" placeholder="Отчество">
                    </div>

                    <div class="form-group mt-2">
                        <label for="NumberPhone">Номер телефона</label>
                        <input type="text" class="form-control" id="NumberPhone" :readonly="!redactUserData"
                               v-model="data_client.number_phone" placeholder="Номер телефона">
                    </div>

                    <div class="form-group mt-2">
                        <label for="Address">Адрес</label>
                        <input type="text" class="form-control" id="Address" :readonly="!redactUserData"
                               v-model="data_client.address" placeholder="Адрес">
                    </div>

                    <div class="form-group mt-2">
                        <label for="City">Город</label>
                        <select class="form-control" aria-label="Default select example" :disabled="!redactUserData"
                                v-model="data_client.city_id">
                            <option value="null">Не указано</option>
                            <option :value="city.id" v-for="city in cities">{{ city.name }}</option>
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
                <div class="d-flex justify-content-center">
                    <h2>Мои заявки в адвокатское бюро</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12
                    order-xl-first order-lg-first order-md-last order-sm-last order-last">
                        <template v-if="requests.length>0">
                            <div class="faq-accordion">
                                <ul class="accordion">
                                    <li class="accordion-item" v-bind:class="{'d-none': item.id === null}"
                                        v-for="item in paginatedDataForRequests">
                                        <a class="accordion-title" href="javascript:void(0)">
                                            <i class="las la-plus"></i>
                                            Заявка №{{ item.id }}. Тема: {{ item.topic }}
                                        </a>
                                        <div class="accordion-content" v-if="item.id !== null">
                                            <p>
                                                {{ item.description }}
                                            </p>
                                            <h6>Статус: <span>{{ item.status }}</span></h6>
                                            <h6>Дата заявки: <span>{{ new Date(item.date_request).getDate() }}.{{
                                                    new Date(item.date_request).getMonth()
                                                    + 1
                                                }}.{{ new Date(item.date_request).getFullYear() }}</span></h6>
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
                            <pagination
                                ref="pagination_requests"
                                @handlePaginateData="handlePaginateData"
                                :array="request_from_server"
                                :maxVisiblePages="maxVisiblePages"
                                :itemsOnPage="itemsOnPageRequests"
                                :namePagination="'requests'"
                            ></pagination>

                            <div class="d-flex flex-column mt-5">
                                <button id="make_request" @click="Create" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"
                                        class="btn default-btn-one">Создать заявку
                                </button>
                            </div>
                        </template>
                        <div class="d-flex flex-column" v-else>
                            <h2 class="text-center">У вас еще нет заявок. Обращайтесь к нам прямо сейчас</h2>
                            <button id="make_request" @click="Create" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop"
                                    class="btn default-btn-one">Создать заявку
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12
                    order-xl-last order-lg-last order-md-first order-sm-first order-first
                    mb-xl-0 mb-lg-0 mb-md-2 mb-sm-2 mb-2">
                        <div class="faq-image">
                            <img src="/photos/request.png" class="img-fluid" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="service-area mt-5 mb-5">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <h2>Мои дела в адвокатской конторе</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12
                    order-xl-first order-lg-first order-md-last order-sm-last order-last">
                        <template v-if="instances_from_server.length>0">
                            <count-elements-table-page
                                @changeCountElementsTable="changeCountElementsTable"
                                :prop_name_table_elements="'instances'"
                            ></count-elements-table-page>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Номер дела</th>
                                        <th scope="col">Тема</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Дата начала</th>
                                        <th scope="col">Дата конца</th>
                                        <th scope="col">Детальнее</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in paginatedDataForInstance">
                                        <th scope="row">{{ item.instance_id }}</th>
                                        <td>{{ item.topic }}</td>
                                        <td>{{ item.status }}</td>
                                        <td>{{ item.start_date }}</td>
                                        <td>{{ item.end_date }}</td>
                                        <td>
                                            <a :href="'/infoInstance/'+item.instance_id" class="btn btn-danger">Детальнее</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <pagination
                                @handlePaginateData="handlePaginateData"
                                :array="instances_from_server"
                                :maxVisiblePages="maxVisiblePages"
                                :itemsOnPage="itemsOnPageInstance"
                                :namePagination="'instances'"
                            ></pagination>
                        </template>
                        <div class="d-flex flex-column" v-else-if="request_from_server.length>0">
                            <h2 class="text-center">Ожидайте пока наши специалисты изучат вашу проблему</h2>

                        </div>
                        <div class="d-flex flex-column" v-else>
                            <h2 class="text-center">Вы еще совершали заявку в наше агенство. Свяжитесь с нами прямо
                                сейчас!</h2>
                            <button id="make_request" @click="Create" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop"
                                    class="btn default-btn-one">Создать заявку
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12
                    order-xl-last order-lg-last order-md-first order-sm-first order-first
                    mb-xl-0 mb-lg-0 mb-md-2 mb-sm-2 mb-2">
                        <div class="faq-image">
                            <img src="/photos/instances.png" class="img-fluid" alt="image">
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
            instances_from_server: null,
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
            birthday_client: {default:null},
            max_date: new Date(),
            locale: {lang: 'ru'},
            redactUserData: false,
            menu: false,
            copyUserData: null,
            itemsOnPageInstance: {default:0},
            itemsOnPageRequests: 5,
            maxVisiblePages: 3,
            paginatedDataForRequests: null,
            paginatedDataForInstance: null,
            breadcrumbs: {default: null}
        }
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
        this.max_date.setFullYear(this.max_date.getFullYear() - 18);
        this.request_from_server = this.requests;
        this.birthday_client = this.data_client.birthday;
        if (this.instances.length === 1) {
            this.instances_from_server = [];
            for (let i = 0; i < 8; i++) {
                this.instances_from_server.push(this.instances[0]);
            }
        } else {
            this.instances_from_server = this.instances;
        }
    },
    methods:
        {
            changeCountElementsTable(data)
            {
                if(data.name_table === 'instances')
                {
                    this.itemsOnPageInstance = data.count;
                }
            },
            handlePaginateData(data) {
                if (data.namePagination === 'instances') {
                    this.paginatedDataForInstance = data.itemsForPage;
                } else if (data.namePagination === 'requests') {
                    this.paginatedDataForRequests = data.itemsForPage;
                }
            },
            Create() {
                this.mode = "create";
            },
            Redact(item) {
                this.new_request.topic = item.topic;
                this.new_request.description = item.description;
                this.mode = "redact";
                this.id_redacted_request = item.id;
            },
            RemoveRequest(id_request) {
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
                                this.$delete(this.request_from_server, index);
                            }
                            const index_in_paginated_requests = this.paginatedDataForRequests.findIndex(item=> item.id===id_request);
                            if(index_in_paginated_requests !==-1)
                            {
                                this.$set(this.paginatedDataForRequests, index, {id: null, topic: null});
                                let count_elements_null = 0;
                                this.paginatedDataForRequests.forEach((item)=>{
                                   if(item.id === null)
                                   {
                                       count_elements_null++;
                                   }
                                });
                                if(count_elements_null === this.itemsOnPageRequests)
                                {
                                    this.$refs.pagination_requests.previousPage();
                                }
                                else {
                                    this.$refs.pagination_requests.goToSamePage();
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
                                }
                                else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: "Ваша заявка была успешно отправлена!",
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    document.getElementById("CloseButton").click();
                                    this.request_from_server.push(response.data.new_request)
                                    let index = this.paginatedDataForRequests.findIndex(x=>x.id===null);
                                    if(index>-1)
                                    {
                                        this.$set(this.paginatedDataForRequests,index, response.data.new_request);
                                    }
                                }
                            })
                            .catch((error) => {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: error.text,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
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
                                if (!response.data.error) // произошла ошибка
                                {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: "Заявка была успешно отредактирована",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    const index = this.request_from_server.findIndex(item => item.id === redacted_data.id);
                                    if (index !== -1) {
                                        this.request_from_server[index].topic = redacted_data.topic;
                                        this.request_from_server[index].description = redacted_data.description;
                                    }
                                    document.getElementById("CloseButton").click();
                                } else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
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

            cancelChanges() {
                this.data_client = {...this.copyUserData};
                this.birthday_client = this.copyUserData.birthday;
                this.redactUserData = false;
                document.getElementById("submit_button").textContent = "Редактировать";
            },
            changeMode() {
                if (this.redactUserData) {
                    this.data_client.birthday = this.birthday_client;
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
        },
    props: {
        data_client: {
            default:
                null,
        },
        instances: {default: null},
        cities: {default: null},
        requests: {default: null},
        prop_breadcrumbs: {default: null}
    },
}
</script>

<style scoped>

</style>
