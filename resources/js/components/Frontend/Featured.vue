<template>

   <div class="ps-container">
      <div class="ps-section__header mb-50">
         <h3 class="ps-section__title" data-mask="features">- Features Products</h3>
         <ul class="ps-masonry__filter">
            <!-- <li class="current"><a href="#" data-filter="*">All <sup>8</sup></a></li>
            <li><a href="#" data-filter=".nike">Nike <sup>1</sup></a></li>
            <li><a href="#" data-filter=".adidas">Adidas <sup>1</sup></a></li>
            <li><a href="#" data-filter=".men">Men <sup>1</sup></a></li>
            <li><a href="#" data-filter=".women">Women <sup>1</sup></a></li>
            <li><a href="#" data-filter=".kids">Kids <sup>4</sup></a></li> -->
         </ul>
      </div>
      <div class="ps-section__content pb-50">
         <div class="masonry-wrapper" data-col-md="4" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
            <div class="ps-masonry" style="position: relative; height: 2016px;">
               <div class="grid-sizer"></div>
               <div class="grid-item kids" style="position: absolute; left: 0px; top: 0px;" v-for="(feature,index) in featured" :key="index">
                  <div class="grid-item__content-wrapper">
                     <div class="ps-shoe mb-30">
                        <div class="ps-shoe__thumbnail">
                           <div class="ps-badge" v-if="feature.is_new == 1"><span>New</span></div>
                           <div class="ps-badge ps-badge--sale ps-badge--2nd" v-if="feature.discount_price"><span>-{{feature.discount_price}}%</span></div>
                           <a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img :src="feature.preview_image" alt=""><a class="ps-shoe__overlay" :href="'/product/'+feature.slug"></a>
                        </div>
                        <br>
                        <div class="ps-shoe__content">
                           <div class="ps-shoe__variants">
                              <div class="ps-shoe__variant normal owl-carousel owl-theme owl-loaded">
                                 <div class="owl-stage-outer">
                                    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 478.668px;" v-if="feature.galleries != null">
                                       <div class="owl-item active"  v-for="(image,index) in feature.galleries" :key="index" style="width: 99.667px; margin-right: 20px;"><img :src="image" alt=""></div>
                                    </div>
                                 </div>
                                 <div class="owl-controls">
                                    <div class="owl-nav">
                                       <div class="owl-prev" style=""><i class="ps-icon-back"></i></div>
                                       <div class="owl-next" style=""><i class="ps-icon-next"></i></div>
                                    </div>
                                    <div class="owl-dots" style="display: none;"></div>
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="ps-shoe__detail">
                              <a class="ps-shoe__name" :href="'/product/'+feature.slug">{{feature.name}}</a>
                              <p class="ps-shoe__categories"><a href="#">{{feature.category_name}}</a></p>
                              <span class="ps-shoe__price" v-if="feature.discount_price">
                                 <del>£{{feature.price}}</del> £ {{feature.discount_price}}
                              </span>
                              <span class="ps-shoe__price" v-else>
                                  £ {{feature.price}}
                              </span>
                              <div class="form-group pull-left">
                                 <button class="btn btn-primary">Add to cart</button>
                              </div>
                              <div class="form-group pull-right">
                                 <button class="btn btn-info">Buy</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
    import mixin from '../../mixin';

    const Featured_URL="/api/frontend/products/featured";

export default {
    mixins: [mixin],
   
    data(){
        return{
          featured:[],
          thumbnails:{
              id:'',
              small:'',
              medium:'',
              large:''
          },
          small_images:[],
        }
    },
    methods: {
        featuredProducts(){
            this.$http.post(Featured_URL)
            .then(resp=>{
                this.featured=resp.data.display_data;
            })
            .catch(errors=>{
                console.log(errors);
            })
        },
    },

    created(){
        this.featuredProducts();
    },
    computed:{
       
    }
 
}
</script>

<style scoped>
 li{
     list-style: none;
     display: inline;
 }
 li span span img{
     display: inline;
 }

 .image_class{
     max-height: 20%;
     max-width: 15%;
 }
</style>