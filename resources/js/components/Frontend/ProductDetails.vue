<template>
    <div class="col-lg-10 col-md-12 col-lg-offset-1">
        <div class="ps-product__thumbnail">
        <div class="ps-product__preview">
            <div class="ps-product__variants">
            <div class="item"><img src="images/shoe-detail/1.jpg" alt=""></div>
            <div class="item"><img src="images/shoe-detail/2.jpg" alt=""></div>
            <div class="item"><img src="images/shoe-detail/3.jpg" alt=""></div>
            <div class="item"><img src="images/shoe-detail/3.jpg" alt=""></div>
            <div class="item"><img src="images/shoe-detail/3.jpg" alt=""></div>
            </div><a class="popup-youtube ps-product__video" href="http://www.youtube.com/watch?v=0O2aH4XLbto"><img src="images/shoe-detail/1.jpg" alt=""><i class="fa fa-play"></i></a>
        </div>
        <div class="ps-product__image">
            <div class="item"><img class="zoom" src="images/shoe-detail/1.jpg" alt="" data-zoom-image="images/shoe-detail/1.jpg"></div>
            <div class="item"><img class="zoom" src="images/shoe-detail/2.jpg" alt="" data-zoom-image="images/shoe-detail/2.jpg"></div>
            <div class="item"><img class="zoom" src="images/shoe-detail/3.jpg" alt="" data-zoom-image="images/shoe-detail/3.jpg"></div>
        </div>
        </div>
        <div class="ps-product__thumbnail--mobile">
        <div class="ps-product__main-img"><img src="images/shoe-detail/1.jpg" alt=""></div>
        <div class="ps-product__preview owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="3" data-owl-item-xs="3" data-owl-item-sm="3" data-owl-item-md="3" data-owl-item-lg="3" data-owl-duration="1000" data-owl-mousedrag="on"><img src="images/shoe-detail/1.jpg" alt=""><img src="images/shoe-detail/2.jpg" alt=""><img src="images/shoe-detail/3.jpg" alt=""></div>
        </div>
        <div class="ps-product__info">
        <h1>{{show.name}}</h1>
        <p class="ps-product__category"><a href="#">{{show.category_name}}</a></p>
        <h3 class="ps-product__price" v-if="show.discount_price">£ {{show.discount_price}} <del>£ {{show.price}}</del></h3>
                <h3 class="ps-product__price" v-else>£ {{show.price}}</h3>
        <div class="ps-product__block ps-product__quickview">
            <h4>QUICK REVIEW</h4>
            <p v-text="show.summary"></p>
        </div>
        <ul v-for="(variant,index) in show.variation" :key="index">
            <div class="ps-product__block ps-product__style" v-if="parseInt(variant.variation_data_type) === 0 ">
                <h4>CHOOSE YOUR {{variant.variation_name.toUpperCase()}}</h4>
                    <li>
                        <a href="">
                            <img :src="images.small" alt="">
                        </a>
                    </li>
            </div>
            <div class="ps-product__block ps-product__size" v-if="parseInt(variant.variation_data_type) === 1 ">
                <h4>CHOOSE {{variant.variation_name.toUpperCase()}}</h4>
                <select class="ps-select selectpicker">
                <option value="1">Select Size</option>
                <option value="2">4</option>
                <option value="3">4.5</option>
                <option value="3">5</option>
                <option value="3">6</option>
                <option value="3">6.5</option>
                <option value="3">7</option>
                <option value="3">7.5</option>
                <option value="3">8</option>
                <option value="3">8.5</option>
                <option value="3">9</option>
                <option value="3">9.5</option>
                <option value="3">10</option>
                </select>
                <div class="form-group">
                <input class="form-control" type="number" value="1">
                </div>
            </div> 
        </ul>
        <div class="ps-product__shopping"><a class="ps-btn mb-10" href="cart.html">Add to cart<i class="ps-icon-next"></i></a>
            <div class="ps-product__actions"><a class="mr-10" href="whishlist.html"><i class="ps-icon-heart"></i></a><a href="compare.html"><i class="ps-icon-share"></i></a></div>
        </div>
        </div>
    </div>
</template>

<script>
import mixin from '../../mixin';

const PRODUCT_URL="/api/frontend/products/product-by-id?slug=";

export default {
    mixins: [mixin],
    props:['product'],

    data(){
        return{
            show:[],
            opt:[],
            images:{
                small:[],
                medium:[],
                large:[],
            },
        }
    },

    methods:{
        productData(){
            this.$http.get(PRODUCT_URL +this.product.slug)
            .then(resp=>{
                this.show=resp.data.display_data;
                // console.log(this.show);
                let options=resp.data.display_data;
                options.variation.forEach(element => {
                    this.opt=element.options;
                    let galleries=element.options;
                    galleries.forEach(gallery=>{
                        let g=gallery.galleries;
                        g.forEach(images=>{
                            this.images.small=images.small;
                            this.images.medium=images.medium;
                            this.images.large=images.large;
                        })  
                    })
                });
            })
            .catch(err=>{
                console.log(err);
            })
        },
          
    },

    created(){
        this.productData();
    },
}
</script>