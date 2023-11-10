<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <!-- Choose Area -->
        <div class="choose-area about-page-area pb-70 my_padding_top">
            <div class="container">
                <div class="section-title text-center mt-faq-title">
                    <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    <h2>Мы - ведущие юристы</h2>
                    <p>Мы гордимся тем, что предоставляем высококвалифицированные юридические услуги, ориентированные на
                        защиту прав и интересов наших клиентов. Наш коллектив состоит из ведущих юристов, обладающих
                        богатым опытом и глубокими знаниями в различных областях права.</p>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-1" v-for="item in info_us.slice(0,3)">
                            <div class="col-12 d-flex align-items-center">
                                <i :class="item.icon+' icon_style'"></i>
                                <h3 class="ms-2">{{item.message}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row mt-1" v-for="item in info_us.slice(3,6)">
                            <div class="col-12 d-flex align-items-center">
                                <i :class="item.icon+' icon_style'"></i>
                                <h3 class="ms-2">{{item.message}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Choose Area -->

        <!-- Fun Fact Area -->
        <facts
            :prop_count_cases='common_count_instances'
            :prop_count_winner_cases='winner_instances'
            :prop_count_lawyers='count_lawyers'
            :prop_count_clients='count_clients'
        ></facts>
        <!-- Ends Fun Fact Area -->

        <!-- About Video Area -->
        <div class="about-video-area">
            <div class="container">
                <div class="about-video-contant">
                    <div class="d-table">
                        <div class="d-table-cell">
                            <div class="video-box">
                                <a href="https://www.youtube.com/watch?v=AQzb8d4cKtg" class="video-btn popup-youtube">
                                    <i class="las la-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Video Area -->
        <!-- Contact Area -->
        <our-advantages></our-advantages>
        <!-- End Contact Area -->
        <div class="contact-area contact-two ptb-25">

            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="contact-text">
                            <div class="section-title">
                                <h2>Свяжитесь С Нами Сегодня, Свяжитесь с Экспертом</h2>
                                <p>Если у вас возникли юридические вопросы или потребности, обратитесь к нашим ведущим
                                    юристам. Мы готовы помочь вам в защите ваших прав и интересов. Свяжитесь с нами
                                    сегодня, и мы обеспечим вас качественными юридическими решениями.</p>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="contact-card">
                                        <span>Номер телефона</span>
                                        <h3><a href="##">+7(949) 456-73-89</a></h3>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="contact-card">
                                        <span>Наши социальные сети</span>
                                        <ul>
                                            <li>
                                                <a href="#" target="_blank">
                                                    <i class="lab la-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" target="_blank">
                                                    <i class="lab la-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" target="_blank">
                                                    <i class="lab la-instagram"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" target="_blank">
                                                    <i class="lab la-google-plus"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <yandex-map :coords="coords"
                                    :zoom="15">
                            <ymap-marker
                                :coords="coords"
                                marker-id="123"
                                hint-content="Адвокатская контора"
                            />
                        </yandex-map>
                    </div>

                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
export default {
    name: "AboutUsPage",
    data() {
        return {
            currentUserAuth: false,
            coords: [
                48.005769, 37.796687
            ],
            breadcrumbs: {default: null},
            common_count_instances: {default: 0},
            winner_instances: {default: 0},
            count_lawyers:{default:0},
            count_clients:{default:0},
            info_us: [
                {icon: "las la-chart-pie", message: "Большой опыт"},
                {icon: "las la-chart-bar", message: "Успешные кейсы"},
                {icon: "las la-user-tie", message: "Профессиональные адвокаты"},
                {icon: "lab la-accessible-icon", message: "Качественный сервис"},
                {icon: "las la-balance-scale", message: "Бесплатная консультация"},
                {icon: "las la-user-astronaut", message: "Поддержка 24/7"},
            ]
        }
    },
    mounted() {
        this.$root.$on("sendInfoUser", (msg) => {
            console.log("aboutUsPage")
            console.log(msg);
        })
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
        this.common_count_instances = this.prop_common_count_instances;
        this.winner_instances = this.prop_winner_instances;
        this.count_lawyers = this.prop_count_lawyers;
        this.count_clients = this.prop_count_clients;
    },
    props: {
        prop_breadcrumbs: {default: null},
        prop_common_count_instances: {default: 0},
        prop_winner_instances: {default: 0},
        prop_count_lawyers:{default:0},
        prop_count_clients:{default:0}
    },
    methods: {},
}
</script>

<style scoped>
.my_about_us_card {
    padding-left: 100px;
    position: relative;
    margin-bottom: 50px;
}

.icon_style {
    background-color: #ffffff;
    width: 70px;
    height: 70px;
    left: 0;
    top: 0;
    border-radius: 5px;
    line-height: 70px;
    text-align: center;
    -webkit-box-shadow: 0px 0px 20px #eeeeee;
    box-shadow: 0px 0px 20px #eeeeee;
    font-size: 30px;
    color: #c8242f;
}
</style>
