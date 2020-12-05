<template>
   <div class="row">
      <div class="col-md-12">
         <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
               <a class="nav-item nav-link active" id="nav-variant-tab" data-toggle="tab" href="#nav-variant" role="tab" aria-controls="nav-variant" aria-selected="true">Variant</a>
               <a class="nav-item nav-link" id="nav-combination-tab" data-toggle="tab" href="#nav-combination" role="tab" aria-controls="nav-combination" aria-selected="false">Combination</a>
               <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Gallery</a>
            </div>
         </nav>
         <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-variant" role="tabpanel" aria-labelledby="nav-variant-tab">
               <div class="card">
                  <div class="card-header">
                     <h6>Add Product Variation</h6>
                     <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right" @click="openModal('#createModal')"><i class="fas fa-plus fa-sm text-white-50"></i> Add Product Variation Option</a>
                  </div>
                  <div class="card-body">
                     <form action="" method="POST" @submit.prevent="storeVariant(ProductVariant)">
                        <div class="row">
                           <div class="col-md-12">
                              <br>
                              <label for="">Variant Name</label>
                              <input type="text" name="" id="" class="form-control" v-model="ProductVariant.name">
                           </div>
                           <div class="col-md-12">
                              <br>
                              <div class="form-group">
                                 <button class="btn btn-primary">Submit</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade" id="nav-combination" role="tabpanel" aria-labelledby="nav-combination-tab">
               <div class="card">
                  <div class="card-header">
                     <h6>Product Combination</h6>
                  </div>
                  <div class="card-body">
                     <form action="" method="POST" @submit.prevent="storeStock(stock)">
                        <div class="row">
                           <div class="col-md-12" v-for="(variants,index) in ProductVariationWithOption" :key="index+1">
                              <label for="">{{variants.name}}:</label>
                              <div class="form-check form-check-inline" v-for="(option,index) in variants.product_variation_options" :key="index+1">
                                 <input class="form-check-input" type="checkbox" :id="'variants_'+ index+option" v-model="stock.option" :value="option.name">
                                 <label :for="'variants_'+ index+option"><span class="badge badge-pill badge-primary">{{option.name}}</span></label>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <br>
                              <label for="">SKU</label>
                              <input type="text" name="" id="" class="form-control" v-model="stock.sku">
                           </div>
                           <div class="col-md-12">
                              <label for="">Price</label>
                              <input type="text" name="" id="" class="form-control" v-model="stock.price">
                           </div>

                           <div class="col-md-12">
                              <label for="">Discount Price</label>
                              <input type="text" name="" id="" class="form-control" v-model="stock.discount_price">
                           </div>
                           <div class="col-md-12">
                              <label for="">Total Quantity</label>
                              <input type="text" name="" id="" class="form-control" v-model="stock.quantity">
                           </div>
                           <div class="col-md-12">
                              <br>
                              <div class="form-group">
                                 <button class="btn btn-primary">Submit</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
               <div class="card">
                  <div class="card-header">
                     <h6>Product Combination</h6>
                  </div>
                  <div class="card-body">
                     <form action="" method="POST" @submit.prevent="storeProductImage(imageData)">
                        <div class="row">
                           <div class="col-md-12">
                              <select name="" id="" class="form-control" v-model="imageData.option">
                                 <option value="">Select the variation option</option>
                                 <option v-for="(option,index) in allVar" :key="index" :value="option.id">{{option.name}}</option>
                              </select>
                           </div>
                           <div class="col-md-12">
                              
                              <ul>
                                 <br>
                                 <li class="image_class" v-for="(image,index) in galleries" :key="index">
                                    <input type="checkbox"  id="'_myCheckbox'+index" v-model="imageData.images" :value="image.id"/>
                                    
                                       <input type="radio" id="preview_image" v-model="imageData.preview_image" :value="image.id" checked>
                                       <label for="preview_image">Select as Featured Image</label>
                                       <label for="'_myCheckbox'+index"><img :src="image.small" alt="" />
                                    </label>
                                 </li>
                              </ul>
                           </div>
                           <div class="col-md-12">
                              <br>
                              <div class="form-group">
                                 <button class="btn btn-primary">Submit</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- createModal -->
      <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:130%">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Variation Options<strong></strong></h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <form action="" method="Post" @submit.prevent="storeProdVarOpt(opt)">
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-12">
                           <label for=""><b>Select Product Variation:</b></label>
                           <select name="" id="" class="form-control" v-model="opt.prodVar_id">
                              <option disabled>Select Variation</option>
                              <option v-for="(va,index) in prodVar" :key="index" :value="va.id">{{va.name}}</option>
                           </select>
                        </div>
                        <div class="col-md-12">
                           <label for=""><b>Product variation option name:</b></label>
                           <input type="text" v-model="opt.name" id="name1" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <div class="form-group">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                     </div>
                     <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      
      <!-- createModal -->
   </div>
