<template>
    <nav class="navbar navbar-expand-lg  navbar-light">
        <div class="container">
        
            <a class="navbar-brand logo-image" href="javascript:void(0)">
                <img src="../../assets/images/logo.png" alt="alternative"></a> 

            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#header">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" @click="openComparisonSteps()" href="javascript:void(0)">Compare Prices</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="#details"></a>
                    </li>
                </ul>
               
            </div> <!-- end of navbar-collapse -->
        </div> <!-- end of container -->

          <modal ref="comparisonModal"  no-close-on-backdrop no-close-on-esc hide-cancel title="PRICE COMPARISON PROCESS"  width="700px" :hide-ok="true" hide-footer centered>
                <form>
                    <div class="row">
                      <div class="col-md-12 pr-1">

                            <div  v-show="showIndustryTitle" class="title common">{{industryTitle}} </div>

                                <div v-show="selectedIndustryOption" class="btn-solid-lg" style="margin:10px;">
                                <span class="closeBtn" @click='restartSelectingIndustry(); return false;'>x</span>

                               {{selectedIndustryName}}
                               
                            </div>

                        <div class="title common" v-show="showCompanyTitle"> {{title}} </div>
                       
                          
                        <div class="title selected-companies" v-show="showSelectedCompanyNames"> 
                            <div class="f6">
                                <a v-for="companyDetail in  selectedCompaniesDetails" :key="companyDetail.id" data-ga-click="Topic, repository page" data-octo-click="topic_click" data-octo-dimensions="topic:linux" href="javascript:void(0)" title="Topic: linux" data-view-component="true" class="topic-tag topic-tag-link">
                                      {{companyDetail.name}}
                                        </a>

                                        <button @click="redoSelectCompanies($event)" tooltip="undo">
                                          <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                            </div>
                        </div>

                        
                        <div class="title common" v-show="showCategoriesTitle"> {{categoriesTitle}} </div>
                    
                        <div  v-show="allIndustries" class="form-group industries" v-for="industry in industries" :key="industry.id">
                            <div class="col-md-11 pr-1" > 
                                <div class="card __web-inspector-hide-shortcut__">
                                    <div class="card-body">
                                        <div class="details">
                                            <div class="text">
                                                <div class="testimonial-author">
                                                        {{industry.name}}
                                                </div>
                                            </div>
                                        </div>
                                         <input type="radio" class="industries" v-model="selectedIndustryDetail" style="margin:10px;" :company_name="industry.name" name="industries" @change="selectedIndustry($event)" :value="industry.id"/>
                                    </div>
                                    </div>
                            </div>
                        </div>



                        <div  v-show="noCompaniesPlaceholder" class="form-group industries">
                    
                            <div class="col-md-11 pr-1" > 

                                <div class="card __web-inspector-hide-shortcut__">
                                   
                                    <div class="card-body" @click="tryAgain($event)">
                               
                                        <div class="details">
                                
                                    
                                            <div class="text">
                                                <div class="testimonial-author">

                                                     SELECTED INDUSTRY HAS NO COMPANIES, TRY AGAIN
                                                </div>
                                              
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </div>

                        <div v-show="allCompanies">

                        <div class="collapse show companies-display" > 
                                <div   class="form-group " v-for="company in industryCompanies" :key="company.name">
                            
                                    <div class="col-md-6 pr-1 column_size" > 
                                        <div class="card __web-inspector-hide-shortcut__">
                                        
                                            <div class="card-body card_name_size" v-if="company.is_default">
                                                <div class="details">
                                                    <div class="text">
                                                        <div class="testimonial-author">

                                                                {{company.name}}
                                                        </div>
                                                    </div>
                                                </div>
                                                 <input type="checkbox" tool-tip="Default Shop" disabled checked class="industries" style="margin:10px;" v-model="selectedCompaniesDetails" name="companies[]" @change="selectedcompany($event)" :value="company"/>
                                            </div>
                                             <div class="card-body card_name_size" v-else>
                                                <div class="details">
                                                    <div class="text">
                                                        <div class="testimonial-author">

                                                                {{company.name}}
                                                        </div>
                                                    </div>
                                                </div>
                                                 <input type="checkbox"  class="industries" style="margin:10px;" v-model="selectedCompaniesDetails" name="companies[]" @change="selectedcompany($event)" :value="company"/>
                                            </div>

                                            </div>
                                    </div>
                                </div>
                        </div>

                         <div>
                             <button  v-show="showGetCategoriesBtn" class="nextBtn" @click="getCategories($event)">
                                    NEXT
                             </button>
                        </div>

                        </div>


                     <div v-show="allCategories">

                            <div class="collapse show companies-display" > 
                                    <div   class="form-group " v-for="category in categories" :key="category.name">
                                
                                        <div class="col-md-6 pr-1 column_size"  > 

                                            <div class="card __web-inspector-hide-shortcut__">
                                            
                                                <div class="card-body card_name_size">
                                        
                                                    <div class="details">
                                                        <!-- <img src="images/testimonial-2.jpg" alt="alternative" class="testimonial-image">  -->
                                                       
                                                        <div class="text">
                                                            <div class="testimonial-author">
                                                                    {{category.name}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <input type="checkbox" style="margin:10px;" @change="selectedCategories($event)" v-model="selectedCategoriesDetails"  :value="category"/>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                            </div>

                            <div>
                                <button v-show ="showCreateComparisonTableBtn" class="nextBtn" @click="createAComparisonTable($event)">
                                        NEXT
                                </button>
                            </div>

                        </div>
                            <Spinner v-show="loader" :message="loadingMessage" size="medium"></Spinner>
                      </div>
                      
                    </div>
                
                    <div class="clearfix"></div>
                  </form>           
        </modal>


        <modal ref="comparisonTable" no-close-on-backdrop no-close-on-esc hide-cancel width="980px" title="PRICE COMPARISON PROCESS"  :hide-ok="true" hide-footer centered>

              <Spinner v-show="productsLoader" :message="productsLoaderMessage" size="medium"></Spinner>

                <table class="table table" v-show="productsTable" width="100%">
                <thead>
                    <tr class="table-info">
                    <th>Products</th>

                    <th v-for="company in selectedCompaniesDetails" :key="company.id">
                        {{company.name}}
                    </th>
                     <th>Select</th>

                    </tr>
                </thead>
                <tbody>

                     <tr v-for="product in products" :key="product.id">
                            <td>
                             <b> ({{product.category.name.toUpperCase()}}) </b>
                               {{ product.name }}
                            <br/>
                            <tr>
                            </tr>
                            <tr v-for="product_attribute in  Object.keys(product.product_attributes)" :key="product_attribute">
                                     <td>
                                          {{product_attribute}}

                                          <span> 
                                              {{product_sku_unit}}
                                          </span>

                                     </td>
                                 </tr>
                            </td>
                           
                            <td v-for="company in selectedCompaniesDetails" :key="company.id">

                                  <br/>
                                 <tr>
                                </tr>

                               <tr v-for="product_ in product.product_attributes" :key="product_">  

                            

                                    <td  v-for="item in product_" :key="item">  
                                        <span v-if="item.company_id == company.id">
                                            {{item.price}}
                                        </span>
                                        <span v-else>
                                           
                                        </span>
                                   </td>
                                 </tr>
                            </td>
                            <td>
                                 <br/>
                                 <tr>
                                </tr>

                                 <tr v-for="attribute_details in product.product_attributes" :key="attribute_details">   
                                    <td>              
                                        <input
                                                type="checkbox"
                                                v-model="chosenItems"
                                                :value="attribute_details"
                                                @change="selectedFinalProducts($event, product)"
                                            />
                                   </td>
                                 </tr>
                            </td>
                        </tr>

                     <tr>
                          <th scope="row">
                          </th>
                           <td v-for ="totalCompanies in totalSelectedCompanies" :key="totalCompanies">
                           </td>
                            <th>

                              <span style="color:red">{{noProductSelectedError}} </span>
                              <br/>
                                <button  class="nextBtn"  @click="generateFinalBill($event)">
                                    GENERATE BILL
                                </button>
                            </th>

                     </tr>
            
                </tbody>

                </table>


             <table class="table table-striped " v-show="billTable" width="100%">
                <thead>
                    <tr class="table-info">
                    <th>Product</th>

                    <th v-for="company in selectedCompaniesDetails" :key="company.id">
                        {{company.name}}
                    </th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr v-for="product in visitorSelectedProducts" :key="product.id">
                            <td>
                             <b>
                                 ({{ product.category.name.toUpperCase()}}) </b>
                                   {{ product.name }} 

                                   <br/>
                                    <tr>
                                   </tr>

                                    <tr v-for="product_attribute in  Object.keys(product.product_attributes)" :key="product_attribute">
                                     <td>
                                          {{product_attribute}}

                                          <span> 
                                              {{product_sku_unit}}
                                          </span>

                                     </td>
                                 </tr>
                          
                            </td>
                            <td   v-for="company in selectedCompaniesDetails" :key="company.id">

                                  <br/>
                                 <tr>
                                </tr>

                               <tr v-for="product_ in product.product_attributes" :key="product_">  


                                    <td  v-for="item in product_" :key="item">  
                                        <span v-if="item.company_id == company.id">
                                            {{item.price}}      
                                        </span>
                                        <span v-else>

                                        </span>
                                   </td>
                                 </tr>
                            </td>
                        </tr>
                     <tr>
                          <th scope="row">
                              TOTAL (ZWL)
                          </th>
                           <td v-for ="total in companyTotals" :key="total">
                               <span>

                                   <strong>
                                     {{total}}
                                   </strong>
                                   </span>
                           </td>
                     </tr>

                     <tr>
                          <th scope="row">
                             Site Links
                          </th>
                           <td v-for ="company in selectedCompaniesDetails" :key="company">
                              

                                   <strong>
                                     <a :href="company.site_link" target="_blank" @click="saveRedirect($event, company)" >  {{company.name}} 
                                         
                                         </a>
                                   </strong>
                                 
                           </td>
                     </tr>


                     

                       <tr>
                          <th scope="row">
                              <a v-show="downloadCatalogBtn" href="javascript:void(0)" @click="generateCatalog($event)">

                              <i class="fa fa-download" aria-hidden="true"></i>
                              DOWNLOAD CATALOG
                              </a>
                                 <Spinner v-show="downloadCatalogLoader" message="Downloading please wait..." size="small"></Spinner>
                          </th>
                           <td v-for ="totalCompanies in totalSelectedCompanies" :key="totalCompanies">
                           </td>
                     </tr>
                </tbody>

                </table>                        
         </modal>


           <modal ref="newsLetterSubscribers" no-close-on-backdrop no-close-on-esc hide-cancel width="400px" title="ENTER YOUR DETAILS"  :hide-ok="true" hide-footer centered>
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Newsletter Form -->
                    <form>
                         <div class="form-group">
                             <label>Name</label>
                            <input type="text" class="form-control-input" id="name" v-model="subscriberName" required>
                            
                            <div class="help-block with-errors"></div>
                        </div>
                         <div class="form-group">
                               <label>Whatsapp phone number</label>
                            <input type="text" class="form-control-input" id="phone" v-model="subscriberPhone" required>
                          
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                             <label>Email address</label>
                            <input type="email" class="form-control-input" id="nemail" v-model="subscriberEmail" required>
                           
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" @click="submitSubscriberDetails($event)" class="form-control-submit-button">
                        
                                
                               {{subscriberDownloadText}}
                             <Spinner v-show="loader" :message="saveSubscriberBeforeDownloading" size="medium"></Spinner>


                            </button>
                        </div>
                        <div class="form-message">
                            <div id="nmsgSubmit" class="h3 text-center hidden"></div>
                        </div>
                    </form>
                   
                </div> <!-- end of col -->
            </div> <!-- end of row -->

            
            </modal>



          <vue-html2pdf
            :show-layout="false"
            :float-layout="true"
            :enable-download="true"
            :paginate-elements-by-height="1400"
             filename="priceline_catalog"
            :pdf-quality="2"
            :manual-pagination="false"
            pdf-format="a4"
            margin= 0
            pdf-orientation="landscape"
            pdf-content-width="100%"
            @progress="onProgress($event)"
            @hasStartedGeneration="hasStartedGeneration()"
            @hasGenerated="hasGenerated($event)"
            ref="html2Pdf"
    >
        <section slot="pdf-content">
            <div id="finalTable">
             <table class="table table-striped " width="100%" >
                <thead>
                    <tr class="table-info">
                    <th>Product Brands</th>
                    <th v-for="company in selectedCompaniesDetails" :key="company.id">
                        {{company.name}}
                    </th>
                    </tr>
                </thead>
               
                <tbody>
                   <tr v-for="product in visitorSelectedProducts" :key="product.id">
                            <td>
                             <b>
                                 ({{ product.category.name.toUpperCase()}}) </b>
                                   {{ product.name }} 

                                   <br/>
                                    <tr>
                                   </tr>

                                    <tr v-for="product_attribute in  Object.keys(product.product_attributes)" :key="product_attribute">
                                     <td>
                                          {{product_attribute}}

                                          <span> 
                                              {{product_sku_unit}}
                                          </span>

                                     </td>
                                 </tr>
                          
                            </td>
                            <td   v-for="company in selectedCompaniesDetails" :key="company.id">

                                  <br/>
                                 <tr>
                                </tr>

                               <tr v-for="product_ in product.product_attributes" :key="product_">  


                                    <td  v-for="item in product_" :key="item">  
                                        <span v-if="item.company_id == company.id">
                                            {{item.price}}      
                                        </span>
                                        <span v-else>

                                        </span>
                                   </td>
                                 </tr>
                            </td>
                        </tr>
                    <tr>
                          <th scope="row">
                              TOTAL (ZWL)
                          </th>
                           <td v-for ="total in companyTotals" :key="total">
                               <span>

                                   <strong>
                                     {{total}}
                                   </strong>
                                   </span>
                           </td>
                     </tr>
                </tbody>
                </table>    
                </div>
        </section>
    </vue-html2pdf>
    </nav>
</template>
<script>

import modal from 'vue-modality';
import axios from"axios";
import Vue from "vue";
import Spinner from 'vue-simple-spinner';
import VueHtml2pdf from 'vue-html2pdf';
import html2PDF from "html-pdf-adaptive";
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 5000})


