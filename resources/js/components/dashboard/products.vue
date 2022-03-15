<template>
  <div>
    <sideBar></sideBar>
    <div class="main-panel">
      <navBar></navBar>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="content-panel">
                <div id="table">
                  <VueGoodTable
                    ref="users"
                    :columns="columns"
                    :rows="rows"
                    @on-page-change="onPageChange"
                    @on-sort-change="onSortChange"
                    @on-column-filter="onColumnFilter"
                    @on-per-page-change="onPerPageChange"
                   
                    :isLoading.sync="isLoading"
                    :search-options="{
                                        enabled: true,
                                        width: '100px',
                                        placeholder:'Search Products'
                                    }"
                    :sort-options="{
                                        enabled: true,
                                        initialSortBy: {
                                            field: 'name',
                                            type: 'asc'
                                        }
                                    }"
                    :pagination-options="{
                                        enabled: true,
                                        mode: 'pages',
                                        perPage: 10,
                                        position: 'top',
                                        perPageDropdown: [25, 50, 100],
                                        dropdownAllowAll: false,
                                        setCurrentPage: 1,
                                        nextLabel: 'next',
                                        prevLabel: 'prev',
                                        rowsPerPageLabel: 'Rows per page',
                                        ofLabel: 'of',
                                        pageLabel: 'page', // for 'pages' mode
                                        allLabel: 'All'
                                    }"
                  >
                    <div slot="table-actions">
                        <button class="btn btn-small" @click="openModal($event)" modalName="Add Population" style="margin-right:10px;">NEW</button>
                     
                    </div>
                    <!-- <div slot="selected-row-actions">
                      <button @click="activateSelected('activate')">Multiple Activate</button>
                      <button @click="deactivateSelected('deactivate')">Multiple De-activate</button>
                    </div>-->

                    <div slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'btn'">
                        <div style="display:flex;">
                            <button
                              @click="deleteRecord(props.formattedRow)"
                              class="btn btn-sm primary"
                              style="margin-right:10px;"
                              type="button"
                            >DELETE</button>

                             <!-- <button
                              @click="openEditModal(props.formattedRow)"
                              class="btn btn-sm primary"
                              style="margin-right:10px;"
                              type="button"
                            >EDIT</button> -->
                         
                        </div>
                        
                      </span>
                      <span v-else>
                        {{
                        props.formattedRow[
                        props.column.field
                        ]
                        }}
                      </span>
                    </div>
                  </VueGoodTable>

        <modal ref="industryPad" title="ADD PRODUCT" width="950px" no-close-on-backdrop no-close-on-esc hide-cancel :hide-ok="true" @cancel="$refs.industryPad.hide()" centered>
                      
          

                  <form>
                    <div class="row">

                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Industry</label>
                           <v-select   :options="industries"  label="name"   @input="getCategoriesPerIndustry" v-model="industry_id"></v-select>
                        </div>
                      </div>

                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label> Category</label>
                            <v-select   :options="industry_categories"  label="name"   @input="getSkuPerCategory" @select='select' v-model="product_category_id" ></v-select>
                        </div>
                      </div>


                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Company</label>
                           <v-select @input="setSelected"  :options="companies" multiple   label="name" @select='select' v-model="company_id"></v-select>
                        </div>
                      </div>

                      
                      <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Product Name</label>
                            <v-select  :options="products" @input="setProductName" label="name"  taggable push-tags></v-select>
                        </div>
                      </div>

                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Manufacturer</label>
                           <v-select   :options="manufacturers"  label="name"  v-model="manufacturer" ></v-select>
                        </div>
                      </div>


                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Size Unit</label> 
                           <v-select   :options="product_skus"  label="name"  v-model="product_size_unit" ></v-select>
                        </div>
                      </div>


                      
                      <div class="col-md-12 pr-1" >
                        <div class="form-group">
                          <label>Sizes</label> 

                            <div  style=" margin: auto;">
                              <span class="size_badge" v-for="size in product_sizes" :key="size">
                              <label>{{size}} {{product_size_unit.measurement}} 

                            <button @click="removeSize(size)"  style="margin-top:-10px;" type="button" class="close" aria-label="Close">
                              &times;
                            </button>

                              </label>
                              </span>
                            </div>
                        </div>
                      </div>


                      <div class="col-md-12 pr-1" >
                        <div class="form-group">
                          <label>New Size</label> 

                           <input   type="text" class="form-control" v-model="new_size" />
                           <p style="color:red;">
                             {{missingNewSize}}
                           </p>
                           <button
                   
                            type="submit"
                            class="btn btn-info btn-fill pull-left"
                            @click="addSize($event)"
                          >
                          New size
                           
                          
                          </button>
                        <br />
                        </div>
                      </div>



                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label> Price</label>

                              <ul class="list-group">
                                <li class="list-group-item" v-for="(company, index) in selectedCompanies" :key="index">
                                 <b style="text-transform:uppercase;"> {{company.name}} </b>
                                    <table class="table" >
                                        <tbody>
                                          <tr  v-for="(size, size_index) in product_sizes" :key="size_index" >
                                            <th scope="row">
                                              {{size}} {{product_size_unit.measurement}}

                                               <input   style="float:right;" type="text"  name="product_price"   @change="(e)=> handleUserInput(e,company,size)" />
                                            </th>
                                          </tr>
                                        </tbody>
                                             
                                      </table>

                                </li>
                              
                              </ul>
                        </div>
                      </div>
                      
                    </div>
                  
                    <button
                   
                      type="submit"
                      class="btn btn-info btn-fill pull-left"
                      @click="addIndustry($event)"
                    >{{text}}
                      <Spinner v-show="saving" size="small"></Spinner>
                    
                    </button>
                    <div class="clearfix"></div>
                  </form>
                      
        </modal>

        <modal ref="editcityPad" title="EDIT PRODUCT" no-close-on-backdrop no-close-on-esc hide-cancel  :hide-ok="true" @cancel="$refs.editcityPad.hide()" centered>

           <form>
                    <div class="row">
                      <div class="col-md-6 pr-1">
                        <div class="form-group">
                          <label> Name</label>
                          <input type="text" class="form-control" v-model="name"  />
                         
                        </div>
                      </div>

                       <div class="col-md-6 pr-1">
                        <div class="form-group">
                          <label> Category</label>
                          <select class="form-control" v-model="product_category_id"> 
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{category.name}}
                               </option>
                          </select>

                        
                        </div>
                      </div>


                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Company</label>

                          <select class="form-control" v-model="company_id"> 
                            <option v-for="company in companies" :key="company.id" :value="company.id">
                                {{company.name}}
                               </option>
                          </select>
                         
                        </div>
                      </div>

                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Price</label>
                          <input type="text" class="form-control" v-model="price"  />
                        </div>
                      </div>

                       <div class="col-md-12 pr-1">
                        <div class="form-group">
                          <label>Description</label>
                          <textarea  type="text"  class="form-control" v-model="description"></textarea>
                        
                        </div>
                      </div>
                      
                    </div>
                  
                    <button
                   
                      type="submit"
                      class="btn btn-info btn-fill pull-left"
                      @click="editIndustry($event)"
                    >{{editText}}
                      <Spinner v-show="saving" size="small"></Spinner>
                    
                    </button>
                    <div class="clearfix"></div>
                  </form>
                     
        </modal>

                </div>
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
import siteFooter from "../dashboard/siteFooter.vue";
import { VueGoodTable } from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";
import axios from "axios";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-default.css";
import "vue-loading-overlay/dist/vue-loading.css";
import Loading from "vue-loading-overlay";
Vue.use(Loading);
Vue.use(VueToast);
import vueSignature from "vue-signature"
import modal from 'vue-modality'
import Spinner from 'vue-simple-spinner'
 import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
  name: "products",
  components: {
    navBar,
    sideBar,
    siteFooter,
    Loading,
    VueGoodTable,
    vueSignature,
    modal,
    Spinner,
    vSelect
  },
   data() {
    return {
      showWarning:false,
      isLoading:true,
      saving:false,
      text:"Save",
      editText:"Edit",
      option:[],
      industries:[],
      categories:[],
      companies:[],
      product_prices:[],
      data_name:"products",
      name:null,
      id:null,
      product_category_id:null,
      company_id:null,
      industry_id:null,
      description:null,
      modalTitle:"ADD COMPANY",
      columns: [
        {
          label: "id",
          field: "id",
          hidden: true,
        },
        {
          label: "Name",
          field: "name",
        },
         {
          label: "Category Name",
          field: "product_category_id",
          hidden:true,
        },
         {
          label: "Category Name",
          field: "category.name",
        },
         {
          label: "Company Name",
          field: "company_id",
          hidden:true
        },
        {
          label: "Action",
          field: "btn",
          html: true,
        },
      ],
      rows: [],
      product_category_id:null,
      selectedCategories:[],
      products:[],
      selectedCompanies:[],
      productName:null,
      product_sizes:[],
      product_size_unit:null,
      product_size:null,
      new_size:null,
      missingNewSize:null,
      price:null,
      manufacturer:null,
      industry_categories:[],
      manufacturers:[],
      product_category_skus:[],
      category_product_category_skus:[],
      product_skus:[]
    };
  },
  methods:{
    getSkuPerCategory:function(record)
    {

      this.product_skus.push(record.sku);

    },
    getCategoriesPerIndustry:function(record)
    {
        this.industry_categories = [];
        this.product_category_id = null;
        this.categories.forEach(element => 
        {
             if(element.industry_id == record.id){
                this.industry_categories.push(element);
             }
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
    removeSize:function()
    {
        const item = this.product_sizes.findIndex(element => element == arguments[0]);
        this.product_sizes.splice(item, 1);
    },
    addSize:function(event)
    {
        event.preventDefault();
        if(this.new_size.length >0)
        {
            this.product_sizes.push(this.new_size);
            this.new_size =null;
        }else{
          this.missingNewSize ="Size cannot be empty"
        }
    },
    setProductName:function(value)
    {
      return this.productName = (typeof value == "string") ? value: value.name;
    },
    select()
    {
    },
    setSelected:function(value)
    {
      this.selectedCompanies = value;
    },
    handleUserInput(e,company,size)
    {
      let companyProductPrice = {
          "company_id":company.id,
          "price":e.target.value,
          "size":size
      };
      this.product_prices.push(companyProductPrice);
    },
    clearFields()
    {
      this.name = "";
      this.price = "";
      this.product_category_id=  "";
      this.company_id= "";
      this.description= "";
      this.industry_id= ""
      this.selectedCompanies =[];
      this.product_sizes =[];
      this.saving =false;
    },
    openModal()
    {
      this.clearFields();
      this.$refs.industryPad.open();
    },
     removeItems: function () {
       arguments[0].forEach((ele) => {
        const item = this.rows.findIndex((p) => p.id === arguments[0]);
        this.rows.splice(item, 1);
      });
    },
    deleteRecord(record)
    {
         this.isLoading =true
        axios
        .delete("api/deleteProduct?id="+ record.id+"&data_name="+this.data_name)
        .then((response) => {
              this.isLoading =false
          if (response.data.status === 204) {
           // this.removeItems(record.id)
             Vue.$toast.open({
              message: response.data.message,
              type: response.data.type,
              position: response.data.position,
            });
          } else {
            Vue.$toast.open({
              message: response.data,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
          this.isLoading = false
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });

    },
    openEditModal(record)
    {
        this.name = record.name;
        this.id = record.id;
        this.description = record.description;
        this.company_id=record.company_id;
        this.product_category_id=record.product_category_id;
        this.price=record.price;
        this.$refs.editcityPad.open();
    },
    editIndustry(event)
    {
         this.saving =true;
            this.editText =""
            event.preventDefault();
            let data = {
                name:this.name,
                id:this.id,
                  price:this.price,
                product_category_id:this.product_category_id,
                company_id:this.company_id,
                description:this.description,
                sku_id:this.product_size_unit.id
            };
            axios
            .put("api/updateProduct", data)
            .then((response) => {
            this.saving =false;
            this.editText ="Edit"
            if(response.data.status == 200)
            {
                Vue.$toast.open({
                    message: response.data.message,
                    type: response.data.type,
                    position: response.data.position,
                });
               
                this.$refs.editcityPad.hide();
                setTimeout(() => {
                    this.loadItems()
                }, 3500);
                
            }else{
                Vue.$toast.open({
                            message: response.data.message,
                            type: response.data.type,
                            position: response.data.position,
                        });
                }
            })
                .catch((error) => {
                this.saving = false;
                this.text ="Save"
                Vue.$toast.open({
                    message: response.message,
                    type: "error",
                    position: "top",
                });
                });

    },
     addIndustry(event)
    {
        
            this.saving =true;
            this.text =""
            event.preventDefault();
            
            let data = {
                name:this.productName,
                product_category_id:this.product_category_id.id,
                company_id:this.company_id,
                description:this.description,
                tax:null,
                discount:null,
                industry_id:this.industry_id.id,
                product_prices:this.product_prices,
                manufacturer_id:this.manufacturer.id,
                sku_id:this.product_size_unit.id
            };
            axios
            .post("api/newProduct?data_name=product" , data)
            .then((response) => {
            this.saving =false;
            this.text ="Save"
            if(response.data.status == 201)
            {
                Vue.$toast.open({
                    message: response.data.message,
                    type: response.data.type,
                    position: response.data.position,
                });
              this.clearFields();

                this.$refs.industryPad.hide();
                setTimeout(() => {
                    this.loadItems()
                }, 3500);
                
            }else{
                Vue.$toast.open({
                            message: response.data.message,
                            type: response.data.type,
                            position: response.data.position,
                        });
                }
            })
                .catch((error) => {
                this.saving = false;
                this.text ="Save"
                Vue.$toast.open({
                    message: response.message,
                    type: "error",
                    position: "top",
                });
                });

    },
         updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },
            onPageChange(params) {
      this.updateParams({ page: params.currentPage });
      this.loadItems();
    },

    onPerPageChange(params) {
      this.updateParams({ perPage: params.currentPerPage });
      this.loadItems();
    },

    onSortChange(params) {
      this.updateParams({
        // sort: [
        //   {
        //     type: params.sortType,
        //     field: this.columns[params.columnIndex].field,
        //   },
        // ],
      });
      this.loadItems();
    },
    getSkus()
    {
      axios
        .get("api/getSkus?data_name=skus")
        .then((response) => {
           this.isLoading =false
          if (response.data.status === 200) {
         
            this.skus = response.data["skus"];
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
    onColumnFilter(params) {
      this.updateParams(params);
      this.loadItems();
    },
    loadItems() {
      this.isLoading =true
      axios
        .get("api/getProducts?data_name="+this.data_name)
        .then((response) => {
           this.isLoading =false
          if (response.data.status === 200) {
            this.totalRecords = response.data[this.data_name].length;
            this.rows = response.data[this.data_name];
          } else {

            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
             this.isLoading =false
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });
    },
    getIndustryCategory()
    {

    },

    getCategories()
    {

      //HTTP_GET('api/getCategories?data_name=categories')

     // HTTP_GET
       axios
        .get("api/getCategories?data_name=categories")
        .then((response) => {
           this.isLoading =false
          if (response.data.status === 200) {
            this.categories = response.data.categories;
          } else {

            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
             this.isLoading =false
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });
    },
    getIndustries()
    {
       axios
        .get("api/getIndustries?data_name=industries")
        .then((response) => {
          // this.isLoading =false
          if (response.data.status === 200) {

             response.data.industries.forEach((element) => {
            let agent = {
              name: element.name ,
              id: element.id,
            };
            this.industries.push(agent);
          });

          //  this.industries = response.data.industries;
          } else {

            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
         //    this.isLoading =false
          Vue.$toast.open({
            message: error.message,
            type: "error",
            position: "top",
          });
        });

    },
    getManufacturers:function()
    {
         axios
          .get("api/getManufacturer?data_name=manufacturers")
          .then((response) => {
            this.isLoading =false
            if (response.data.status === 200) {
              this.manufacturers = response.data.manufacturers;
            } else {

              Vue.$toast.open({
                message: response.data.message,
                type: "error",
                position: "top",
              });
            }
          })
          .catch((error) => {
              this.isLoading =false
            Vue.$toast.open({
              message: error.message,
              type: "error",
              position: "top",
            });
          });

    },
    getProducts:function()
    {
        axios
          .get("api/getProducts?data_name=products")
          .then((response) => {
            this.isLoading =false
            if (response.data.status === 200) {
              this.products = response.data.products;
            } else {

              Vue.$toast.open({
                message: response.data.message,
                type: "error",
                position: "top",
              });
            }
          })
          .catch((error) => {
              this.isLoading =false
            Vue.$toast.open({
              message: error.message,
              type: "error",
              position: "top",
            });
          });
    },
      getCompanies()
    {
       axios
        .get("api/getCompanies?data_name=companies")
        .then((response) => {
           this.isLoading =false
          if (response.data.status === 200) {
            this.companies = response.data.companies;
          } else {

            Vue.$toast.open({
              message: response.data.message,
              type: "error",
              position: "top",
            });
          }
        })
        .catch((error) => {
             this.isLoading =false
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
    this.getCategories()
    this.getIndustries() 
    this.getCompanies()
    this.getProducts()
    this.getSkus();
    this.getManufacturers();
    this.getProductCategorySku();
  }
}
  </script>
  <style scoped>
  .size_badge{
    display: inline-block;
    padding: .25em .4em;
    font-size: 95%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
  }

  </style>