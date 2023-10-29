<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="faq-area my_padding_top_bottom">
            <div class="container">
                <div class="section-title">
                    <h2>Ответы на часто задаваемые вопросы<br>Юридические консультации от экспертов</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-12">
                        <div class="faq-accordion">
                            <ul class="accordion">
                                <li class="accordion-item" v-for="question in questions">
                                    <a class="accordion-title" href="javascript:void(0)">
                                        <i class="las la-plus"></i>
                                        {{ question.question }}
                                    </a>
                                    <p class="accordion-content">
                                        {{ question.answer }}
                                    </p>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12 mt-5">
                        <div class="faq-image">
                            <img src="/photos/faq.png" alt="image">
                        </div>
                    </div>
                </div>


                <div class="contact-form" style="position:relative">
                    <div class="container_loader" v-if="loader">
                        <div class="spinner-grow text-danger loader" role="status">
                            <span class="visually-hidden">Loading...</span>
                            <p>Отправка сообщения</p>
                        </div>
                    </div>
                    <form id="contactForm" @submit.prevent="ValidateAndSendEmail">

                        <div class="section-title">
                            <h2>Задайте свой вопрос</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                           v-bind:class="{ 'is-invalid': formErrors.NameErrors.length >0 }"
                                           placeholder="Your Name" v-model="formData.name">
                                    <i class="las la-user"></i>
                                    <div class="invalid-feedback" v-if="formErrors.NameErrors.length >0">
                                        <div class="col-md-6">
                                            <ul>
                                                <li v-for="item in formErrors.NameErrors">
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="emailAddress" class="form-control" id="email"
                                           v-bind:class="{ 'is-invalid': formErrors.EmailAddressErrors.length >0 }"
                                           placeholder="Email Address" v-model="formData.emailAddress">
                                    <i class="las la-envelope"></i>
                                    <div class="invalid-feedback" v-if="formErrors.EmailAddressErrors.length >0">
                                        <div class="col-md-6">
                                            <ul>
                                                <li v-for="item in formErrors.EmailAddressErrors">
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" id="Phone"
                                           v-bind:class="{ 'is-invalid': formErrors.PhoneErrors.length >0 }"
                                           placeholder="Your Phone" v-model="formData.phone">
                                    <i class="las la-phone"></i>
                                    <div class="invalid-feedback" v-if="formErrors.PhoneErrors.length >0">
                                        <div class="col-md-6">
                                            <ul>
                                                <li v-for="item in formErrors.PhoneErrors">
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" id="subject"
                                           v-bind:class="{ 'is-invalid': formErrors.SubjectErrors.length >0 }"
                                           placeholder="Your subject" v-model="formData.subject">
                                    <i class="las la-id-card"></i>
                                    <div class="invalid-feedback" v-if="formErrors.SubjectErrors.length >0">
                                        <div class="col-md-6">
                                            <ul>
                                                <li v-for="item in formErrors.SubjectErrors">
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control" cols="30" rows="6"
                                              v-bind:class="{ 'is-invalid': formErrors.MessageErrors.length >0 }"
                                              placeholder="Write your message..." v-model="formData.message"></textarea>
                                    <i class="las la-sms"></i>
                                    <div class="invalid-feedback" v-if="formErrors.MessageErrors.length >0">
                                        <div class="col-lg-12 col-md-12">
                                            <ul>
                                                <li v-for="item in formErrors.MessageErrors">
                                                    {{ item.message }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="default-btn-one">Отправить сообщение</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End FAQ Area -->
        <footer></footer>
    </fragment>
</template>

<script>
import emailjs from 'emailjs-com';
import Swal from "sweetalert2";

export default {
    name: "FAQPage",
    created() {
        console.log("created");
        console.log(this.formErrors["NameErrors"]);
    },
    methods: {
        ControlElementOnForm(bool_block) {
            const form = document.getElementById("contactForm");
            const elements = form.elements;
            let i = 0, len = elements.length;
            for (; i < len; ++i) {
                elements[i].readOnly = bool_block;
            }
        },
        ValidateAndSendEmail() {
            this.ControlElementOnForm(true);
            let hasError = this.validate()
            if (!hasError) {

                this.sendEmail();

            } else {
                this.ControlElementOnForm(false);
            }
        },
        sendEmail() {
            this.loader = true;
            var form = document.getElementById("contactForm");
            emailjs.sendForm('service_8qcwcnx', 'template_28waqqe',
                form, "fT5U8cgehPbwVNKdX").then(
                (result) => {
                    this.loader = false;
                    Object.keys(this.formData).map((key) => {
                        this.formData[key] = [];
                    });
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: this.successText,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.ControlElementOnForm(false);
                },
                (error) => {
                    this.loader = false;
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: error.text,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.ControlElementOnForm(false);
                });
        },
        validate() {
            let hasError = false;
            Object.keys(this.formErrors).map((key) => {
                this.formErrors[key] = [];
            });
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            const telephoneRegex = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
            if (!emailRegex.test(this.formData.emailAddress)) {
                this.formErrors.EmailAddressErrors.push({"message": 'Введите корректный email'})
                hasError = true;
            }
            if (this.formData.name === "") {
                this.formErrors.NameErrors.push({"message": 'Введите ваше имя'});
                hasError = true;
            }
            if (this.formData.subject === "") {
                this.formErrors.SubjectErrors.push({"message": 'Введите тему сообщения'});
                hasError = true;
            }
            if (this.formData.message === "") {
                this.formErrors.MessageErrors.push({"message": 'Введите текст сообщения'});
                hasError = true;
            }
            if (!telephoneRegex.test(this.formData.phone)) {
                this.formErrors.PhoneErrors.push({"message": 'Введите номер телефона'});
            }
            return hasError;
        }
    },
    data() {
        return {
            loader: false,
            successText: "Ваше сообщение успешно отправлено. В ближайшее время с вами свяжется наш представитель",
            formData: {
                name: "",
                emailAddress: "",
                phone: "",
                subject: "",
                message: ""
            },
            formErrors: {
                NameErrors: [],
                EmailAddressErrors: [],
                PhoneErrors: [],
                SubjectErrors: [],
                MessageErrors: []
            },
            questions: [
                {
                    "question": "Вопрос: Какие документы мне нужны для подачи на развод?",
                    "answer": " Обычно требуется свидетельство о браке, документы о доходах, а также информация о совместно нажитом имуществе и обязательствах.",
                },
                {
                    "question": "Что делать, если меня обвинили в совершении преступления?",
                    "answer": "Немедленно обратитесь к адвокату. Не отвечайте на вопросы полиции без присутствия адвоката. Ваши права нужно защищать профессионально"
                },
                {
                    "question": "Как защитить свой бизнес от юридических проблем?",
                    "answer": "Регулярно консультируйтесь с корпоративным адвокатом, поддерживайте документацию в порядке, следите за соблюдением законов в сфере вашей деятельности."
                },
                {
                    "question": "Как получить страховку после несчастного случая?",
                    "answer": "Свяжитесь с вашим адвокатом и предоставьте документы о несчастном случае. Адвокат поможет вам взаимодействовать со страховой компанией и защитит ваши интересы."
                },
                {
                    "question": "Могу ли я оспорить решение суда?",
                    "answer": "Да, вы можете подать апелляцию. Обсудите свои права и возможности с адвокатом, чтобы определить наилучший способ обжалования решения суда."
                },
                {
                    "question": "Как оформить завещание?",
                    "answer": "Завещание должно быть составлено в соответствии с местными законами. Лучше всего обратиться к нотариусу или адвокату для правильного составления завещания."
                },
                {
                    "question": "Какие шаги нужно предпринять при нарушении моих прав на работе?",
                    "answer": "Запишите все инциденты, обратитесь к HR, и если необходимо, к адвокату по трудовым вопросам. Соблюдение правильной процедуры может быть ключом к успешной защите ваших прав."
                }
            ]
        }
    }
}
</script>

<style scoped>
.section-title {
    text-align: center;
    max-width: 921px;
    margin: 0 auto 60px;
}

.loader {
    position: absolute;
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
    width: 15rem;
    text-align: center;
    height: 15rem;
    top: 33%;
}
.container_loader{
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    background-color: rgba(0, 0, 0, 0.3);
    top: 0;
    z-index: 1;
}
.container_loader p{
    position: relative;
    top: 43%;
    color:black;
}
</style>
