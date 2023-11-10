<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="section-title mt-specializations-title text-center" style="margin-bottom: 30px">
            <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
            <h2>Наши <span>специализации</span></h2>
        </div>
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 col-sm-6" v-for="specialization in specializations">
                    <div class="service-card h-100 d-flex flex-column" >
                        <div  class="service-text"><i :class="'las '+ specialization.icon"></i>
                            <h3><a :href="'/specialization/'+specialization.id">{{concatenateWords(specialization.name)}} <span>{{getLastWord(specialization.name)}}</span></a></h3>
                            <p>{{specialization.description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
export default {
    name: "AllSpecializationsPage",
    data() {
        return {
            breadcrumbs: {default: null},
            specializations: {default: []}
        }
    },
    methods:{
        concatenateWords(str)
        {
            return str.split(' ').slice(0,-1).join(' ')
        },
        getLastWord(str)
        {
            const words = str.split(' ');
            return words[words.length - 1];
        },
    },
    props: {
        prop_breadcrumbs: {default: null},
        prop_specializations: {default: []}
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
        this.specializations = this.prop_specializations;
        console.log("Специализации");
        console.log(this.specializations);
    }
}
</script>

<style scoped>

</style>
