<template>
  <div>
    <sideBar></sideBar>
    <div class="main-panel">
      <navBar></navBar>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8 offset-md-2">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title" style="text-transform:uppercase;">Set Schedule</h4>
                </div>
                <div class="card-body">
                  <form>
                    <label>Availability</label>

                    <select
                      class="form-control checkbox"
                      v-model="availability"
                      :class="{error: validation.hasError('availability')}"
                     >
                       <option value>Select Option</option>
                      <option value="Available">Available</option>
                      <option value="Unavailable">Unavailable</option>
                      <!-- <option value="Holiday">Holiday</option> -->
                    </select>
                    <div class="message">{{ validation.firstError('availability') }}</div>
                    <br />
                    <label>Starting Week</label>
                    <div style="display:flex">
                      <DatePicker :disabled-date="disabledBeforeTodayAndAfterAWeek" placeholder="Select Start Date"  @change="getWeekDays($event)" @clear="removeOtherDates" class="form-group" v-model="weekStartDate"  valueType="format"></DatePicker>
                    <a
                      href="javascript:void(0);"
                  style="margin:0 5px 0 5px;"
                      class="btn btn-info btn-fill pull-right btn-sm"
                     @click="changeDays('everyday')"
                    >Everyday
                     
                    
                    </a>
                     <a
                      href="javascript:void(0);"
                     style="margin:0 5px 0 5px;"
                      class="btn btn-info btn-fill pull-right btn-sm"
                      @click="changeDays('weekdays')"
                    >Monday - Friday
                   
                    
                    </a>
                   
                    </div>
                    <div class="message">{{ validation.firstError('weekStartDate') }}</div>
                     <div  v-show="pastDate" class="message">Date cannot be in the past</div>
                    <br />
                    <table style="width:100%">
                      <tr>
                        <td class="align">
                          <label>Monday</label>
                          <input
                            type="checkbox"
                            v-model="monday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('monday')}"
                          />
                          <div class="message">{{ validation.firstError('monday') }}</div>
                          {{firstDayOfTheweek}}
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />
                            <DatePicker
                            v-model="mondayStart"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                            @change="getMondayStartTime($event)"
                              ></DatePicker>
                          
                        <div class="message">{{ validation.firstError('mondayStart') }}</div>
                         <div class="message" v-show="showMondayErrors">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />
                           <DatePicker
                            v-model="mondayEnd"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                            @change="getMondayEndTime($event)"
                              ></DatePicker>
                         
                          <div class="message">{{ validation.firstError('mondayEnd') }}</div>
                         
                        </td>
                      </tr>
                      <tr>
                        <td class="align">
                          <label>Tuesday</label>
                          <input
                            type="checkbox"
                            v-model="tuesday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('tuesday')}"
                          />
                          <div class="message">{{ validation.firstError('tuesday') }}</div>
                          {{secondDayOfTheweek}}
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />
                          <DatePicker
                            v-model="tuesdayStart"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                                @change="getTuesdayStartTime($event)"
                              ></DatePicker>
                          
                          <div class="message">{{ validation.firstError('tuesdayStart') }}</div>
                             <div class="message" v-show="showTuesdayError">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />
                         
                           <DatePicker
                            v-model="tuesdayEnd"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                                @change="getTuesdayEndTime($event)"
                              ></DatePicker>
                          <div class="message">{{ validation.firstError('tuesdayEnd') }}</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align">
                          <label>Wednesday</label>
                          <input
                            type="checkbox"
                            v-model="wednesday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('wednesday')}"
                          />
                          <div class="message">{{ validation.firstError('wednesday') }}</div>
                          {{thirdDayOfTheweek}}
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />

                           <DatePicker
                            v-model="wednesdayStart"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                                @change="getWednesdayStartTime($event)"
                              ></DatePicker>

                         
                          <div class="message">{{ validation.firstError('wednesdayStart') }}</div>
                             <div class="message" v-show="showWednesdayError">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />
                            <DatePicker
                            v-model="wednesdayEnd"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                                @change="getWednesdayEndTime($event)"
                              ></DatePicker>
                         
                          <div class="message">{{ validation.firstError('wednesdayEnd') }}</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align">
                          <label>Thursday</label>
                          <input
                            type="checkbox"
                            v-model="thursday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('thursday')}"
                          />
                          <div class="message">{{ validation.firstError('thursday') }}</div>
                          {{forthDayOfTheweek}}
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />

                           <DatePicker
                            v-model="thursdayStart"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                                @change="getThursdayStartTime($event)"
                              ></DatePicker>


                          <div class="message">{{ validation.firstError('thursdayStart') }}</div>
                             <div class="message" v-show="showThursdayError">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />
                           <DatePicker
                            v-model="thursdayEnd"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                                @change="getThursdayEndTime($event)"
                              ></DatePicker>
                        
                          <div class="message">{{ validation.firstError('thursdayEnd') }}</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align">
                          <label>Friday</label>
                          <input
                            type="checkbox"
                            v-model="friday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('friday')}"
                          />
                          {{fifthDayOfTheweek}}
                          <div class="message">{{ validation.firstError('friday') }}</div>
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />

                            <DatePicker
                            v-model="fridayStart"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                                @change="getFridayStartTime($event)"
                              ></DatePicker>

                        
                          <div class="message">{{ validation.firstError('fridayStart') }}</div>
                             <div class="message" v-show="showFridayError">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />
                            <DatePicker
                            v-model="fridayEnd"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                                @change="getFridayEndTime($event)"
                              ></DatePicker>
                         
                          <div class="message">{{ validation.firstError('fridayEnd') }}</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align">
                          <label>Saturday</label>
                          <input
                            type="checkbox"
                            v-model="saturday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('saturday')}"
                          />
                          {{sixthDayOfTheweek}}
                          <div class="message">{{ validation.firstError('saturday') }}</div>
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />
                             <DatePicker
                            v-model="saturdayStart"
                             :editable="canEdit"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                                @change="getSaturdayStartTime($event)"
                              ></DatePicker>
                         
                          <div class="message">{{ validation.firstError('saturdayStart') }}</div>
                             <div class="message" v-show="showSaturdayError">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />
                             <DatePicker
                            v-model="saturdayEnd"
                             :editable="canEdit"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                                @change="getSaturdayEndTime($event)"
                              ></DatePicker>
                        
                          <div class="message">{{ validation.firstError('saturdayEnd') }}</div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align">
                          <label>Sunday</label>
                          <input
                            type="checkbox"
                            v-model="sunday"
                            class="form-control checkbox"
                            :class="{error: validation.hasError('sunday')}"
                          />
                          {{seventhDayOfTheweek}}
                          <div class="message">{{ validation.firstError('sunday') }}</div>
                        </td>
                        <td>
                          <label>Starting Time</label>
                          <br />

                              <DatePicker
                            v-model="sundayStart"
                             :editable="canEdit"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select Start Time"
                                @change="getSundayStartTime($event)"
                              ></DatePicker>
                        
                          <div class="message">{{ validation.firstError('sundayStart') }}</div>
                             <div class="message" v-show="showSundayError">{{ mondayEndStart }}</div>
                        </td>
                        <td>
                          <label>Ending Time</label>
                          <br />

                            <DatePicker
                            v-model="sundayEnd"
                             :editable="canEdit"
                            format="HH:mm"
                            value-type="format"
                            type="time"
                            placeholder="Select End Time"
                                @change="getSundayEndTime($event)"
                              ></DatePicker>
                         
                          <div class="message">{{ validation.firstError('sundayEnd') }}</div>
                        </td>
                      </tr>
                    </table>

                    <br />

                    <a
                      type="submit"
                      href="javascript:void(0);"
                      class="btn btn-info btn-fill pull-left"
                      @click="clearForm()"
                    >Clear
                    
                    </a>
                    <a
                    style="margin-left:10px;"
                      href="javascript:void(0);"
                      type="submit"
                      class="btn btn-info btn-fill"
                      @click="submitData($event)"
                    >{{text}}
                      <Spinner v-show="saving" size="small"></Spinner>
                    </a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <siteFooter></siteFooter>
    </div>
  </div>
