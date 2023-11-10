<template>
    <div class="d-flex row">
        <h3 class="text-center">{{title}}</h3>
        <h3 class="text-center" v-if="average_score_title!==null">{{average_score_title}}</h3>
        <div class="col-12">
            <Doughnut
                :chart-options="chartOptions"
                :chart-data="dataChart"
                :chart-id="chartId"
                :dataset-id-key="datasetIdKey"
                :css-classes="cssClasses"
                :styles="styles"
                :width="width"
                :height="height"
            />
        </div>
    </div>
</template>

<script>
import { Doughnut } from 'vue-chartjs/legacy'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale
} from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)
export default {
    name: "DoughnutChart",
    components: {
        Doughnut
    },
    props: {
        chartId: {
            type: String,
            default: 'doughnut-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Array,
            default: () => []
        },
        dataChart: {default:null},
        title: {default:null},
        average_score_title: {default:null}
    },
    data() {
        return {
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    }
}
</script>

<style scoped>

</style>