</template>
<script>
import mixin from '../mixin'

const STOCK_URL="/api/admin/stores";
const PRODUCT_VARIANT_URL="/api/admin/product/variation/store";
const PRODUCT_VARIANT_OPTION_URL="/api/admin/product/variation/option/store";
const PRODUCT_IMAGE_URL="/api/admin/product/image/store"
export default {
    mixins: [mixin],
   props:['product'],
    data(){
        return{
           ProductVariationWithOption:[],
          allVar:[],
          prodVar:[],
          var_id:'',
          option:[],
          galleries:[],
          stock:{
              sku:'',
              price:'',
              option:[],
              quantity:'',
              discount_price:'',
              product_id:this.product.id,
          },

          ProductVariant:{
              name:'',
              product_id:this.product.id,
          },

          opt:{
              name:'',
              prodVar_id:'',
          },
          imageData:{
              images:[],
              option:"",
              preview_image:'',
              product_id:'',
          }
          
        }
    },
    methods: {
        getVariations(data){  
             this.getVar(data);
         },

         storeStock(stock){
             this.stock.sku=stock.sku;
             this.stock.price=stock.price;
             this.stock.option=stock.option;
             this.stock.quantity=stock.quantity;
             this.stock.product_id;
             this.stock.discount_price=stock.discount_price;
             console.log(stock);
             this.$http.post(STOCK_URL,stock)
             .then(response=>{
                 this.successSweetAlert();
                    this.SuccessToaster();
                    this.reload();
                 console.log(response);
             })
             .catch(errors=>{
                this.failedSweetAlert();
                this.FailedToaster();
                this.reload();
                console.log(errors);
             })
         },

         storeVariant(data){
             this.ProductVariant.name=data.name;
             this.ProductVariant.product_id;
             console.log(data);
             this.$http.post(PRODUCT_VARIANT_URL,data)
             .then(response=>{
                 this.successSweetAlert();
                    this.SuccessToaster();
                    this.reload();
                 console.log(response);
             })
             .catch(errors=>{
                this.failedSweetAlert();
                this.FailedToaster();
                this.reload();
                console.log(errors);
             })
         },

         storeProdVarOpt(data){
             this.opt.name=data.name;
             this.opt.prodVar_id=data.prodVar_id;
             this.$http.post(PRODUCT_VARIANT_OPTION_URL,data)
             .then(response=>{
                  this.successSweetAlert();
                  this.SuccessToaster();
                  this.reload();
                  console.log(response);
             })
             .catch(errors=>{
                this.failedSweetAlert();
                this.FailedToaster();
                this.reload();
                console.log(errors);
             })
         },

        getAllProdVar(){
            let URL="/api/admin/product/get-variations-all?product_id="+this.product.id;
            this.$http.get(URL)
            .then(resp=>{
                this.prodVar=resp.data.prodVars;
                // console.log(this.prodVar);
            })
            .catch(errors=>{
                console.log(errors);
            })
        },

        getAllVProdVarOpt(){
           let vars=[];
            let URL="/api/admin/product/variation/option/all?product_id="+this.product.id;
            this.$http.get(URL)
            .then(resp=>{
               vars=resp.data.prodVarOpts;
               this.ProductVariationWithOption=resp.data.prodVarOpts;
               //  console.log(this.allVar);
               vars.forEach(element => {
                  this.allVar=element.product_variation_options;
                  // console.log(element.product_variation_options);
               });
            })
            .catch(errors=>{
                console.log(errors);
            })
        },

        storeProductImage(data){
            this.imageData.images=data.images;
            this.imageData.option=data.option;
            this.imageData.preview_image=data.preview_image;
            this.imageData.product_id=this.product.id;
            console.log(data);
            this.$http.post(PRODUCT_IMAGE_URL,data)
            .then(resp=>{
               //  console.log(resp.data);
               this.successSweetAlert();
               this.SuccessToaster();
               this.reload();
            })
            .catch(error=>{
               //  console.log(error);
               this.failedSweetAlert();
               this.FailedToaster();
               this.reload();
            })
        }
    },
    computed:{
    },

    created(){
        this.getAllProdVar();
        this.getAllVProdVarOpt();
    }
 
};
</script>

<style scoped>

ul {
  list-style-type: none;
}

.image_class{
  display: inline-block;
}

input[type="checkbox"][id^="_myCheckbox"] {
  display: none;
}

/* input+div{display:none;}

input:hover+div{
   display:inline;
   } */

label {
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked + label {
  border-color: #ddd;
}

:checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

:checked + label img {
  transform: scale(0.9);
  /* box-shadow: 0 0 5px #333; */
  z-index: -1;
}
</style>