const regex = '/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/';

export default
   {
       name:"myBar",
       data(){
           return {

               industries_data:"industries",
               companies_data:"companies",
               categories_data:"categories",
               industries:[],
               companies:[],
               industry_detail:"",
               loader:false,
               title:"SELECT INDUSTRY",
               selectedIndustryOption:false,
               industryCompanies:[],
               allCompanies:false,
               noCompanies:false,
               allCategories:false,
               selectedIndustryName:"",
               showCompanyTitle:false,
               allIndustries:true,
               showIndustryTitle:true,
               showSelectedCompanyNames:false,
               industryTitle:"SELECT INDUSTRY",
               categories:[],
               selectedIndustryId:"",
               selectedCompaniesDetails:[],
               selectedCategoriesDetails:[],
               loadingMessage:"Loading",
               products:[],
               allSelectedCompanyProducts:[],
               productsTable:false,
               productsLoader:false,
               selectedProducts:[],
               showCategoriesTitle:false,
               categoriesTitle:"SELECT CATEGORIES",
               totalSelectedCompanies:0,
               productsLoaderMessage:"Loading products",
               billTable:false,
               chosenItems:[],
               totalCosts:[],
               downloadCatalogLoader:false,
               downloadCatalogBtn:true,
               companyTotals:{},
               noCompaniesPlaceholder:false,
               selectedIndustryDetail:0,
               showGetCategoriesBtn:false,
               showCreateComparisonTableBtn:false,
               noProductSelectedError:null,
               shopsavvyDetails:null,
               shopsavvyExist:false,
               defaultShopName:"",
               subscriberName:null,
               subscriberPhone:null,
               subscriberEmail:null,
               saveSubscriberBeforeDownloading:false,
               subscriberDownloadText:"SAVE AND DOWNLOAD",
               companyProductAttributes:[],
               allServerProducts:[],
               visitorSelectedProducts:[],
                product_category_skus:[],
                product_sku_unit:null
           }
       },
       components:
       {
           modal,
           Spinner,
           VueHtml2pdf,
           html2PDF 
       },
        watch:
        {
                // a computed getter
        getSkuMeasurement: function () {
                return arguments[0];
                }
        },
       methods:
       {
           submitSubscriberDetails:function(event)
           {
                event.preventDefault();
                this.subscriberDownloadText ="";
                this.saveSubscriberBeforeDownloading = true;
                let payload = {
                        name: this.subscriberName,
                        phone:this.subscriberPhone,
                        email:this.subscriberEmail
                    }
                 axios
                .post("api/newSubscriber", payload)
                .then((response) => {
                    this.saveSubscriberBeforeDownloading = false;
                    this.subscriberDownloadText ="SAVE AND DOWNLOAD";
                    if(response.data.status == 201)
                    {
                        this.subscriberName ="";
                        this.subscriberPhone ="";
                        this.subscriberEmail ="";
                        this.$refs.newsLetterSubscribers.hide();
                        this.$refs.html2Pdf.generatePdf();
                        setTimeout(() => {
                               this.$toaster.success("Catalog has been downloaded")
                        }, 3000);
                    }else{
                        this.$toaster.error(response.data.message)
                    }
                })
                .catch((error) => {
                    this.$toaster.error(error.message)
                });
           },
       
        GetSortOrder:function(prop) {    
            return function(a, b) {    
                        if (a[prop] > b[prop]) {    
                            return 1;    
                        } else if (a[prop] < b[prop]) {    
                            return -1;    
                        }    
                        return 0;    
                    }    
                },
           restartSelectingIndustry:function()
           {
               this.allCompanies = false;
               this.showCompanyTitle = false;
               this.industryTitle="SELECT INDUSTRY"
               this.selectedIndustryOption  = false
               this.allIndustries = true;
               this.selectedIndustryId = ""
               this.selectedCompaniesDetails = []
               this.selectedCategoriesDetails =[];
               this.allCategories = false;
               this.showSelectedCompanyNames =false
               this.categories = [];
               this.companies =[];
               this.products=[];
               this.selectedIndustryDetail =0
               this.showCategoriesTitle =false
           },
           selectedProductsForBilling:function(event)
           {

           },
        selectedCategories:function(event)
           {
                if(this.selectedCategoriesDetails.length >0)
                {
                    this.showCreateComparisonTableBtn = true;
                }else{
                     this.showCreateComparisonTableBtn = false
                }
           },
         selectedcompany:function(event)
           {
               if(this.selectedCompaniesDetails.length >0)
               {
                   this.showGetCategoriesBtn = true;

               }else{
                   this.showGetCategoriesBtn = false
               }
           },    
           onProgress:function(event)
           {
                if(event == 100)
                {
                    this.downloadCatalogBtn =true;
                    this.downloadCatalogLoader =false;
                }
           },
           generateCatalog:function(event)
           {    
                this.$refs.comparisonTable.hide();
                this.$refs.newsLetterSubscribers.open();
                this.downloadCatalogBtn = false;
                this.downloadCatalogLoader = true;
           },   
           getTotalCost:function()
           {  
               const priceByCompany = this.chosenItems.reduce((tot, prod) => 
               {
                    prod.forEach((p) => {
                        this.selectedCompaniesDetails.forEach((company)=>{
                            if(company.id == p.company_id)
                            {
                                if (!tot[p.company_id])
                                {   tot[p.company_id] = [] }
                                 //const numberPrice = parseFloat(p.price).toFixed(2)
                                   const numberPrice = parseInt(p.price, 10)
                                 tot[p.company_id].push(numberPrice)
                            }
                        });
                    })
                    return tot
                }, {})

                Object.keys(priceByCompany).forEach((company) => {
                            const total = priceByCompany[company].reduce((tot, price) => tot + price, 0)
                            priceByCompany[company] = total
                        })
                this.companyTotals  = priceByCompany;
           },
        createAComparisonTable:function(event)
           {    
               event.preventDefault();
               this.$refs.comparisonModal.hide();
               this.$refs.comparisonTable.open();
               this.productsLoader = true;
                this.selectedCategoriesDetails = this.selectedCategoriesDetails.sort(this.GetSortOrder('name'));
                 axios.get("api/getProducts?data_name=products&industry_id="+this.selectedIndustryId)
                        .then((response) => {
                        if (response.data.status === 200) {
                           let allProducts = response.data.record;
                           this.allServerProducts = allProducts;
                          if(allProducts.length > 0)
                          {
                            allProducts.forEach(prod =>{
                                    
                                        let result = this.selectedProducts.filter(product_element =>(product_element.id ===prod.id))
                                            if(result.length == 0){
                                                  const productAttributes = prod.product_attributes.reduce((tot, product) => 
                                                        {
                                                            if (!tot[product.description])
                                                                {   tot[product.description] = [] }
                                                                    const product_ = product;
                                                                    tot[product.description].push(product_)
                                                                return tot
                                                            }, {})

                                                    prod.product_attributes = productAttributes;
                                                    this.selectedProducts.push(prod);
                                                }
                                    });

                             this.selectedCategoriesDetails.forEach(category => {
                                 this.selectedProducts.forEach(product_el =>{
                                     if(product_el.category.id == category.id)
                                     {
                                        let result = this.products.filter(product_element =>(product_element.id ===product_el.id))
                                                                            if(result.length == 0)
                                                                            {
                                                                                this.products.push(product_el);
                                                                            }
                                     }
                                 })    
                             })
                            this.productsLoader = false
                            this.category_sku = localStorage.getItem("categorySku");
                            this.productsTable = true

                          }else{

                               this.$toaster.success("No product were found for your selection")


                          this.$refs.comparisonModal.hide();
                          }
                        } else 
                        {
                             this.$toaster.success(response.data.message)
                          }
                        })
                        .catch((error) => {

                             this.$toaster.success(error.message)
                    

                        });

           },
        tryAgain:function(event)
        {
            this.selectedIndustryDetail = 0
            this.allIndustries = true;
            this.showIndustryTitle = true;
            this.noCompaniesPlaceholder = false 
        },
        openComparisonSteps:function()
        {
            this.allIndustries = true;
            this.showIndustryTitle = true;
            this.industryTitle ="SELECT INDUSTRY";
            this.selectedIndustryOption = false;
            this.showCategoriesTitle = false;
            this.showCompanyTitle = false;
            this.showSelectedCompanyNames = false;
            this.allCompanies= false;
            this.allCategories = false;
            this.selectedCompaniesDetails =[]
            this.selectedCategoriesDetails =[]
            this.productsTable =false;
            this.selectedCompaniesDetails =[]
            this.products =[];
            this.chosenItems =[];
            this.totalSelectedCompanies =0;
            this.companyTotals ={}
            this.billTable = false;
            this.selectedIndustryDetail =0
            this.noCompaniesPlaceholder = false;
            this.$refs.comparisonModal.open();
        },
        getShopsavvyDetails:function(company)
        {
            if(company.is_default)
            {
               this.shopsavvyDetails = company;
            }
        },
        selectedIndustry:function(event)
        {
            //this.allIndustries =false;
            this.loader = true
            this.showIndustryTitle = false
            this.allCompanies=false
            this.selectedIndustryOption = false;
            this.selectedIndustryName ="";
            this.industryCompanies = [];
            this.selectedIndustryId = event.target.value
            this.allIndustries = false

             axios
                .get("api/getCompanies?data_name=companies&industry_id="+this.selectedIndustryId+"&is_active=1")
                .then((response) => {
                if (response.data.status === 200) {
                this.companies = response.data.companies;
                setTimeout(() => {
                  if(this.companies.length > 0)
                    {

                        var industryId  = event.target.value;
                        this.companies.forEach(company => {
                            if(company.industry_id == industryId)
                            {
                                this.getShopsavvyDetails(company);
                                this.industryCompanies.push(company);
                            }
                                this.showCompanyTitle = true;
                                this.title ="SELECT COMPANIES"
                                this.allCompanies = true
                                this.loader =false
                                this.selectedIndustryOption = true;
                                this.showIndustryTitle=true
                                this.industryTitle ="SELECTED INDUSTRY";
                                this.selectedIndustryName = event.target.getAttribute('company_name').toUpperCase();
                                this.selectedIndustryId  = industryId
                        })  
                    }else{
                            this.loader =false
                            this.noCompaniesPlaceholder = true;

                    }
            }, 2000);
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
         getIndustries:function()
            {
                axios
                .get("api/getIndustries?data_name="+this.industries_data)
                .then((response) => {

                if (response.data.status === 200) {
                    this.industries = response.data[this.industries_data];
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
        getProducts()
        {
            axios
                .get("api/getProducts?data_name=products")
                .then((response) => {

                if (response.data.status === 200) {
                    this.products = response.data["products"];
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
        getCompanies:function()
        {
            axios
            .get("api/getCompanies?data_name="+this.companies_data)
            .then((response) => {
            if (response.data.status === 200) {
                this.companies = response.data[this.companies_data];
             //   this.$store.commit("putCompanies", this.companies)
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

        saveRedirect:function(event, company)
        {
            axios
            .post("api/new", company)
            .then((response) => {
            if (response.data.status === 201) {
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
        selectedFinalProducts:function(event, product)
        {
            if(this.chosenItems.length < 0)
             {
                this.noProductSelectedError = "Select something";
             }
            else{
                this.noProductSelectedError = null;
                //product.product_attributes = this.chosenItems;
                if(!this.visitorSelectedProducts.some(data => data.id === product.id))
                {
                  this.visitorSelectedProducts.push(product);      
                }
             }
        },
        saveVisitorSelections:function()
        {
            let data = {
                products:this.chosenItems,
                companies:this.selectedCompaniesDetails
            }
             axios
                .post("api/saveVisitorSelection",data)
                .then((response) => {
                if (response.data.status === 201) 
                {
                    console.log("visitor data saved");
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
        generateFinalBill:function(event)
        {
            if(this.chosenItems.length > 0){

                this.productsTable = false;
                this.productsLoader = true;
                this.productsLoaderMessage =" Loading wishlist products..."
                this.getTotalCost();
                this.saveVisitorSelections();
                setTimeout(() => {
                      this.billTable = true;
                      this.productsLoader = false;
                }, 3000);
            }else{
                this.noProductSelectedError ="Select something"
            }
        },
        redoSelectCompanies:function(event)
        {
            event.preventDefault();
            this.allCompanies = true;
            this.showSelectedCompanyNames =false
            this.allCategories = false;
           // this.categories = [];
            this.selectedCategoriesDetails= [];
            this.title="SELECT COMPANIES";
            this.showCategoriesTitle=false;
            this.totalSelectedCompanies = 0;
            this.shopsavvyExist=false;
            this.shopsavvyDetails=null;

        }, 
        getCategories:function(event, collapsibleEvent)
        {
            event.preventDefault();
            this.allCompanies = false
            this.showSelectedCompanyNames = true
            this.showCreateComparisonTableBtn = false;
            this.allCategories = false;
            this.title ="SELECTED COMPANIES"
            this.showCategoriesTitle = true;

            if(this.shopsavvyDetails != null)
            {
                  this.selectedCompaniesDetails.forEach(el => { 
                                         if(el.name == this.shopsavvyDetails.name)
                                             {
                                                this.shopsavvyExist = true;   
                                            }
                                        }
                                    );

                if(!this.shopsavvyExist)
                {
                    this.selectedCompaniesDetails.push(this.shopsavvyDetails);
                }
            }

            this.selectedCompaniesDetails = this.selectedCompaniesDetails.sort(this.GetSortOrder("id"));
            this.totalSelectedCompanies =this.selectedCompaniesDetails.length
            if(this.categories.length<=0)
            {

                this.loadingMessage ="Loading Categories";
                this.loader = true

                axios
                .get("api/getCategories?data_name="+this.categories_data+"&industry_id="+this.selectedIndustryId)
                .then((response) => {
                if (response.data.status === 200) {
                    this.categories = response.data[this.categories_data];
                    this.loader = false;
                    this.loadingMessage ="";
                    this.allCategories = true;
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

            }else{
               this.allCategories =true;
            }           
        },

        getProductAttributes:function()
        {
             axios
                .get("api/getCompanyProducts?data_name=attributes")
                .then((response) => {
                if(response.data.status === 200) 
                {
                    this.companyProductAttributes = response.data.attributes;
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
        getProductCategorySku:function()
        {
            axios
                .get("api/getProductCategorySku?data_name=product_category_sku")
                .then((response) => {
                if (response.data.status === 200) {
                    this.product_category_skus = response.data.product_category_sku;
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
        getDefaultCompanyDetials:function()
        {
           axios
                .get("api/getCompanies?data_name=company&id=2")
                .then((response) => {
                if(response.data.status === 200) 
                {
                    //TODO:: fix the vuex not detected problem
                   // this.$store.commit("putDefaultCompany", response.data.company);
                    this.selectedCompaniesDetails.push(response.data.company);
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
      mounted(){
          this.getIndustries();
          this.getProductCategorySku();
      }
   }
</script>

<style scoped>
  .title{
      text-transform: uppercase;
      margin:13px
  }
.option{
    border-radius: 20px;
    border: 1px solid #73AD21;
    padding: 15px; 
    width: 100px;
    height: 15px; 

}

#close {
    float:right;
    display:inline-block;
    padding:2px 5px;
    background:#ccc;
}
.companies-display{
    display: flex;
    	 flex-wrap: wrap;
}
.column_size{
     max-width:    100%;
    
}
.card_name_size{
 padding: 0.4rem;
}
  
  .selected-companies{
     margin-top: 16px!important;
  }

  .f6{
          font-size: 12px!important;
  }

  .topic-tag {
    margin: 0 .125em .333em 0;
}

.delete-topic-button, .topic-tag, .topic-tag-action {
     background-color: #ff6c02;
    border: 1px solid transparent;
    border-radius: 2em;
    display: inline-block;
    font-weight: 500;
    line-height: 18px;
    line-height: 22px;
    padding: 0 10px;
    color: white;
     font-size: 0.875rem;
}

a {
    text-decoration: none;
}

.nextBtn{
    display: inline-block;
    padding: 1.0rem 2.20rem 1.0rem 2.0rem;
    border: 1px solid #ff6c02;
    border-radius: 4px;
    background-color: #ff6c02;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    line-height: 0;
    text-decoration: none;
    transition: all 0.2s;
}

.testimonial-author{
    	cursor: pointer;
        text-transform: uppercase;
        color:#1e266d;
            font-weight: 600;
         font-size: 0.875rem;
         
}
.closeBtn{
  

        margin-top: -3px;
    font-size: 23px;
    float: right;
    margin-left: 20px;
    	cursor: pointer;
}


 .card-body:hover {
     border: 1px solid #ff6c02;
     border-radius: 0.2px;

}


.industries{
    cursor: pointer;
}

.common{
        font-weight: 600;
    font-size: 0.875rem;
     color:#1e266d;
     text-decoration-line: underline;
}

.vm-header .vm-header-border span{
       font-weight: 600;
    font-size: 0.875rem;
     color:#1e266d;
}
.card-body{
display:flex; justify-content:center; align-items:center;
}

th{
    text-transform: uppercase;
}

</style>
