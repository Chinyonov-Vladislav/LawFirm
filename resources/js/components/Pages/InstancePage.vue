<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="attorney-details pt-100 pb-70">
            <div class="container faq-area">
                <div class="row">
                    <div class="section-title text-center mt-instance-title">
                        <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                        <h2>Информация о деле №<span>{{ local_info_case.basic_info_instance.id_instance }}</span></h2>
                    </div>
                    <div class="col-lg-5">
                        <div class="attor-details-item">
                            <div class="attor-details-left">
                                <div class="attor-social-details ptb-25">
                                    <h3 class="text-center">Краткая сводка о деле</h3>
                                    <div class="row text-break">
                                        <div class="col-5">
                                            <h3>Тема</h3>
                                        </div>
                                        <div class="col-7">
                                            <p>{{ local_info_case.basic_info_instance.topic }}</p>
                                        </div>
                                        <div class="col-5">
                                            <h3>Описание</h3>
                                        </div>
                                        <div class="col-7">
                                            <p>{{ local_info_case.basic_info_instance.description }}</p>
                                        </div>
                                        <div class="col-5">
                                            <h3>Статус</h3>
                                        </div>
                                        <div class="col-7">
                                            <p>{{ local_info_case.basic_info_instance.status }}</p>
                                        </div>
                                        <div class="col-5">
                                            <h3>Дата начала</h3>
                                        </div>
                                        <div class="col-7">
                                            <p>{{ local_info_case.basic_info_instance.start_date }}</p>
                                        </div>

                                        <template v-if="local_info_case.basic_info_instance.end_date!==null">
                                            <div class="col-5">
                                                <h3>Дата окончания</h3>
                                            </div>
                                            <div class="col-7">
                                                <p>{{ local_info_case.basic_info_instance.end_date }}</p>
                                            </div>
                                        </template>
                                        <template v-if="common_cost>0">
                                            <div class="col-5">
                                                <h3>Общая стоимость услуг</h3>
                                            </div>
                                            <div class="col-7">
                                                <p>{{ common_cost }}</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>
                            <div class="attor-details-item" v-if="local_info_case.services_case.length>0">
                                <div class="attor-details-left">
                                    <div class="attor-social-details ptb-25">
                                        <chart-pie :dataChart="chartData"
                                                   :title="'Диаграмма затрат на услуги адвокатов'"
                                        ></chart-pie>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="attor-details-item">
                            <div class="attor-details-right">
                                <div class="attor-details-things" v-if="local_info_case.services_case.length>0">
                                    <h3>Услуги адвокатов в рамках дела</h3>
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <count-elements-table-page
                                                @changeCountElementsTable="changeCountElementsTable"
                                                :prop_name_table_elements="'services_case'"
                                            ></count-elements-table-page>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Номер услуги</th>
                                                        <th scope="col">Название услуги</th>
                                                        <th scope="col">Адвокат</th>
                                                        <th scope="col">Стоимость</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(item, index) in paginatedDataCaseServiceCase">
                                                        <th scope="row">{{ index + 1 }}</th>
                                                        <td>{{ item.service_name }}</td>
                                                        <td>{{ item.second_name }} {{ item.first_name }}
                                                            {{ item.middle_name }}
                                                        </td>
                                                        <td>{{ item.cost }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <pagination
                                                class="mt-2"
                                                @handlePaginateData="handlePaginateData"
                                                :array="local_info_case.services_case"
                                                :maxVisiblePages="maxVisiblePages"
                                                :itemsOnPage="itemsOnPageServiceCase"
                                                :namePagination="'services_case'"
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                                <div class="attor-details-things" v-if="local_info_case.case_procceding.length>0">
                                    <h3>Судебные заседания</h3>
                                    <count-elements-table-page
                                        @changeCountElementsTable="changeCountElementsTable"
                                        :prop_name_table_elements="'case_procceding'"
                                    ></count-elements-table-page>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">№</th>
                                                <th scope="col">Этап судебного разбирательства</th>
                                                <th scope="col">Судья</th>
                                                <th scope="col">Должность</th>
                                                <th scope="col">Суд</th>
                                                <th scope="col">Город</th>
                                                <th scope="col">Дата начала</th>
                                                <th scope="col">Дата окончания</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in paginatedDataCaseProceedings">
                                                <th scope="row">{{ index + 1 }}</th>
                                                <td>{{ item.name_court_stage }}</td>
                                                <td>{{ item.second_name }} {{ item.first_name }} {{
                                                        item.middle_name
                                                    }}
                                                </td>
                                                <td>{{ item.position_name }}</td>
                                                <td>{{ item.court_name }}</td>
                                                <td>{{ item.name_city }}</td>
                                                <td>{{ item.start_date }}</td>
                                                <td>{{ item.finish_date }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <pagination
                                        class="mt-2"
                                        @handlePaginateData="handlePaginateData"
                                        :array="local_info_case.case_procceding"
                                        :maxVisiblePages="maxVisiblePages"
                                        :itemsOnPage="itemsOnPageCaseProcceding"
                                        :namePagination="'case_procceding'"
                                    ></pagination>
                                </div>
                            </div>
                        </div>


                        <div class="attor-details-things mb-2" v-if="local_info_case.outcomes.length>0">
                            <h3>Приговоры</h3>
                            <count-elements-table-page
                                @changeCountElementsTable="changeCountElementsTable"
                                :prop_name_table_elements="'outcomes'"
                            ></count-elements-table-page>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">№ приговора</th>
                                        <th scope="col">Тип приговора</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in paginatedDateOutcomes">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{ item.type_outcome_name }}</td>
                                        <td v-if="item.count_years !== null">Количество лет: {{item.count_years}}</td>
                                        <td v-else-if="item.monetary_penalty !== null">Количество денег: {{item.monetary_penalty}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <pagination
                                class="mt-2"
                                @handlePaginateData="handlePaginateData"
                                :array="local_info_case.outcomes"
                                :maxVisiblePages="maxVisiblePages"
                                :itemsOnPage="itemsOnPageOutcomes"
                                :namePagination="'outcomes'"
                            ></pagination>
                        </div>


                        <div class="row border border-danger rounded-3 mx-2 mx-sm-0 mx-md-0 mx-lg-0 mx-xl-0"
                             id="feedback_fields"
                             style="padding: 20px"
                             v-if="local_info_case.basic_info_instance.status !== 'В процессе'">
                            <div class="col-12">
                                <h3>Отзыв о процессе дела</h3>
                            </div>
                            <div class="col-12">
                                <div class="form-group mt-2">
                                    <label for="feedback_text">Текст отзыва</label>
                                    <textarea
                                        rows="3"
                                        v-bind:class="{ 'is-invalid': errors.feedback_errors.length >0 }"
                                        class="form-control" id="feedback_text"
                                        autocomplete="off"
                                        v-model="local_info_case.basic_info_instance.feedback"
                                        placeholder="Отзыв пользователя"></textarea>
                                    <div class="invalid-feedback" v-if="errors.feedback_errors.length >0">
                                        <div class="col-lg-12">
                                            <ul>
                                                <li v-for="item in errors.feedback_errors">
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <h3>Рейтинг</h3>
                                <star-rating
                                    id="star_rating"
                                    autocomplete="off"
                                    v-bind:class="{ 'is-invalid': errors.rating_errors.length >0 }"
                                    v-model="local_info_case.basic_info_instance.rating"
                                    text-class="rating-text"></star-rating>
                                <div class="invalid-feedback" v-if="errors.rating_errors.length >0">
                                    <div class="col-lg-12">
                                        <ul>
                                            <li v-for="item in errors.rating_errors">
                                                {{ item.message }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <button @click="saveFeedback" id="saveFeedback"
                                            class="btn default-btn-one w-100">Сохранить
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button @click="removeFeedback" id="RemoveFeedback"
                                            class="btn default-btn-one w-100">Удалить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>

</template>

<script>
import StarRating from 'vue-star-rating'
import Swal from "sweetalert2";
import _ from 'lodash';

export default {
    name: "InstancePage",
    components: {
        StarRating
    },
    data() {

        return {
            local_info_case: {default: null},
            itemsOnPage: 5,
            itemsOnPageServiceCase:{default:0},
            itemsOnPageCaseProcceding:{default:0},
            itemsOnPageOutcomes: {default:0},
            maxVisiblePages: 3,
            paginatedDataCaseProceedings: null,
            paginatedDataCaseServiceCase: null,
            paginatedDateOutcomes: null,
            common_cost: 0,
            errors: {
                feedback_errors: [],
                rating_errors: []
            },
            chartData: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: []
                    }
                ]
            },
            breadcrumbs: {default: null}
        }
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
        this.local_info_case = _.cloneDeep(this.info_case);
        let services = [];
        this.local_info_case.services_case.forEach((element) => {
            let hasService = false;
            let index_service = 0;
            for (; index_service < services.length; index_service++) {
                if (services[index_service].id === element.id_service) {
                    hasService = true;
                    break;
                }
            }
            if (!hasService) {
                services.push({
                    'id': element.id,
                    'name': element.service_name,
                    'cost': parseInt(element.cost)
                });
            } else {
                services[index_service].cost += parseInt(element.cost);
            }
            this.common_cost += parseInt(element.cost)
        });
        services.forEach((service) => {
            this.chartData.labels.push(service.name);
            this.chartData.datasets[0].data.push(service.cost);
            this.chartData.datasets[0].backgroundColor.push(this.getRandomColor());
        });
    },
    props: {
        info_case: {default: null},
        prop_breadcrumbs: {default: null}
    },
    methods: {
        changeCountElementsTable(data)
        {
            if(data.name_table === 'services_case')
            {
                this.itemsOnPageServiceCase = data.count;
            }
            else if(data.name_table==='case_procceding')
            {
                this.itemsOnPageCaseProcceding = data.count;
            }
            else if(data.name_table === 'outcomes')
            {
                this.itemsOnPageOutcomes = data.count;
            }
        },
        controlButtons(control_boolean) {
            let text_review = document.getElementById("feedback_text");
            let stars = document.getElementById("star_rating");
            if (text_review !== null) {
                text_review.readonly = control_boolean;
            }
            if (stars !== null) {
                stars.disabled = control_boolean;
            }
            let buttons = document.querySelectorAll('#feedback_fields buttons');
            buttons.forEach((button) => {
                button.disabled = control_boolean;
            });
        },
        removeFeedback() {
            axios.delete("/deleteFeedback/" + this.local_info_case.basic_info_instance.id_instance)
                .then((response) => {
                    if (!response.data.success) {
                        this.showSwal("error", response.data.message).then(() => {
                            this.controlButtons(false);
                        });
                    } else {
                        this.showSwal("success", response.data.message).then(() => {
                            console.log("Успех при удалении");
                            this.controlButtons(false);
                            this.local_info_case.basic_info_instance.feedback = null;
                            this.local_info_case.basic_info_instance.rating = null;
                            console.log("Конец");
                        });
                    }
                })
                .catch((error) => {
                    this.showSwal("error", error.text).then(() => {
                        this.controlButtons(false);
                    });
                })
        },
        validate() {
            let hasErrors = false;
            this.errors.feedback_errors = [];
            if (this.local_info_case.basic_info_instance.feedback === null) {
                this.errors.feedback_errors.push({"message": "Вы не заполнили поле \"Текст отзыва\" "});
                hasErrors = true;
            } else {
                if (this.local_info_case.basic_info_instance.feedback.length <= 0) {
                    this.errors.feedback_errors.push({"message": "Вы не заполнили поле \"Текст отзыва\" "});
                    hasErrors = true;
                }
            }
            return hasErrors;
        },
        saveFeedback() {
            this.controlButtons(true);
            if (!this.validate()) {
                let data = {
                    "instance_id": this.local_info_case.basic_info_instance.id_instance,
                    "feedback_text": this.local_info_case.basic_info_instance.feedback,
                    "rating": this.local_info_case.basic_info_instance.rating
                };
                axios.put("/saveFeedback", data)
                    .then((response) => {
                        console.log("response");
                        console.log(response);
                        if (response.data.errors) {
                            Object.keys(response.data.errors).map((key) => {
                                response.data.errors[key].map((elem) => {
                                    if (key === "feedback_text") {
                                        this.errors.feedback_errors.push({"message": elem});
                                    }
                                })
                            })
                        } else {
                            if (response.data.success) {
                                this.showSwal("success", response.data.message).then(() => {
                                    this.controlButtons(false);
                                });
                            } else {
                                this.showSwal("error", response.data.message).then(() => {
                                    this.controlButtons(false);
                                });
                            }
                        }
                    })
                    .catch((error) => {
                        console.log("error");
                        console.log(error);
                        this.showSwal("error", error.text).then(() => {
                            this.controlButtons(false);
                        });
                    });
            } else {
                this.controlButtons(false);
            }
        },
        showSwal(icon, title_text) {
            return Swal.fire({
                position: 'top-end',
                icon: icon,
                title: title_text,
                showConfirmButton: false,
                timer: 1500
            })
        },
        getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        handlePaginateData(data) {
            if (data.namePagination === 'case_procceding') {
                this.paginatedDataCaseProceedings = data.itemsForPage;
            } else if (data.namePagination === "services_case") {
                this.paginatedDataCaseServiceCase = data.itemsForPage;
            }
            else if(data.namePagination === 'outcomes')
            {
                this.paginatedDateOutcomes = data.itemsForPage;
            }
        },
    },
    mounted() {
        console.log("infoCaseFromServer");
        console.log(this.local_info_case);
    }
}
</script>

<style scoped>

</style>
