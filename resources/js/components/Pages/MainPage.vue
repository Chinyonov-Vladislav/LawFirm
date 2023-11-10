<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="law-card-area pt-100 margin_top_cards_main_page">
            <div class="container">
                <div class="card-contant">
                    <div class="row no-gutters">
                        <div class="col-lg-3 bor-right col-sm-6 col-sm-6 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-0">
                            <div class="low-card h-100 d-flex flex-column">
                                <h3>Судебные дела</h3>
                                <i class="las la-home"></i>
                                <p >Наши адвокаты обладают богатым опытом в ведении судебных дел различной сложности. Мы предоставляем квалифицированную правовую поддержку в судах, стремясь к максимально благоприятному исходу для наших клиентов.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 bor-right col-sm-6 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-2">
                            <div class="low-card h-100 d-flex flex-column">
                                <h3>Обзор документов</h3>
                                <i class="las la-file-alt"></i>
                                <p>Наши адвокаты профессионально проводят обзор документов, предоставленных клиентами. Мы осуществляем тщательный анализ каждого документа, выявляя ключевые моменты и потенциальные правовые риски.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 bor-right col-sm-6 mt-xl-0 mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                            <div class="low-card h-100 d-flex flex-column">
                                <h3>Опытные юристы</h3>
                                <i class="las la-balance-scale"></i>
                                <p>Наш коллектив состоит из опытных юристов, специализирующихся в различных областях права. Их профессионализм и глубокие знания позволяют нам эффективно решать самые сложные правовые вопросы, стоящие перед нашими клиентами.</p>
                            </div>
                        </div>

                        <div class="col-lg-3 bor-right col-sm-6 mt-xl-0 mt-lg-0 mt-md-2 mt-sm-2 mt-2">
                            <div class="low-card h-100 d-flex flex-column">
                                <h3>Успешное закрытие дел</h3>
                                <i class="las la-gavel"></i>
                                <p>Мы гордимся своими достижениями в успешном закрытии дел. Благодаря стратегическому подходу, высокой квалификации наших юристов и постоянному вниманию к интересам клиента, мы достигаем положительных результатов в самых трудных ситуациях.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <our-advantages class="mt-5"></our-advantages>
        <div class="service-area mt-5" v-if="specializations.length>0">
            <div class="container">
                <div class="section-title">
                    <span>Практики</span>
                    <h2>Наши сферы <span>специализации</span> </h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-md-6 col-12 mt-3" v-for="item in specializations">
                        <div class="service-card h-100 d-flex flex-column">
                            <div class="service-text">
                                <i :class="'las '+item.icon"></i>
                                <h3><a :href="'/specialization/'+item.id">{{concatenateWords(item.name)}} <span>{{getLastWord(item.name)}}</span></a></h3> <!-- добавить ссылку -->
                                <p>{{item.description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <facts
            class="mt-5"
            :prop_count_cases='local_count_cases'
            :prop_count_winner_cases='local_count_winner_cases'
            :prop_count_lawyers='count_lawyers'
            :prop_count_clients='count_clients'
        ></facts>

        <div class="blog-area mt-5 ptb-100">
            <div class="container">
                <div class="section-title">
                    <span>Последние новости из мира юриспруденции от наших адвокатов</span>
                    <h2><span>Лучший блог </span> по юриспруденции, судебным делам и консалтингу</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6" v-for="item in news">
                        <div class="blog-card h-100 d-flex flex-column">
                            <a :href="'/news/'+item.id">
                                <img :src="item.images[0]" class="img-fluid img_height" alt="Image" v-if="item.images.length >0">
                                <img src="/photos/News.jpg" class="img-fluid img_height" alt="Image" v-else>
                            </a>
                            <div class="blog-card-text d-flex flex-column">
                                <h3><a :href="'/news/'+item.id">{{item.title}}</a></h3>
                                <ul>
                                    <li>
                                        <i class="las la-calendar"></i>
                                        {{ moment()(item.created_at).format("DD-MM-YYYY") }}
                                    </li>
                                    <li>
                                        <i class="las la-user-alt"></i>
                                        {{item.lawyer.second_name}} {{item.lawyer.first_name}} {{item.lawyer.middle_name}}
                                    </li>
                                </ul>

                                <p class="text_article_in_card">{{item.description}}</p>
                            </div>
                            <div class="blog-card-text mt-auto">
                                <a :href="'/news/'+item.id" class="read-more">
                                    Читать полностью <i class="las la-angle-double-right"></i>
                                </a>
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
import moment from 'moment';
export default {
    name: "MainPage",
    data(){
        return {
            local_count_cases: 0,
            local_count_winner_cases: 0,
            count_lawyers:0,
            count_clients:0
        }
    },
    props:{
        specializations:{
            default: []
        },
        news:{
            default:[]
        },
        common_count_instances:{
            default:0
        },
        winner_instances:{
            default:0
        },
        prop_count_lawyers:{default:0},
        prop_count_clients:{default:0}
    },
    created()
    {
        this.local_count_cases = this.common_count_instances;
        this.local_count_winner_cases = this.winner_instances;
        this.count_lawyers = this.prop_count_lawyers;
        this.count_clients = this.prop_count_clients;
    },
    methods:{
        getLastWord(str)
        {
            const words = str.split(' ');
            return words[words.length - 1];
        },
        moment() {
            return moment
        },
        concatenateWords(str)
        {
           return str.split(' ').slice(0,-1).join(' ')
        }
    },
    mounted() {
      console.log(this.news);
    }
}
</script>

<style scoped>

</style>
