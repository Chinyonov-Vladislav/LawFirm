<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="services-details-area ptb-100">
            <div class="container pt-5" style="margin-top:50px">
                <div class="row mt-article-title">
                    <div class="col-12 mb-3 d-flex justify-content-center">
                        <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 border border-danger rounded-3 p-3">
                        <div id="carouselExampleControls" class="carousel carousel-dark slide"
                             data-bs-ride="carousel">
                            <div class="carousel-inner" style="height:300px">
                                <template v-if="main_article.images.length>0">
                                    <div class="carousel-item" v-bind:class="{'active':index===0}"
                                         v-for="(image,index) in main_article.images">
                                        <img :src="image" class="d-block w-100" alt="..."
                                             style="object-fit: contain;height: 300px;">
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="carousel-item active">
                                        <img src="/photos/News.jpg" class="d-block w-100" alt="..."
                                             style="object-fit: contain;height: 300px;">
                                    </div>
                                </template>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-xl-0 mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                        <div class="attor-details-item pl-25">
                            <div class="attor-details-left ">
                                <div class="attor-social-details ptb-25">
                                    <h3 class="text-center text-break">{{ main_article.title }}</h3>
                                    <div class="row text-break">
                                        <ul class="row blog-card-text">
                                            <li class="col-6">
                                                <i class="las la-calendar"></i>
                                                {{ moment()(main_article.created_at).format("DD-MM-YYYY") }}
                                            </li>
                                            <li class="col-6 ">
                                                <i class="las la-user-alt"></i>
                                                {{ main_article.lawyer.second_name }} {{
                                                    main_article.lawyer.first_name
                                                }}
                                                {{ main_article.lawyer.middle_name }}
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="row text-center mt-auto" v-if="can_redact">
                                    <div class="col-6 ">
                                        <div class="about-btn">
                                            <a id="redact" @click="copyArticle" data-bs-toggle="modal"
                                               data-bs-target="#staticBackdrop" class="default-btn-one w-100"
                                               role='button'>Редактировать</a>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="about-btn">
                                            <a id="delete" @click="removeNews(main_article.id)"
                                               class="default-btn-one w-100"
                                               style="cursor: pointer">Удалить</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-5 border border-danger rounded-3 p-3">
                        <h6 class="text-center">Текст новости</h6>
                        <hr/>
                        <div style="text-indent:25px" v-html="formattedText"></div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Редактирование новости</h5>
                    </div>
                    <div class="modal-body">
                        <div class="sign-in-form">
                            <form id="article_form" @submit.prevent="validateAndSend">
                                <div class="input-group mb-2 justify-content-center">
                                    <div class="row">
                                        <h6>Изображения статьи</h6>
                                        <div class="col-4" v-for="(image, index) in article_for_redact.images">
                                            <img :src="image" alt="img" style="object-fit: contain; height: 125px"/>
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
                                        <label class="default_btn_redact_delete_image mt-2 text-center"
                                               @input="addNewFiles" role="button">
                                            <i class="lar la-file-image"></i>
                                            Выберите изображения
                                            <input id="imagesLoad" type="file" multiple accept="image/*" hidden>
                                        </label>

                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="TitleArticle">Заголовок статьи</label>
                                        <input type="text" class="form-control" id="TitleArticle"
                                               v-bind:class="{ 'is-invalid': errors.topicArticleError.length >0 }"
                                               v-model="article_for_redact.title" placeholder="Заголовок статьи">
                                        <div class="invalid-feedback" v-if="errors.topicArticleError.length >0">
                                            <div class="col-12 ">
                                                <ul>
                                                    <li v-for="item in errors.topicArticleError">
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
                                                  cols="30"
                                                  v-model="article_for_redact.description"
                                                  v-bind:class="{ 'is-invalid': errors.textArticleError.length >0 }"
                                                  rows="6"
                                                  placeholder="Текст статьи">{{article_for_redact.description}}</textarea>
                                        <div class="invalid-feedback" v-if="errors.textArticleError.length >0">
                                            <div class="col-12 ">
                                                <ul>
                                                    <li v-for="item in errors.textArticleError">
                                                        {{ item.message }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            @click="clearArticleRedact">Отмена
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
import moment from 'moment';
import Swal from "sweetalert2";

export default {
    name: "ArticlePage",
    data() {
        return {
            main_article: {
                default: null
            },
            article_for_redact: {},
            errors: {
                topicArticleError: [],
                textArticleError: []
            },
            new_uploaded_images: [],
            breadcrumbs: {default: null}
        }
    },
    methods: {
        controlElementsFormChangeArticle(boolean_control) {
            var form = document.getElementById("article_form");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].readOnly = boolean_control;
            }
            var buttons_and_input = document.querySelectorAll('#article_form button, #article_form input');
            buttons_and_input.forEach(function (button) {
                button.disabled = boolean_control;
            });
            var tegs_a = document.querySelectorAll("#article_form a");
            tegs_a.forEach((teg_a) => {
                if (teg_a.classList.contains("disabled")) {
                    teg_a.classList.remove("disabled");
                } else {
                    teg_a.classList.add("disabled");
                }
            })
        },
        validateAndSend() {
            this.controlElementsFormChangeArticle(true);
            if (!this.validate()) {
                if (this.new_uploaded_images.length > 0) {
                    this.load_images_to_server();
                } else {
                    this.saveNewArticle([]);
                }

            } else {
                this.controlElementsFormChangeArticle(false);
            }
        },
        load_images_to_server() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            this.new_uploaded_images.forEach((new_upload_image, index) => {
                data.append('files[' + index + ']', new_upload_image.file);
            });
            axios.post("/loadImage", data, config).then((response) => {
                if (response.data.errors) // есть ошибки валидации
                {

                }
                if (response.data.success) {
                    this.showSweetAlert("success", response.data.message).then((result) => {
                        this.saveNewArticle(response.data.paths_to_new_images);
                    });
                } else {
                    this.showSweetAlert("error", response.data.message).then((result) => {
                        this.controlElementsFormChangeArticle(false);
                    });
                }
            }).catch((error) => {
                this.showSweetAlert("error", error.text).then((result) => {
                    this.controlElementsFormChangeArticle(false);
                });
            });
        },
        saveNewArticle(new_paths_images) {
            let data = {
                "article": this.article_for_redact,
                "images_paths": new_paths_images
            }
            console.log("Сохраняем статью");
            axios.put("/changeNews", data).then((response) => {
                if (!response.data.success) {
                    this.showSweetAlert("error", response.data.message).then((result) => {
                        this.controlElementsFormChangeArticle(false);
                    });
                } else {
                    this.showSweetAlert("success", response.data.message).then((result) => {
                        window.location.reload();
                        //window.location.back();
                    });
                }
            }).catch((error) => {
                console.log("Ошибка при сохранении статьи");
                console.log(error);
                this.showSweetAlert("error", error.text).then((result) => {
                    this.controlElementsFormChangeArticle(false);
                });
            });
        },
        imageWasChanged(index) {
            if (event.target.files.length === 1) {
                const file = event.target.files[0];
                const url_for_file = URL.createObjectURL(file);
                const previous_file_url = this.article_for_redact.images[index];
                let changeUploadedFile = false;
                this.new_uploaded_images.forEach((new_file, index) => {
                    if (new_file.url === previous_file_url) {
                        changeUploadedFile = true;
                        this.new_uploaded_images[index] = {"url": url_for_file, "file": file};
                        return;
                    }
                });
                if (!changeUploadedFile) {
                    this.new_uploaded_images.unshift({"url": url_for_file, "file": file});
                }
                this.article_for_redact.images.splice(index, 1, url_for_file);
                const fileBuffer = new DataTransfer();
                event.target.files = fileBuffer.files;
            }
        },
        validate() {
            let hasError = false;
            this.errors.topicArticleError = [];
            this.errors.textArticleError = [];
            if (this.article_for_redact.title.length <= 0) {
                this.errors.topicArticleError.push({"message": "Поле \"Заголовок статьи\" должно быть заполнено"});
                hasError = true;
            }
            if (this.article_for_redact.description.length <= 0) {
                this.errors.textArticleError.push({"message": "Поле \"Текст статьи\" должно быть заполнено"});
                hasError = true;
            }
            return hasError;
        },
        clearArticleRedact() {
            this.article_for_redact = {};
            this.errors.textArticleError = [];
            this.errors.topicArticleError = [];
            this.new_uploaded_images = [];
            document.getElementById("article_form").reset();
        },
        deleteImage(index_image) {
            let deletedImageURL = this.article_for_redact.images.splice(index_image, 1);
            //console.log("DeleteImage");
            //console.log("URL image for delete");
            //console.log(deletedImageURL);
            //console.log(this.new_uploaded_images);
            this.new_uploaded_images.forEach((file, index) => {
                if (file.url === deletedImageURL[0]) {
                    this.new_uploaded_images.splice(index, 1);
                }
            });
            //console.log(this.new_uploaded_images);
        },
        addNewFiles(event) {
            Object.keys(event.target.files).forEach((i) => {
                const file = event.target.files[i];
                const url_for_file = URL.createObjectURL(file);
                this.new_uploaded_images.push({"url": url_for_file, "file": file});
                this.article_for_redact.images.push(url_for_file);
            });
            const fileBuffer = new DataTransfer();
            event.target.files = fileBuffer.files;
        },
        copyArticle() {
            this.article_for_redact = JSON.parse(JSON.stringify(this.article));
        },
        moment() {
            return moment
        },
        sendInfoUser(message) {
            console.log("ArticlePage");
            console.log(message);
        },
        removeNews(id) {
            const deleteButton = document.getElementById("delete");
            const redactButton = document.getElementById("redact");
            deleteButton.classList.add("disabled");
            redactButton.classList.add("disabled");
            axios.delete("/deleteNews/" + id).then(
                (response) => {
                    if (response.data.success) {
                        this.showSweetAlert('success', response.data.message).then(
                            (() => {
                                //window.location.href = "/blog";
                                //window.history.back();
                                //window.location.reload();
                                window.location.href = document.referrer;
                            })
                        );
                    } else {
                        this.showSweetAlert('error', response.data.message);
                        deleteButton.classList.remove("disabled");
                        redactButton.classList.remove("disabled");
                    }
                }
            ).then((error) => {
                this.showSweetAlert("error", error.text)
            });
        },
        showSweetAlert(icon, title) {
            return Swal.fire({
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 1500
            })
        }
    },
    computed: {
        formattedText() {
            const paragraphs = this.article.description.split("\r\n");
            // Заключение каждого абзаца в <p> и добавление к форматированному тексту
            return paragraphs.map(paragraph => `<h6>${paragraph}</h6>`).join("");
        }
    },
    props: {
        article: {default: {}},
        can_redact: {default: false},
        prop_breadcrumbs: {default: null}
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
        this.main_article = JSON.parse(JSON.stringify(this.article));
        console.log(this.article);
    }
}
</script>

<style scoped>
a.disabled {
    pointer-events: none; /* делаем ссылку некликабельной */
    cursor: default; /* устанавливаем курсор в виде стрелки */
    color: #999; /* цвет текста для нективной ссылки */
}
</style>
