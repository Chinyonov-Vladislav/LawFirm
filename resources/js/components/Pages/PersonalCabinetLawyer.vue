<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header :new_username="new_user_name"></my-header>
        <div class="sign-in-area ptb-100">
            <div class="container">
                <div class="section-title mt-cabinet-lawyer">
                    <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    <h2>Добро пожаловать в личный кабинет</h2>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="sign-in-form h-100 d-flex flex-column">
                            <h2 class="text-center">Персональные данные</h2>
                            <form id="personalData" @submit.prevent="changeMode">
                                <div class="form-group mt-2">
                                    <label for="SecondName">Фамилия</label>
                                    <input type="text"
                                           v-bind:class="{ 'is-invalid': errors.second_name_errors.length >0 }"
                                           class="form-control" :readonly="!redactLawyerData" id="SecondName"
                                           v-model="local_lawyer_data.second_name" placeholder="Фамилия">
                                </div>

                                <div class="invalid-feedback" v-if="errors.second_name_errors.length >0">
                                    <div class="col-lg-12">
                                        <ul>
                                            <li v-for="item in errors.second_name_errors">
                                                <i class="las la-exclamation-circle"></i>
                                                {{ item.message }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="FirstName">Имя</label>
                                    <input type="text"
                                           v-bind:class="{ 'is-invalid': errors.first_name_errors.length >0 }"
                                           class="form-control" :readonly="!redactLawyerData" id="FirstName"
                                           v-model="local_lawyer_data.first_name" placeholder="Имя">
                                </div>
                                <div class="invalid-feedback" v-if="errors.first_name_errors.length >0">
                                    <div class="col-lg-12">
                                        <ul>
                                            <li v-for="item in errors.first_name_errors">
                                                <i class="las la-exclamation-circle"></i>
                                                {{ item.message }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="form-group mt-2">
                                    <label for="MiddleName">Отчество</label>
                                    <input type="text"
                                           v-bind:class="{ 'is-invalid': errors.middle_name_errors.length >0 }"
                                           class="form-control" :readonly="!redactLawyerData" id="MiddleName"
                                           v-model="local_lawyer_data.middle_name" placeholder="Отчество">
                                </div>

                                <div class="invalid-feedback" v-if="errors.middle_name_errors.length >0">
                                    <div class="col-lg-12">
                                        <ul>
                                            <li v-for="item in errors.middle_name_errors">
                                                <i class="las la-exclamation-circle"></i>
                                                {{ item.message }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="hire_date">Дата принятия на работу</label>
                                    <VueDatePicker disabled
                                                   id="hire_date"
                                                   :locale="locale"
                                                   button-validate="Ok"
                                                   button-cancel="Cancel"
                                                   validate
                                                   name="Дата принятия на работу"
                                                   placeholder="Дата принятия на работу"
                                                   fullscreen-mobile
                                                   v-model="local_lawyer_data.hire_date"
                                                   @onOpen="menu = true"
                                                   @onClose="menu = false"
                                                   format="DD-MM-YYYY"/>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="NumberPhone">Номер телефона</label>
                                    <input type="text"
                                           v-bind:class="{ 'is-invalid': errors.number_phone_errors.length >0 }"
                                           class="form-control" :readonly="!redactLawyerData" id="NumberPhone"
                                           v-model="local_lawyer_data.number_phone" placeholder="Номер телефона">
                                </div>
                                <div class="invalid-feedback" v-if="errors.number_phone_errors.length >0">
                                    <div class="col-lg-12">
                                        <ul>
                                            <li v-for="item in errors.number_phone_errors">
                                                <i class="las la-exclamation-circle"></i>
                                                {{ item.message }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="University">Университет</label>
                                    <input type="text" class="form-control" :readonly="true" id="University"
                                           v-model="local_lawyer_data.university.name" placeholder="Университет">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="LevelEducation">Уровень образования</label>
                                    <input type="text" class="form-control" :readonly="true" id="LevelEducation"
                                           v-model="local_lawyer_data.level_education" placeholder="LevelEducation">
                                </div>

                                <div class="text-center row">
                                    <div class="col-12">
                                        <button type="submit" id="submit_button" class="btn default-btn-one">Редактировать
                                        </button>
                                    </div>
                                   <div class="col-12 mt-2">
                                       <button id="cancel_button" @click="cancelChanges" class="btn default-btn-one"
                                               v-if="redactLawyerData">Отменить изменения
                                       </button>
                                   </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="sign-in-form h-100 d-flex flex-column" id="imagesLawyer">
                            <div class="row text-center">
                                <h2>Фотографии
                                    <button type="button" class="btn btn-secondary" data-toggle="tooltip"
                                            data-placement="top" :title="title_tip">
                                        <i class="las la-exclamation-circle"></i>
                                    </button>
                                </h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 text-center mt-2" v-for="(image,index) in imagesLawyer">
                                    <img
                                        @click="showImageFullScreen(image.url)"
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                        :src="image.url" alt="img" style="object-fit: contain; height: 125px"/>
                                    <div class="row mt-1">
                                        <div class="about-btn col-6">
                                            <label class="default_btn_redact_delete_image w-100 text-center"
                                                   @change="imageWasChanged(index)"
                                                   role="button">
                                                <i class="las la-pen"></i>
                                                <input id="changeImage" type="file" accept="image/*" hidden>
                                            </label>
                                        </div>
                                        <div class="about-btn col-6">
                                            <a id="deleteImage" @click="deleteImage(index)"
                                               class="default_btn_redact_delete_image w-100"
                                               role='button' style="text-align:center">
                                                <i class="las la-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="default_btn_redact_delete_image mt-2 text-center w-100"
                                           @input="addNewFiles"
                                           role="button">
                                        <i class="lar la-file-image"></i>
                                        Выберите изображения
                                        <input id="imagesLoad" type="file" multiple accept="image/*" hidden>
                                    </label>
                                    <template v-if="wasChanges">
                                        <div class="row mt-2">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="about-btn text-center">
                                                    <a id="saveChangesImages" @click="saveImagesChanges"
                                                       class="default-btn-one w-100"
                                                       role='button'>Сохранить изменения</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-xl-0 mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                                                <div class="about-btn text-center">
                                                    <a id="saveChangesImages" @click="cancelImagesChanges"
                                                       class="default-btn-one w-100"
                                                       role='button'>Отменить изменения</a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="my_nav_vertical_list flex-column nav-pills col-lg-3 col-sm-12" id="v-pills-tab"
                         role="tablist"
                         aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-service-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-service" type="button" role="tab"
                                aria-controls="v-pills-service"
                                aria-selected="true">Услуги
                        </button>
                        <button class="nav-link" id="v-pills-cases-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-cases" type="button" role="tab"
                                aria-controls="v-pills-cases" aria-selected="false">Дела
                        </button>
                        <button class="nav-link" id="v-pills-graphics-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-graphics" type="button" role="tab"
                                aria-controls="v-pills-graphics" aria-selected="false">Графики
                        </button>
                        <button class="nav-link" id="v-pills-news-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-news" type="button" role="tab"
                                aria-controls="v-pills-news" aria-selected="false">Мои новости
                        </button>
                        <button class="nav-link" id="v-pills-service-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-actions" type="button" role="tab"
                                aria-controls="v-pills-actions"
                                aria-selected="true">Скачать файлы
                        </button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-settings" type="button" role="tab"
                                aria-controls="v-pills-settings" aria-selected="false">Настройки
                        </button>
                    </div>
                    <div class="tab-content col-lg-9 col-sm-12" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-service" role="tabpanel"
                             aria-labelledby="v-pills-service-tab">
                            <template v-if="local_lawyer_data.services.length>0">
                                <count-elements-table-page
                                    @changeCountElementsTable="changeCountElementsTable"
                                    :prop_name_table_elements="'services'"
                                ></count-elements-table-page>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">Номер услуги</th>
                                            <th scope="col">Название услуги</th>
                                            <th scope="col">Специализация</th>
                                            <th scope="col">Стоимость</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(service,index) in paginatedServices">
                                            <th scope="row">{{ index + 1 }}</th>
                                            <td>{{ service.name }}</td>
                                            <td>{{ service.specialization.name }}</td>
                                            <td>{{ service.pivot.cost }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <pagination
                                    @handlePaginateData="handlePaginateData"
                                    :array="local_lawyer_data.services"
                                    :maxVisiblePages="maxVisiblePages"
                                    :itemsOnPage="itemsOnPageService"
                                    :namePagination="'services'"
                                ></pagination>
                            </template>
                            <div class="row" v-else>
                                <div class="col-12">
                                    <h3 class="text-center">Вы не предоставляете никаких услуг</h3>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-cases" role="tabpanel"
                             aria-labelledby="v-pills-cases-tab">
                            <template v-if="local_instances_lawyer.length>0">
                                <count-elements-table-page
                                    @changeCountElementsTable="changeCountElementsTable"
                                    :prop_name_table_elements="'instances'"
                                ></count-elements-table-page>
                                <div class="table-responsive overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">№ дела</th>
                                            <th scope="col">Тема дела</th>
                                            <th scope="col">Клиент</th>
                                            <th scope="col">Статус</th>
                                            <th scope="col">Дата начала</th>
                                            <th scope="col">Дата конца</th>
                                            <th scope="col">Подробнее</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="instance in paginatedInstances">
                                            <tr>
                                                <td>{{ instance.id }}</td>
                                                <td>{{ instance.request.topic }}</td>
                                                <td>{{ instance.request.client.full_name_client }}</td>
                                                <td>
                                                    <p v-bind:class="(instance.status === 'В процессе')?'my_badge negative_badge':
                                                        (instance.status === 'Выиграно')?'my_badge success_badge': 'my_badge failure_badge'">
                                                        {{ instance.status }}</p>
                                                </td>
                                                <td v-if="instance.start_date!==null">
                                                    {{ formatDate(instance.start_date) }}
                                                </td>
                                                <td v-else></td>
                                                <td v-if="instance.end_date!==null">
                                                    {{ formatDate(instance.end_date) }}
                                                </td>
                                                <td v-else></td>
                                                <td>
                                                    <button id="showDetailsCase" @click="showDetails(instance.id)"
                                                            class="btn default-btn-one">Подробнее
                                                    </button>
                                                </td>
                                            </tr>

                                            <tr :id="'DetailCase№'+instance.id" class="d-none"
                                                v-if="instance.case_services.length>0">
                                                <td colspan="7">
                                                    <div class="ms-5 d-flex justify-content-center">
                                                        <h6>Предоставляемые услуги</h6>
                                                    </div>
                                                    <div class="table-responsive ms-5 overflow-x-auto">
                                                        <table class="table">
                                                            <thead>
                                                            <tr class="table-danger">
                                                                <th scope="col">Наименование услуги</th>
                                                                <th scope="col">Специализация</th>
                                                                <th scope="col">Стоимость</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="info in instance.case_services">
                                                                <td>
                                                                    {{ info.service_lawyer.service.name }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        info.service_lawyer.service.specialization.name
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{ info.service_lawyer.cost }}
                                                                </td>
                                                            </tr>
                                                            <tr class="text-end">
                                                                <td colspan="7">
                                                                    <h3>Общий заработок:
                                                                        {{ getCommonCost(instance.case_services) }}
                                                                        руб.</h3>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr :id="'ProceedingCase№'+instance.id" class="d-none"
                                                v-if="instance.case_proceeding.length>0">
                                                <td colspan="7">
                                                    <div class="ms-5 d-flex justify-content-center">
                                                        <h6>Судебные заседания</h6>
                                                    </div>

                                                    <div class="table-responsive ms-5 overflow-x-auto">
                                                        <table class="table">
                                                            <thead>
                                                            <tr class="table-danger">
                                                                <th scope="col">№ судебного заседания</th>
                                                                <th scope="col">Судья</th>
                                                                <th scope="col">Должность судьи</th>
                                                                <th scope="col">Этап суда</th>
                                                                <th scope="col">Суд</th>
                                                                <th scope="col">Адрес суда</th>
                                                                <th scope="col">Город</th>
                                                                <th scope="col">Дата начала</th>
                                                                <th scope="col">Дата конца</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="(info_case_proceeding, index) in instance.case_proceeding">
                                                                <td>
                                                                    {{ index + 1 }}
                                                                </td>
                                                                <td>
                                                                    {{ info_case_proceeding.judge.second_name }}
                                                                    {{ info_case_proceeding.judge.first_name }}
                                                                    {{ info_case_proceeding.judge.middle_name }}
                                                                </td>
                                                                <td>
                                                                    {{ info_case_proceeding.judge.position.name }}
                                                                </td>
                                                                <td>
                                                                    {{ info_case_proceeding.court_stage.name }}
                                                                </td>
                                                                <td>
                                                                    {{ info_case_proceeding.judge.court.name_court }}
                                                                </td>
                                                                <td>
                                                                    {{ info_case_proceeding.judge.court.address }}
                                                                </td>
                                                                <td>
                                                                    {{ info_case_proceeding.judge.court.city.name }}
                                                                </td>
                                                                <td>
                                                                    {{ formatDate(info_case_proceeding.start_date) }}
                                                                </td>
                                                                <td>
                                                                    {{ formatDate(info_case_proceeding.finish_date) }}
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr :id="'OutcomesCase№'+instance.id" class="d-none"
                                                v-if="instance.types_outcome.length>0">
                                                <td colspan="7">
                                                    <div class="ms-5 d-flex justify-content-center">
                                                        <h6>Приговоры суда</h6>
                                                    </div>
                                                    <div class="table-responsive ms-5 overflow-x-auto">
                                                        <table class="table">
                                                            <thead>
                                                            <tr class="table-danger">
                                                                <th scope="col">№ приговора</th>
                                                                <th scope="col">Приговор</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="(outcome,index) in instance.types_outcome">
                                                                <td>
                                                                    {{ index + 1 }}
                                                                </td>
                                                                <td>
                                                                    {{ outcome.name }}
                                                                </td>
                                                                <td v-if="outcome.pivot.count_years !== null">
                                                                    Количество лет: {{ outcome.pivot.count_years }}
                                                                </td>
                                                                <td v-else-if="outcome.pivot.monetary_penalty !== null">
                                                                    Количество денег:
                                                                    {{ formatCost(outcome.pivot.monetary_penalty) }}
                                                                </td>
                                                                <td v-else></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                                <pagination
                                    @handlePaginateData="handlePaginateData"
                                    :array="local_instances_lawyer"
                                    :maxVisiblePages="maxVisiblePages"
                                    :itemsOnPage="itemsOnPageInstance"
                                    :namePagination="'instances'"
                                ></pagination>
                            </template>
                            <template v-else>
                                <h3>У вас еще не было дел!</h3>
                            </template>
                        </div>
                        <div class="tab-pane fade" id="v-pills-graphics" role="tabpanel"
                             aria-labelledby="v-pills-graphics-tab">
                            <div class="row mx-2">
                                <div class="col-12 mt-sm-2 mt-md-2 mt-2 border border-danger rounded-3 p-3">
                                    <chart-pie v-if="instances_counts.length>0"
                                               :dataChart="chartData1"
                                               :title="'Количество дел по статусу'"
                                    ></chart-pie>
                                    <h4 v-else class="text-center">У вас еще не было дел</h4>
                                </div>
                                <div class="col-12 mt-sm-2 mt-md-2 mt-2 border border-danger rounded-3 p-3">
                                    <doughnut-chart
                                        v-if="moneys_by_cases.length>0"
                                        :dataChart="chartData2"
                                        :title="'Количество заработанных денег по делам'"
                                    ></doughnut-chart>
                                    <h4 v-else class="text-center">У вас еще нет дел со статусом "Выиграно"</h4>
                                </div>
                                <div class="col-12 mt-sm-2 mt-md-2 mt-2 border border-danger rounded-3 p-3">
                                    <bar-chart
                                        v-if="count_cases_by_rating.length>0"
                                        :dataChart="chartData3"
                                        :title="'Количество дел по оценкам пользователей'"
                                    ></bar-chart>
                                    <h4 v-else class="text-center">У вас еще нет дел, которым пользователи выставили
                                        оценку</h4>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-news" role="tabpanel"
                             aria-labelledby="v-pills-news-tab">
                            <div class="row text-center mb-4">
                                <h3>Мои новости</h3>
                                <a id="publish_news"
                                   data-bs-toggle="modal"
                                   data-bs-target="#staticBackdropNews"
                                   class="default-btn-one w-100"
                                   v-if="news.length>0"
                                   role='button'>Опубликовать новость</a>
                            </div>
                            <div class="row text-center" v-if="news.length===0">
                                <h3>Вы еще не публиковали новости</h3>
                                <div class="about-btn text-center">
                                    <a id="publish_news"
                                       data-bs-toggle="modal"
                                       data-bs-target="#staticBackdropNews"
                                       class="default-btn-one w-100"
                                       role='button'>Опубликовать новость</a>
                                </div>
                            </div>
                            <div class="row" v-else>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-2" v-for="item in paginatedNews">
                                    <div class="blog-card h-100 d-flex flex-column">
                                        <img :src="item.images[0]" alt="Image" class="card-img-top my_image"
                                             v-if="item.images.length>0">
                                        <img src="/photos/News.jpg" alt="Image" class="card-img-top my_image" v-else>
                                        <div class="blog-card-text d-flex flex-column">
                                            <h3><a href="#">{{ item.title }}</a></h3>
                                            <ul>
                                                <li>
                                                    <i class="las la-calendar"></i>
                                                    {{ formatDate(item.created_at) }}
                                                </li>
                                            </ul>
                                            <p class="short_text">{{ item.description }}</p>
                                        </div>
                                        <div class="blog-card-text mt-auto">
                                            <a :href="'/news/'+item.id" class="read-more">
                                                Читать полностью <i class="las la-angle-double-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <pagination
                                    @handlePaginateData="handlePaginateData"
                                    :array="news"
                                    :maxVisiblePages="maxVisiblePages"
                                    :itemsOnPage="countNewsOnOnePage"
                                    :namePagination="'news'"
                                ></pagination>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-actions" role="tabpanel"
                             aria-labelledby="v-pills-actions-tab">
                            <div class="row border border-danger rounded-3 p-3">
                                <div class="responsive-table">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">№</th>
                                            <th scope="col">Данные</th>
                                            <th scope="col">Скачать в формате excel</th>
                                            <th scope="col">Скачать в формате docx</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Данные об услугах</td>
                                            <td>
                                                <a id="downloadButton" :href="'/excel/export-specializations-lawyer/'+current_user_id" class="btn default-btn-one w-100">Скачать <i class="las la-download"></i></a>
                                            </td>
                                            <td>
                                                <a id="downloadButton" :href="'/docx/export-services-lawyer/'+current_user_id" class="btn default-btn-one w-100">Скачать <i class="las la-download"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Данные о делах</td>
                                            <td>
                                                <a id="downloadButton" :href="'/excel/export-instances-lawyer/'+current_user_id" class="btn default-btn-one w-100">Скачать <i class="las la-download"></i></a>
                                            </td>
                                            <td>
                                                <a id="downloadButton" :href="'/docx/export-instances-lawyer/'+current_user_id" class="btn default-btn-one w-100">Скачать <i class="las la-download"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade border border-danger rounded-3 margin_top_2rem" id="v-pills-settings"
                             role="tabpanel"
                             aria-labelledby="v-pills-settings-tab">
                            <div class="row" style="padding: 20px">
                                <div id="setting_group" class="col-12">
                                    <div class="form-group mt-2">
                                        <label for="Username">Имя пользователя</label>
                                        <input type="text"
                                               v-bind:class="{ 'is-invalid': errors.username_errors.length >0 }"
                                               class="form-control" id="Username"
                                               v-model="local_lawyer_data.user.name" placeholder="Имя пользователя">
                                    </div>

                                    <div class="invalid-feedback" v-if="errors.username_errors.length >0">
                                        <div class="col-lg-12">
                                            <ul>
                                                <li v-for="item in errors.second_name_errors">
                                                    <i class="las la-exclamation-circle"></i>
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-decoration-underline mt-3">Смена пароля</h6>
                                <div class="form-group mt-2">
                                    <label for="Password">Пароль</label>
                                    <div class="input-group ">
                                        <input v-model="password_info.password"
                                               readonly onfocus="this.removeAttribute('readonly')"
                                               v-bind:class="{ 'is-invalid': errors.password_errors.length >0 }"
                                               type="password" class="form-control"
                                               id="Password" placeholder="Введите пароль">
                                        <span class="input-group-text bg-transparent" id="inputPasswordEye"
                                              @click="showHidePassword"><i id="eye_password"
                                                                           class="lar la-eye"></i></span>
                                        <div class="invalid-feedback" v-if="errors.password_errors.length >0">
                                            <div class="col-lg-12">
                                                <ul>
                                                    <li v-for="item in errors.password_errors">
                                                        <i class="las la-exclamation-circle"></i>
                                                        {{ item.message }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="СonfirmPassword">Подтверждение пароля</label>
                                    <div class="input-group">
                                        <input v-model="password_info.password_confirm"
                                               v-bind:class="{ 'is-invalid': errors.confirm_password_errors.length >0 }"
                                               type="password"
                                               readonly onfocus="this.removeAttribute('readonly')"
                                               class="form-control"
                                               id="СonfirmPassword"
                                               placeholder="Подтверждение пароля">
                                        <span class="input-group-text bg-transparent" id="inputConfirmPasswordEye"
                                              @click="showHidePassword"><i id="eye_confirm_password"
                                                                           class="lar la-eye"></i></span>
                                        <div class="invalid-feedback" v-if="errors.confirm_password_errors.length >0">
                                            <div class="col-lg-12">
                                                <ul>
                                                    <li v-for="item in errors.confirm_password_errors">
                                                        <i class="las la-exclamation-circle"></i>
                                                        {{ item.message }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <button @click="saveChanges" id="saveSettings" class="btn default-btn-one">Сохранить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Изображение</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center">
                        <img class="img-fluid" :src="imageShowing">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="staticBackdropNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Публикация новости</h5>
                    </div>
                    <div class="modal-body">
                        <div class="sign-in-form">
                            <form id="publish_news_form" @submit.prevent="validateNewsAndSave">
                                <div class="input-group mb-2 justify-content-center">
                                    <div class="row">
                                        <h6>Изображения статьи</h6>
                                        <div class="col-4" v-for="(image, index) in news_for_publish.images">
                                            <img :src="image.url" alt="img" style="object-fit: contain; height: 125px"/>
                                            <div class="row mt-1">
                                                <div class="about-btn col-6">
                                                    <label class="default_btn_redact_delete_image w-100 text-center"
                                                           @change="imagePublishedNewsWasChanged(index)"
                                                           role="button">
                                                        <i class="las la-pen"></i>
                                                        <input id="changeImage" type="file" accept="image/*" hidden>
                                                    </label>
                                                </div>
                                                <div class="about-btn col-6">
                                                    <a id="deleteImage"
                                                       @click="deleteImagePublishedImage(index)"
                                                       class="default_btn_redact_delete_image w-100"
                                                       role='button' style="text-align:center">
                                                        <i class="las la-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <label class="default_btn_redact_delete_image mt-2 text-center"
                                               @input="addNewImagesFilesToPublishedArticle"
                                               role="button">
                                            <i class="lar la-file-image"></i>
                                            Выберите изображения
                                            <input id="imagesLoad" type="file" multiple accept="image/*" hidden>
                                        </label>

                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="TitleArticle">Заголовок статьи</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="news_for_publish.article"
                                               v-bind:class="{ 'is-invalid': errorsPublishedNews.errorsArticle.length >0 }"
                                               id="TitleArticle"
                                               placeholder="Заголовок статьи">
                                        <div class="invalid-feedback" v-if="errorsPublishedNews.errorsArticle.length >0">
                                            <div class="col-12 ">
                                                <ul>
                                                    <li v-for="item in errorsPublishedNews.errorsArticle">
                                                        {{ item.message }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="TextArticle">Текст статьи</label>
                                        <textarea name="message"
                                                  id="TextArticle"
                                                  class="form-control"
                                                  v-model="news_for_publish.description"
                                                  v-bind:class="{ 'is-invalid': errorsPublishedNews.errorsDescription.length >0 }"
                                                  cols="30"
                                                  rows="6"
                                                  placeholder="Текст статьи"></textarea>
                                        <div class="invalid-feedback" v-if="errorsPublishedNews.errorsDescription.length >0">
                                            <div class="col-12 ">
                                                <ul>
                                                    <li v-for="item in errorsPublishedNews.errorsDescription">
                                                        {{ item.message }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeModalPublishNews" class="btn btn-secondary" @click="ClearDataPublishedNews" data-bs-dismiss="modal">Отмена
                                    </button>
                                    <button type="submit" class="btn btn-danger">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </fragment>
</template>

<script>
import _ from 'lodash';
import {VueDatePicker} from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
import Swal from "sweetalert2";
import moment from 'moment';

export default {
    name: "PersonalCabinetLawyer",
    data() {
        return {
            current_user_id: 0,
            chartData1: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: []
                    }
                ]
            },
            chartData2: {
                labels: [],
                datasets: [
                    {
                        data: [],
                        backgroundColor: []
                    }
                ]
            },
            chartData3: {
                labels: [],
                datasets: [
                    {
                        label: 'Bar Chart',
                        data: [],
                        backgroundColor: []
                    }
                ]
            },
            count_cases_by_rating: {default: null},
            moneys_by_cases: {default: null},
            instances_counts: {default: null},
            breadcrumbs: {default: null},
            title_tip: "Первая фотография будет использоваться в качестве изображения профиля",
            redactLawyerData: false,
            copyLawyerData: null,
            local_lawyer_data: null,
            locale: {lang: 'ru'},
            menu: false,
            wasChanges: false,
            imagesLawyer: [],
            imageShowing: null,
            new_user_name: null,
            errors: {
                second_name_errors: [],
                first_name_errors: [],
                middle_name_errors: [],
                number_phone_errors: [],
                username_errors: [],
                password_errors: [],
                confirm_password_errors: []
            },
            password_info: {
                password: "",
                password_confirm: "",
            },
            paginatedServices: [],
            paginatedInstances: [],
            paginatedNews: [],
            countNewsOnOnePage: 2,
            maxVisiblePages: 3,
            local_instances_lawyer: {default: null},
            itemsOnPageService: {default:0},
            itemsOnPageInstance: {default:0},
            news:[],
            news_for_publish:{
                article: "",
                description: "",
                images:  []
            },
            errorsPublishedNews:{
                errorsArticle: [],
                errorsDescription: []
            }
        }
    },
    methods: {
        load_images_to_server()
        {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            this.news_for_publish.images.forEach((new_upload_image, index)=>{
                data.append('files[' + index + ']',new_upload_image.file );
            });
            axios.post("/loadImage", data, config).then((response)=>{
                if(response.data.errors) // есть ошибки валидации
                {
                    this.showSwal("error", "Произошла ошибка при загрузке изображений на сервер").then(()=>{
                        this.controlElementsFormPublishArticle(false);
                    })
                }
                if(response.data.success)
                {
                    this.showSwal("success", response.data.message).then(()=>{
                        this.saveNewArticle(response.data.paths_to_new_images);
                    });
                }
                else
                {
                    this.showSwal("error",response.data.message).then(()=>{
                        this.controlElementsFormPublishArticle(false);
                    });
                }
            }).catch((error)=>{
                this.showSwal("error", error.text).then((result)=>{
                    this.controlElementsFormPublishArticle(false);
                });
            });
        },
        saveNewArticle(array_images_path_on_server)
        {
            let data = {
                "images_paths" :array_images_path_on_server,
                "title": this.news_for_publish.article,
                "description": this.news_for_publish.description
            };
            axios.post("/createNews", data)
                .then((response)=>{
                    if(response.data.errors)
                    {
                        Object.keys(response.data.errors).map((key)=>{
                            response.data.errors[key].map((elem)=> {
                                if(key==="title")
                                {
                                    this.errorsPublishedNews.errorsArticle.push({"message": elem});
                                }
                                else if(key==="description")
                                {
                                    this.errorsPublishedNews.errorsDescription.push({"message": elem});
                                }
                            });
                        });
                        this.controlElementsFormPublishArticle(false);
                    }
                    else
                    {
                        if(response.data.success)
                        {
                            this.showSwal("success", response.data.message).then(()=>{
                                this.news.push(response.data.new_article);
                                if(this.paginatedNews.length < this.countNewsOnOnePage)
                                {
                                    this.paginatedNews.push(response.data.new_article);
                                }
                                this.controlElementsFormPublishArticle(false);
                                let button_close_modal_add_new_article = document.getElementById("closeModalPublishNews");
                                console.log("Сука");
                                button_close_modal_add_new_article.click();
                            });
                        }
                        else
                        {
                            this.showSwal("error", response.data.message).then(()=>{
                                this.controlElementsFormPublishArticle(false);
                            });
                        }
                    }
                })
                .catch((error)=>{
                    this.showSwal("error", error.text).then(()=>{
                        this.controlElementsFormPublishArticle(false);
                    });
                })
        },
        controlElementsFormPublishArticle(boolean_control)
        {
            let form = document.getElementById("publish_news_form");
            let elements = form.elements;
            let i = 0, len = elements.length;
            for (; i < len; ++i) {
                elements[i].readOnly = boolean_control;
            }
            let buttons_and_input = document.querySelectorAll('#publish_news_form button, #publish_news_form input');
            buttons_and_input.forEach(function (button) {
                button.disabled = boolean_control;
            });
            let tegs_a = document.querySelectorAll("#publish_news_form a");
            tegs_a.forEach((teg_a)=>{
                if (teg_a.classList.contains("disabled"))
                {
                    teg_a.classList.remove("disabled");
                }
                else
                {
                    teg_a.classList.add("disabled");
                }
            })
        },
        validate()
        {
            let hasError =false;
            if(this.news_for_publish.article.length<=0)
            {
                this.errorsPublishedNews.errorsArticle.push({"message":"Вы не заполнили заголовок статьи"});
                hasError = true;
            }
            if(this.news_for_publish.description.length <= 0)
            {
                this.errorsPublishedNews.errorsDescription.push({"message":"Вы не заполнили текст статьи"});
                hasError = true;
            }
            return hasError;
        },
        validateNewsAndSave()
        {
            this.errorsPublishedNews.errorsArticle = [];
            this.errorsPublishedNews.errorsDescription = [];
            this.controlElementsFormPublishArticle(true);
            if(!this.validate())
            {
                if(this.news_for_publish.images.length>0)
                {
                    this.load_images_to_server();
                    // загрузить изображения на сервер
                }
                else
                {
                    this.saveNewArticle([]);
                    // загрузить данные о статье на сервер
                }
            }
            else
            {
                this.controlElementsFormPublishArticle(false);
            }
        },

        deleteImagePublishedImage(index_image)
        {
            this.news_for_publish.images.splice(index_image, 1);
        },
        imagePublishedNewsWasChanged(index_image)
        {
            if(event.target.files.length === 1) {
                this.news_for_publish.images.splice(index_image, 1, {
                    "url": URL.createObjectURL(event.target.files[0]),
                    "file": event.target.files[0]
                });
                const fileBuffer = new DataTransfer();
                event.target.files = fileBuffer.files;
            }
        },
        ClearDataPublishedNews()
        {
            this.news_for_publish.article="";
            this.news_for_publish.description ="";
            this.news_for_publish.images=[];
        },
        addNewImagesFilesToPublishedArticle(event) {
            Object.keys(event.target.files).forEach((i) => {
                const file = event.target.files[i];
                const url_for_file = URL.createObjectURL(file);
                this.news_for_publish.images.push({"url": url_for_file, "file":file});
            });
            const fileBuffer = new DataTransfer();
            event.target.files = fileBuffer.files;
        },
        changeCountElementsTable(data)
        {
            if(data.name_table === 'services')
            {
                this.itemsOnPageService = data.count;
            }
            else if(data.name_table === 'instances')
            {
                this.itemsOnPageInstance = data.count;
            }
        },
        getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        formatCost(cost) {
            if (cost.endsWith(".00")) {
                return cost.slice(0, -3);
            }
            return cost;
        },
        getCommonCost(services_in_instance) {
            let cost = 0;
            services_in_instance.forEach((case_services) => {
                try {
                    cost += parseFloat(case_services.service_lawyer.cost);
                } catch (ex) {
                    console.log(ex);
                }
            });
            return cost;
        },
        showDetails(instance_id) {
            let array = [document.getElementById("ProceedingCase№" + instance_id), document.getElementById("DetailCase№" + instance_id), document.getElementById("OutcomesCase№" + instance_id)]
            array.forEach((item) => {
                if (item !== null) {
                    if (item.classList.contains("d-none")) {
                        item.classList.remove("d-none");
                        item.classList.add("appearance");
                        //detailsBlock.classList.add("row");
                    } else {
                        //detailsBlock.classList.remove("row");
                        item.classList.add("d-none");
                        item.classList.remove("appearance");
                    }
                }
            })
        },
        formatDate(str_date) {
            return moment(str_date).format("DD/MM/YYYY");
        },
        handlePaginateData(data) {
            if (data.namePagination === 'services') {
                this.paginatedServices = data.itemsForPage;
            } else if (data.namePagination === 'instances') {
                this.paginatedInstances = data.itemsForPage;
            }
            else if(data.namePagination === 'news')
            {
                this.paginatedNews = data.itemsForPage;
            }
        },
        validateChanges() {
            this.errors.password_errors = [];
            this.errors.confirm_password_errors = [];
            let hasError = false;
            if (this.local_lawyer_data.user.name.length === 0) {
                this.errors.username_errors.push({"message": "Поле \"Имя пользователя\" не заполнено"})
                hasError = true;
            }
            if (this.password_info.password.length <= 0) {
                this.errors.password_errors.push({"message": "Поле \"Пароль\" не заполнено"})
                hasError = true;
            }
            if (this.password_info.password_confirm.length <= 0) {
                this.errors.confirm_password_errors.push({"message": "Поле \"Подтверждение пароля\" не заполнено"})
                hasError = true;
            }
            if (this.password_info.password.length > 0 && this.password_info.password_confirm.length > 0) {
                if (this.password_info.password !== this.password_info.password_confirm) {
                    this.errors.password_errors.push({"message": "Значение в поле \"Пароль\" не совпадает со значением в поле \"Подтверждение пароля\""});
                    this.errors.confirm_password_errors.push({"message": "Значение в поле \"Подтверждение пароля\" не совпадает со значением в поле \"Пароль\""});
                    hasError = true;
                } else {
                    if (this.password_info.password.length < 8) {
                        this.errors.password_errors.push({"message": "Минимальная длина пароля должна составлять 8 символов"});
                        hasError = true;
                    }
                }
            }
            return hasError;
        },
        controlButtonSaveChanges(bool_control) {
            let button = document.getElementById("saveSettings");
            let inputs = document.querySelectorAll('#setting_group input');
            if (button !== null) {
                button.disabled = bool_control;
            }
            if (Array.isArray(inputs)) {
                inputs.forEach(function (button) {
                    button.disabled = bool_control;
                });
            }
        },
        saveChangesToDatabase() {
            let data = {
                "id_user": this.local_lawyer_data.user.id,
                "username": this.local_lawyer_data.user.name,
                "password": this.password_info.password,
                "confirm_password": this.password_info.password_confirm
            }
            axios.post("/updateDataUser", data).then((response) => {
                if (response.data.errors) {
                    Object.keys(response.data.errors).forEach((key) => {
                        if (key === "username") {
                            response.data.errors[key].forEach((error) => {
                                this.errors.username_errors.push({"message": error});
                            })
                        } else if (key === "password") {
                            response.data.errors[key].forEach((error) => {
                                this.errors.password_errors.push({"message": error});
                            })
                        } else if (key === "confirm_password") {
                            response.data.errors[key].forEach((error) => {
                                this.errors.confirm_password_errors.push({"message": error});
                            })
                        }
                    });
                    this.controlButtonSaveChanges(false);
                } else {
                    if (response.data.success) {
                        this.showSwal("success", response.data.message).then(() => {
                            this.controlButtonSaveChanges(false);
                            this.password_info.password = "";
                            this.password_info.password_confirm = "";
                            this.new_user_name = this.local_lawyer_data.user.name;
                        });
                    } else {
                        this.showSwal("error", response.data.message).then(() => {
                            this.controlButtonSaveChanges(false);
                        });
                    }
                }

            }).catch((error) => {
                this.showSwal("error", error.text).then(() => {
                    this.controlButtonSaveChanges(false);
                })
            });
        },
        saveChanges() {
            this.controlButtonSaveChanges(true);
            let hasError = this.validateChanges();
            if (!hasError) {
                this.saveChangesToDatabase();
            } else {
                this.controlButtonSaveChanges(false);
            }
        },
        showHidePassword(event) {
            let clickedElement = event.target;
            let idClickedElement = clickedElement.id;

            let passwordInputId, eyeElement;

            if (idClickedElement === "inputPasswordEye" || idClickedElement === "eye_password") {
                passwordInputId = "Password";
                eyeElement = idClickedElement === "eye_password" ? event.target : event.target.querySelector('i');
            } else if (idClickedElement === "inputConfirmPasswordEye" || idClickedElement === "eye_confirm_password") {
                passwordInputId = "СonfirmPassword";
                eyeElement = idClickedElement === "eye_confirm_password" ? event.target : event.target.querySelector('i');
            }

            let elementPasswordInput = document.getElementById(passwordInputId);

            if (elementPasswordInput.type === "password") {
                elementPasswordInput.type = "text";
                eyeElement.classList.remove("la-eye");
                eyeElement.classList.add("la-eye-slash");
            } else {
                elementPasswordInput.type = "password";
                eyeElement.classList.remove("la-eye-slash");
                eyeElement.classList.add("la-eye");
            }
        },
        controlElementsChangeImages(boolean_control) {
            var buttons_and_input = document.querySelectorAll('#imagesLawyer button, #imagesLawyer input');
            buttons_and_input.forEach(function (button) {
                button.disabled = boolean_control;
            });
            var tegs_a = document.querySelectorAll("#imagesLawyer a");
            tegs_a.forEach((teg_a) => {
                if (teg_a.classList.contains("disabled")) {
                    teg_a.classList.remove("disabled");
                } else {
                    teg_a.classList.add("disabled");
                }
            })
        },

        showImageFullScreen(imageURL) {
            this.imageShowing = imageURL;
        },
        saveNewImagesToDatabase(paths_images) {
            let paths_images_to_save = [];
            let index_new_image = 0;
            this.imagesLawyer.forEach((image) => {
                if (image.file === null) {
                    paths_images_to_save.push(image.url)
                } else {
                    paths_images_to_save.push(paths_images[index_new_image]);
                    index_new_image += 1;
                }
            });
            let data = {
                "id_lawyer": this.local_lawyer_data.id,
                "images": paths_images_to_save
            };
            axios.put("/updateImageLawyer", data)
                .then((response) => {
                    if (response.data.errors) {
                        this.showSwal("error", response.data.errors).then(() => {
                            this.controlElementsChangeImages(false);
                        });
                    }
                    if (response.data.success) {
                        this.showSwal("success", response.data.message).then(() => {
                                console.log("Успешное обновление фотографий!");
                                this.local_lawyer_data.images = paths_images_to_save;
                                this.imagesLawyer = [];
                                this.copyImagesToImageslawyer();
                                this.controlElementsChangeImages(false);
                                this.wasChanges = false;
                            }
                        );
                    } else {
                        this.showSwal("error", response.data.message).then(() => {
                                this.controlElementsChangeImages(false);
                            }
                        );
                    }
                })
                .catch((error) => {
                    this.showSwal('error', error.text).then(() => {
                        this.controlElementsChangeImages(false);
                    });
                });
        },
        addNewFiles(event) {
            if (event.target.files.length > 0) {
                Object.keys(event.target.files).forEach((i) => {
                    const file = event.target.files[i];
                    const url_for_file = URL.createObjectURL(file);
                    this.imagesLawyer.push({"url": url_for_file, "file": file});
                });
                const fileBuffer = new DataTransfer();
                event.target.files = fileBuffer.files;
                this.wasChanges = true;
            }
        },

        saveImagesChanges() {
            this.controlElementsChangeImages(true);
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            let count_new_images = 0;
            this.imagesLawyer.forEach((new_upload_image, index) => {
                if (new_upload_image.file !== null) {
                    data.append('files[' + index + ']', new_upload_image.file);
                    count_new_images += 1;
                }
            });
            if (count_new_images > 0) {
                axios.post("/loadImage", data, config).then((response) => {
                    if (response.data.errors) // есть ошибки валидации
                    {
                        this.showSwal("error", "Ошибка валидации данных").then(() => {
                            this.controlElementsChangeImages(false);
                        });
                    }
                    if (response.data.success) {
                        this.showSwal("success", response.data.message).then(() => {
                            this.saveNewImagesToDatabase(response.data.paths_to_new_images);
                        });
                    } else {
                        console.log(response);
                        this.showSwal("error", response.data.message).then(() => {
                            this.controlElementsChangeImages(false);
                        });
                    }
                }).catch((error) => {
                    this.showSwal("error", error.text).then(() => {
                        console.log("ТУТ4");
                        this.controlElementsChangeImages(false);
                    });
                });
            } else {
                this.saveNewImagesToDatabase([]);
            }
        },
        cancelImagesChanges() {
            this.imagesLawyer = [];
            this.local_lawyer_data.images.forEach((image_url) => {
                this.imagesLawyer.push({"url": image_url, "file": null});
            });
            this.wasChanges = false;
        },
        imageWasChanged(index) {
            if (event.target.files.length === 1) {
                this.imagesLawyer.splice(index, 1, {
                    "url": URL.createObjectURL(event.target.files[0]),
                    "file": event.target.files[0]
                });
                const fileBuffer = new DataTransfer();
                event.target.files = fileBuffer.files;
                this.wasChanges = true;
            }
        },
        deleteImage(index) {
            this.imagesLawyer.splice(index, 1);
            this.wasChanges = true;
        },
        controlButtons(boolean_disabled) {
            let submit_button = document.getElementById("submit_button");
            let cancel_button = document.getElementById("cancel_button");
            if (submit_button !== null) {
                submit_button.disabled = boolean_disabled;
            }
            if (cancel_button !== null) {
                cancel_button.disabled = boolean_disabled;
            }
        },
        validateNewData() {
            let hasError = false;
            Object.keys(this.errors).forEach((key) => {
                this.errors[key] = [];
            })
            if (this.local_lawyer_data.second_name.length <= 0) {
                hasError = true;
                this.errors.second_name_errors.push({"message": "Поле \"Фамилия\" должно быть заполнено"})
            }
            if (this.local_lawyer_data.first_name.length <= 0) {
                hasError = true;
                this.errors.first_name_errors.push({"message": "Поле \"Имя\" должно быть заполнено"})
            }
            if (this.local_lawyer_data.middle_name.length <= 0) {
                hasError = true;
                this.errors.middle_name_errors.push({"message": "Поле \"Отчество\" должно быть заполнено"})
            }
            if (this.local_lawyer_data.number_phone.length <= 0) {
                hasError = true;
                this.errors.number_phone_errors.push({"message": "Поле \"Номер телефона\" должно быть заполнено"})
            }
            return hasError;
        },
        changeMode() {
            if (this.redactLawyerData) {
                this.controlButtons(true);
                let hasError = this.validateNewData();
                if (!hasError) {
                    let new_data_lawyer = {
                        id_lawyer: this.local_lawyer_data.id,
                        second_name: this.local_lawyer_data.second_name,
                        first_name: this.local_lawyer_data.first_name,
                        middle_name: this.local_lawyer_data.middle_name,
                        number_phone: this.local_lawyer_data.number_phone
                    };
                    axios.put("/saveNewInfoLawyer", new_data_lawyer).then((response) => {
                        this.controlButtons(false);
                        if (response.data.errors) {
                            Object.keys(response.data.errors).forEach((key) => {
                                response.data.errors[key].forEach((text_error) => {
                                    if (key === "second_name") {
                                        this.errors.second_name_errors.push({"message": text_error});
                                    } else if (key === "first_name") {
                                        this.errors.first_name_errors.push({"message": text_error});
                                    } else if (key === "middle_name") {
                                        this.errors.middle_name_errors.push({"message": text_error});
                                    } else if (key === "number_phone") {
                                        this.errors.number_phone_errors.push({"message": text_error});
                                    }
                                })
                            })
                        }
                        if (response.data.success) {
                            this.showSwal("success", response.data.message).then((result) => {
                                let button_submit = document.getElementById("submit_button");
                                button_submit.textContent = "Редактировать";
                                this.redactLawyerData = false;
                                this.copyLawyerData = _.cloneDeep(this.local_lawyer_data);
                            });
                        } else {
                            this.showSwal("error", response.data.message)
                        }
                    }).catch((error) => {
                        this.showSwal('error', error.text);
                    });
                }
            } else {
                let button_submit = document.getElementById("submit_button");
                this.redactLawyerData = !this.redactLawyerData;
                if (this.redactLawyerData) {
                    this.copyLawyerData = _.cloneDeep(this.local_lawyer_data);
                    button_submit.textContent = "Сохранить изменения";
                } else {
                    button_submit.textContent = "Редактировать";
                }
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
        cancelChanges() {
            this.local_lawyer_data = _.cloneDeep(this.copyLawyerData);
            this.redactLawyerData = false;
            document.getElementById("submit_button").textContent = "Редактировать";
        },
        copyImagesToImageslawyer() {
            if (this.local_lawyer_data.images !== null) {
                this.local_lawyer_data.images.forEach((image_url) => {
                    this.imagesLawyer.push({"url": image_url, "file": null});
                });
            }
        },
        getCurrentUserIdFromRoute()
        {
            const currentUrl = window.location.href;
            const urlParts = currentUrl.split('/');
            const userId = urlParts[urlParts.length - 1];
            this.current_user_id = parseInt(userId);
        }
    },
    props: {
        lawyer_data: {
            default: null
        },
        instances_lawyer: {default: null},
        prop_instances_counts: {default: null},
        prop_breadcrumbs: {default: null},
        prop_moneys_by_cases: {default: null},
        prop_count_cases_by_rating: {default: null},
        prop_news : {default:null}
    },

    created() {
        this.news = this.prop_news;
        console.log("Новости");
        console.log(this.news);
        this.count_cases_by_rating = this.prop_count_cases_by_rating;
        this.moneys_by_cases = this.prop_moneys_by_cases;
        this.instances_counts = this.prop_instances_counts;
        this.breadcrumbs = this.prop_breadcrumbs;
        this.local_lawyer_data = _.cloneDeep(this.lawyer_data);
        this.local_instances_lawyer = this.instances_lawyer;
        this.copyImagesToImageslawyer();
        this.instances_counts.forEach((item) => {
            this.chartData1.labels.push(item.status);
            this.chartData1.datasets[0].data.push(item.count);
            this.chartData1.datasets[0].backgroundColor.push(this.getRandomColor());
        });
        this.moneys_by_cases.forEach((item) => {
            this.chartData2.labels.push("Дело №" + item.instance_id + " - " + item.topic);
            this.chartData2.datasets[0].data.push(item.total_cost);
            this.chartData2.datasets[0].backgroundColor.push(this.getRandomColor());
        });
        this.count_cases_by_rating.forEach((item) => {
            if (item.rating !== null) {
                this.chartData3.labels.push("Оценка " + item.rating);
            } else {
                this.chartData3.labels.push("Без оценки от пользователей");
            }
            this.chartData3.datasets[0].data.push(item.count);
            this.chartData3.datasets[0].backgroundColor.push(this.getRandomColor());
        });
        this.getCurrentUserIdFromRoute();
    }
}
</script>

<style scoped>

/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;

    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
}

.overflow_table_scroll {
    overflow-x: auto;
}

.appearance {
    opacity: 0;
    animation: ani 2.5s forwards;
}


@keyframes ani {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>
