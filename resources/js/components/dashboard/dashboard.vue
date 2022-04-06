<template>
  <div>
    <sideBar></sideBar>
    <div class="main-panel">
      <navBar></navBar>
      <div class="content">
        <div class="container-fluid">

          	<div class="row">

              
						  <div class="col-xl-3 col-md-3 col-6">
                    <router-link to="/product-categories">
								<div class="info-box bg-b-green">


									<span class="info-box-icon push-bottom" style="color:white">
                    <i class="nc-icon nc-app"></i>
                    
                    </span>
									<div class="info-box-content">
										<span class="info-box-text" style="color:white">Product Categories</span>
										<span class="info-box-number" style="color:white">{{totalProductCategories}}</span>
										<!-- <div class="progress">
											<div class="progress-bar" style="width: 45%"></div> 
										</div> -->
										<!-- <span class="progress-description">
											45% Increase in 28 Days
										</span> -->
									</div>
									<!-- /.info-box-content -->
								</div>
						    </router-link>
							</div>

                <div class="col-xl-3 col-md-3 col-6">
                <router-link to="/manufacturers">
								<div class="info-box bg-b-blue">
									<span class="info-box-icon push-bottom" style="color:white">
                    <i class="nc-icon nc-bag"></i>
                    
                    </span>
									<div class="info-box-content">
										<span class="info-box-text" style="color:white"> Manufacturers</span>
										<span class="info-box-number" style="color:white">{{totalManufacturers}}</span>
										<!-- <div class="progress">
											<div class="progress-bar" style="width: 45%"></div> 
										</div> -->
										<!-- <span class="progress-description">
											45% Increase in 28 Days
										</span> -->
									</div>
									<!-- /.info-box-content -->
								</div>
                </router-link>
							</div>

              

                <div class="col-xl-3 col-md-3 col-6">
                       <router-link to="/subscribers">
								<div class="info-box bg-b-green">
									<span class="info-box-icon push-bottom" style="color:white">
                    <i class="nc-icon nc-app"></i>
                    
                    </span>
									<div class="info-box-content">
										<span class="info-box-text" style="color:white">Subscribers</span>
										<span class="info-box-number" style="color:white">{{totalSubscibers}}</span>
										<!-- <div class="progress">
											<div class="progress-bar" style="width: 45%"></div> 
										</div> -->
										<!-- <span class="progress-description">
											45% Increase in 28 Days
										</span> -->
									</div>
									<!-- /.info-box-content -->
								</div>
                       </router-link>
								<!-- /.info-box -->
							</div>

               <div class="col-xl-3 col-md-3 col-6">
                     <router-link to="/companies">
								<div class="info-box bg-b-blue">
									<span class="info-box-icon push-bottom" style="color:white">
                    <i class="nc-icon nc-bag"></i>
                    
                    </span>
									<div class="info-box-content">
										<span class="info-box-text" style="color:white">Companies</span>
										<span class="info-box-number" style="color:white">{{totalCompanies}}</span>
										<!-- <div class="progress">
											<div class="progress-bar" style="width: 45%"></div> 
										</div> -->
										<!-- <span class="progress-description">
											45% Increase in 28 Days
										</span> -->
									</div>
									<!-- /.info-box-content -->
								</div>
                     </router-link>
								<!-- /.info-box -->
							</div>

            </div>


  <div class="row">
   	<div class="col-xl-12 col-md-12 col-12">
       <center>
       <label for="">

         <h4>
           <b>
           Most Selected Products
           </b>
         </h4>
       </label>
       </center>
    </div>
							<div class="col-xl-12 col-md-12 col-12">
                  <apexchart width="100%" height="300" type="donut" :options="chartOptions" :series="series"></apexchart>
                      <!-- <div class="totalVisitors" ref="bestSold">
                </div> -->
                 
              </div>
        </div> 
      

        <div class="row">
							<div class="col-xl-12 col-md-12 col-12">

                <div class="totalVisitors" ref="totalVisitors">
                </div>
              </div>
        </div> 

        
        </div>
      </div>
      <!-- <siteFooter></siteFooter> -->
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import navBar from "../navBar.vue";
import sideBar from "../sideBar.vue";
import axios from "axios";
import siteFooter from "../dashboard/siteFooter.vue";
import Spinner from 'vue-simple-spinner';
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
am4core.useTheme(am4themes_animated);
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)