</template>
<script>
import Vue from "vue";
import axios from "axios";
import navBar from "../navBar.vue";
import sideBar from "../sideBar.vue";
import siteFooter from "../dashboard/siteFooter.vue";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import { message } from "ant-design-vue";
import Antd from "ant-design-vue";
import "ant-design-vue/dist/antd.css";
import moment from "moment";
import SimpleVueValidation from "simple-vue-validator";
const Validator = SimpleVueValidation.Validator;
import Spinner from 'vue-simple-spinner';
Vue.use(SimpleVueValidation);
Vue.use(Antd);
export default {
  name: "availability",
  components: {
    navBar,
    sideBar,
    siteFooter,
    DatePicker,
    moment,
    Spinner
  },
  data() {
    return {
      savedDates:[],
      text:"SAVE",
      saving:false,
      canEdit:true,
      availability: "",
      monday: "",
      mondayStart: "",
      mondayEnd: "",
      tuesday: "",
      tuesdayStart: "",
      tuesdayEnd: "",
      wednesday: "",
      wednesdayEnd: "",
      wednesdayStart: "",
      thursday: "",
      thursdayStart: "",
      thursdayEnd: "",
      weekStartDate: "",
      friday: "",
      fridayStart: "",
      fridayEnd: "",
      saturday: "",
      saturdayStart: "",
      saturdayEnd: "",
      sunday: "",
      sundayEnd: "",
      sundayStart: "",
      openMondayStart: false,
      openMondayEnd: false,
      openTuesdayStart: false,
      openTuesdayEnd: false,
      openWednesdayStart: false,
      openWednesdayEnd: false,
      openThursdayStart: false,
      openThursdayEnd: false,
      openFridayStart: false,
      openFridayEnd: false,
      openSaturdayStart: false,
      openSaturdayEnd: false,
      openSundayStart: false,
      openSundayEnd: false,
      minDatetime: "",
      firstDayOfTheweek: "",
      secondDayOfTheweek: "",
      thirdDayOfTheweek: "",
      forthDayOfTheweek: "",
      fifthDayOfTheweek: "",
      sixthDayOfTheweek: "",
      seventhDayOfTheweek: "",
      pastDate:false,
      mondayEndStart: "start must be less than end time",
      showMondayErrors:false,
      showTuesdayError:false,
      showWednesdayError:false,
      showThursdayError:false,
      showFridayError:false,
      showSaturdayError:false,
      showSundayError:false,

    };
  },
  validators: {
    
    availability: function (value) {
      return Validator.value(value).required();
    },
    weekStartDate: function (value) {
      return Validator.value(value).required();
    },
    monday: function (value) {
      return Validator.value(value).required();
    },
    mondayStart: function (value) {
      return Validator.value(value).required();
    },
    mondayEnd: function (value) {
      return Validator.value(value).required();
    },

    tuesday: function (value) {
      return Validator.value(value).required();
    },
    tuesdayStart: function (value) {
      return Validator.value(value).required();
    },
    tuesdayEnd: function (value) {
      return Validator.value(value).required();
    },

    wednesday: function (value) {
      return Validator.value(value).required();
    },
    wednesdayStart: function (value) {
      return Validator.value(value).required();
    },
    wednesdayEnd: function (value) {
      return Validator.value(value).required();
    },

    thursday: function (value) {
      return Validator.value(value).required();
    },
    thursdayStart: function (value) {
      return Validator.value(value).required();
    },
    thursdayEnd: function (value) {
      return Validator.value(value).required();
    },

    friday: function (value) {
      return Validator.value(value).required();
    },
    fridayStart: function (value) {
      return Validator.value(value).required();
    },
    fridayEnd: function (value) {
      return Validator.value(value).required();
    },

    saturday: function (value) {
      return Validator.value(value).required();
    },
    saturdayStart: function (value) {
      return Validator.value(value).required();
    },
    saturdayEnd: function (value) {
      return Validator.value(value).required();
    },

    sunday: function (value) {
      return Validator.value(value).required();
    },
    sundayStart: function (value) {
      return Validator.value(value).required();
    },
    sundayEnd: function (value) {
      return Validator.value(value).required();
    },
   
  },
  methods: {
    disabledBeforeTodayAndAfterAWeek(date) {
      const today = new Date();
     // today.setHours(0, 0, 0, 0);
      return date < today;
    },

    checkIfDatesAreEqual:function()
    {
          var choosedDate  = arguments[0];
          this.savedDates.forEach((el)=>{
          if(el === choosedDate)
          {
              return true;
          }else{
             return false;
          }
          });
    },
    getMondayStartTime:function()
    {      
        if(!this.mondayEnd)
        {
          if(this.mondayStart >= this.mondayEnd)
          {
            this.showMondayErrors =true;
          }else{
              this.showMondayErrors=false;
          }
        }else{
            if(this.mondayStart >= this.mondayEnd)
            {
              this.showMondayErrors =true;
            }else{
                this.showMondayErrors=false;
            }
        }  
    },
    getMondayEndTime:function()
    {
      if(this.mondayStart >= this.mondayEnd)
      {
         this.showMondayErrors =true;
      }else{
          this.showMondayErrors=false;
      }
    },

    getTuesdayStartTime:function()
    {
        if(!this.tuesdayEnd)
        {
          if(this.tuesdayStart >=this.tuesdayEnd)
          {
            this.showTuesdayError =true;
          }else{
              this.showTuesdayError=false;
          }
        }else{
            if(this.tuesdayStart >= this.tuesdayEnd)
            {
              this.showTuesdayError =true;
            }else{
                this.showTuesdayError=false;
            }
        }  
    },
    getTuesdayEndTime:function()
    {
      if(this.tuesdayStart >= this.tuesdayEnd)
      {
         this.showTuesdayError =true;
      }else{
          this.showTuesdayError=false;
      }
    },

    getWednesdayStartTime:function()
    {
        if(!this.wednesdayEnd)
        {
          if(this.wednesdayStart >= this.wednesdayEnd)
          {
            this.showWednesdayError =true;
          }else{
              this.showWednesdayError=false;
          }
        }else{
            if(this.wednesdayStart >= this.wednesdayEnd)
            {
              this.showWednesdayError =true;
            }else{
                this.showWednesdayError=false;
            }
        }  
    },
    getWednesdayEndTime:function()
    {
      if(this.wednesdayStart >= this.wednesdayEnd)
      {
         this.showWednesdayError =true;
      }else{
          this.showWednesdayError=false;
      }
    },

    
    getThursdayStartTime:function()
    {
        if(!this.thursdayEnd)
        {
          if(this.thursdayStart >= this.thursdayEnd)
          {
            this.showThursdayError =true;
          }else{
              this.showThursdayError=false;
          }
        }else{
            if(this.thursdayStart >= this.thursdayEnd)
            {
              this.showThursdayError =true;
            }else{
                this.showThursdayError=false;
            }
        }  
    },
    getThursdayEndTime:function()
    {
      if(this.thursdayStart >= this.thursdayEnd)
      {
         this.showThursdayError =true;
      }else{
          this.showThursdayError=false;
      }
    },


    getFridayStartTime:function()
    {
        if(!this.fridayEnd)
        {
          if(this.fridayStart >= this.fridayEnd)
          {
            this.showFridayError =true;
          }else{
              this.showFridayError=false;
          }
        }else{
            if(this.fridayStart >= this.fridayEnd)
            {
              this.showFridayError =true;
            }else{
                this.showFridayError=false;
            }
        }  
    },
    getFridayEndTime:function()
    {
      if(this.fridayStart >= this.fridayEnd)
      {
         this.showFridayError =true;
      }else{
          this.showFridayError=false;
      }
    },

      getSaturdayStartTime:function()
    {
        if(!this.saturdayEnd)
        {
          if(this.saturdayStart >= this.saturdayEnd)
          {
            this.showSaturdayError =true;
          }else{
              this.showSaturdayError=false;
          }
        }else{
            if(this.saturdayStart >= this.saturdayEnd)
            {
              this.showSaturdayError =true;
            }else{
                this.showSaturdayError=false;
            }
        }  
    },
    getSaturdayEndTime:function()
    {
      if(this.saturdayStart >= this.saturdayEnd)
      {
         this.showSaturdayError =true;
      }else{
          this.showSaturdayError=false;
      }
    },

     getSundayStartTime:function()
    {
        if(!this.sundayEnd)
        {
          if(this.sundayStart >= this.sundayEnd)
          {
            this.showSundayError =true;
          }else{
              this.showSundayError=false;
          }
        }else{
            if(this.sundayStart >= this.sundayEnd)
            {
              this.showSundayError =true;
            }else{
                this.showSundayError=false;
            }
        }  
    },
    getSundayEndTime:function()
    {
      if(this.sundayStart >= this.sundayEnd)
      {
         this.showSundayError =true;
      }else{
          this.showSundayError=false;
      }
    },
   
    removeOtherDates:function()
    {
      this.firstDayOfTheweek="";
      this.secondDayOfTheweek="";
      this.thirdDayOfTheweek="";
      this.forthDayOfTheweek="";
      this.fifthDayOfTheweek="";
      this.sixthDayOfTheweek="";
      this.seventhDayOfTheweek="";
       this.pastDate = false;
    },
    clearForm:function()
    {
      this.firstDayOfTheweek="";
      this.secondDayOfTheweek="";
      this.thirdDayOfTheweek="";
      this.forthDayOfTheweek="";
      this.fifthDayOfTheweek="";
      this.sixthDayOfTheweek="";
      this.seventhDayOfTheweek="";
      this.availability="";
      this.monday="";
      this.tuesday="";
      this.wednesday="";
      this.thursday="";
      this.friday="";
        this.saturday="";
        this.sunday="";
       this.mondayStart="";
      this.mondayEnd="";
       this.tuesdayStart="";
        this.tuesdayEnd="";
        this.wednesdayStart="";
       this.wednesdayEnd="";
        this.thursdayStart="";
      this.thursdayEnd="";
        this.fridayStart="";
        this.fridayEnd="";
       this.saturdayStart="";
       this.saturdayEnd="";
       this.sundayStart="";
       this.sundayEnd="";
        this.weekStartDate="";
       
      this.validation.reset();
    },

    checkDates:function()
    {
      let data = {
        monday:this.firstDayOfTheweek,
        tuesday:this.secondDayOfTheweek,
        wednesday:this.thirdDayOfTheweek,
        thursday:this.forthDayOfTheweek,
        friday:this.fifthDayOfTheweek,
        saturday:this.sixthDayOfTheweek,
        sunday:this.seventhDayOfTheweek
      }
        axios
            .post("api/checkDates", data)
            .then((response) => {
              if (response.data.status === 200) {
                  this.savedDates  = response.data.data;
              } else {
                Vue.$toast.open({
                  message: response.data.message,
                  type: response.data.type,
                  position: response.data.position,
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
    getWeekDays:function()
    {
      var date = new Date(arguments[0]);
      this.monday = false;
      this.tuesday = false;
      this.wednesday = false;
      this.thursday = false;
      this.friday = false;
      this.saturday = false;
      this.sunday = false;
      var first = date.getDate() - date.getDay();
      var firstday = new Date(date.setDate(first + 1)).toUTCString();
      var secondday = new Date(date.setDate(first + 2)).toUTCString();
      var thirdday = new Date(date.setDate(first + 3)).toUTCString();
      var forthday = new Date(date.setDate(first + 4)).toUTCString();
      var fifthday = new Date(date.setDate(first + 5)).toUTCString();
      var sixthday = new Date(date.setDate(first + 6)).toUTCString();
      var sevenday = new Date(date.setDate(first + 7)).toUTCString();
      this.firstDayOfTheweek = moment(firstday).format("DD-MMM-YYYY");
      this.secondDayOfTheweek = moment(secondday).format("DD-MMM-YYYY");
      this.thirdDayOfTheweek = moment(thirdday).format("DD-MMM-YYYY");
      this.forthDayOfTheweek = moment(forthday).format("DD-MMM-YYYY");
      this.fifthDayOfTheweek = moment(fifthday).format("DD-MMM-YYYY");
      this.sixthDayOfTheweek = moment(sixthday).format("DD-MMM-YYYY");
      this.seventhDayOfTheweek = moment(sevenday).format("DD-MMM-YYYY");
       this.checkDates();
    },
    submitData: function () {
      event.preventDefault();
      let data = {
        title: this.availability,
        monday: this.monday,
        tuesday: this.tuesday,
        wednesday: this.wednesday,
        thursday: this.thursday,
        friday: this.friday,
        saturday: this.saturday,
        sunday: this.sunday,
        mondayStart:this.mondayStart,
        mondayEnd:this.mondayEnd,
        tuesdayStart:this.tuesdayStart,
        tuesdayEnd:this.tuesdayEnd,
        wednesdayStart:this.wednesdayStart,
        wednesdayEnd:this.wednesdayEnd,
        thursdayStart:this.thursdayStart,
        thursdayEnd:this.thursdayEnd,
        fridayStart:this.fridayStart,
        fridayEnd:this.fridayEnd,
        saturdayStart:this.saturdayStart,
        saturdayEnd:this.saturdayEnd,
        sundayStart:this.sundayStart,
        sundayEnd:this.sundayEnd,
        weekStartDate: this.weekStartDate,
        mondayOfTheweek: this.firstDayOfTheweek,
        tuesdayOfTheweek: this.secondDayOfTheweek,
        wednesdayOfTheweek: this.thirdDayOfTheweek,
        thursdayOfTheweek: this.forthDayOfTheweek,
        fridayOfTheweek: this.fifthDayOfTheweek,
        saturdayOfTheweek: this.sixthDayOfTheweek,
        sundayOfTheweek: this.seventhDayOfTheweek,
      };

      this.$validate().then(function (success) {
        if (success) {
          axios
            .post("api/availableTime", data)
            .then((response) => {
              
              if (response.data.status === 201) {
                Vue.$toast.open({
                  message: response.data.message,
                  type: response.data.type,
                  position: response.data.position,
                });

                setTimeout(() => {
                  window.location.reload();
                }, 3000);

               
              } else {
                Vue.$toast.open({
                  message: response.data.message,
                  type: response.data.type,
                  position: response.data.position,
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
      });
    },
    changeDays: function () {
      event.preventDefault();
      if (arguments[0] === "everyday") {
        this.monday = true;
        this.tuesday = true;
        this.wednesday = true;
        this.thursday = true;
        this.friday = true;
        this.saturday = true;
        this.sunday = true;
        this.saturdayStart ="";
        this.saturdayEnd ="";
        this.sundayStart ="";
        this.sundayEnd ="";
      } else {
        this.monday = true;
        this.tuesday = true;
        this.wednesday = true;
        this.thursday = true;
        this.friday = true;
        this.saturday = false;
        this.sunday = false;
        this.saturdayStart ="00:00";
        this.saturdayEnd ="00:00";
        this.sundayStart ="00:00";
        this.sundayEnd ="00:00";
        this.canEdit =false;
      }
    },
  },
};
</script>
<style scoped>
.days {
  float: right;
}
.checkbox {
  height: 13px;
}
.form-control {
  padding: 0px;
  height: 20px;
}
.main-panel {
  overflow: auto;
  max-height: calc(100vh - 30px);
  min-height: 100%;
}

.align {
  display: block;
}
.message {
  color: red;
}
.btn-sm {
    font-size: 12px;
    border-radius: 3px;
    padding: 5px 10px;
    height: 34px;}

</style>