export default {
  name: "dashboard",
  components: {
    navBar,
    sideBar,
    siteFooter,
    Spinner
  },

  data(){
    return {
      fetchTasks:true,
      showTasks:false,
      zeroTasks:false,
      tasks:[],
      totalProducts:0,
      totalCompanies:0,
      totalProductCategories:0,
      totalSubscibers:0,
      maximumVisitors:0,
      totalManufacturers:0,
      chartOptions: {
            chart: {
              width: 380,
              type: 'pie',
            },
            labels: [],
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
      },
      series: []
    }
  }, methods:{
    getTotalVisitors:function()
    {        
      axios
        .get("api/getTotalVisitors")
        .then((response) => {
           this.isLoading =false
          if (response.data.status === 200) {
            let visitors = response.data.record;
            const groups = visitors.reduce((groups, game) => {
                const date = game.date;
                if (!groups[date]) {
                  groups[date] = [];
                }
                groups[date].push(game);
                return groups;
              }, {});

              const groupArrays = Object.keys(groups).map((date) => {
                return  groups[date].length
              });

               const d = new Date(visitors[0].date);
               let chart = am4core.create(this.$refs.totalVisitors, am4charts.XYChart);
                 chart.paddingRight = 20;
               let title =  chart.titles.create()
               title.text ="Total Visitors";
               title.fontSize = 24;

                //TODO:: ensure to render the graph using correct dates
                let data = [];
                for (let i = 0; i <= 365; i++) {
                  data.push({ date: new Date(d.getFullYear(),  d.getMonth(), i), name: "name" + i, value: groupArrays[i]});
                }

                chart.data = data;

                let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.grid.template.location = 0;

                let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.tooltip.disabled = true;
                valueAxis.renderer.minWidth = 35;

                let series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.dateX = "date";
                series.dataFields.valueY = "value";

                series.tooltipText = "{valueY.value}";
                chart.cursor = new am4charts.XYCursor();

                let scrollbarX = new am4charts.XYChartScrollbar();
                scrollbarX.series.push(series);
                chart.scrollbarX = scrollbarX;

                this.chart = chart;

          } else {
            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });

    },
       getTotalSelection:function()
    {        
      axios
        .get("api/getProductSelection")
        .then((response) => {
           this.isLoading =false
           
          if (response.data.status === 200) {
            let products_ = response.data.record;

           const groups = products_.reduce((groups, game) => {
                        const name = game.products.product.name;
                        if (!groups[name]) {
                          groups[name] = [];
                        }
                        groups[name].push(game);
                        return groups;
                      }, {});

            this.chartOptions.labels = Object.keys(groups);
            const total = Object.keys(groups).map((date) => {
                      return  groups[date].length
                    });

              this.series = total;
          } else {
            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });

    },

    getMetrics:function()
    {
      axios
        .get("api/dashboardMetrics")
        .then((response) => {
           this.isLoading =false
          if (response.data.status === 200) {
            if(response.data.record.length ===0)
            {
             
             
            }else{
            this.showTasks =true
            //console.log("record", response.data.record)
            this.totalProductCategories = response.data.record.categories.total_categories
            this.totalCompanies =  response.data.record.companies.total_companies
            this.totalSubscibers = response.data.record.subscribers.total_subscribers
            this.totalManufacturers = response.data.record.manufacturers.total_manufacturers;
            }
           
          } else {
            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });
    }
  },
    mounted() 
    {
    this.getMetrics();
    this.getTotalVisitors();
    this.getTotalSelection();
    }
};
</script>
<style scoped>

.totalVisitors{
  width: 100%;
  height: 500px;
}
.container-fluid {
  margin-top: 10px;
}
.main-panel {
  overflow: auto;
  max-height: calc(100vh - 30px);
  min-height: 100%;
}

.info-box {
    min-height: 100px;
    background: #fff;
    width: 100%;
    box-shadow: 0 5px 20px rgb(0 0 0 / 10%);
    margin-bottom: 20px;
    padding: 15px;
    border-radius: 10px;
}

.bg-b-green {background: linear-gradient(45deg, #2ed8b6, #59e0c5);}
.bg-b-blue {background: linear-gradient(45deg, #4099ff, #73b4ff);}



.info-box-icon {
    float: left;
    height: 70px;
    width: 70px;
    text-align: center;
    font-size: 30px;
    line-height: 74px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 100%;
}

.info-box-content {
    padding: 10px 10px 10px 0;
    margin-left: 90px;
}

.info-box-text, .progress-description {
    display: block;
    font-size: 16px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 400;
}

.state-overview {
    color: #fff;
}

.info-box .progress {
    background: rgba(0, 0, 0, 0.2);
    margin: 5px -10px 5px 0;
    height: 2px;
}

.progress {
    border: 0;
    background-image: none;
    filter: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    height: 8px;
    border-radius: 0 !important;
    margin: 0;
}

.progress {
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: .25rem;
}

</style>
